<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verify extends Model
{
    use HasFactory;
    protected $table="verify_emails";
    protected $primaryKey="email";
    protected $fillable=[
        'email',
        'token',
        'created_at',
    ];
}
