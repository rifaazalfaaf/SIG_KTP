@extends('layouts.default')
@section('title','Home')

@section('styles')
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 100%;
    height: 30%;
  }
  /* width */
  </style>
@endsection

@section('content')
<div id="home" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#home" data-slide-to="0" class="active"></li>
    <li data-target="#home" data-slide-to="1"></li>
    <li data-target="#home" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/a.png" alt="Penjelasan SIG KTP">
    </div>
    <div class="carousel-item">
      <img src="img/b.png" alt="Bagian Visualisasi">
    </div>
    <div class="carousel-item">
      <img src="img/c.png" alt="Bagian Prediksi">
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
  <div class="mt-5 mb-5 rounded-lg border p-3" style="box-shadow: 0 0 1px 1px rgba(20,23,28,.1), 0 3px 1px 0 rgba(20,23,28,.1);">
    <h3 class="font2 fitur" align="center">SIG KTP</h3>
    <p class="font2 bodyy" align="center">SIG KTP adalah sebuah website yang dapat memprediksi dan memetakan jumlah kasus kekerasan terhadap perempuan di Kabupaten Bandung, dengan harapan adanya website ini dapat membantu stakeholder dalam menekan banyaknya kasus kekerasan tersebut. Pada proses analisis agar mendapatkan hasil prediksi, terdapat kecamatan yang didiskualifikasi dikarenakan data yang kurang sesuai, sehingga hasil prediksi yang dikeluarkan oleh website ini hanya 19 kecamatan dengan faktor yang dapat di inputkan adalah banyaknya perempuan yang bekerja, ibu rumah tangga, dan pernikahan dini dari setiap kecamatannya. </p>
    <hr>
    <h3 class="font2 fitur" align="center">Kekerasan Terhadap Perempuan</h3>
    <p class="font2 bodyy" align="center">Kekerasan merupakan suatu perbuatan yang mengacu pada kontrol, kekerasan, dan pemaksaan, termasuk perilaku seksual, psikologis, fisik, dan ekonomi yang dilakukan oleh seseorang terhadap orang lain. Kekerasan terhadap perempuan adalah suatu tindakan kekerasan berbasis gender yang biasanya dilakukan oleh laki-laki terhadap perempuan. </p>
  </div>
  <hr>
	<div class="mt-4">
    <h3 class="font2 fitur" align="center">Cara Menggunakan Website</h3>
    <div class="row">
      <div class="col-md-6">
        <h5 class="font2 submenu mt-5">Fitur Visualisasi Data</h5>
        <p class="font2 bodyy">Fitur visualisasi data merupakan fitur yang menampilkan data yang dianalisis oleh peneliti kedalam peta Kabupaten Bandung. Adapun data yang dipetakan yaitu mengenai kekerasan terhadap perempuan dan faktor-faktor yang mempengaruhi kekerasan tersebut. Langkah-langkah untuk menggunakan fitur viasualisasi data adalah sebagai berikut: </p>
        <ol class="font2 bodyy">
          <li>Pilih data yang ingin ditampilkan</li>
          <li>tekan tombol "Pilih Data" data dan legenda</li>
          <li>Kemudian arahkan kursor pada setiap kecamatan untuk melihat data yang lebih detil</li>
          <li>Apabila ingin menampilkan data yang lain, lakukan langkah 1,2 dan 3 lalu arahkan kursor pada peta untuk merubah warna peta tersebut</li>
        </ol>
        <p class="font2 bodyy">Untuk melihat berapa banyak data dapat dilihat pada keterangan di sebelah kanan atas dan kanan bawah peta</p>
      </div>
      <div class="col-md-6">
        <h5 class="font2 submenu mt-5">Fitur Prediksi Data</h5>
        <p class="font2 bodyy">Fitur prediksi data merupakan fitur utama dari SIG KTP. Pada fitur ini user dapat memprediksi dan menampilkan hasil prediksi jumlah kasus kekerasan terhadap perempuan di Kabupaten Bandung. Data yang di Input hanya faktor ibu rumah tangga saja. Langkah-langkah untuk menggunakan fitur prediksi adalah sebagai berikut:</p>
        <ol class="font2 bodyy">
          <li>tekan tombol "Download Template Excel"</li>
          <li>Pada file excel, kolom perempuan_bekerja, ibu_rumah_tangga dan penikahan_dini diisi sesuai dengan data yang anda punya</li>
          <li>Apabila data di excel sudah terisi, tekan tombol "Import Excel"</li>
          <li>Pilih file yang akan di import</li>
          <li>Kemudian tekan "Import"</li>
          <li>tekan "Prediksi Hasil", untuk menampilkan data perkiraan banyaknya kasus kekerasan terhadap perempuan di Kabupaten Bandung</li>
        </ol>
      </div>
    </div>
	</div>
</div>

@endsection


@section('scripts')

@endsection
