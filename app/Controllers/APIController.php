<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController
{
    protected $modelName = 'App\Models\animalesModelo';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }


    }
    
    public function registrarAnimal()
    {

        $nombre = $this->request->getPost('nombre');
        $edad = $this->request->getPost('edad');
        $tipo = $this->request->getPost('tipo');
        $descripcion = $this->request->getPost('descripcion');
        $comida = $this->request->getPost('comida');



        $datosEnvio = array(
    
            "nombre" => $nombre,
            "edad" => $edad,
            "tipo" => $tipo,
            "descripcion" => $descripcion,
            "comida" => $comida
        );



        if($this->validate('animales'))
        {
            $this->model->insert($datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro agregado con exito");
            return $this->respond($mensaje);
        }
        else
        {
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);
        }

    }

    public function editarAnimal($id)
    {

        $datosPeticion=$this->request->getRawInput();

        $nombre = $datosPeticion["nombre"];
        $edad = $datosPeticion["edad"];
        $tipo = $datosPeticion["tipo"];
        $descripcion = $datosPeticion["descripcion"];
        $comida = $datosPeticion["comida"];


        $datosEnvio = array(

            "nombre" => $nombre,
            "edad" => $edad,
            "tipo" => $tipo,
            "descripcion" => $descripcion,
            "comida" => $comida
        );

        
        if($this->validate('animalesPUT'))
        {

            $this->model->update($id, $datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"editado con exito");
            return $this->respond($mensaje);
        }
        else
        {
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);
        }



    }


    public function eliminarAnimal($id)
    {

        // 1. ejecutar la operacion con delete
        $consulta = $this->model->where('id', $id)->delete();
        
        $filasAfectadas = $consulta->connID->affected_rows;


        // 2. validar si el registro a elimianr existe o no

        if ($filasAfectadas == 1)
        {
            $mensaje=array('estado'=>true,'mensaje'=>"eliminado con exito");
            return $this->respond($mensaje);
        }else
        {
            $mensaje=array('estado'=>false,'mensaje'=>"Error al eliminar");
            return $this->respond($mensaje,400);
        }

    }


}