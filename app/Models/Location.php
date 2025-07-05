<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'subtitle','content','category','image','image2','image3','image4','number','address','zip','city','url','country','website','phone',
        'lat','lng','edited_by','view','seo','keywords','delay','price'
    ];
    


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'edited_by', 'id');
    }
    
    /*
    public function tags()
    {
        return $this->hasMany('App\Models\Tags')->withPivot('location_id',null);

        
    }
    
    */

    public function toArray(){
        $data = parent::toArray();
        $data['edited_by']=$this->user;
        $data['edited_by']->makeHidden('email_verified_at');
        $data['edited_by']->makeHidden('created_at');
        $data['edited_by']->makeHidden('updated_at');
        $data['edited_by']->makeHidden('email');
        $data['tags']=$this->tags;
        return $data;
    }
    
}    
    