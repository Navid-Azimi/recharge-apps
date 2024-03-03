<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    const UPLOAD_DISK = 'public';
    const UPLOAD_DIR = 'img/announcements';

    public static function getAnnouncementsByCountry()
    {
        $records = static::where('ann_country', auth()->user()->user_country)->orWhere('ann_country', 'All')->latest()->take(1)->get();
        return $records;
    }
}
