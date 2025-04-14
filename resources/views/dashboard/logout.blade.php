@extends('dashboard.master')

@section('site-title')
Logout
@endsection

@section('page-main-title')
Logout
@endsection

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-12">
            <!-- File input -->
            <form action="/submit/logout" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <p>Are you sure you want to logout?</p>
                        <div class="mb-3">
                            <input type="submit" class="btn btn-danger" value="Logout">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection