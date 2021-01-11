<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordReset extends Model
{

    use SoftDeletes;

    protected $table = 'password_resets';

    protected $fillable = ['email', 'token'];

    public static function findByToken($token)
    {
        return static::where('token', $token)->orderBy('created_at', 'DESC')->first();
    }

    public static function latest($email)
    {
        return static::orderBy('created_at', 'DESC')->first();
    }

    public static function removeByEmail($email)
    {
        return static::where('email', $email)->delete();
    }
}