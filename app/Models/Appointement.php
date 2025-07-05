<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;



class Appointement extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'state',
        'edited_by',
        'user_id',
        'state',
        'view',
        'start_at',
        'end_at',
        'birthdate_activite', 
        'firstname_activite',
        'lastname_activite',
        'idproduct',
        'moyendepaiement',
        'price',
        'idinvoice'

    ];



    public function tech()
{
    return $this->belongsTo('App\Models\User', 'edited_by', 'id');
}

    public function user()
{
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
}

    public function images()
{
 return $this->hasMany('App\Imagegallery', 'product_id');
}


public function toArray(){
$data = parent::toArray();
$data['user_id']=$this->user;
$data['technicien']=$this->tech;


return $data;
}
}
