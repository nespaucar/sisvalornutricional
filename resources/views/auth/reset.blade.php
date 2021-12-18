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

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" placeholder="Correo Electrónico" required autofocus>
                        <i class="md md-mail form-control-feedback l-h-34"></i>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Nueva Contraseña">
                        <i class="md md-vpn-key form-control-feedback l-h-34"></i>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    
                    <div class="col-md-12">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirme Contraseña" required>
                        <i class="md md-vpn-key form-control-feedback l-h-34"></i>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12" style="text-align: center;">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            Restablecer Contraseña
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@include('auth.footer')