<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserContact extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'country_iso',
                           'operator_name', 'operator_logo',
                           'country_name', 'is_favorite', 'user_id'];
}