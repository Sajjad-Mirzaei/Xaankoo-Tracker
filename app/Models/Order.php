<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['id','user_id','count','amount','payed'];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function payments(){
        return $this->hasOne(Payment::class);
    }
}
