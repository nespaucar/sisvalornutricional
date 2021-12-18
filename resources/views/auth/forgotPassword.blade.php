@include('auth.header')
<div class="wrapper-page">
    <div class="card-box">
        <div class="text-center">
            <img style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));" class="img img-responsive" src="{{ asset('assets/images/logo.png') }}" alt="">
            <a class="logo-lg" style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));"><i class="md md-equalizer"></i> <span>Restablecer Contraseña</span></a>
        </div>
        <div class="panel-body">
            <div id="notificaciones" class="alert hide">
                <strong id="wordNotifications"></strong>
            </div>
            <form id="formSend" class="form-horizontal" role="form" onsubmit="return false;">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-md-12">
                        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Correo Electrónico" autofocus maxlength="120">
                        <i class="md md-mail form-control-feedback l-h-34"></i>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group" style="text-align: center">
                    <div class="col-md-12">
                        <a href="{{ url('/login') }}" class="btn btn-warning btn-custom w-md waves-effect waves-light">
                            <i class="fa fa-arrow-left"></i> Retornar
                        </a>
                        <button class="btn btn-primary btn-custom w-md waves-effect waves-light" onclick="sendData();">
                            <i class="fa fa-save"></i> Restablecer Contraseña
                        </button>                        
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('auth.footer')
<script>
    function sendData() {
        $.ajax({
            url: 'recuperarPassword',
            data: $('#formSend').serialize(),
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function() {
                $('#wordNotifications').html('Cargando');
                $('#notificaciones')
                    .removeClass('alert-danger')
                    .removeClass('alert-success')
                    .removeClass('hide');
            },
            success: function(e) {
                if(e === 'OK') {
                    $('#wordNotifications').html('Tu contraseña ha sido enviada a tu correo, revisa tu bandeja de entrada o spam.');
                    $('#notificaciones')
                        .removeClass('alert-danger')
                        .addClass('alert-success')
                        .removeClass('hide');
                } else {
                    $('#wordNotifications').html(e);
                    $('#notificaciones')
                        .removeClass('alert-success')
                        .addClass('alert-danger')
                        .removeClass('hide');
                }
            },
            error: function() {
                $('#wordNotifications').html('Ocurrió un error desconocido, vuelve a intentar');
                $('#notificaciones')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .removeClass('hide');
            }
        });
    }
</script>