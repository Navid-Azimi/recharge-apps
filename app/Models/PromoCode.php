<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(User::class, 'promo_code_user')->withTimestamps();
    }

    public static function getRecords(array $filterConditions  = null)
    {
        $records = static::where('id', '>', 0);

        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['promo_code'])) {
                $otherConditions[] = ['promo_code', 'like', "%{$filterConditions['promo_code']}%"];
                unset($filterConditions['promo_code']);
            }
            if (!empty($filterConditions['min_amount'])) {
                $otherConditions[] = ['min_amount', 'like', "%{$filterConditions['min_amount']}%"];
                unset($filterConditions['min_amount']);
            }
            if (!empty($filterConditions['max_amount'])) {
                $otherConditions[] = ['max_amount', 'like', "%{$filterConditions['max_amount']}%"];
                unset($filterConditions['max_amount']);
            }
            if (!empty($filterConditions['discount'])) {
                $otherConditions[] = ['discount', 'like', "%{$filterConditions['discount']}%"];
                unset($filterConditions['discount']);
            }
            if (!empty($filterConditions['start_date'])) {
                $otherConditions[] = ['start_date', 'like', "%{$filterConditions['start_date']}%"];
                unset($filterConditions['start_date']);
            }

            if (!empty($filterConditions['end_date'])) {
                $otherConditions[] = ['end_date', 'like', "%{$filterConditions['end_date']}%"];
                unset($filterConditions['end_date']);
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
}
