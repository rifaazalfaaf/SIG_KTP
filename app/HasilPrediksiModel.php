<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HasilPrediksiModel extends Model
{
    protected $table = "hasil_prediksi";

    // $data = "select * from peta_kecamatan join faktor_ktp on peta_kecamatan.id_kecamatan = faktor_ktp.id_kecamatan WHERE id IN (select max(id) FROM `faktor_ktp` group by id_kecamatan) ORDER BY id asc";
    protected $fillable = ['hasil_dari_prediksi'];
    // return $data;
}