<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;

    protected $table = 'assistants';
    protected $fillable = ['title', 'id_file','id_vector', 'assitant_id', 'thread_id', 'content','category', 'image', 'edited_by'];

  



}

