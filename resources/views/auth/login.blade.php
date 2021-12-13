@include('auth.header')
<div class="wrapper-page">
    <div class="card-box">
        <div class="text-center">
            <img style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));" class="img img-responsive" src="https://ci3.googleusercontent.com/proxy/VtN6L4u-tLf2JQF0tBC-27G9Qx0sEGPVoeKa8AM9KKFSYN2rdNuDeWcLsacj3H05YaFjEepIH0Q381KTUbiC1_WcaLn-aJOutvOVxcPEnf3VvBjfX0NXqGs7-mNITfk03So9xYdyQRr7rLUpFQJd7nfq=s0-d-e1-ft#https://munisanignacio.gob.pe/wp-content/uploads/2019/12/cropped-cropped-logompsi-1-768x180.png" alt="">
            <a class="logo-lg" style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));"><i class="md md-equalizer"></i> <span>Sistema de Gestión de Pagos</span> </a>            
        </div>
        <form action="{{ url('/login') }}" method="post" class="form-horizontal m-t-20">
            {{ csrf_field() }}
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="form-group">
                <div class="col-xs-12">
                    <input name="login" class="form-control" type="text" placeholder="Usuario" value="">
                    <i class="md md-account-circle form-control-feedback l-h-34"></i>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input name="password" class="form-control" type="password" placeholder="Contraseña">
                    <i class="md md-vpn-key form-control-feedback l-h-34"></i>
                </div>
            </div>
            <div class="form-group text-right m-t-20">
                <div class="col-xs-12">
                    <button class="btn btn-primary btn-custom w-md waves-effect waves-light" type="submit">Ingresar
                    </button>
                </div>
            </div>
            <div class="form-group m-t-30">
                <div class="col-sm-7">
                    <a href="{{ url('/password/reset') }}" class="text-muted"><i class="fa fa-lock m-r-5"></i> ¿Olvidó su contraseña?</a>
                </div>
            </div>
        </form>
    </div>
</div>
@include('auth.footer')