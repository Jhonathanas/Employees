<?php

namespace App\Models;

use App\Models\State;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name','country_code'];

    public function employees(){
        return $this->hasMany(Employee::class);
    }
    public function state(){
        return $this->hasMany(State::class);
    }


}
