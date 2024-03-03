<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'pck_type', 'pck_credit_amount', 'general_comm', 'pck_country', 'pck_user_id', 'pck_user_role',
        'pck_data_amount', 'pck_minutes_amount',
        'pck_sms_amount', 'pck_price', 'pck_currency_id', 'pck_memo',
        'pck_exp_date', 'pck_is_available', 'pck_pin_number', 'pck_pin_info', 'interior_charges', 'outdoor_charges', 'pck_ntw_id'
    ];

    public function network()
    {
        return $this->belongsTo(Networks::class, 'pck_ntw_id');
    }

    public static function getRecords(array $filterConditions  = null)
    {
        $records = static::where('id', '>', 0);

        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['package_country']) && $filterConditions['package_country'] !== 'all') {
                $otherConditions[] = ['pck_country', 'like', "%{$filterConditions['package_country']}%"];
            }
            unset($filterConditions['package_country']);

            if (!empty($filterConditions['package_operator']) && $filterConditions['package_operator'] !== 'all') {
                $otherConditions[] = ['pck_ntw_id', 'like', "%{$filterConditions['package_operator']}%"];
            }
            unset($filterConditions['package_operator']);

            if (!empty($filterConditions['pck_type']) && $filterConditions['pck_type'] !== 'all') {
                $otherConditions[] = ['pck_type', 'like', "%{$filterConditions['pck_type']}%"];
            }
            unset($filterConditions['pck_type']);

            if (!empty($filterConditions['package_user']) && $filterConditions['package_user'] !== 'all') {
                $selectedUsers = $filterConditions['package_user'];
                $records = $records->whereIn('pck_user_id', $selectedUsers);
            }
            unset($filterConditions['package_user']);

            if (!empty($filterConditions['package_user_role']) && $filterConditions['package_user_role'] !== 'all') {
                $otherConditions[] = ['pck_user_role', 'like', "%{$filterConditions['package_user_role']}%"];
            }
            unset($filterConditions['package_user_role']);

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