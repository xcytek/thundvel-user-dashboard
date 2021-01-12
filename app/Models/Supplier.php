<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $table = 'suppliers';


    public static function findBySubdomain($subdomain)
    {
        return static::where('subdomain', $subdomain)->first();
    }
}