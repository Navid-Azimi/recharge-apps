<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment_info';

    protected $fillable = [
        'amount',
        'payment_method_types',
        'status',
        'payment_method',
        'currency',
        'payment_info_id',
        'user_id',
    ];

    public static function getBalance($user_id = null)
    {
        $reseller = $user_id ? User::find($user_id) : auth()->user();

        $paymentTotal = (float) DB::table('payment_info')
            ->where('user_id', $reseller->id)
            ->sum('amount');

        $topUpTotal = (float) DB::table('topups')
            ->where('user_id', $reseller->id)
            ->sum('top_amount');

        $resellerBalance = max($paymentTotal - $topUpTotal, 0);

        $reseller->balance = $resellerBalance;
        $reseller->save();

        return (float) number_format($resellerBalance, 2, '.', '');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getPaymentsList(array $filterConditions = null)
    {
        $role = auth()->user()->user_role;
        if ($role === 'admin') {
            $records = static::where('id', '>', 0);
        } elseif ($role === 'reseller') {
            $records = self::latest()
                ->where('user_id', auth()->user()->id);
        }

        if ($filterConditions !== null && count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['currency'])) {
                $otherConditions[] = ['currency', 'like', "%{$filterConditions['currency']}%"];
                unset($filterConditions['currency']);
            }
            if (!empty($filterConditions['start_date'])) {
                $records->where('created_at', '>=', $filterConditions['start_date']);
            }

            if (!empty($filterConditions['end_date'])) {
                $records->where('created_at', '<=', $filterConditions['end_date']);
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
