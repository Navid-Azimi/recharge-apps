<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetworkCommissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'com_ntw_id', 'com_user_id', 'com_custom_rate'
    ];


    public function network()
    {
        return $this->belongsTo(Networks::class, 'com_ntw_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'com_user_id')->withDefault([
            'email' => 'N/A',
        ]);
    }   

}
