<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable=['id','order_id','status','track_id','gate_id','pay_id','card_no','hashed_card_no','date'];

    public function orders(){
        return $this->belongsTo(User::class);
    }
}
