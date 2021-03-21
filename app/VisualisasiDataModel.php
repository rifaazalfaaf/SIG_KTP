<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VisualisasiDataModel extends Model
{
    // public function allData(){
    // 	$results = DB::table('peta_kecamatan')
    // 		->select('kode_kecamatan','nama_kecamatan','lokasi_kecamatan')
    // 		-> get();
    // 	return $results;
    // }

    protected $table="peta_kecamatan";
	// protected $primaryKey="id_kecamatan";
	// protected $fillable=['kode_kecamatan','nama_kecamatan','lokasi_kecamatan'];
}
