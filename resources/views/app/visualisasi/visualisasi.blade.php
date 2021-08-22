@extends('layouts.default')
@section('title','Visualisasi Data')

@section('styles')
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    #map {
      /*width: 600px;*/
      height: 500px;
    }
    .info {
      padding: 6px 8px;
      font: 14px/16px Arial, Helvetica, sans-serif;
      background: white;
      background: rgba(255,255,255,0.8);
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      border-radius: 5px;
    }
    .info h4 {
      margin: 0 0 5px;
      color: #777;
    }
    .legend {
      line-height: 18px;
      color: #555;
    }
    .legend i {
      width: 18px;
      height: 18px;
      float: left;
      margin-right: 8px;
      opacity: 0.7;
    }
  </style>
@endsection

@section('content')
{{-- button lihat cara menggunakan fitur --}}
<div class="menunav" style="background-color: #ededed">
  <div class="container" >
    <div class="row" >
      <button type="button" class="btn buttonSIG font2 btn-block my-1" data-toggle="modal" data-target="#myModal">
        Lihat disini untuk cara menggunakan fitur
      </button>
    </div>
  </div>
</div>
<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Cara Menggunakan Fitur Visualisasi</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ol class="font2 bodyy">
          <li>Pilih data yang ingin ditampilkan</li>
          <li>tekan tombol "Pilih Data" data dan legenda</li>
          <li>Kemudian arahkan kursor pada setiap kecamatan untuk melihat data yang lebih detil</li>
          <li>Apabila ingin menampilkan data yang lain, lakukan langkah 1,2 dan 3</li>
        </ol>
        <p class="font2 bodyy">Untuk melihat berapa banyak data dapat dilihat pada keterangan di sebelah kanan atas dan kanan bawah peta</p>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>

<div class="container mb-0">
  <div class="row m-2">
    <div class="form-check-inline col-md-12">
      <label class="form-check-label col-md-3 font2" for="radio1">
        <input class="form-check-input" type="radio" name="data" id ="jumlah_kasus" value="jumlah_kasus" checked="checked">Kasus Kekerasan 
      </label>
      <label class="form-check-label col-md-1 font2" for="radio1">
        <input class="form-check-input" type="radio" name="data" id="IRT" value="IRT">IRT
      </label>
      <label class="form-check-label col-md-3 font2" for="radio1">
        <input class="form-check-input" type="radio" name="data" id="perempuan_bekerja" value="perempuan_bekerja">Perempuan yang Bekerja
      </label>  
      <label class="form-check-label col-md-3 font2" for="radio1">
        <input class="form-check-input" type="radio" name="data" id="pernikahan_dini" value="pernikahan_dini">Pernikahan Dini
      </label>  
      <button type="button" class="btn buttonSIG col-md-2 font2" onclick="reset()">
          Pilih Data
      </button>
    </div>
  </div>
</div>
<div class="borderatas" id="map"></div>
@endsection


@section('scripts')

<script type="text/javascript" src="js/leaflet.ajax.js"></script>
<script type="text/javascript" src="js/visualisasi.js">

</script>
<script type="text/javascript">
  var geojson;
  var dataKecamatan = <?php echo json_encode($kecamatan) ?>;
  var geojsonlist = [];
  
  dataKecamatan.forEach(function(itemKecamatan){
    var url = `/geojson/${itemKecamatan.lokasi_kecamatan}`;
    // console.log(url)
    geojson = new L.GeoJSON.AJAX(url, {
        style: style, 
        onEachFeature: onEachFeature
    }).addTo(map);
    geojsonlist.push(geojson);
  });

  function reset(){
    geojsonlist.forEach(function(layer){
      layer.resetStyle();
    })
    displayRadioValue();
  }
</script>
@endsection
