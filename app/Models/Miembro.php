<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Miembro extends Model
{

    protected $connection='casa';
    protected $table='Miembros';
    protected $primaryKey = "id";
    public $timestamps=false;
}