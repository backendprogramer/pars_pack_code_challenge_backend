<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPlatformSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'platform_id',
        'app_id',
        'status',
        'expire_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expire_date' => 'datetime',
    ];

    /**
     * Get the status of app subscription.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return self::$STATUS[$this->status];
    }

    /**
     * Status values.
     *
     * @var array<int, string>
     */
    static array $STATUS  = [
        1 => 'Active',
        2 => 'Expired',
        3 => 'Pending',
    ];

    public function getPlatform()
    {
        return $this->hasOne(Platform::class,'id', 'platform_id');
    }

    public function getApp()
    {
        return $this->hasOne(App::class, 'id', 'app_id');
    }
}
