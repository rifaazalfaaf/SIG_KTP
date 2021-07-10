<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrediksiDataModel extends Model
{
    protected $table = "faktor_ktp";

    // $data = "select * from peta_kecamatan join faktor_ktp on peta_kecamatan.id_kecamatan = faktor_ktp.id_kecamatan WHERE id IN (select max(id) FROM `faktor_ktp` group by id_kecamatan) ORDER BY id asc";
    protected $fillable = ['perempuan_bekerja','ibu_rumah_tangga','pernikahan_dini'];
    // return $data;
}