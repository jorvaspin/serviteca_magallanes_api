<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderTask extends Model
{
    use HasFactory;

    protected $table = 'trabajos_ot';
    protected $fillable = [];
    protected $guarded = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];

    public function orden_trabajo()
    {
        return $this->belongTo(WorkOrder::class, 'ot_id');
    }
}
