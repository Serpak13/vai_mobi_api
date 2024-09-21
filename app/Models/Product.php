<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string name
 * @property string description
 * @property int price
 * @property int category_id
 */
class Product extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
