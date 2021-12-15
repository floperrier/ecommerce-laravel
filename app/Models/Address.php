<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "users_addresses";
    protected $fillable = ['shipping_name','address','zipcode','country','city','user_id'];
    public $timestamps = false;

}
