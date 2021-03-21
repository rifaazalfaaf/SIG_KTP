<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Http;
use App\VisualisasiDataModel;

class VisualisasiController extends Controller
{
 	
 	public function index()
    {
    	$bandung = VisualisasiDataModel::all();
    	// $bandung = DB::table('peta_kecamatan')->get();

    	return view('app/visualisasi/jumlah_kasus',['kecamatan' => $bandung]);
    }   
}
