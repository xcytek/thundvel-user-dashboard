<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{

    protected $table = 'suppliers';

    protected $fillable = ['name', 'country', 'industry', 'website', 'subdomain', 'contact_name', 'phone', 'email'];

    public function myPlan()
    {
        return $this->hasOne(SupplierPlan::class, 'supplier_id', 'id');
    }

    public static function findBySubdomain($subdomain)
    {
        return static::where('subdomain', $subdomain)->first();
    }

    public static function existsBySubdomain($subdomain)
    {
        return (! is_null(static::findBySubdomain($subdomain)));
    }

}