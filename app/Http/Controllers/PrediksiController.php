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
		$data = DB::table('faktor_ktp')->latest()->limit(19)->orderBy('id')->get();
		// dd($data);
		$ret['data'] = $data;

		$data2 = DB::table('peta_kecamatan')->join('hasil_prediksi', 'hasil_prediksi.id_kecamatan', '=','peta_kecamatan.id_kecamatan')->latest()->limit(19)->orderBy('id')->get();
		
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
		 				'perempuan_bekerja' => $data[$i][2],
		 				'ibu_rumah_tangga' =>$data[$i][3],
		 				'pernikahan_dini' =>$data[$i][4],
		  			];
				}
 			}
 		}
 		

 		// dd($dataSet);
 		DB::table('faktor_ktp')->insert($dataSet);

		// notifikasi dengan session
		Session::flash('sukses','Data Faktor Berhasil Diimport!');
		// Session::flash('gagal','Data Faktor Gagal Diimport!');
		
 
		// alihkan halaman kembali
		return redirect('/prediksi_data');
    }

    public function prediksi()
    {
    	$data = DB::table('peta_kecamatan')->join('faktor_ktp', 'faktor_ktp.id_kecamatan', '=','peta_kecamatan.id_kecamatan')->latest()->limit(19)->orderBy('id')->get();
		// dd($data);
		// $ret['data'] = $data;
	// mengambil data banyaknya perempuan yang bekerja
    	$perempuan_bekerja = array();
		for ($i=0; $i<count($data); $i++) {
			$perempuan_bekerja[$i]=$data[$i]->perempuan_bekerja;
		}
		// dd($perempuan_bekerja);

	// mengambil data banyaknya ibu rumah tangga
    	$irt = array();
		for ($i=0; $i<count($data); $i++) {
			$irt[$i]=$data[$i]->ibu_rumah_tangga;
		}
		// dd($irt);
	// mengambil data banyaknya pernikahan dini
		$pernikahan_dini = array();
		for ($i=0; $i<count($data); $i++) {
			$pernikahan_dini[$i]=$data[$i]->pernikahan_dini;
		}
		// dd($pernikahan_dini);

	// Data yang dibutuhkan untuk perhitungan prediksi
    	$intercept = -0.12282;
    	$rhoTopi = 0.32378;
    	$betaSatu = 0.000013551;
    	$betaDua = 0.000085814;
    	$betaTiga = 0.0039697;
    	$bobot=array(array(0,0.24055,0.04923,0.02412,0.01291,0.01357,0.01427,0.01465,0.0212,0.04485,0.07974,0.05709,0.07089,0.10326,0.0848,0.04923,0.04697,0.04288,0.02978),array(0.07175,0,0.04497,0.01279,0.00653,0.0072,0.00744,0.00744,0.01224,0.03832,0.11512,0.05874,0.11512,0.21407,0.13216,0.06476,0.03832,0.03304,0.01999),array(0.00828,0.02537,0,0.01737,0.00755,0.00828,0.0079,0.01264,0.01864,0.10146,0.18038,0.18038,0.04047,0.08645,0.05707,0.02537,0.12075,0.08645,0.0152),array(0.01866,0.03318,0.07989,0,0.1075,0.0857,0.01997,0.02221,0.02687,0.06991,0.0857,0.07465,0.05184,0.06991,0.05812,0.04417,0.06561,0.05812,0.02798),array(0.00121,0.00205,0.00421,0.01304,0,0.90547,0.00665,0.00748,0.01039,0.00509,0.00441,0.00905,0.00313,0.0029,0.0026,0.00279,0.00848,0.00748,0.00354),array(0.00126,0.00223,0.00456,0.01026,0.89376,0,0.01521,0.00837,0.0119,0.00349,0.00479,0.01026,0.00335,0.00309,0.00276,0.00297,0.00956,0.00837,0.0038),array(0.0041,0.00717,0.0135,0.00742,0.02038,0.0472,0,0.69354,0.06242,0.01485,0.01415,0.0216,0.0104,0.0104,0.00923,0.0113,0.0118,0.01084,0.02969),array(0.00387,0.0066,0.01987,0.00759,0.02109,0.0239,0.63811,0,0.08973,0.02243,0.02109,0.0293,0.01242,0.00997,0.00883,0.01436,0.01436,0.01302,0.04343),array(0.01002,0.0194,0.05237,0.01642,0.05237,0.06074,0.10265,0.16038,0,0.06074,0.05632,0.11373,0.02442,0.03352,0.02699,0.02221,0.06569,0.05632,0.06569),array(0.0061,0.01747,0.082,0.01229,0.00738,0.00512,0.00702,0.01153,0.01747,0,0.09758,0.32798,0.04086,0.05248,0.03644,0.01747,0.14577,0.09758,0.01747),array(0.0048,0.02321,0.06447,0.00666,0.00282,0.00311,0.00296,0.0048,0.00716,0.04316,0,0.06447,0.20888,0.32638,0.10657,0.03626,0.05222,0.03626,0.0058),array(0.00164,0.00566,0.03083,0.00277,0.00277,0.00319,0.00216,0.00319,0.00692,0.06936,0.03083,0,0.00975,0.02497,0.01478,0.00566,0.62428,0.15607,0.00516),array(0.00629,0.03424,0.02134,0.00594,0.00296,0.00321,0.00321,0.00417,0.00458,0.02666,0.30814,0.03009,0,0.21399,0.09511,0.02134,0.12037,0.07704,0.02134),array(0.00473,0.0329,0.02356,0.00414,0.00142,0.00153,0.00166,0.00173,0.00325,0.01769,0.24883,0.03981,0.11059,0,0.44236,0.02356,0.02031,0.01555,0.00637),array(0.00551,0.02879,0.02204,0.00488,0.0018,0.00194,0.00209,0.00217,0.00371,0.01742,0.11517,0.03339,0.06967,0.62702,0,0.02204,0.01953,0.01563,0.0072),array(0.01603,0.07067,0.04908,0.01859,0.00969,0.01045,0.0128,0.01767,0.01529,0.04182,0.19632,0.0641,0.07831,0.16728,0.11043,0,0.03878,0.03361,0.04908),array(0.00095,0.00261,0.01456,0.00172,0.00183,0.0021,0.00083,0.0011,0.00282,0.02175,0.01762,0.44049,0.02753,0.00899,0.0061,0.00242,0,0.44049,0.0061),array(0.00137,0.00353,0.01638,0.00239,0.00254,0.00288,0.0012,0.00157,0.0038,0.02288,0.01922,0.17302,0.02768,0.01081,0.00767,0.00329,0.69208,0,0.00767),array(0.01298,0.0292,0.03938,0.01576,0.01642,0.01788,0.045,0.07153,0.06055,0.05598,0.04205,0.07818,0.10482,0.06055,0.04827,0.0657,0.13094,0.10482,0));
    	$variabelY=array(array(1),array(1),array(0),array(2),array(1),array(1),array(0),array(1),array(2),array(1),array(2),array(1),array(2),array(5),array(3),array(0),array(3),array(3),array(3));

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
				$hasil[$i][$j] = ceil($intercept + ($rhoTopi * $hasil[$i][$j]) + ($betaSatu * $perempuan_bekerja[$i])+ ($betaDua * $irt[$i]) + ($betaTiga * $pernikahan_dini[$i]));
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
