<?php

namespace App\Models;

use App\Notifications\ForgotPasswordNotificationAdmin;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
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


    public function sendPasswordResetNotificationAdmin($token)
    {
        $this->notify(new ForgotPasswordNotificationAdmin($token));
    }

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

    public function userLocation()
    {
        return $this->hasOne(UserLocation::class,'user_id');
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class,'user_id');
    }

    public function defaultShippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class,'default_shipping_address');
    }


}
