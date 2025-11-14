<?php
include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "ResponsableV.php";
include_once "Pasajero.php";
include_once "Viaje.php";

class TestViajes
{

    /** OPERACIONES SOBRE EMPRESA */
    public function altaEmpresa($nombre, $direccion)
    {
        $emp = new Empresa();
        $emp->setEnombre($nombre);
        $emp->setEdireccion($direccion);
        return $emp->insertar();
    }

    public function modificarEmpresa($id, $nombre, $direccion)
    {
        $emp = new Empresa();
        if ($emp->buscar($id)) {
            $emp->setEnombre($nombre);
            $emp->setEdireccion($direccion);
            return $emp->modificar();
        }
        return false;
    }

    public function eliminarEmpresa($id)
    {
        $emp = new Empresa();
        if ($emp->buscar($id)) {
            return $emp->eliminar();
        }
        return false;
    }

    /** OPERACIONES SOBRE VIAJE */
    public function altaViaje($dest, $max, $idEmpresa, $idResponsable, $importe)
    {

        $empresa = new Empresa();
        $empresa->buscar($idEmpresa);

        $resp = new ResponsableV();
        $resp->buscar($idResponsable);

        $v = new Viaje();
        $v->cargar(0, $dest, $max, $empresa, $resp, $importe);

        return $v->insertar();
    }

    public function modificarViaje($idviaje, $dest, $max, $idEmpresa, $idResp, $importe)
    {

        $v = new Viaje();
        if ($v->buscar($idviaje)) {

            $empresa = new Empresa();
            $empresa->buscar($idEmpresa);

            $resp = new ResponsableV();
            $resp->buscar($idResp);

            $v->setVdestino($dest);
            $v->setVcantmaxpasajeros($max);
            $v->setObjEmpresa($empresa);
            $v->setObjResponsable($resp);
            $v->setVimporte($importe);

            return $v->modificar();
        }
        return false;
    }

    public function eliminarViaje($idviaje)
    {
        $v = new Viaje();
        if ($v->buscar($idviaje)) {
            return $v->eliminar();
        }
        return false;
    }
}
