<?php

namespace App\Models;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'birth_date', 'date_hired', 'zip_code', 'addres', 'country_id', 'state_id', 'city_id', 'department_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function City(){
        return $this->belongsTo(City::class);
    }
    public function State(){
        return $this->belongsTo(State::class);
    }
    public function Department(){
        return $this->belongsTo(Department::class);
    }
}
