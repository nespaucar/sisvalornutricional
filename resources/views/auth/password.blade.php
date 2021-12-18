@include('auth.header')
<div class="wrapper-page">
    <div class="card-box">
        <div class="text-center">
            <img style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));" class="img img-responsive" src="{{ asset('assets/images/logo.png') }}" alt="">
            <a class="logo-lg" style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));"><i class="md md-equalizer"></i> <span>Restablecer Contraseña</span></a>
        </div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
</div>
@include('auth.footer')