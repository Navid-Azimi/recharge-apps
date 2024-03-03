<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\FrontendResetPasswordNotification;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, CanResetPassword, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function topups()
    {
        return $this->hasMany(Topups::class);
    }

    public function card()
    {
        return $this->hasOne(BillingInfo::class);
    }

    public function contacts()
    {
        return $this->hasMany(UserContact::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $url = url("https://kikwek.com/#/reset-password?token=$token");
        $this->notify(new FrontendResetPasswordNotification($url));
    }

    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    public static function getRecordsByRole($role, array $filterConditions)
    {
         $records = static::where('user_role', 'like', '%' . $role . '%' );
         if (count($filterConditions) > 0) {
            $otherConditions = [];

            if (!empty($filterConditions['name'])) {
                $otherConditions[] = ['name', 'like', "%{$filterConditions['name']}%"];
                unset($filterConditions['name']);
            }

            if (!empty($filterConditions['mobile'])) {
                $otherConditions[] = ['mobile_no', 'like', "%{$filterConditions['mobile']}%"];
                unset($filterConditions['mobile']);
            }

            if (!empty($filterConditions['email'])) {
                $otherConditions[] = ['email', $filterConditions['email']];
                unset($filterConditions['email']);
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
}
