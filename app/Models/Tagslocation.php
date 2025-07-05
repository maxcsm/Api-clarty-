<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagslocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pivot_id', 'tag_id','location_id'
    ];
}
