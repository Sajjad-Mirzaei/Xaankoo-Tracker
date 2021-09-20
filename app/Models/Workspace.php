<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Workspace extends Model
{
    use HasFactory;

    protected $fillable=['user_id','label','url','description'];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
