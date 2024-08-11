<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'cant'
    ];

    public function newVisit(){
        $this->cant++;
        $this->save();
    }
}
