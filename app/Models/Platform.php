<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
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
        'response_text',
        'delay_hour',
        'admin_id',
    ];

    public function getAppPlatformSubscriptions()
    {
        return $this->hasMany(AppPlatformSubscription::class);
    }

    public function getAdmin()
    {
        return $this->hasOne(User::class, 'id','admin_id');
    }
}
