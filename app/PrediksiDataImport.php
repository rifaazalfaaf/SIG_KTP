<?php
   
namespace App;
   
use App\PrediksiDataModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
    
class PrediksiDataImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PrediksiDataModel([
            'id_kecamatan'    => $row[0], 
            'kasus_kekerasan'    => $row[2], 
            'perempuan_bekerja'    => $row[3], 
            'ibu_rumah_tangga'    => $row[4], 
            'pernikahan_dini'    => $row[5], 
        ]);
    }
}