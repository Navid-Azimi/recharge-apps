<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countryrate extends Model
{
    use HasFactory;
    
    protected $table = 'country_rate';
    
    protected $fillable = [
        'id', 'country_name', 'rate', 'tax', 'description', 'country_code', 'product_type'
    ];
}
