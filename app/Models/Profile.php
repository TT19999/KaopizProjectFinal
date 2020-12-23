<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * @var mixed
     */
    protected $fillable=[
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'type',
        'avatar',
        'cover',
        'subject',
        'facebook',
        'twitter',
        'github',
        'website',
        'status',
    ];
}
