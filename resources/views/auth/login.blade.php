<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Operator JOB</title>
    <link rel="icon" type="image/png"
        href="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>

<body>
    <div class="preloader">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png"
            alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <a href="" class="text-nowrap logo-img d-block px-4 py-9 w-100">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png"
                                class="dark-logo" alt="Logo-Dark" width="40" />
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/48/Insignia_of_the_Indonesian_National_Armed_Forces.svg/1200px-Insignia_of_the_Indonesian_National_Armed_Forces.svg.png"
                                class="light-logo" alt="Logo-light" width="40" />
                        </a>
                        <div class="d-none d-xl-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px);">
                            <img src="images/backgrounds/login-security.svg" alt="" class="img-fluid"
                                width="500">
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">Welcome to Operator Job</h2>
                                <p class=" mb-9">Your Admin Dashboard</p>
                                <form action="{{ route('login.process') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            required>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            required>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input primary" type="checkbox" id="remember"
                                                name="remember">
                                            <label class="form-check-label text-dark" for="remember">
                                                Remember this Device
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign
                                        In</button>
                                </form>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/app.init.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
</body>

</html>
