<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [

        'email',
        'password',
        'phone_n',
        'adress',
        'type',

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
    ];

    public function import():HasMany
    {
        return $this->HasMany('imports');
    }

    public function export():HasMany
    {
        return $this->HasMany('exports');
    }

    public function inventory():HasMany
    {
        return $this->HasMany('inventories');
    }

    public function lost():HasMany
    {
        return $this->HasMany('losts');
    }


    public function address():HasOne
    {
        return $this->HasOne('addresses');
    }

    public function employee():HasMany
    {
        return $this->HasMany('employees');
    }

}
