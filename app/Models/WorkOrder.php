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
        'mecanico_nombre',
        'taller_nombre'
    ];

    public function trabajos_realizados()
    {
        return $this->hasMany(WorkOrderTask::class, 'ot_id');
    }

    public function mecanico()
    {
        return $this->hasMany(User::class, 'user_id');
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
            $nombres_trabajo .= $value->trabajo .  " - costo: $" . number_format($value->costo) .  " ";
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

    // trae el nombre del mecanico
    public function getMecanicoNombreAttribute()
    {
        $mecanico = $this->attributes['user_id'];
        $mecanico = User::where('id', $mecanico)->first();
        return $mecanico->name;
    }

    // traemos el nombre del taller
    public function getTallerNombreAttribute()
    {
        $taller = $this->attributes['work_id'];
        $taller = WorkShop::where('id', $taller)->first();
        return $taller->name;
    }
}
