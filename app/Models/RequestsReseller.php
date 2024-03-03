<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestsReseller extends Model
{
    protected $table = 'requests_reseller';
    use HasFactory;
    protected $fillable = [
        'name','business_name','email',
        'country','state_province','city',
        'address','postal_code','phone_number',
        'partner_type','company_size',
        'hear_about_ding','interests',
        'authorized_signatory',
    ];
}
