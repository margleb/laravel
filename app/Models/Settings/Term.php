<?php

namespace App\Models\Settings;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    use HasFactory;

    /**
     * Get the user record associated with the term.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('user_id')->withTimestamps();
    }
}
