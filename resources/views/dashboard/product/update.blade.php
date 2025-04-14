@extends('dashboard.master')
@section('content')

    @section('site-title')
        Admin | Add Post
    @endsection
    @section('page-main-title')
        Add Product
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/submit/updateProduct/" method="post" enctype="multipart/form-data">
                    @csrf
                    @if ($errors-> any())
                        <div class="alert alert-danger" id="alert">
                            <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        @if (Session::has('error'))
                            <div class="alert alert-danger" id="alert">{{ Session::get('error') }}</div>
                        @endif
                        <div class="card-body">
                            <input type="hidden" name="id" value="{{ $show[0] -> id }}">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name"  value="{{ $show[0]->name }}"/>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Quantity</label>
                                    <input class="form-control" type="text" name="qty" value="{{ $show[0]->qty }}" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Regular Price</label>
                                    <input class="form-control" type="number" name="regular_price" value="{{ $show[0]->regular_price }}" />
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Sale Price</label>
                                    <input class="form-control" type="number" name="sale_price" value="{{ $show[0]->sale_price }}"/>
                                </div>
                                @php
                                    //$sizeString = explode(',',$show[0]->size);
                                    $sizeString = json_decode($show[0]->size, true);
                                    $colorString = json_decode($show[0]->color,true);
                                @endphp
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Available Size</label>
                                    <select name="size[]" class="form-control size-color"  multiple="multiple">
                                        <option value="s" {{ in_array('s',$sizeString)? 'selected':'' }}>S</option>
                                        <option value="m" {{ in_array('m',$sizeString)? 'selected':'' }}>M</option>
                                        <option value="l" {{ in_array('l',$sizeString)? 'selected':'' }}>L</option>
                                        <option value="xl" {{ in_array('xl',$sizeString)? 'selected':'' }}>XL</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Available Color</label>
                                    <select name="color[]" class="form-control size-color" multiple="multiple">
                                        <option value="white" {{ in_array('white',$colorString)? 'selected' : '' }} >White</option>
                                        <option value="black" {{ in_array('black',$colorString)? 'selected' : '' }} >Black</option>
                                        <option value="blue" {{ in_array('blue',$colorString)? 'selected' : '' }} >Blue</option>
                                        <option value="red" {{ in_array('red',$colorString)? 'selected' : '' }}>Red</option>
                                        <option value="yellow" {{ in_array('yellow',$colorString)? 'selected' : '' }}>Yellow</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label">Category</label>
                                    <input type="text" value="{{ $show[0]->category_id }}" name="category_id">
                                    <select name="category" class="form-control">
                                        @foreach ($showCate as $cat)
                                            <option value="{{ $cat -> id }}" {{ $cat ->id== $show[0]->category_id ? 'selected' : '' }}> {{ $cat -> name }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="formFile" class="form-label text-danger">Recommend image size ..x.. pixels.</label>
                                    <input class="form-control" type="file" name="thumbnail" />
                                    <input type="text" value="{{$show[0] -> thumbnail  }}" name="oldThumbnail">
                                </div>
                                <div class="mb-3 col-12">
                                    <label for="formFile" class="form-label text-danger">Description</label>
                                    <textarea name="description" class="form-control" cols="30" rows="10">{{ $show[0]->description }}</textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Post" name="submitAddProduct">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
@section('script')
<script>
    @if(Session::has('success'))
      toastr.success("{{ Session::get('success') }}");
    @endif
    $(document).ready(function() {
        $('.size-color').select2();
    });
</script>
@endsection
