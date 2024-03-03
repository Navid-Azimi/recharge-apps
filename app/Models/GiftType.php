<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GiftType extends Model
{
    use HasFactory;

    protected $table = 'gift_types';

    public function cardBrand(): BelongsTo
    {
        return $this->belongsTo(CardBrand::class, 'brand_id');
    }

    public function giftCards(): HasMany 
    {
        return $this->hasMany(GiftCard::class, 'gift_type_id');
    }
}
