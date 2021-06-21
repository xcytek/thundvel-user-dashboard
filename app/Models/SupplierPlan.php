<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class SupplierPlan extends Model
{

    protected $table = 'supplier_plans';

    protected $fillable = ['supplier_id', 'plan_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}