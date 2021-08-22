@extends('layouts.default')
@section('title','Prediksi Data')

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
    .btn-fitur{
      background-color: #EFA1AF;
      color : white;
    }
    
  </style>
@endsection

@section('content')
{{-- validasi untuk file selain excel --}}
@if($errors->any())
{!!implode('',$errors->all('<div class="alert alert-danger alert-block mb-0"> <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>:message</strong> </div>'))!!}
@endif
{{-- validasi data masuk ke database --}}
@if (Session::has('sukses'))
  <div class="alert alert-success alert-block mb-0">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>{{ Session::get('sukses') }}</strong>
  </div>
@endif

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
        <h4 class="modal-title">Cara Menggunakan Fitur Prediksi Data</h4>
        <button type="button" class="close" data-dismiss="modal">×</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <ol class="font2 bodyy">
          <li>tekan tombol "Download Template Excel"</li>
          <li>Pada file excel, kolom perempuan_bekerja, ibu_rumah_tangga dan penikahan_dini diisi sesuai dengan data yang anda punya</li>
          <li>Apabila data di excel sudah terisi, tekan tombol "Import Excel"</li>
          <li>Pilih file yang akan di import</li>
          <li>Kemudian tekan "Import"</li>
          <li>tekan "Prediksi Hasil", untuk menampilkan data perkiraan banyaknya kasus kekerasan terhadap perempuan di Kabupaten Bandung</li>
        </ol>
      </div>
      
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="map"></div>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-5">
        <a class="link_download" href="template/data_input.xlsx" download>
          <button type="button" class="btn btn-outline-danger font2 btn-block"><i class="fa fa-download" style="text-decoration: none !important;"></i> Download Templat Excel</button>
        </a>
        </div>

        <div class="col-md-3">
          <button type="button" class="btn btn-outline-danger font2 btn-block" data-toggle="modal" data-target="#importExcel">
            Import Excel
          </button>
        </div>
        <!-- Import Excel -->
        <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form method="post" action="{{ route('import') }}" enctype="multipart/form-data">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title font2" id="exampleModalLabel">Import Excel</h5>
                </div>
                <div class="modal-body">

                  {{ csrf_field() }}

                  <label class="font2">Pilih file excel</label>
                  <div class="form-group">
                    <input type="file" name="file" required="required">
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary font2" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-outline-danger font2">Import</button>
                </div>
              </div>
            </form>
          </div>
        </div> 
      </div>
    </div>

    <div class="col-md-4" align="right">
        <form method="POST" action="{{ url('prediksi') }}" >
          @csrf
          <button type="submit" class="btn btn-outline-danger font2 btn-block">Prediksi Hasil</button>
        </form>
    </div>
  </div>
</div>
@endsection


@section('scripts')

<script type="text/javascript" src="js/leaflet.ajax.js"></script>
<script type="text/javascript">

  <?php 
    $hasilPred = array();
    for ($i=0; $i<count($dataPred); $i++) {
      $hasilPred[$i]=[
        $hasilPred[$dataPred[$i]->kode_kecamatan]= 
        $dataPred[$i]->hasil_dari_prediksi,
      ];
    }
  ?>
  
  var KODEKec = <?=json_encode($hasilPred)?>; 
  
  var data_map = L.layerGroup();

  var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

  var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox/light-v9', tileSize: 512, zoomOffset: -1, attribution: mbAttr}),
      streets  = L.tileLayer(mbUrl, {id: 'mapbox/streets-v11', tileSize: 512, zoomOffset: -1, attribution: mbAttr});

  var map = L.map('map', {
    center: [-7.0702032,107.6295788],
    zoom: 10,
    layers: [grayscale, data_map]
  });

  // control that shows state info on hover
  var info = L.control();

  info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };

  info.update = function (props) {
    this._div.innerHTML = '<h4>Banyaknya Perkiraan Kasus KTP di Kabupaten Bandung</h4>' +  (props ?
      '<b>' + props.WADMKC + '</b><br />' + KODEKec[props.Kode_Kecamatan] + ' Kasus / tahun '
      : 'Dekatkan kursor ke kecamatan tertentu untuk melihat lebih detail');
  };

  info.addTo(map);


  // get color depending on population density value
  function getColor(d) {
    return d > {{$batas_atas}}  ? '#800026' :
           d > {{$batas_bawah}} ? '#FC4E2A' :
           d > 0                ? '#FFEDA0':
                                  '#7df25a';
  }

  function style(feature) {
    return {
      weight: 2,
      opacity: 1,
      color: 'grey',
      dashArray: '3',
      fillOpacity: 0.7,
      fillColor: getColor(KODEKec[feature.properties.Kode_Kecamatan])
    };
  }

  function highlightFeature(e) {
    var layer = e.target;

    layer.setStyle({
      weight: 5,
      color: '#666',
      dashArray: '',
      fillOpacity: 0.7
    });

    if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
      layer.bringToFront();
    }

    info.update(layer.feature.properties);
  }

 
  function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
  }

  function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
  }

  function onEachFeature(feature, layer) {
    layer.on({
      mouseover: highlightFeature,
      mouseout: resetHighlight,
      click: zoomToFeature
    });
  }
  
  
 var baseLayers = {
    "Grayscale": grayscale,
    "Streets": streets
  };

  var overlays = {
    "Kecamatan Tersampel": data_map,
    "Kecamatan Tidak Tersampel" : new L.GeoJSON.AJAX(["/geojson/bandung.geojson"],{style: style, 
        onEachFeature: onEachFeature}).addTo(map),
    
  };

  L.control.layers(baseLayers, overlays).addTo(map);
  
  var geojson;
    
  var dataKecamatan = <?php echo json_encode($dataPred) ?>;

  dataKecamatan.forEach(function(itemKecamatan){
    var url = `/geojson/${itemKecamatan.lokasi_kecamatan}`;
    // console.log(url)
    geojson = new L.GeoJSON.AJAX(url, {
        style: style, 
        onEachFeature: onEachFeature
    }).addTo(data_map);
  });


  map.attributionControl.addAttribution('Data diambil dari Pemda Kabupaten Bandung dan Kemenag Kabupaten Bandung');


  var legend = L.control({position: 'bottomright'});

  legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
      grades = ['undifined', 1, {{$batas_bawah}}, {{$batas_atas}}],
      labels = [],
      from, to;

    for (var i = 0; i < grades.length; i++) {
      from = grades[i];
      to = grades[i + 1];

      labels.push(
        '<i style="background:' + getColor(from + 1) + '"></i> ' +
        from + (to ? '&ndash;' + to : '+'));
    }

    div.innerHTML = labels.join('<br>');
    return div;
  };

  legend.addTo(map);

</script>
@endsection
