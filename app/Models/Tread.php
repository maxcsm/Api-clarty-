<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Message;

class Tread extends Model
{
    use HasFactory, Notifiable;


protected $fillable = [
    'from_id', 'to_id','thread_id','id'
];

public function user()
{
    return $this->belongsTo('App\Models\User', 'from_id');
}


public function userto()
{
    return $this->belongsTo('App\Models\User', 'to_id');
}

 public function lastPost()
{
   // return $this->hasOne('App\Models\Message', 'thread_id', 'thread_id');
   // return $this->hasOne('App\Models\Message', 'thread_id');

   return $this->hasOne('App\Models\Message', 'thread_id', 'thread_id')->latest();
}





public function toArray(){
    $data = parent::toArray();
    $data['from_id']=$this->user;
    $data['to_id']=$this->userto;
    $data['last_message']=$this->lastPost;
  //  $data['lastpost']=$this->lastpostbyuser;
    return $data;
}
}



