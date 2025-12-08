<!DOCTYPE html>
<html>
<head>
    <title>Login UMKM</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5 col-4">

    <h3 class="text-center mb-4">Login</h3>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-3">
            <label>Username</label>
            <input class="form-control" name="username">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control" name="kata_sandi">
        </div>

        <button class="btn btn-primary w-100">Login</button>
    </form>
</div>

</body>
</html>
