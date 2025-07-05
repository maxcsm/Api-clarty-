<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'content',
        'category',
        'ref',
        'price', 
        'age_min',
        'age_max',
        'autorisation_parentale',
        'nb_places',
        'nb_free',
        'intervenant',
        'image', 
        'view', 
        'edited_by'
    ];
}
