<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taken extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $casts = [
        'taken_at' => 'date:U'
    ];

    public function dosage(){
        return $this->belongsTo(Dosage::class);
    }

}
