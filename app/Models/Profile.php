<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'country',
        'state',
        'city',
        'postal_code',
        'street_address',
        'locale',
    ];

    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
