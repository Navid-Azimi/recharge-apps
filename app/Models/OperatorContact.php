<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorContact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'operator', 'country', 'lastname', 'email', 'title', 'address', 'town_city', 'zipcode', 'description'];
}

