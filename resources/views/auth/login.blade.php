<!DOCTYPE html>
<html lang="id">
<head>
@section('title', 'Login')  
@include('includes.style')
    <style>
        .bg-login-image {
            background: url('{{ asset("assets/img/8364.jpg") }}');
            background-position: center;
            background-size: cover;
        }
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
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                                    </div>

                                    @if(session('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif
                                     
                                    @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <form class="user" action="{{ route('login.post') }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <input type="email" 
                                                   name="email" 
                                                   class="form-control form-control-user @error('email') is-invalid @enderror" 
                                                   id="exampleInputEmail"
                                                   aria-describedby="emailHelp"
                                                   placeholder="Masukkan Alamat Email..."
                                                   value="{{ old('email') }}"
                                                   required />
                                            @error('email')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" 
                                                   name="password" 
                                                   class="form-control form-control-user @error('password') is-invalid @enderror" 
                                                   id="exampleInputPassword"
                                                   placeholder="Password"
                                                   required />
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" 
                                                       name="remember" 
                                                       class="custom-control-input" 
                                                       id="customCheck" />
                                                <label class="custom-control-label" for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <div class="text-center">
                                            <a class="small" href="{{ route('password.request') }}">Lupa Password?</a>
                                        </div>
                                            <hr />
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
    @stack('after-script')
</body>
</html>