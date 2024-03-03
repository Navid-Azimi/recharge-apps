<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topups extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'top_phone_number', 'top_country', 'top_ntw_name', 'user_id', 'user_role',
        'top_pac_id', 'top_profit', 'top_amount', 'top_currency',
        'top_rate', 'top_status', 'top_ussd_output', 'payment_status', 'top_amount2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTopupsTotal()
    {
        return DB::table('topups')
            ->where('user_id', auth()->user()->id)
            ->sum('top_amount');
    }

    public static function getRecords($userId, array $filterConditions)
    {
        $user = User::find($userId);
        if ($user->user_role !== 'admin') {
            $records = static::where('user_id', $user->id);
        } else {
            $records = static::where('id', '>', 0);
        }

        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['top_status'])) {
                $otherConditions[] = ['top_status', 'like', "%{$filterConditions['top_status']}%"];
                unset($filterConditions['top_status']);
            }

            if (!empty($filterConditions['trans'])) {
                $otherConditions[] = ['id', 'like', "%{$filterConditions['trans']}%"];
                unset($filterConditions['trans']);
            }

            if (!empty($filterConditions['top_amount'])) {
                $otherConditions[] = ['top_amount', 'like', "%{$filterConditions['top_amount']}%"];
                unset($filterConditions['top_amount']);
            }

            if (!empty($filterConditions['top_phone_number'])) {
                $otherConditions[] = ['top_phone_number', 'like', "%{$filterConditions['top_phone_number']}%"];
                unset($filterConditions['top_phone_number']);
            }

            if (!empty($filterConditions['operator_name'])) {
                $otherConditions[] = ['top_ntw_name', 'like', "%{$filterConditions['operator_name']}%"];
                unset($filterConditions['operator_name']);
            }

            if (!empty($filterConditions['country_name']) && $filterConditions['country_name'] !== 'all') {
                $otherConditions[] = ['top_country', 'like', "%{$filterConditions['country_name']}%"];
            }
            unset($filterConditions['country_name']);

            if (!empty($filterConditions['currency'])) {
                $otherConditions[] = ['top_currency', 'like', "%{$filterConditions['currency']}%"];
            }
            unset($filterConditions['currency']);

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

            $records = $records->orderBy('id', 'desc')->paginate(10);
            return $records;
        } else {
            $records = self::orderBy('id', 'desc');

            if ($user->user_role !== 'admin') {
                $records->where('user_id', $user->id);
            }
            $records = $records->orderBy('id', 'desc')->paginate(10);
            return $records;
        }
    }

    public static function getRecordsByRole($role, array $filterConditions)
    {
        $records = static::where('user_role', 'like', '%' . $role . '%');
        if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['top_status'])) {
                $otherConditions[] = ['top_status', 'like', "%{$filterConditions['top_status']}%"];
                unset($filterConditions['top_status']);
            }

            if (!empty($filterConditions['trans'])) {
                $otherConditions[] = ['id', 'like', "%{$filterConditions['trans']}%"];
                unset($filterConditions['trans']);
            }

            if (!empty($filterConditions['reseller_id']) && $filterConditions['reseller_id'] !== 'all') {
                $otherConditions[] = ['user_id', $filterConditions['reseller_id']];
            }
            unset($filterConditions['reseller_id']);

            if (!empty($filterConditions['top_amount'])) {
                $otherConditions[] = ['top_amount', 'like', "%{$filterConditions['top_amount']}%"];
                unset($filterConditions['top_amount']);
            }

            if (!empty($filterConditions['top_phone_number'])) {
                $otherConditions[] = ['top_phone_number', 'like', "%{$filterConditions['top_phone_number']}%"];
                unset($filterConditions['top_phone_number']);
            }

            if (!empty($filterConditions['operator_name'])) {
                $otherConditions[] = ['top_ntw_name', 'like', "%{$filterConditions['operator_name']}%"];
                unset($filterConditions['operator_name']);
            }

            if (!empty($filterConditions['currency'])) {
                $otherConditions[] = ['top_currency', 'like', "%{$filterConditions['currency']}%"];
            }
            unset($filterConditions['currency']);

            if (!empty($filterConditions['country_name']) && $filterConditions['country_name'] !== 'all') {
                $otherConditions[] = ['top_country', 'like', "%{$filterConditions['country_name']}%"];
            }
            unset($filterConditions['country_name']);

            if (!empty($filterConditions['start_date'])) {
                $records->whereDate('created_at', '>=', $filterConditions['start_date']);
                unset($filterConditions['start_date']);
            }

            if (!empty($filterConditions['end_date'])) {
                $records->whereDate('created_at', '<=', $filterConditions['end_date']);
                unset($filterConditions['end_date']);
            }

            $records = $records->where($otherConditions)
                ->where($filterConditions)
                ->where('user_role', 'like', '%' . $role . '%');

            $records = $records->orderBy('id', 'desc')->paginate(10);
            return $records;
        } else {
            $records = $records->orderBy('id', 'desc')->paginate(10);
            return $records;
        }
    }

    public static function getCountriesWithVisitsAndPercentages()
    {
        $topups = DB::table('topups')
            ->select('top_country', DB::raw('COUNT(*) as topup_count'))
            ->groupBy('top_country')
            ->orderByDesc('topup_count')
            ->get();

        $totalTopups = $topups->sum('topup_count');

        $topupsWithPercentages = $topups->map(function ($topup) use ($totalTopups) {
            $percentage = ($topup->topup_count / $totalTopups) * 100;
            return (object)[
                'country' => $topup->top_country,
                'topup_count' => $topup->topup_count,
                'percentage' => round($percentage, 2),
            ];
        });

        return $topupsWithPercentages;
    }

    public static function getDataForVectorMap()
    {
        $fileContent = file_get_contents(public_path('data/countries.json'));

        if ($fileContent !== false) {
            $countries = json_decode($fileContent, true);
        }
        $topupsCountries = self::getCountriesWithVisitsAndPercentages();

        $countriesWithLatLng = [];

        foreach ($countries as $country) {
            $countryName = $country['name']['common'];

            $matchingTopupCountry = $topupsCountries->firstWhere('country', $countryName);

            if ($matchingTopupCountry) {
                $countriesWithLatLng[] = (object)[
                    'latLng' => $country['latlng'],
                    'name' => $countryName,
                ];
            }
        }

        return $countriesWithLatLng;
    }
}
