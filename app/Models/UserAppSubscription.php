<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppSubscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'app_id',
        'user_id',
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
     * Get the status of user subscription.
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

    public function getApp()
    {
        return $this->hasOne(App::class, 'id', 'app_id');
    }

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
