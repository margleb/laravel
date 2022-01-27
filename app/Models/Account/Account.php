<?php

namespace App\Models\Account;

use App\Models\User\User;
use App\Services\User\CreateUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_key',
    ];

    public static function createDefault($first_name, $last_name, $email, $password, $ip_address = null, $lang = null) {


        // создаем новый аккаунт
        $account = new self;
        $account->api_key = Str::random(30);
        $account->created_at = now();
        $account->save();

        try {

            // создаем первого пользователя для аккаунта
            app(CreateUser::class)->execute([
                'account_id' => $account->id,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'password' => $password,
                'ip_address' => $ip_address,
                'lang' => $lang
            ]);
        } catch(\Exception $e) {
            $account->delete();
            throw $e;
        }

        // заполняем столбцы по умолчании при создании новой записи
        // $this->populateDefaultFields();

        return $account;
    }

    /**
     * Get the user records associated with the account.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

}
