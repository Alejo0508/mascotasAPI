<?php namespace App\Models;

use CodeIgniter\Model;

class animalesModelo extends Model
{

    protected $table      = 'animales';
    protected $primaryKey = 'id';

    protected $allowedFields = ['id', 'nombre', 'edad','tipo','descripcion','comida'];

}