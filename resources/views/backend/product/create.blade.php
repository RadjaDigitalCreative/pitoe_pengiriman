@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Product</h5>
        <div class="card-body">
            <form method="post" action="{{route('product.store')}}">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{old('title')}}"
                           class="form-control">
                    @error('title')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="summary">{{old('summary')}}</textarea>
                    @error('summary')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control"  name="description">{{old('description')}}</textarea>
                    @error('description')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="is_featured">Is Featured</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
                </div>
                {{-- {{$categories}} --}}

                <div class="form-group">
                    <label for="cat_id">Category <span class="text-danger">*</span></label>
                    <select name="cat_id" id="cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                        @foreach($categories as $key=>$cat_data)
                            <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                        {{-- @foreach($parent_cats as $key=>$parent_cat)
                            <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
                        @endforeach --}}
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Price(Rp. ) <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Enter price" value="{{old('price')}}"
                           class="form-control">
                    @error('price')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Discount(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"
                           value="{{old('discount')}}" class="form-control">
                    @error('discount')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size[]" class="form-control" data-live-search="true">
                        <option value="">--Select any size--</option>
                        <option value="S">Small (S)</option>
                        <option value="M">Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="brand_id">Brand</label>
                    {{-- {{$brands}} --}}

                    <select name="brand_id" class="form-control">
                        <option value="">--Select Brand--</option>
                        @foreach($brands as $brand)
                            <option value="{{$brand->id}}">{{$brand->title}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select name="condition" class="form-control">
                        <option value="">--Select Condition--</option>
                        <option value="default">Default</option>
                        <option value="new">New</option>
                        <option value="hot">Hot</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="weight">Weight <span class="text-danger">*</span></label>
                    <input id="weight" type="number" name="weight" min="0" placeholder="Enter weight ( Gram )"
                           value="{{old('weight')}}" class="form-control">
                    @error('weight')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock">Quantity <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"
                           value="{{old('stock')}}" class="form-control">
                    @error('stock')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Choose
                  </a>
              </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="condition">Delivery Location</label>
                    <select class="form-control" name='provinsi' id='provinsi'>";
                        <option>Choose Province</option>
                        <?php
                        for ($i = 0; $i < count($get['rajaongkir']['results']); $i++):
                        ?>
                        <option
                            value="<?php echo $get['rajaongkir']['results'][$i]['province_id']; ?>"><?php echo $get['rajaongkir']['results'][$i]['province']; ?></option>
                        <?php endfor; ?>
                    </select><br>
                    <label>Districts </label><br>
                    <select class="form-control " id="kabupaten" name="location_id">
                    </select> <br>
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        $('#provinsi').change(function () {

            //Mengambil value dari option select provinsi kemudian parameternya dikirim menggunakan ajax
            var prov = $('#provinsi').val();
            var nama_provinsi = $(this).attr("nama_provinsi");
            $.ajax({
                type: 'GET',
                url: " {{ url('admin/product/ambil-kabupaten') }}",
                data: 'prov_id=' + prov,
                success: function (data) {
                    //jika data berhasil didapatkan, tampilkan ke dalam option select kabupaten
                    $("#kabupaten").html(data);
                }
            });
        });

        $('#kurir').change(function () {

            //Mengambil value dari option select provinsi asal, kabupaten, kurir kemudian parameternya dikirim menggunakan ajax
            var kab = $('#kabupaten').val();
            var kurir = $('#kurir').val();

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url('admin/product/ambil-ongkir') }}",
                data: {'kab_id': kab, 'kurir': kurir},
                success: function (data) {
                    //jika data berhasil didapatkan, tampilkan ke dalam element div tampil_ongkir
                    $("#tampil_ongkir").html(data);
                }
            });
        });
    </script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function () {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function () {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();

    </script>

    <script>
        $('#cat_id').change(function () {
            var cat_id = $(this).val();
            // alert(cat_id);
            if (cat_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{csrf_token()}}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function (response) {
                        if (typeof (response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            // alert(data);
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function (id, title) {
                                    html_option += "<option value='" + id + "'>" + title + "</option>"
                                });
                            } else {
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            } else {
            }
        })
    </script>
@endpush
