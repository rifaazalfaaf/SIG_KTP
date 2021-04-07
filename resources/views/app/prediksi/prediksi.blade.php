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
<div id="map"></div>
<div class="row center mt-5" >
  {{-- <a class="font2" href="{{url('/input_data')}}" style="text-decoration: none;">
    <button type="button" class="btn btn-outline-danger mr-4"> Input Data</button>
  </a> --}}
  <button type="button" class="btn btn-outline-danger mr-5 font2" data-toggle="modal" data-target="#importExcel">
    Import Excel
  </button>

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
  <a class="font2" href="{{url('/')}}" style="text-decoration: none;">
    <button type="button" class="btn btn-outline-danger ml-4">Prediksi Data</button>
  </a>
</div>
@endsection


@section('scripts')

<script type="text/javascript" src="js/leaflet.ajax.js"></script>
<script type="text/javascript">

  var map = L.map('map').setView([-7.0702032,107.6295788], 10);

  L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
      'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/light-v9',
    tileSize: 512,
    zoomOffset: -1
  }).addTo(map);


  // control that shows state info on hover
  var info = L.control();

  info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
  };

  info.update = function (props) {
    this._div.innerHTML = '<h4>Jumlah Kasus KTP di Kabupaten Bandung</h4>' +  (props ?
      '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_kasus_2019 + ' Kasus / tahun '
      : 'Dekatkan kursor ke kecamatan tertentu untuk melihat lebih detail');
  };

  info.addTo(map);


  // get color depending on population density value
  function getColor(d) {
    return d > 10 ? '#800026' :
        d > 8  ? '#BD0026' :
        d > 6  ? '#FC4E2A' :
        d > 4   ? '#FEB24C' :
        d > 2   ? '#FED976' :
              '#FFEDA0';
  }

  function style(feature) {
    return {
      weight: 2,
      opacity: 1,
      color: 'white',
      dashArray: '3',
      fillOpacity: 0.7,
      fillColor: getColor(feature.properties.Jumlah_kasus_2019)
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

  var geojson;


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

  geojson = new L.GeoJSON.AJAX('geojson/bandung.geojson', {
      style: style, 
      onEachFeature: onEachFeature
  }).addTo(map);
  

  map.attributionControl.addAttribution('Data diambil dari  &copy; <a href="http://census.gov/">Pemerintah Kabupaten Bandung</a>');


  var legend = L.control({position: 'bottomright'});

  legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
      grades = [0, 2, 4, 6, 8, 10],
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
