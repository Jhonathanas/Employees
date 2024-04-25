<?php

namespace App\Models;

use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable =['name','country_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function city(){
        return $this->hasMany(City::class);
    }
    public function Employee(){
        return $this->belongsTo(Employee::class);
    }
}
