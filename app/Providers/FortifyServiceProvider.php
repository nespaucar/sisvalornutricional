<?php

namespace App\Providers;

use App\Models\Bitacora;
use App\Models\Usuario;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->login.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function() {
            return view('auth.login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = Usuario::where('login', $request->login)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                $bitacoraant = Bitacora::where('descripcion', '=', 'Se INICIA SESIÓN el ' . $user->usertype->nombre . ' ' . $user->persona->nombres . ' a las ' . date('H:i:s') . ' del ' . date('d/m/Y'))->first();
                if($bitacoraant === NULL) {
                    $bitacora = new Bitacora();
                    $bitacora->fecha = date('Y-m-d');
                    $bitacora->descripcion = 'Se INICIA SESIÓN el ' . $user->usertype->nombre . ' ' . $user->persona->nombres . ' a las ' . date('H:i:s') . ' del ' . date('d/m/Y');
                    $bitacora->tabla = 'SESIÓN';
                    $bitacora->tabla_id = $user->id;
                    $bitacora->usuario_id = $user->id;
                    $bitacora->save();
                }                    
                return $user;
            }
        });
    }
}
