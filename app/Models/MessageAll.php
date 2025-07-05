<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageAll extends Model
{


    use HasFactory;
    protected $fillable = [
        'id', 'type','thread_id','user_id', 'body','attachement','seen'
    ];

    /** * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];


public function user()
{
    return $this->belongsTo('App\Models\User', 'from_id');
}


public function userto()
{
    return $this->belongsTo('App\Models\User', 'to_id');
}


public function allPost()
{
    return $this->belongsToMany('App\Models\MessageAll', 'thread_id')->orderBy('id', 'desc');;
}




public function toArray(){
    $data = parent::toArray();
    $data['from_id']=$this->user;
    $data['to_id']=$this->userto;
    $data['posts']=$this->allPost;
    return $data;
}
}
