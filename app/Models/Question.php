<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question','subtitle','content','answer1','answer2','answer3','answer4','answer5','category','image','view','url','edited_by'
    ];

}
