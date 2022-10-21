<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosage extends Model
{
    use HasFactory;

    public function medication(){
        return $this->belongsTo(Med::class, 'med_id');
    }

    public function takes(){
        return $this->hasMany(Taken::class);
    }
}
