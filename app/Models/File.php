<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'files';
    protected $fillable = ['title', 'id_file','id_vector', 'content','category','address','delay','company_name','price', 'image', 'edited_by', 'filename'];

  



}

