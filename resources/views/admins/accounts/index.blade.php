{{-- Để kế thừa lại master layout ta sử dụng extends --}}
@extends('layouts.admin')
{{-- Một file chỉ được kế thừa 1 master layout --}}

@section('title')
    Quản lý tài khoản
@endsection

@section('CSS')

@endsection

{{-- @section: dùng để chị định phần nội dụng được hiển thị --}}
@section('content')
<?php  if(isset($_COOKIE['name'])) {
    $username = $_COOKIE['name'];
    echo "Username: " . $username;
}else{
    echo "Không có gì";
} ?>
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                    <h4 class="mb-sm-0">Quản lý tài khoản</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{route('users.index') }}">Admin</a></li>
                            <li class="breadcrumb-item active">Danh sách tài khoản</li>
                        </ol>
                    </div>
                </div>
                <form action="{{ route('users.search') }}" method="get" class="col-3" onsubmit="return validateSearch()">
                    @csrf
                    <div class="mt-3">
                        <input class="form-control @error('error')  @enderror" style="border:1px solid" type="text"
                        placeholder="Tìm kiếm" name="key" value="{{ isset($key) ? $key : '' }}" id="search">
                        <input class="btn btn-success btn-sm mt-3" type="submit" >
                    </div>
                    @if(isset($error))
                        <p class="text-danger">{{ $error }}</p>
                    @endif
                </form>

        </div>
        <!-- end page title -->

        <!-- Success Alert -->
        @if(session('success') )
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>  {{ session('success') }} </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Danger Alert -->
        @if(session('error') )
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>  {{ session('error') }} </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Danh sách tài khoản</h4>
                            <a href="{{ route('users.create') }}" class="btn btn-soft-success material-shadow-none">
                                <i class="ri-add-circle-line align-middle me-1"></i>
                                Thêm tài khoản
                            </a>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="table-responsive">
                                    <table class="table table-striped table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">STT</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">email</th>
                                                <th scope="col">role</th>
                                                <th scope="col">created_at</th>
                                                <th scope="col">updated_at</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $product = isset($search) ? $search : $listSanPham ;
                                                // dd($product);
                                            ?>
                                                @if(!empty($product))
                                                @foreach($product as $index => $item)
                                            <tr>
                                                <td scope="col">{{ ++$index }}</td>
                                                <td scope="col">{{ $item->name }}</td>
                                                <td scope="col">{{ $item->email }}</td>
                                                <td scope="col">{{ $item->role }}</td>
                                                <td scope="col">{{ $item->created_at }}</td>
                                                <td scope="col">{{ $item->updated_at }}</td>
                                                <td scope="col">Action</td>
                                                <td>
                                                    {{-- <a href="{{ route('users.show',$item->id) }}" class="btn btn-primary btn-sm">Xem</a> --}}
                                                    <form action="{{ route('users.destroy',$item->id) }}" method="POST"
                                                        class="d-inline" onclick="return confirm('Bạn có muốn xóa không?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm ">Xóa Mềm</button>
                                                    </form>
                                                    {{-- <a href="{{ route('users.edit',$item->id) }}" class="btn btn-secondary btn-sm">Sửa</a> --}}
                                                </td>
                                            </tr>
                                                @endforeach


                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        {{ $product->links("pagination::bootstrap-5") }}
                                    </div>

                                    @endif


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
{{-- <script src="{{ asset('assets/admins/js/search.js') }}"></script> --}}
@endsection
