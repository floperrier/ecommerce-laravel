<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    private static $vatFactor = 1.2;

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function priceWithVAT() {
        return number_format($this->price * self::$vatFactor, 2);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        unset($array['created_at']);
        unset($array['updated_at']);
        unset($array['image']);
        unset($array['category_id']);
        $array['category'] = $this->category->name;
        return $array;
    }
}
