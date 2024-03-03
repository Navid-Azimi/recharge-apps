<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PragmaRX\Countries\Package\Services\Countries;

class Networks extends Model
{
    use HasFactory;

    protected $fillable = [
        'ntw_name',
        'ntw_country_iso',
        'ntw_rate',
        'ntw_logo',
        'ntw_max_value',
        'ntw_min_value',
        'image',
    ];

    public static function getNetworksNamesList()
    {
        return static::select('ntw_name')->get();
    }
    
    public static function getRecords(array $filterConditions  = null)
    {
        $records = static::where('id', '>', 0);

        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['operator_country']) && $filterConditions['operator_country'] !== 'all') {
                $otherConditions[] = ['ntw_country_iso', 'like', "%{$filterConditions['operator_country']}%"];
            }
            unset($filterConditions['operator_country']);

            
            if (!empty($filterConditions['operator_name']) && $filterConditions['operator_name'] !== 'all') {
                $otherConditions[] = ['ntw_name', 'like', "%{$filterConditions['operator_name']}%"];
            }
            unset($filterConditions['operator_name']);

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
