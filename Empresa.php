<?php

/**
 * Clase Empresa
 * Representa una empresa de viajes dentro del sistema.
 * Permite insertar, modificar, eliminar y buscar empresas en la BD.
 */

class Empresa
{

    /*** Atributos ***/
    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    /*** Constructor ***/
    public function __construct()
    {
        $this->idempresa = 0;
        $this->enombre = "";
        $this->edireccion = "";
        $this->mensajeOperacion = "";
    }

    /** Carga los datos en el objeto */
    public function cargar($idempresa, $enombre, $edireccion)
    {
        $this->setIdEmpresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }

    /************* GETTERS *************/
    public function getIdEmpresa()
    {
        return $this->idempresa;
    }
    public function getEnombre()
    {
        return $this->enombre;
    }
    public function getEdireccion()
    {
        return $this->edireccion;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /************* SETTERS *************/
    public function setIdEmpresa($id)
    {
        $this->idempresa = $id;
    }
    public function setEnombre($nombre)
    {
        $this->enombre = $nombre;
    }
    public function setEdireccion($dir)
    {
        $this->edireccion = $dir;
    }
    public function setMensajeOperacion($msj)
    {
        $this->mensajeOperacion = $msj;
    }

    /** BUSCAR */
    public function buscar($id)
    {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM empresa WHERE idempresa=" . $id;
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                if ($row = $base->Registro()) {
                    $this->cargar(
                        $row['idempresa'],
                        $row['enombre'],
                        $row['edireccion']
                    );
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion("Empresa->buscar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Empresa->buscar: " . $base->getError());
        }

        return $resp;
    }

    /**LISTAR */
    public static function listar($condicion = "")
    {
        $arreglo = [];
        $base = new BaseDatos();
        $consulta = "SELECT * FROM empresa";

        if ($condicion != "") {
            $consulta .= " WHERE " . $condicion;
        }

        $consulta .= " ORDER BY idempresa";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                while ($row = $base->Registro()) {
                    $obj = new Empresa();
                    $obj->cargar(
                        $row['idempresa'],
                        $row['enombre'],
                        $row['edireccion']
                    );
                    array_push($arreglo, $obj);
                }
            }
        }

        return $arreglo;
    }

    /** INSERTAR */
    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "INSERT INTO empresa (enombre, edireccion) 
                     VALUES ('{$this->getEnombre()}', '{$this->getEdireccion()}')";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $id = $base->devuelveIDInsercion();
                $this->setIdEmpresa($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Empresa->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Empresa->insertar: " . $base->getError());
        }

        return $resp;
    }

    /** MODIFICAR */
    public function modificar()
    {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "UPDATE empresa SET 
                     enombre = '{$this->getEnombre()}', 
                     edireccion = '{$this->getEdireccion()}'
                     WHERE idempresa = {$this->getIdEmpresa()}";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Empresa->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Empresa->modificar: " . $base->getError());
        }

        return $resp;
    }

    /** ELIMINAR */
    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;

        $consulta = "DELETE FROM empresa WHERE idempresa = {$this->getIdEmpresa()}";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consulta)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Empresa->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Empresa->eliminar: " . $base->getError());
        }

        return $resp;
    }

    /** toString */
    public function __toString()
    {
        return "EMPRESA => ID: {$this->getIdEmpresa()}, Nombre: {$this->getEnombre()}, Dirección: {$this->getEdireccion()}";
    }
}
