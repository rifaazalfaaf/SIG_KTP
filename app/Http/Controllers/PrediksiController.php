<?php

namespace App\Http\Controllers;

use Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\PrediksiDataModel;
use Maatwebsite\Excel\Facades\Excel;
use Http;


class PrediksiController extends Controller
{
 	public function index()
    {
    	return view('app/prediksi/prediksi');
    }   

    public function input_data()
    {
    	return view('app/prediksi/input_data');
    } 

    public function import(Request $request) 
    {
    	// menangkap file excel
		$file = $request->file('file');

		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();

		// upload ke folder file_siswa di dalam folder public
		$file->move('faktor_KTP',$nama_file);

        // import data
		// $coba = Excel::import(new PrediksiDataModel, public_path('/faktor_KTP/'.$nama_file));
 		// var_dump($coba);

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
		 				'wanita_kerja' => $data[$i][3],
		 				'ibu_rumah_tangga' =>$data[$i][4],
		 				'pernihakan_dini' => $data[$i][5],
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
}
