<?php

/**
 * Clase Viaje
 */

class Viaje
{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objEmpresa;
    private $objResponsable;
    private $vimporte;
    private $colPasajeros;
    private $mensajeOperacion;

    public function __construct()
    {
        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = 0;
        $this->objEmpresa = new Empresa();
        $this->objResponsable = new ResponsableV();
        $this->vimporte = 0;
        $this->colPasajeros = [];
        $this->mensajeOperacion = "";
    }
    /** Cargar */
    public function cargar($id, $dest, $max, $empresa, $responsable, $importe)
    {
        $this->setIdViaje($id);
        $this->setVdestino($dest);
        $this->setVcantmaxpasajeros($max);
        $this->setObjEmpresa($empresa);
        $this->setObjResponsable($responsable);
        $this->setVimporte($importe);
    }

    /************* GETTERS *************/
    public function getIdViaje()
    {
        return $this->idviaje;
    }
    public function getVdestino()
    {
        return $this->vdestino;
    }
    public function getVcantmaxpasajeros()
    {
        return $this->vcantmaxpasajeros;
    }
    public function getObjEmpresa()
    {
        return $this->objEmpresa;
    }
    public function getObjResponsable()
    {
        return $this->objResponsable;
    }
    public function getVimporte()
    {
        return $this->vimporte;
    }
    public function getColPasajeros()
    {
        return $this->colPasajeros;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /************* SETTERS *************/
    public function setIdViaje($v)
    {
        $this->idviaje = $v;
    }
    public function setVdestino($v)
    {
        $this->vdestino = $v;
    }
    public function setVcantmaxpasajeros($v)
    {
        $this->vcantmaxpasajeros = $v;
    }
    public function setObjEmpresa($v)
    {
        $this->objEmpresa = $v;
    }
    public function setObjResponsable($v)
    {
        $this->objResponsable = $v;
    }
    public function setVimporte($v)
    {
        $this->vimporte = $v;
    }
    public function setColPasajeros($v)
    {
        $this->colPasajeros = $v;
    }
    public function setMensajeOperacion($v)
    {
        $this->mensajeOperacion = $v;
    }

    /** Buscar viaje */
    public function buscar($id)
    {
        $base = new BaseDatos();
        $sql = "SELECT * FROM viaje WHERE idviaje = $id";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row = $base->Registro()) {

                    $empresa = new Empresa();
                    $empresa->buscar($row["idempresa"]);

                    $responsable = new ResponsableV();
                    $responsable->buscar($row["rnumeroempleado"]);

                    $this->cargar(
                        $row['idviaje'],
                        $row['vdestino'],
                        $row['vcantmaxpasajeros'],
                        $empresa,
                        $responsable,
                        $row['vimporte']
                    );

                    // cargar pasajeros
                    $this->colPasajeros = Pasajero::listar("idviaje=$id");

                    return true;
                }
            }
        }
        return false;
    }

    /** Listar viajes */
    public static function listar($condicion = "")
    {
        $arreglo = [];
        $base = new BaseDatos();

        $sql = "SELECT * FROM viaje";
        if ($condicion != "") $sql .= " WHERE $condicion";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                while ($row = $base->Registro()) {

                    $empresa = new Empresa();
                    $empresa->buscar($row["idempresa"]);

                    $responsable = new ResponsableV();
                    $responsable->buscar($row["rnumeroempleado"]);

                    $obj = new Viaje();
                    $obj->cargar(
                        $row["idviaje"],
                        $row["vdestino"],
                        $row["vcantmaxpasajeros"],
                        $empresa,
                        $responsable,
                        $row["vimporte"]
                    );

                    $obj->setColPasajeros(Pasajero::listar("idviaje={$row['idviaje']}"));

                    $arreglo[] = $obj;
                }
            }
        }
        return $arreglo;
    }

    /** Insertar viaje */
    public function insertar()
    {
        $base = new BaseDatos();
        $sql = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
                VALUES ('{$this->vdestino}', {$this->vcantmaxpasajeros},
                        {$this->objEmpresa->getIdEmpresa()},
                        {$this->objResponsable->getRnumeroempleado()},
                        {$this->vimporte})";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $this->idviaje = $base->devuelveIDInsercion();
                return true;
            }
        }
        return false;
    }

    /** Modificar */
    public function modificar()
    {
        $base = new BaseDatos();

        $sql = "UPDATE viaje SET 
                vdestino='{$this->vdestino}',
                vcantmaxpasajeros={$this->vcantmaxpasajeros},
                idempresa={$this->objEmpresa->getIdEmpresa()},
                rnumeroempleado={$this->objResponsable->getRnumeroempleado()},
                vimporte={$this->vimporte}
                WHERE idviaje={$this->idviaje}";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }

    /** Eliminar */
    public function eliminar()
    {
        $base = new BaseDatos();
        $sql = "DELETE FROM viaje WHERE idviaje={$this->idviaje}";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }
    /** To String */
    public function __toString()
    {
        $str = "VIAJE => ID: {$this->idviaje}, Destino: {$this->vdestino}, Máx: {$this->vcantmaxpasajeros}, Importe: {$this->vimporte}\n";
        $str .= "Empresa: " . $this->objEmpresa . "\n";
        $str .= "Responsable: " . $this->objResponsable . "\n";
        $str .= "Pasajeros:\n";

        foreach ($this->colPasajeros as $p) {
            $str .= " - $p\n";
        }
        return $str;
    }
}
