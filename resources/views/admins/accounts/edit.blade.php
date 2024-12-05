{{-- Để kế thừa lại master layout ta sử dụng extends --}}
@extends('layouts.admin')
{{-- Một file chỉ được kế thừa 1 master layout --}}

@section('title')
    Quản lý Account
@endsection

@section('CSS')
@endsection

{{-- @section: dùng để chị định phần nội dụng được hiển thị --}}
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Quản lý Account</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                            <li class="breadcrumb-item active">Update Account</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Update Account</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('users.update',$itemId->id) }}" method="POST" enctype="multipart/form-data">
                                    {{-- khi sử dụng form trong laravel bắt buộc phải có form @csrf  --}}
                                    @csrf
                                    @method('PUT')
                                    <div class="row gy-4">
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <label for="ten_nhan_vien" class="form-label">Tên tài khoản</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    name="name" id="name" placeholder="Nhập tên Account"
                                                    value="{{ $itemId->name }}">
                                                @error('name')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mt-3">
                                                <label for="email"
                                                    class="form-label">Email: </label>
                                                <input type="email" step="0.01" class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" placeholder="Email"
                                                    value="{{ $itemId->email }}" >
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>


                                            <div class="mt-3">
                                                <label for="password"
                                                    class="form-label">Password:</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                                    id="password" value="{{ $itemId->password }}" placeholder="Password">
                                                @error('password')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="mt-3">
                                                    <label for="role"
                                                        class="form-label @error('role') is-invalid @enderror">Role</label>
                                                    <input type="text" class="form-control" name="role"
                                                        id="role" value="admin" readonly>
                                                    @error('role')
                                                        <p class="text-danger">{{ $message }}</p>
                                                    @enderror
                                                </div>


                                                <div class="mt-3 text-center">
                                                    <button class="btn btn-primary" type="submit">Update</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                                <!--end col-->
                            </div>
                        </div>

                    </div><!-- end card-body -->
                </div><!-- end card -->

            </div> <!-- end .h-100-->

        </div> <!-- end col -->
    </div>

    </div>
@endsection

@section('JS')
    <script src="https:////cdn.ckeditor.com/4.8.0/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('mo_ta');
    </script>
@endsection
