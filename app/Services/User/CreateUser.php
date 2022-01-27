<?php

namespace App\Services\User;
use App\Helpers\RequestHelper;
use App\Models\User\User;
use App\Services\BaseService;
use Illuminate\Support\Facades\App;

class CreateUser extends BaseService
{

    public function rules(): array {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'locale' => 'nullable',
            'ip_address' => 'nullable',
        ];
    }

    public function execute(array $data) {

        // валидируем полученные данные
        $this->validate($data);

        $ipAddress = $data['ip_address'] ?? RequestHelper::ip();

        // создаем пользователя
        $user = $this->createUser($data);
        // выставляем региональные параметры для пользователя
        // $this->setRegionalParameters($user, $ipAddress);
        $user->save();

        // политика конфидициальности

        return $user;
    }

    public function createUser($data) {

        $user = new User();
        $user->account_id = $data['account_id'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->locale = $data['ip_address'] ?? App::getLocale();

        return $user;
    }
}
