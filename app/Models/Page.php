<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{


    use HasFactory;
    protected $fillable = [
        'title', 'subtitle','content','category', 'image','url','edited_by','view'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'edited_by', 'id');
    }

    public function toArray(){
        $data = parent::toArray();
        $data['edited_by']=$this->user;
        $data['edited_by']->makeHidden('email_verified_at');
        $data['edited_by']->makeHidden('created_at');
        $data['edited_by']->makeHidden('updated_at');
        $data['edited_by']->makeHidden('email');
        return $data;
    }
    }
