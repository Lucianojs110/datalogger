<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Establecimiento extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'establecimientos';
    protected $primarykey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'ubicacion',
    ];


    public function usuarios(){
        return $this->belongsToMany (User::class)->withTimestamps();
       /*  return $this->belongsToMany('App\User', 'establecimiento-user', 'id', 'user_id')->withpivot('descripcion'); */
    }
}
