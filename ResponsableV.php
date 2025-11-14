<?php

/**
 * Clase ResponsableV
 * Representa a la persona responsable del viaje.
 */

class ResponsableV
{

    private $rnumeroempleado; //numero de empleado
    private $rnumerolicencia;//numero de licencia
    private $rnombre; //nombre de empleado
    private $rapellido; //apellido de empleado
    private $mensajeOperacion; //mensaje de operación

    /** Constructor */
    public function __construct()
    {
        $this->rnumeroempleado = 0;
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";
        $this->mensajeOperacion = "";
    }
    /** Cargar */
    public function cargar($numEmp, $numLic, $nombre, $apellido)
    {
        $this->setRnumeroempleado($numEmp);
        $this->setRnumerolicencia($numLic);
        $this->setRnombre($nombre);
        $this->setRapellido($apellido);
    }

    /************* GETTERS *************/
    public function getRnumeroempleado()
    {
        return $this->rnumeroempleado;
    }
    public function getRnumerolicencia()
    {
        return $this->rnumerolicencia;
    }
    public function getRnombre()
    {
        return $this->rnombre;
    }
    public function getRapellido()
    {
        return $this->rapellido;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /************* SETTERS *************/
    public function setRnumeroempleado($v)
    {
        $this->rnumeroempleado = $v;
    }
    public function setRnumerolicencia($v)
    {
        $this->rnumerolicencia = $v;
    }
    public function setRnombre($v)
    {
        $this->rnombre = $v;
    }
    public function setRapellido($v)
    {
        $this->rapellido = $v;
    }
    public function setMensajeOperacion($m)
    {
        $this->mensajeOperacion = $m;
    }

    /** Buscar responsable */
    public function buscar($id)
    {
        $base = new BaseDatos();
        $sql = "SELECT * FROM responsable WHERE rnumeroempleado = $id";
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row = $base->Registro()) {
                    $this->cargar(
                        $row['rnumeroempleado'],
                        $row['rnumerolicencia'],
                        $row['rnombre'],
                        $row['rapellido']
                    );
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }
        return $resp;
    }

    /** Listar responsables */
    public static function listar($condicion = "")
    {
        $arreglo = [];
        $base = new BaseDatos();
        $sql = "SELECT * FROM responsable";

        if ($condicion != "") {
            $sql .= " WHERE " . $condicion;
        }
        $sql .= " ORDER BY rnumeroempleado";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                while ($row = $base->Registro()) {
                    $obj = new ResponsableV();
                    $obj->cargar(
                        $row["rnumeroempleado"],
                        $row["rnumerolicencia"],
                        $row["rnombre"],
                        $row["rapellido"]
                    );
                    $arreglo[] = $obj;
                }
            }
        }
        return $arreglo;
    }

    /** Insertar */
    public function insertar()
    {
        $base = new BaseDatos();
        $sql = "INSERT INTO responsable (rnumerolicencia, rnombre, rapellido)
        VALUES ('{$this->rnumerolicencia}', '{$this->rnombre}', '{$this->rapellido}')";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $this->setRnumeroempleado($base->devuelveIDInsercion());
                return true;
            }
            $this->setMensajeOperacion($base->getError());
        }
        return false;
    }

    /** Modificar */
    public function modificar()
    {
        $base = new BaseDatos();
        $sql = "UPDATE responsable SET 
        rnumerolicencia = '{$this->rnumerolicencia}',
        rnombre = '{$this->rnombre}',
        rapellido = '{$this->rapellido}'
        WHERE rnumeroempleado = {$this->rnumeroempleado}";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        $this->setMensajeOperacion($base->getError());
        return false;
    }

    /** Eliminar */
    public function eliminar()
    {
        $base = new BaseDatos();
        $sql = "DELETE FROM responsable WHERE rnumeroempleado = {$this->rnumeroempleado}";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        $this->setMensajeOperacion($base->getError());
        return false;
    }

    /** toString */
    public function __toString()
    {
        return "RESPONSABLE => Empleado: {$this->rnumeroempleado}, Licencia: {$this->rnumerolicencia}, Nombre: {$this->rnombre}, Apellido: {$this->rapellido}";
    }
}
