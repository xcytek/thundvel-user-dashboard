<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{

    protected $table = 'workspaces';

    protected $fillable = ['supplier_id', 'data_source_id', 'name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dataSource()
    {
        return $this->hasOne(DataSource::class, 'id', 'data_source_id');
    }

    public static function findBySupplier($supplierId)
    {
        return static::where('supplier_id', $supplierId)->get();
    }

    public static function getBySubdomain($subdomain)
    {
        return static::where('supplier_id', Supplier::findBySubdomain($subdomain)->id)->get();
    }
}