<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'image',
        'password',
        'account_type',
        'provider',
    ];

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
        'password' => 'hashed',
    ];


    /**
     * User has many followings
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followings(): HasMany
    {
        return $this->hasMany(Follow::class, 'follower_id', 'id');
    }


    /**
     * User has many followers
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function follower(): HasMany
    {
        return $this->hasMany(Follow::class, 'writer_id', 'id');
    }
    

    /**
     * User has many posts
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'writer_id', 'id');
    }
}
