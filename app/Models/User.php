<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;



use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'salutation','firstname','lastname','email','user_avatar','status','website','phone_number','phone_mobile','customer_type','code','address','cp','city',
        'state','country','billing_phone','billing_fax','shipping_address','shipping_cp','shipping_city','shipping_state','shipping_country','shipping_phone',
        'shipping_fax','payment_terms','payment_terms_label','payment_reminder','tva_number','siret_number','company','role','pushid','notes','lat','lng','legal','signature',
        'user_patient','birthday_date','user_genre'
     ];


    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
