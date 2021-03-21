@extends('layouts.default')
@section('title','Home')

@section('styles')
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 30%;
  }
  </style>
@endsection

@section('content')
{{-- masukin html nya disini --}}
<div id="home" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#home" data-slide-to="0" class="active"></li>
    <li data-target="#home" data-slide-to="1"></li>
    <li data-target="#home" data-slide-to="2"></li>
    <li data-target="#home" data-slide-to="3"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/a.png" alt="Penjelasan SIG KTP">
    </div>
    <div class="carousel-item">
      <img src="img/b.png" alt="Penjelasan dari Kekerasan">
    </div>
    <div class="carousel-item">
      <img src="img/c.png" alt="Kategori Kekerasan">
    </div>
    <div class="carousel-item">
      <img src="img/d.png" alt="Stop Kekerasan">
    </div>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#home" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#home" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
<div class="container mt-5">
	<div class="mt-5">
      <h3 class="font2 fitur">Cara Menggunakan Website</h3>
			<h5 class="font2 submenu mt-5">Fitur Visualisasi Data</h5>
      <p class="font2 bodyy">Fitur visualisasi data merupakan fitur yang menampilkan pemetaan data kekerasan terhadap perempuan dan faktor-faktor yang mempengaruhi kekerasan tersebut. Cara menggunakan fitur ini tinggal memilih menu yang akan ditampilkan, apakah mau jumlah kekerasan atau faktor-faktor yang mempengaruhinya. </p>
      <h5 class="font2 submenu mt-5">Fitur Prediksi Data</h5>
      <p class="font2 bodyy">Fitur prediksi data merupakan fitur utama dari SIG KTP. Pada fitur ini user dapat memprediksi dan menampilkan hasil prediksi jumlah kasus kekerasan di Kabupaten Bandung. Dengan langkah-langkah sebagai berikut</p>
      <ol class="font2 bodyy">
        <li>Klik button input</li>
        <li>Masukkan data sesuai kebutuhan (dapat 1 kabupaten langsung, atau hanya 1 kecamatan)</li>
        <li>Klik button save</li>
        <li>Klik button prediksi</li>
        <li>Tunggu hasil prediksi</li>
      </ol>
			
		</div>
</div>

@endsection


@section('scripts')

@endsection
