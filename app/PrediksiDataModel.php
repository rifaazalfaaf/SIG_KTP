<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrediksiDataModel extends Model
{
    protected $table = "faktor_KTP";

    protected $fillable = ['wanita_kerja','ibu_rumah_tangga','pernikahan_dini'];
}