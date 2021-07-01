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
<div class="menunav" style="background-color: #ededed">
<div class="container" >
  <div class="row" >
    <button type="button" class="btn buttonSIG font2 btn-block my-1" data-toggle="modal" data-target="#myModal">
      Lihat disini untuk cara menggunakan fitur
    </button>
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
    <button type="button" class="btn buttonSIG col-md-2 font2" onclick="displayRadioValue()">
        Pilih Data
    </button>
  </div>
  </div>
</div>
<div class="borderatas" id="map"></div>

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
            <li>Klik tombol "Pilih Data" untuk menampilkan data dan legenda</li>
            <li>Kemudian dekatkan kursor pada setiap kecamatan untuk melihat data yang lebih detil</li>
            <li>Apabila ingin menampilkan data yang lain, lakukan langkah 1,2 dan 3 lalu dekatkan kursor pada peta untuk merubah warna peta tersebut</li>
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
  
  var legend = L.control({position: 'bottomright'});


  function displayRadioValue() {
    var data1 = document.getElementById("jumlah_kasus");
    var data2 = document.getElementById('IRT');
    var data3 = document.getElementById('perempuan_bekerja');
    var data4 = document.getElementById('pernikahan_dini');

    if(data1.checked){
    // console.log(data1.checked)
      info.update = function (props) {
        this._div.innerHTML = '<h4>Rata-Rata Banyaknya Kasus KTP di Kabupaten Bandung <br/>pada Tahun 2019 dengan 2020</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_kasus_2019 + ' Kasus / Tahun '
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 1, 3],
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

    }else if(data2.checked){
      info.update = function (props) {
        this._div.innerHTML = '<h4>Rata-Rata Banyaknya IRT di Kabupaten Bandung <br/>pada Tahun 2019 dengan 2020</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_IRT + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {        
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 25054, 29929],
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
    }else if(data3.checked){
      info.update = function (props) { 
        this._div.innerHTML = '<h4>Rata-Rata Banyaknya Perempuan yang Bekerja <br/> di Kabupaten Bandung pada Tahun 2019 dengan 2020</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_Perempuan_Bekerja + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 5252,7075],
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
    }else if(data4.checked){
      info.update = function (props) { 
        this._div.innerHTML = '<h4>Rata-Rata Banyaknya Pernikahan Dini <br/>di Kabupaten Bandung pada Tahun 2019 dengan 2020</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_Pernikahan_Dini + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0,  3, 27],
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
    }
  }
  
  // get color depending on population density value
  function getColor(d) {
    var data1 = document.getElementById("jumlah_kasus");
    var data2 = document.getElementById('IRT');
    var data3 = document.getElementById('perempuan_bekerja');
    var data4 = document.getElementById('pernikahan_dini');

    if(data1.checked){
      return d > 3 ? '#800026' :
          // d > 6  ? '#FC4E2A' :
          d > 1   ? '#FC4E2A' :
                '#FFEDA0';
    }else if(data2.checked){
      return d > 29929 ? '#800026' :
          d > 25054  ? '#FC4E2A' :
                '#FFEDA0';
    }else if(data3.checked){
      return d > 7075 ? '#800026' :
          d > 5252  ? '#FC4E2A' :
                '#FFEDA0';
    }else if(data4.checked){
      return d > 27 ? '#800026' :
          d > 3  ? '#FC4E2A' :
                '#FFEDA0';
    }
  }

  function style(feature) {
    var data1 = document.getElementById("jumlah_kasus");
    var data2 = document.getElementById('IRT');
    var data3 = document.getElementById('perempuan_bekerja');
    var data4 = document.getElementById('pernikahan_dini');

    if(data1.checked){
      return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.Jumlah_kasus_2019)
      };
    }else if(data2.checked){
      return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.Jumlah_IRT)
      };
    }else if(data3.checked){
      return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.Jumlah_Perempuan_Bekerja)
      };
    }else if(data4.checked){
      return {
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7,
        fillColor: getColor(feature.properties.Jumlah_Pernikahan_Dini)

      };
    }

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

  var dataKecamatan = <?php echo json_encode($kecamatan) ?>;

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

 dataKecamatan.forEach(function(itemKecamatan){
    var url = `/geojson/${itemKecamatan.lokasi_kecamatan}`;
    // console.log(url)
    geojson = new L.GeoJSON.AJAX(url, {
        style: style, 
        onEachFeature: onEachFeature
    }).addTo(map);
  });

  map.attributionControl.addAttribution('Data diambil dari Pemda Kabupaten Bandung dan Kemenag Kabupaten Bandung');





</script>
@endsection
