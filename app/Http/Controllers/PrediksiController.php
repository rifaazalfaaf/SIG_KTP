<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\PrediksiDataModel;
use App\HasilPrediksiModel;
use Maatwebsite\Excel\Facades\Excel;
use Http;


class PrediksiController extends Controller
{
	
 	public function index()
    {
    // mengambil data dari database
		$data = DB::table('faktor_ktp')->latest()->limit(22)->orderBy('id')->get();
		// dd($data);
		$ret['data'] = $data;

		$data2 = DB::table('peta_kecamatan')->join('hasil_prediksi', 'hasil_prediksi.id_kecamatan', '=','peta_kecamatan.id_kecamatan')->latest()->limit(22)->orderBy('id')->get();
		
		// $ret['dataHasil'] = $data2;
		$ret['dataPred'] = $data2;
	
    	return view('app/prediksi/prediksi', $ret);
    }   

    public function import(Request $request) 
    {
    	// validasi
		$this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
		
    	// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('faktor_KTP',$nama_file);

        
 		$array = Excel::toArray(new PrediksiDataModel, public_path('/faktor_KTP/'.$nama_file));
 		// $totalarray = array_sum(array_map("count", $array));
 		$count = 0;
		foreach ($array as $type) {
		    $count+= count($type);
		}
 		// dd($count);

 		$dataSet=[];
 		$i=1;
 		// $count = count($array[0]);
 		for ($i=1; $i<=count($array[0])-1; $i++) { 
 			foreach ($array as $data){
	 			if($data[$i][0] !== null){
		 			$dataSet[]=[
		 				'id_kecamatan' => $data[$i][0],
		 				'ibu_rumah_tangga' =>$data[$i][3],
		  			];
				}
 			}
 		}
 		

 		// dd($dataSet);
 		DB::table('faktor_ktp')->insert($dataSet);

		// notifikasi dengan session
		Session::flash('sukses','Data Faktor Berhasil Diimport!');
		
 
		// alihkan halaman kembali
		return redirect('/prediksi_data');
    }

    public function prediksi()
    {
    	$data = DB::table('peta_kecamatan')->join('faktor_ktp', 'faktor_ktp.id_kecamatan', '=','peta_kecamatan.id_kecamatan')->latest()->limit(22)->orderBy('id')->get();
		// dd($data);
		// $ret['data'] = $data;

	// mengambil data banyaknya ibu rumah tangga
    	$irt = array();
		for ($i=0; $i<count($data); $i++) {
			$irt[$i]=$data[$i]->ibu_rumah_tangga;
		}
		// dd($irt);

	// Data yang dibutuhkan untuk perhitungan prediksi
    	$intercept = 0.8121;
    	$rhoTopi = -0.30244;
    	$betaDua = 0.000085814;
    	$bobot=array(array(0,0.00739,0.89425,0.00085,0.00093,0.0008,0.00087,0.00096,0.00067,0.00203,0.00155,0.00261,0.01238,0.00676,0.01238,0.02117,0.01397,0.00739,0.00456,0.00397,0.00203,0.00248), array(0.15176,0,0.20347,0.01092,0.01148,0.01793,0.01911,0.01239,0.00927,0.0211,0.01793,0.02519,0.06745,0.04829,0.05996,0.08734,0.07173,0.04164,0.03973,0.03627,0.02184,0.02519), array(0.86994,0.00964,0,0.00088,0.00097,0.00082,0.00091,0.001,0.00071,0.00217,0.00164,0.00284,0.01547,0.00789,0.01547,0.02876,0.01775,0.0087,0.00515,0.00444,0.00217,0.00268), array(0.00185,0.00116,0.00197,0,0.86954,0.00814,0.00931,0.00719,0.00386,0.01479,0.00998,0.02415,0.00423,0.0087,0.00301,0.00279,0.0025,0.00268,0.00814,0.00719,0.00542,0.0034),array(0.00199,0.0012,0.00213,0.8517,0,0.00911,0.01051,0.00798,0.00415,0.01738,0.01134,0.02994,0.00456,0.00978,0.00319,0.00295,0.00263,0.00283,0.00911,0.00798,0.00591,0.00362),array(0.00076,0.00084,0.00081,0.00356,0.00407,0,0.85631,0.01057,0.00381,0.05352,0.02027,0.01522,0.00334,0.00647,0.00214,0.0028,0.00237,0.00169,0.00437,0.00381,0.00149,0.00177),array(0.00079,0.00084,0.00084,0.00383,0.00442,0.80558,0,0.01259,0.00411,0.08951,0.02663,0.01907,0.00358,0.00731,0.00223,0.00223,0.00249,0.00174,0.00477,0.00411,0.00152,0.00183),array(0.00636,0.00399,0.00679,0.02172,0.02461,0.073,0.09239,0,0.16424,0.19546,0.09239,0.08184,0.02172,0.03017,0.01279,0.01027,0.00909,0.01478,0.01478,0.01341,0.06551,0.04471),array(0.00931,0.00627,0.01013,0.02451,0.02684,0.05514,0.0633,0.34465,0,0.09382,0.0633,0.05901,0.02451,0.03102,0.01641,0.01379,0.01212,0.01835,0.01835,0.01702,0.05164,0.04051),array(0.00381,0.00193,0.00421,0.01272,0.01526,0.10514,0.18692,0.05561,0.01272,0,0.26917,0.18692,0.0139,0.03433,0.00519,0.00748,0.00618,0.00466,0.01682,0.0139,0.02629,0.01682),array(0.0051,0.00287,0.00555,0.01498,0.01738,0.06951,0.09709,0.04589,0.01498,0.4699,0,0.09709,0.01611,0.03254,0.00699,0.00959,0.00772,0.00635,0.0188,0.01611,0.02664,0.0188),array(0.0074,0.00347,0.00827,0.03126,0.03956,0.04501,0.05993,0.03505,0.01204,0.28134,0.0837,0,0.03956,0.15825,0.00603,0.01621,0.01292,0.01915,0.05993,0.04501,0.02093,0.01498),array(0.01893,0.00502,0.02431,0.00296,0.00325,0.00534,0.00608,0.00502,0.0027,0.0113,0.0075,0.02137,0,0.06754,0.21883,0.34192,0.11165,0.03799,0.05471,0.03799,0.0095,0.00608),array(0.00488,0.0017,0.00586,0.00287,0.00329,0.00488,0.00586,0.00329,0.00161,0.01318,0.00715,0.04035,0.03188,0,0.01009,0.02582,0.01528,0.00586,0.6456,0.1614,0.00382,0.00534),array(0.02646,0.00624,0.03399,0.00294,0.00319,0.00478,0.0053,0.00414,0.00253,0.0059,0.00455,0.00455,0.30591,0.02987,0,0.21244,0.09442,0.02118,0.1195,0.07648,0.01446,0.02118),array(0.02358,0.00474,0.03293,0.00142,0.00153,0.00325,0.00276,0.00173,0.00111,0.00443,0.00325,0.00638,0.24904,0.03985,0.11068,0,0.44274,0.02358,0.02033,0.01557,0.00474,0.00638),array(0.02197,0.00549,0.0287,0.00179,0.00193,0.0039,0.00434,0.00216,0.00137,0.00517,0.0037,0.00718,0.11481,0.03329,0.06945,0.62506,0,0.02197,0.01947,0.01558,0.00549,0.00718),array(0.05384,0.01477,0.06514,0.00894,0.00964,0.01287,0.01409,0.01629,0.00964,0.01805,0.01409,0.04926,0.18095,0.05909,0.07218,0.15419,0.10179,0,0.03574,0.03098,0.03324,0.04524),array(0.00228,0.00096,0.00264,0.00186,0.00212,0.00228,0.00264,0.00111,0.00066,0.00446,0.00285,0.01056,0.01784,0.44597,0.02787,0.0091,0.00617,0.00245,0,0.44597,0.00405,0.00617),array(0.0031,0.00138,0.00356,0.00257,0.00291,0.0031,0.00356,0.00158,0.00096,0.00577,0.00383,0.01242,0.0194,0.17459,0.02793,0.01091,0.00774,0.00332,0.69835,0,0.00528,0.00774),array(0.01743,0.00914,0.01922,0.02129,0.02373,0.01335,0.01453,0.08518,0.032,0.12011,0.06973,0.06353,0.05338,0.04549,0.05813,0.03656,0.03003,0.03922,0.06973,0.05813,0,0.12011),array(0.02113,0.01046,0.02354,0.01324,0.01442,0.01576,0.01729,0.05767,0.0249,0.07627,0.04881,0.04513,0.0339,0.06303,0.08451,0.04881,0.03891,0.05296,0.10556,0.08451,0.11917,0));
    	$variabelY=array(array(5),array(1),array(1),array(1),array(1),array(1),array(6),array(1),array(1),array(4),array(2),array(3),array(2),array(2),array(1),array(4),array(3),array(1),array(3),array(2),array(1),array(2));

    	// dd($bobot);
    	
    // Perhitungan model untuk Prediksi
    	$hasil = array();
		for ($i=0; $i<sizeof($bobot); $i++) {
			for ($j=0; $j<sizeof($variabelY[0]); $j++) {
				$temp = 0;
				for ($k=0; $k<sizeof($variabelY); $k++) {
					$temp += $bobot[$i][$k] * $variabelY[$k][$j];
				}
				$hasil[$i][$j] = $temp;
				$hasil[$i][$j] = round($intercept + ($rhoTopi * $hasil[$i][$j]) + ($betaDua * $irt[$i]));
			}
		}
		// dd($hasil);

	// menambahkan data ketabel Hasil Prediksi
		for ($i = 0; $i < count($data); $i++) {
	        $hasilPrediksi[] = [
	            // 'user_id' => Sentinel::getUser()->id,
	            'id_kecamatan'  => $data[$i]->id_kecamatan,
	            'hasil_dari_prediksi'=> $hasil[$i][0],
	        ];
	    }
   		
   		
 		DB::table('hasil_prediksi')->insert($hasilPrediksi);
 		// dd($hasilPrediksi);

		return redirect('/prediksi_data');
    }
}
