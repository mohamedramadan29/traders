<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="website_logo">
            <a class="navbar-brand" href="{{ url('/') }}"> <img src="{{ asset('assets/uploads/logo.png') }}"
                    alt=""> </a>
        </div>
        <div class="nav_buttons">
            <a class="login" href="{{ url('login') }}"> تسجيل دخول </a>
            <a class="register" href="{{ route('user_register') }}"> حساب جديد </a>
        </div>
        {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}"> الرئيسية </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('user_login') }}"> تسجيل دخول </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('user_register') }}">حساب جديد </a>
                </li>

            </ul>

        </div> --}}
    </div>
</nav>
