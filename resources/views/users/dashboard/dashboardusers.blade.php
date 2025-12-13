<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand">📚 Dashboard User</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
        <p>Role: <strong>{{ Auth::user()->role }}</strong></p>
        <p>Email: <strong>{{ Auth::user()->email }}</strong></p>
        
        <div class="alert alert-info">
            <strong>Info:</strong> Ini adalah dashboard untuk user biasa. Admin memiliki dashboard terpisah di /admin/dashboard
        </div>
    </div>
</body>
</html>