<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
}