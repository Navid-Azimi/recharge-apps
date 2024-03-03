<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BillingInfo extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getCardDetails()
    {
        return self::where('user_id', '=', auth()->user()->id)->orderBy('id', 'desc')->first();
    }

    public static function getAllCards()
    {
        return self::where('user_id', auth()->user()->id)->orderBy('id', 'desc')->skip(1)->take(10)->get();
    }
}
