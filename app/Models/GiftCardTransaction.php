<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCardTransaction extends Model
{
    use HasFactory;
    protected $table = 'giftcards_transactions';

    protected $fillable = [
        'product','currency','country',
        'price','commission','discount',
        'total','status','recipient_name',
        'recipient_phone','recipient_email',
        'image','value','bar_code'
    ];
    public static function getRecords(array $filterConditions)
    {
        $records = static::where('id', '>', 0);
        
        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['status'])) {
                $otherConditions[] = ['status', 'like', "%{$filterConditions['status']}%"];
                unset($filterConditions['status']);
            }

            if (!empty($filterConditions['trans_id'])) {
                $otherConditions[] = ['id', 'like', "%{$filterConditions['trans_id']}%"];
                unset($filterConditions['trans_id']);
            }

            if (!empty($filterConditions['email'])) {
                $otherConditions[] = ['recipient_email', 'like', "%{$filterConditions['email']}%"];
                unset($filterConditions['email']);
            }

            if (!empty($filterConditions['start_date'])) {
                $records->whereDate('created_at', '>=', $filterConditions['start_date']);
                unset($filterConditions['start_date']);
            }

            if (!empty($filterConditions['end_date'])) {
                $records->whereDate('created_at', '<=', $filterConditions['end_date']);
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
