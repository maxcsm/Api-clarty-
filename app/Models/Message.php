<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{


    use HasFactory;
    protected $fillable = [
        'id', 'type','thread_id','from_id','to_id','user_id', 'body','attachement','seen'
    ];

    /** * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }



    public function toArray(){
        $data = parent::toArray();
        $data['from_id']=$this->user;
        $data['to_id']=$this->user;
       // $data['user_id']=$this->user;
        return $data;
    }
}
