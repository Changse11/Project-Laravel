<!DOCTYPE html>
<html lang="id">
<head>
@section('title', 'Reset Password')
@include('includes.style')
    <style>
        body {
            display: flex;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image" style="background: url('{{ asset("assets/img/8364.jpg") }}'); background-position: center; background-size: cover;"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Password</h1>
                                        <p class="mb-4">Masukkan password baru untuk akun Anda</p>
                                    </div>

                                    <div class="alert alert-info">
                                        <i class="fas fa-envelope"></i> Email: <strong>{{ $email }}</strong>
                                    </div>

                                    <form class="user" action="{{ route('password.update') }}" method="POST">
                                        @csrf
                                        
                                        <input type="hidden" name="email" value="{{ $email }}">

                                        <div class="form-group">
                                            <input type="password" 
                                                   name="password" 
                                                   class="form-control form-control-user @error('password') is-invalid @enderror" 
                                                   placeholder="Password Baru"
                                                   required />
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   class="form-control form-control-user" 
                                                   placeholder="Konfirmasi Password Baru"
                                                   required />
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-key"></i> Reset Password
                                        </button>
                                    </form>

                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Kembali ke Login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.scripts')
</body>
</html>