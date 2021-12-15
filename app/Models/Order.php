<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['status'];

    public function address() {
        return Address::find($this->user_address_id);
    }
    public function details() {
        return $this->hasMany(OrderDetail::class);
    }
}
