<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_type_id',
        'name_es',
        'name_en'
    ];

    public function categoryType()
    {
        return $this->belongsTo(CategoryType::class);
    }

}
