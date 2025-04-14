@extends('dashboard.master')
@section('content')
    @section('site-title')
        Admin | Update Post
    @endsection
    @section('page-main-title')
        Update Category
    @endsection

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-xl-12">
                <!-- File input -->
                <form action="/submit/updateCategory/" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        @if (Session::has('success'))
                            <div class="alert alert-success" id="alert">{{ Session::get('success') }}</div>
                        @endif

                        @if ($errors -> any())
                          <div class="alert alert-danger" id="alert">
                            <ul>
                                <li>{{ $errors }}</li>
                            </ul>
                          </div>
                        @endif
                        <div class="card-body">

                            <div class="row">
                                <div class="mb-3 col-12">
                                    <input type="hidden" name="id" value="{{ $update[0]->id }}">
                                    <p>Old category name:</p>
                                    <p>{{ $update[0] -> name }}</p>
                                    <label for="formFile" class="form-label text-danger">Update category:</label>
                                    <input class="form-control" type="text" name="category_name" placeholder="Category_name"/>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="submit" class="btn btn-primary" value="Add Post">
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
