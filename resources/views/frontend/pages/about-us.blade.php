@extends('frontend.layouts.master')

@section('title','PitoeStore || Tentang Kami')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Tentang Kami</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- About Us -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <h3>Selamat Datang <span> di PitoeStore</span></h3>
                        <p align="justify">@foreach($settings as $data) {{$data->description}} @endforeach</p>
                        <div class="button">
                            <a href="{{route('blog')}}" class="btn">Blog Kami</a>
                            <a href="{{route('contact')}}" class="btn primary">Kontak Kami</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-img overlay">
                        {{-- <div class="button">
                            <a href="https://www.youtube.com/watch?v=nh2aYrGMrIE" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
                        </div> --}}
                        <img src="@foreach($settings as $data) {{$data->photo}} @endforeach"
                             alt="@foreach($settings as $data) {{$data->photo}} @endforeach">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Us -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Gratis ongkos kirim</h4>
                        <p>Pesanan lebih dari $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Pengembalian Gratis</h4>
                        <p>Dalam 30 hari kembali</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Pembayaran Aman</h4>
                        <p>100% pembayaran aman</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Bagian Terbaik</h4>
                        <p>Harga dijamin</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')
@endsection
