<!DOCTYPE html>
<html lang="id">
<head>
@section('title', 'Lupa Password')
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
                                        <h1 class="h4 text-gray-900 mb-2">Lupa Password?</h1>
                                        <p class="mb-4">Masukkan email Anda untuk melanjutkan reset password</p>
                                    </div>

                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('password.email') }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control form-control-user @error('email') is-invalid @enderror" 
                                                   placeholder="Masukkan Alamat Email..."
                                                   value="{{ old('email') }}"
                                                   required />
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-search"></i> Lanjutkan
                                        </button>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Kembali ke Login</a>
                                    </div>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Buat Akun Baru!</a>
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