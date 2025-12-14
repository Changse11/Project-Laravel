<!DOCTYPE html>
<html lang="id">
<head>
@section('title', 'Register')
@include('includes.style')
    <style>
        .bg-register-image {
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
        <div class="card o-hidden border-0 shadow-lg">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
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

                            <form class="user" action="{{ route('register.post') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <input type="text" 
                                           name="name" 
                                           class="form-control form-control-user @error('name') is-invalid @enderror" 
                                           id="exampleName"
                                           placeholder="Nama Lengkap"
                                           value="{{ old('name') }}"
                                           required />
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="email" 
                                           name="email" 
                                           class="form-control form-control-user @error('email') is-invalid @enderror" 
                                           id="exampleInputEmail"
                                           placeholder="Alamat Email"
                                           value="{{ old('email') }}"
                                           required />
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
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
                                    <div class="col-sm-6">
                                        <input type="password" 
                                               name="password_confirmation" 
                                               class="form-control form-control-user" 
                                               id="exampleRepeatPassword"
                                               placeholder="Ulangi Password"
                                               required />
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Daftar Akun
                                </button>
                                
                                <hr />
                            </form>

                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
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