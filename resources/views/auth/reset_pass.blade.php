@extends('layouts.auth')

@section('title')
    Reset
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">
                <div>
                    <a href="index.html" class="d-inline-block auth-logo">
                        <img src="{{asset('assets/admins/images/logo-light.png')}}" alt="" height="20">
                    </a>
                </div>
                <p class="mt-3 fs-15 fw-medium">Premium Admin & Dashboard Template</p>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4 card-bg-fill">

                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Welcome Back !</h5>
                        <p class="text-muted">Reset to continue to Velzon.</p>
                    </div>
                    <div class="p-2 mt-4">
                        <form action="{{ route('restore.getTokenOfPass',$token) }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input" placeholder="Enter password"
                                    id="password-input" name="password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="confirm_password-input">Confirm Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="confirm_password" class="form-control pe-5 password-input" placeholder="Enter password"
                                    id="confirm_password-input" name="confirm_password">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                                @error('confirm_password')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>


                            @error('error')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror

                            <div class="mt-4">
                                <button class="btn btn-success w-100" type="submit">Reset</button>
                            </div>

                            {{-- <div class="mt-4 text-center">
                                <div class="signin-other-title">
                                    <h5 class="fs-13 mb-4 title">Reset with</h5>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                    <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                </div>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->

            <div class="mt-4 text-center">
                <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}" class="fw-semibold text-primary text-decoration-underline"> Signup </a> </p>
            </div>

        </div>
    </div>
    <!-- end row -->
</div>
@endsection
