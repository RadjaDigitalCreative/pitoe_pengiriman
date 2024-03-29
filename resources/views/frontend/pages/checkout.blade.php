@extends('frontend.layouts.master')

@section('title','Halaman Checkout')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{route('cart.order')}}">
                @csrf
                <div class="row">
                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Lakukan Pembayaran Anda Di Sini</h2>
                            <p>Silahkan daftar untuk checkout lebih cepat</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nama Depan <span>*</span></label>
                                        <input type="text" name="first_name" placeholder=""
                                               value="{{old('first_name')}}" value="{{old('first_name')}}">
                                        @error('first_name')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nama Belakang <span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{old('lat_name')}}">
                                        @error('last_name')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Alamat Email <span>*</span></label>
                                        <input type="email" name="email" placeholder="" value="{{old('email')}}">
                                        @error('email')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Nomor Handphone <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" required
                                               value="{{old('phone')}}">
                                        @error('phone')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Kota / Kabupaten<span>*</span></label>
                                        <select  class="form-control theSelect" name='provinsi' id='provinsi'>";
                                            <option>Pilih Kota</option>
                                            <?php
                                            for ($i = 0; $i < count($get['rajaongkir']['results']); $i++):
                                            ?>
                                            <option
                                                value="<?php echo $get['rajaongkir']['results'][$i]['city_id']; ?>"><?php echo $get['rajaongkir']['results'][$i]['city_name']; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Alamat Detail</label>
                                        <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                        @error('address1')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <select class="form-control theSelect" id="kabupaten" name="kabupaten">
                                        </select> <br>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>KodePOS</label>
                                        <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                        @error('post_code')
                                        <span class='text-danger'>{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Total Keranjang Belanja</h2>
                                <div class="content">
                                    <ul>
                                        @php
                                            function rupiah($m)
                                            {
                                              $rupiah = "Rp ".number_format($m,0,",",".");
                                              return $rupiah;
                                            }
                                        @endphp
                                        <li class="order_subtotal">Dikirim Dari
                                            <span>{{ Helper::getOrigin(),2 }}</span></li>
                                        <input type="hidden" value="{{ Helper::getOriginID(),2 }}" id="dari" name="dari">
                                        <li class="order_subtotal">Berat Barang
                                            <span>{{ Helper::getWeight(),2 }} Gram</span></li>
                                        <input type="hidden" value="{{ Helper::getWeight(),2 }}" id="weight" name="weight">
                                        <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Keranjang
                                            Subtotal
                                            <span>{{rupiah(Helper::totalCartPrice(),2)}}</span></li>
                                        <li class="shipping">
                                            Biaya Pengiriman <br><br>

                                            @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                                <select  id="kurir" name="shipping" class="form-control ">
                                                    <option value="">Pilih Kurir</option>
                                                    <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                                    <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                                                    <option value="pos">Pos Indonesia</option>
                                                    <option value="lion">Lion Parcel</option>
                                                    <option value="ninja">Ninja Xpress</option>
                                                    <option value="ide">ID Express</option>
                                                    <option value="sicepat">SiCepat Express</option>
                                                    <option value="sap">SAP Express</option>
                                                    <option value="ncs">Nusantara Card Semesta</option>
                                                    <option value="anteraja">AnterAja (ANTERAJA)</option>
                                                    <option value="rex">Royal Express Indonesia</option>
                                                    <option value="sentral">Sentral Cargo</option>
                                                    <option value="pandu">Pandu Logistics (PANDU)</option>
                                                    <option value="wahana">Wahana Prestasi Logistik (WAHANA)</option>
                                                    <option value="jnt">J&T Express (J&T)</option>
                                                    <option value="pahala">Pahala Kencana Express (PAHALA)</option>
                                                    <option value="jet">JET Express (JET)</option>
                                                    <option value="slis">Solusi Ekspres (SLIS)</option>
                                                    <option value="expedito">Expedito* (EXPEDITO)</option>
                                                    <option value="dse">21 Express (DSE)</option>
                                                    <option value="first">First Logistics (FIRST)</option>
                                                    <option value="star">Star Cargo (STAR)</option>
                                                    <option value="idl">IDL Cargo (IDL)</option>
                                                </select>

                                                <input type="hidden" id="hasil" value="{{ Helper::totalCartPrice() }}">

                                                {{--                                                <div id="ongkir2"></div>--}}
                                            @else
                                                <span>Bebas Biaya</span>
                                            @endif
                                        </li>

                                        @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{session('coupon')['value']}}">Kamu
                                                Simpan<span>{{rupiah(session('coupon')['value'],2)}}</span></li>
                                        @endif
                                        @php
                                            $total_amount=Helper::totalCartPrice();
                                            if(session('coupon')){
                                                $total_amount=$total_amount-session('coupon')['value'];
                                            }
                                        @endphp

                                        <span id="tampil_ongkir"></span>
                                        @if(session('coupon'))
                                            <li class="last" id="order_total_price">
                                                Total Keranjang<span>{{rupiah($total_amount)}}</span></li>
                                        @else
                                            <li class="last" id="order_total_price">
                                                Total Keranjang<span>{{rupiah($total_amount)}}</span></li>
                                        @endif
                                        <input type="hidden" name="total" id="ongkir3" value="">
                                        <input type="hidden" name="shipping_amount" id="ongkir4" value="">
                                        <input type="hidden" name="courier" id="courier" value="">
                                        <li class="last">
                                            Total Semua<span id="ongkir2"></span></li>
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Pembayaran</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        {{-- <label class="checkbox-inline" for="1"><input name="updates" id="1" type="checkbox"> Check Payments</label> --}}
                                        <form-group>
                                            <input name="payment_method" type="radio" value="cod"> <label> Cash On
                                                Delivery</label><br>
                                            <input name="payment_method" type="radio" value="transfer"> <label> Transfer
                                                Rekening
                                                Bank</label><br>
                                            <input name="payment_method" type="radio" value="paypal"> <label>
                                                PayPal</label>
                                        </form-group>

                                    </div>
                                </div>
                            </div>
                            <!--/ End Order Widget -->
                            <!-- Payment Method Widget -->
                            <div class="single-widget payement">
                                <div class="content">
                                    <img src="{{('backend/img/payment-method.png')}}" alt="#">
                                </div>
                            </div>
                            <!--/ End Payment Method Widget -->
                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn">Proses Ke CheckOut</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--/ End Checkout -->

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

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Buletin</h4>
                            <p> Berlangganan buletin kami dan dapatkan diskon <span>10%</span> untuk pembelian pertama
                                Anda</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Alamat Email" required="" type="email">
                                <button class="btn">Langganan</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        li.shipping {
            display: inline-flex;
            width: 100%;
            font-size: 14px;
        }

        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }

        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }

        .form-select {
            height: 30px;
            width: 100%;
        }

        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 45px;
            padding-right: 40px;
            width: 100%;
        }

        .list li {
            margin-bottom: 0 !important;
        }

        .list li:hover {
            background: #F7941D !important;
            color: white !important;
        }

        .form-select .nice-select::after {
            top: 14px;
        }
    </style>

@endpush

@push('scripts')
    {{--    <script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>--}}
{{--        <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    {{--    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>--}}
    <script>
        $(".theSelect").select2();
        function format_rupiah(nominal) {
            var reverse = nominal.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            return ribuan = ribuan.join('.').split('').reverse().join('');
        }

        $('#provinsi').change(function () {

            var prov = $('#provinsi').val();
            var nama_provinsi = $(this).attr("nama_provinsi");
            $.ajax({
                type: 'GET',
                url: " {{ url('front/ambil-kabupaten') }}",
                data: 'prov_id=' + prov,
                success: function (data) {
                    $("#kabupaten").html(data);
                }
            });
        });

        $('#kurir').change(function () {

            //Mengambil value dari option select provinsi asal, kabupaten, kurir kemudian parameternya dikirim menggunakan ajax
            var kab = $('#kabupaten').val();
            var hasil = $('#hasil').val();
            var kurir = $('#kurir').val();
            var weight = $('#weight').val();
            var dari = $('#dari').val();
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('front/ambil-ongkir') }}",
                data: {'kab_id': kab, 'kurir': kurir, 'hasil': hasil, 'weight': weight,  'dari': dari},
                success: function (data) {
                    //jika data berhasil didapatkan, tampilkan ke dalam element div tampil_ongkir
                    $("#tampil_ongkir").html(data);
                }
            });
        });

    </script>
    <script>
        $(document).ready(function () {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        function showMe(box) {
            var checkbox = document.getElementById('shipping').style.display;
            // alert(checkbox);
            var vis = 'none';
            if (checkbox == "none") {
                vis = 'block';
            }
            if (checkbox == "block") {
                vis = "none";
            }
            document.getElementById(box).style.display = vis;
        }
    </script>
    <script>

        {{--var kurir  = {{}}}--}}

        //        $(document).ready(function () {
        //
        //            $('.shipping select[name=shipping]').change(function () {
        //                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
        //                let subtotal = parseFloat($('.order_subtotal').data('price'));
        //                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
        //                // alert(coupon);
        //                $('#order_total_price span').text('Rp ' + (subtotal + cost - coupon).toFixed(2));
        //            });
        //            console.log(biaya)
        //        });

    </script>

@endpush
