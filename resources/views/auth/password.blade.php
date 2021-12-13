@include('auth.header')
<div class="wrapper-page">
    <div class="card-box">
        <div class="text-center">
            <img style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));" class="img img-responsive" src="https://ci3.googleusercontent.com/proxy/VtN6L4u-tLf2JQF0tBC-27G9Qx0sEGPVoeKa8AM9KKFSYN2rdNuDeWcLsacj3H05YaFjEepIH0Q381KTUbiC1_WcaLn-aJOutvOVxcPEnf3VvBjfX0NXqGs7-mNITfk03So9xYdyQRr7rLUpFQJd7nfq=s0-d-e1-ft#https://munisanignacio.gob.pe/wp-content/uploads/2019/12/cropped-cropped-logompsi-1-768x180.png" alt="">
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