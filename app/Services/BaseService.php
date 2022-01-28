<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

abstract class BaseService
{

    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Validate all datas to execute the service.
     *
     * @param  array  $data
     * @return bool
     */
    public function validate(array $data): bool {
        Validator::make($data, $this->rules())->validate();
        return true;
    }

    /**
     * Checks if the value is empty or null.
     *
     * @param  mixed  $data
     * @param  mixed  $index
     * @return mixed
     */
    public function nullOrValue($data, $index)
    {
        $value = Arr::get($data, $index, null);

        return is_null($value) || $value === '' ? null : $value;
    }

}
