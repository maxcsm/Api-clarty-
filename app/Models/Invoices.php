<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'CustomerID' , 'ItemName', 'ItemDesc', 'DueDate','ItemPrice', 'ItemTotal','Quantity', 'InvoiceDate','InvoiceID',
        'InvoiceNumber','ItemTax1','SubTotal','ItemTax1','Total','ItemTax1Amount','InvoiceStatus'


    ];
    


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'CustomerID', 'id');
    }
    
    public function toArray(){
        $data = parent::toArray();
        $data['edited_by']=$this->user;
        return $data;
    }
    


}
