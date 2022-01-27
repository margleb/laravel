<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\InstanceHelper;
use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginOrRegister()
    {
        $hasNotAccount = !InstanceHelper::hasAtLeastOneAccount();

        // если нет ни одного аккаунта
        if($hasNotAccount) {
            // показываем страницу регистрации
            return redirect()->route('register');
        }
        // иначе страницу логина
        return $this->showLoginForm();

    }
}
