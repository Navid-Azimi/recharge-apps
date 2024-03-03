<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftCard extends Model
{
    use HasFactory;
    protected $table = 'gift_cards';
 

    public static function getRecords(array $filterConditions  = null)
    {
        $records = static::where('id', '>', 0);

        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['country_iso']) && $filterConditions['country_iso'] !== 'all') {
                $otherConditions[] = ['country_iso', 'like', "%{$filterConditions['country_iso']}%"];
            }
            unset($filterConditions['country_iso']);


            if (!empty($filterConditions['giftCard_name'])) {
                $otherConditions[] = ['name', 'like', "%{$filterConditions['giftCard_name']}%"];
                unset($filterConditions['giftCard_name']);
            }

            $records = $records->where($otherConditions)
                ->where($filterConditions);


            $records = $records->orderBy('id', 'desc');
            return $records;
        } else {
            $records = $records->orderBy('id', 'desc');
            return $records;
        }
    }

    public function giftType(): BelongsTo
    {
        return $this->belongsTo(GiftType::class, 'gift_type_id');
    }
}
