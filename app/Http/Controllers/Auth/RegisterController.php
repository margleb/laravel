<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\InstanceHelper;
use App\Helpers\RequestHelper;
use App\Http\Controllers\Controller;
use App\Models\Account\Account;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // валидириуем имя/фамилию/email/пароль/политику конфидициальности
        return Validator::make($data, [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', PasswordRules::default()],
            'policy' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User\User
     */
    protected function create(array $data)
    {

        $hasNotAccount = !InstanceHelper::hasAtLeastOneAccount();

        // прерываем код, если запрещена регистрация, либо нет ни одного аккаунта
        if(!$hasNotAccount && config('monica.disable_signup') == 'true') {
            abort(403, trans('auth.disabled_signup'));
        }

        try {

            // создаем новый аккаунт
            $account = Account::createDefault(
                $data['first_name'],
                $data['last_name'],
                $data['email'],
                $data['password'],
                RequestHelper::ip(),
                $data['lang']
            );

            $user = $account->users()->first();

            // если не можем получить аккаунт то отправляем об этом сообщение
            // if($user) {}

            return $user;

        } catch(\Exception $e) {
            Log::error($e);
            abort(500, trans('auth.signup_error'));
        }

    }
}
