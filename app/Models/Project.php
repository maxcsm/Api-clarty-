<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'name_contact','name_regie','type','ref','address','cp','city','phone','image1','url','edited_by','view','date'
    ];


    public function posts()
{
    return $this->hasMany('App\Models\Post', 'project_id', 'id');
}

public function toArray(){
    $data = parent::toArray();
    $data['posts']=$this->posts;
    return $data;
}
}
