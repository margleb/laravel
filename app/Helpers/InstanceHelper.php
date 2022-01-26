<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class InstanceHelper
{
    /**
     * Check if the instance has at least one account.
     *
     * @return bool
     */
    public static function hasAtLeastOneAccount(): bool
    {
        return DB::table('accounts')->count() > 0;
    }
}
