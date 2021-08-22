
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
    var data1 = document.getElementById('jumlah_kasus');
    var data2 = document.getElementById('IRT');
    var data3 = document.getElementById('perempuan_bekerja');
    var data4 = document.getElementById('pernikahan_dini');

    if(data1.checked){
    // console.log(data1.checked)
      info.update = function (props) {
        this._div.innerHTML = '<h4>Banyaknya Kasus KTP di Kabupaten Bandung </br> pada Tahun 2019</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_kasus_2019 + ' Kasus / Tahun '
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 2, 3],
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
        this._div.innerHTML = '<h4>Banyaknya IRT di Kabupaten Bandung pada Tahun 2019</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_IRT + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {        
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 24670, 29464],
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
        this._div.innerHTML = '<h4>Banyaknya Perempuan yang Bekerja <br/> di Kabupaten Bandung pada Tahun 2019</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_Perempuan_Bekerja + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 4943,6668],
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
        this._div.innerHTML = '<h4>Banyaknya Pernikahan Dini di Kabupaten Bandung </br> pada Tahun 2019</h4>' +  (props ?
          '<b>' + props.WADMKC + '</b><br />' + props.Jumlah_Pernikahan_Dini + ' Orang / Tahun'
          : 'Dekatkan kursor ke kecamatan tertentu untuk melihat informasi lebih detail');
      };
      info.addTo(map); 

      legend.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'info legend'),
        grades = [0,  4, 15],
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
             d > 2 ? '#FC4E2A' :
                     '#FFEDA0';
    }else if(data2.checked){
      return d > 29464 ? '#800026' :
             d > 24670 ? '#FC4E2A' :
                         '#FFEDA0';
    }else if(data3.checked){
      return d > 6668 ? '#800026' :
             d > 4943 ? '#FC4E2A' :
                        '#FFEDA0';
    }else if(data4.checked){
      return d > 15 ? '#800026' :
             d > 4  ? '#FC4E2A' :
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




