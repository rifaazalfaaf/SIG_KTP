<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Http;

class PrediksiController extends Controller
{
 	public function index()
    {
    	return view('app/visualisasi/jumlah_kasus');
    }   
}
