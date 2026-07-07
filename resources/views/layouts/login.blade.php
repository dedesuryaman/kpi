<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KPI Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
            background: #020617;
        }

        .bg-animation {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(59, 130, 246, .15);
            animation: float 20s infinite linear;
        }

        .circle:nth-child(1) {
            width: 250px;
            height: 250px;
            left: 10%;
            top: 20%;
        }

        .circle:nth-child(2) {
            width: 350px;
            height: 350px;
            right: 10%;
            top: 15%;
            animation-duration: 25s;
        }

        .circle:nth-child(3) {
            width: 180px;
            height: 180px;
            left: 40%;
            bottom: 10%;
            animation-duration: 15s;
        }

        @keyframes float {
            from {
                transform: rotate(0deg) translateX(30px) rotate(0deg);
            }

            to {
                transform: rotate(360deg) translateX(30px) rotate(-360deg);
            }
        }

        .login-container {
            position: relative;
            z-index: 2;
            min-height: 100vh;
        }

        .left-panel {
            color: white;
            padding: 80px;
        }

        .brand {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .brand-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            /*background: linear-gradient(135deg, #2563eb, #06b6d4);*/
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-right: 20px;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 700;
        }

        .hero-title {
            font-size: 56px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 25px;
        }

        .hero-text {
            color: #cbd5e1;
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 50px;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .feature i {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, .1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 30px;
            padding: 45px;
            color: white;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .4);
        }

        .login-card h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-card p {
            color: #94a3b8;
        }

        .form-control {
            height: 58px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            color: white;
            border-radius: 15px;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, .1);
            color: white;
            box-shadow: none;
            border-color: #3b82f6;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .input-group-text {
            background: rgba(255, 255, 255, .08);
            color: white;
            border: 1px solid rgba(255, 255, 255, .15);
            cursor: pointer;
        }

        .btn-login {
            height: 58px;
            border-radius: 15px;
            font-weight: 600;
            background: linear-gradient(135deg,
                    #2563eb,
                    #06b6d4);
            border: none;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .copyright {
            color: #94a3b8;
            font-size: 14px;
        }

        @media(max-width:992px) {
            .left-panel {
                display: none;
            }

            .login-card {
                margin: 20px;
            }
        }

        .form-select {
            height: 58px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .15);
            color: white;
            border-radius: 15px;
        }

        .form-select:focus {
            background: rgba(255, 255, 255, .10);
            color: white;
            border-color: #3b82f6;
            box-shadow: none;
        }

        .form-select option {
            background: #0f172a;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="bg-animation">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>

    <div class="container-fluid login-container">

        <div class="row min-vh-100">

            <div class="col-lg-7 d-flex align-items-center">

                <div class="left-panel">

                    <div class="brand">
                        <div class="brand-icon">
                            <img src="{{ asset('assets/images/Logomk-white.png') }}" height="60" class="me-3">
                        </div>

                        <div class="brand-title">
                            PT. Makerindo Prima Solusi
                        </div>
                    </div>

                    <h1 class="hero-title">
                        Employee Performance Intelligence Platform
                    </h1>

                    <p class="hero-text">
                        Integrated KPI Management System with
                        Artificial Bee Colony Optimization,
                        Markov Decision Process Analysis,
                        Reward & Punishment Simulation,
                        and Executive Dashboard Reporting.
                    </p>

                    <div class="feature">
                        <i class="fas fa-chart-pie"></i>
                        <span>Real-Time KPI Dashboard</span>
                    </div>

                    <div class="feature">
                        <i class="fas fa-users"></i>
                        <span>Employee Performance Monitoring</span>
                    </div>

                    <div class="feature">
                        <i class="fas fa-brain"></i>
                        <span>ABC Optimization Engine</span>
                    </div>

                    <div class="feature">
                        <i class="fas fa-project-diagram"></i>
                        <span>MDP Decision Support System</span>
                    </div>

                </div>

            </div>

            <div class="col-lg-5 d-flex justify-content-center align-items-center">

                <div class="login-card">

                    <div class="text-center mb-4">
                        <h2>Welcome Back</h2>
                        <p>Sign in to your account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Role --}}


                        {{-- Email --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Email
                            </label>

                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="name@company.com" required>

                            @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Password --}}
                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <div class="input-group">

                                <input type="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password" required>

                                <span class="input-group-text" onclick="togglePassword()">
                                    <i class="fa-solid fa-eye"></i>
                                </span>

                            </div>

                            @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        <div class="d-flex justify-content-between mb-4">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember">

                                <label class="form-check-label">
                                    Remember Me
                                </label>
                            </div>

                            <a href="#" class="text-info text-decoration-none d-none">
                                Forgot Password?
                            </a>

                        </div>

                        <button type="submit" class="btn btn-primary btn-login w-100">
                            <i class="fas fa-right-to-bracket me-2"></i>
                            Sign In
                        </button>

                    </form>

                    <hr class="my-4 text-secondary">

                    <div class="text-center copyright">
                        © {{ date('Y') }} KPI Management System
                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {

    const password =
        document.getElementById('password');

    if(password.type === 'password')
        password.type = 'text';
    else
        password.type = 'password';
}

    </script>

</body>

</html>