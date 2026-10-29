<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 80px;
            background: url("{{ asset('foto sekolah 1.jpg') }}") no-repeat center center;
            background-size: cover;
        }

        .login-navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 77px;
            display: flex;
            align-items: center;
            padding: 0 40px;
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(30px);
            box-shadow: 0 2px 10px rgb(173, 173, 173);
            z-index: 999;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .nav-brand img {
            height: 45px;
            width: auto;
        }

        .nav-brand span {
            color: #fff;
            text-shadow: 0 2px 6px rgba(0,0,0,0.6);
        }

        .login-box {
            width: 360px;
            padding: 50px;
            padding-top: 100px;
            border-radius: 18px;
            background: linear-gradient(135deg, #ffffff39 19%, #0066ffa0 36%, #4bff3bdb 100%);
            box-shadow: 0 15px 40px rgba(0,0,0,.25);
        }

        .login-photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid white;
            margin-top: -60px;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,.2);
        }

        .login-box h3 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 20px;
            color: #003366;
        }

        .login-box input {
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg,#00c6ff,#0072ff);
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
        }

        .login-box button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,.3);
        }

        .text-danger {
            font-size: 13px;
        }
    </style>
</head>
<body>

<nav class="login-navbar">
    <div class="nav-brand">
        <img src="{{ asset('smk.png') }}" alt="Logo Sekolah">
        <span>SMK AL-FALAH NAGREG</span>
    </div>
</nav>

<div class="login-box">
    <div class="text-center mb-3">
        <img src="{{ asset('smk.png') }}" class="login-photo">
    </div>

    <center><h4 class="mb-4">Login Guru</h4></center>

    <form action="{{ route('login.post') }}" method="post">
        @csrf
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
            <button class="btn btn-primary" type="submit">Login</button>
        </div>
    </form>
</div>

</body>
</html>
