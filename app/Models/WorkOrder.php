<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkOrder extends Model
{
    use HasFactory;

    protected $table = 'orden_trabajo';
    protected $fillable = [];
    protected $guarded = ['created_at', 'updated_at'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $appends = [
        'trabajos_realizados',
        'trabajos_counts',
        'trabajos_realizados_nombre',
        'fecha_recepcion',
        'fecha_creada',
    ];

    public function trabajos_realizados()
    {
        return $this->hasMany(WorkOrderTask::class, 'ot_id');
    }

    public function getTrabajosRealizadosAttribute()
    {
        return $this->trabajos_realizados()->get();
    }

    public function getTrabajosCountsAttribute()
    {
        return $this->trabajos_realizados()->count();
    }

    public function getTrabajosRealizadosNombreAttribute()
    {
        $array_names = $this->trabajos_realizados()->get();
        $nombres_trabajo = "";
        $numero_elementos = count($array_names);
        foreach ($array_names as $key => $value) {
            $nombres_trabajo .= $value->nombre_trabajo .  " - costo: $" . number_format($value->precio) .  " ";
        }
        return $nombres_trabajo;
    }

    public function getFechaRecepcionAttribute()
    {
        $date = $this->attributes['created_at'];
        $date = Carbon::parse($date);

        return $date->format('d-m-Y');
    }

    public function getFechaCreadaAttribute()
    {
        $date = $this->attributes['created_at'];
        Carbon::setLocale('es');
        $date = Carbon::parse($date);

        return $date->DiffForHumans();
    }
}
