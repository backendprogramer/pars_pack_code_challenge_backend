<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'admin_id',
    ];

    public function getUserAppSubscriptions()
    {
        return $this->hasMany(UserAppSubscription::class, 'app_id', 'id');
    }

    public function getAdmin()
    {
        return $this->hasOne(User::class, 'id','admin_id');
    }

    public function getPlatforms() {
        return $this->belongsToMany(Platform::class, 'app_platform_subscriptions', 'app_id', 'platform_id');
    }
}
