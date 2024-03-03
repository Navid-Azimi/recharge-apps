<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardBrand extends Model
{
    use HasFactory;
    protected $table = 'gift_brands';

    public function giftTypes(): HasMany
    {
        return $this->hasMany(GiftType::class, 'brand_id');
    }
}
