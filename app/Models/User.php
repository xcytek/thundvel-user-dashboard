<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_id',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @param $email
     * @return mixed
     */
    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public static function findByEmailAndSupplierId($email, $supplierId)
    {
        return static::where('email', $email)->where('supplier_id', $supplierId)->first();
    }

    public static function findBySubdomain($subdomain)
    {
        return static::where('supplier_id', Supplier::findBySubdomain($subdomain)->id)->orderBy('role_id', 'ASC')->get();
    }


}
