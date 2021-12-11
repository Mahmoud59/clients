<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model
{
    protected $fillable = ['name', 'mobile', 'email', 'longitude', 'latitude', 'address'];
}
