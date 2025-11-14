<?php

/**
 * Clase Pasajero
 */

class Pasajero
{

    private $pdocumento; //documento del pasajero
    private $pnombre; //nombre del pasajero
    private $papellido; //apellido del pasajero
    private $ptelefono; //teléfono del pasajero
    private $idviaje; //id del viaje
    private $mensajeOperacion; //mensaje de operación

    public function __construct()
    {
        $this->pdocumento = "";
        $this->pnombre = "";
        $this->papellido = "";
        $this->ptelefono = "";
        $this->idviaje = "";
        $this->mensajeOperacion = "";
    }
    /** Cargar */
    public function cargar($doc, $nom, $ape, $tel, $idviaje)
    {
        $this->setPdocumento($doc);
        $this->setPnombre($nom);
        $this->setPapellido($ape);
        $this->setPtelefono($tel);
        $this->setIdviaje($idviaje);
    }

   /************* GETTERS *************/
    public function getPdocumento()
    {
        return $this->pdocumento;
    }
    public function getPnombre()
    {
        return $this->pnombre;
    }
    public function getPapellido()
    {
        return $this->papellido;
    }
    public function getPtelefono()
    {
        return $this->ptelefono;
    }
    public function getIdviaje()
    {
        return $this->idviaje;
    }
    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    /************* SETTERS *************/

    public function setPdocumento($v)
    {
        $this->pdocumento = $v;
    }
    public function setPnombre($v)
    {
        $this->pnombre = $v;
    }
    public function setPapellido($v)
    {
        $this->papellido = $v;
    }
    public function setPtelefono($v)
    {
        $this->ptelefono = $v;
    }
    public function setIdviaje($v)
    {
        $this->idviaje = $v;
    }
    public function setMensajeOperacion($v)
    {
        $this->mensajeOperacion = $v;
    }

    /** Buscar pasajero */
    public function buscar($dni)
    {
        $base = new BaseDatos();
        $sql = "SELECT * FROM pasajero WHERE pdocumento = '$dni'";
        $resp = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                if ($row = $base->Registro()) {
                    $this->cargar(
                        $row['pdocumento'],
                        $row['pnombre'],
                        $row['papellido'],
                        $row['ptelefono'],
                        $row['idviaje']
                    );
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($base->getError());
            }
        }
        return $resp;
    }

    /** Listar pasajeros */
    public static function listar($condicion = "")
    {
        $arreglo = [];
        $base = new BaseDatos();
        $sql = "SELECT * FROM pasajero";

        if ($condicion != "") {
            $sql .= " WHERE $condicion";
        }

        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                while ($row = $base->Registro()) {
                    $obj = new Pasajero();
                    $obj->cargar(
                        $row["pdocumento"],
                        $row["pnombre"],
                        $row["papellido"],
                        $row["ptelefono"],
                        $row["idviaje"]
                    );
                    $arreglo[] = $obj;
                }
            }
        }
        return $arreglo;
    }

    /** Insertar pasajero */
    public function insertar()
    {
        $base = new BaseDatos();
        $sql = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje)
                VALUES ('{$this->pdocumento}', '{$this->pnombre}', '{$this->papellido}', '{$this->ptelefono}', {$this->idviaje})";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }

    /** Modificar */
    public function modificar()
    {
        $base = new BaseDatos();
        $sql = "UPDATE pasajero SET 
        pnombre='{$this->pnombre}', papellido='{$this->papellido}',
        ptelefono='{$this->ptelefono}', idviaje={$this->idviaje}
        WHERE pdocumento='{$this->pdocumento}'";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }

    /** Eliminar */
    public function eliminar()
    {
        $base = new BaseDatos();
        $sql = "DELETE FROM pasajero WHERE pdocumento='{$this->pdocumento}'";

        if ($base->Iniciar()) {
            return $base->Ejecutar($sql);
        }
        return false;
    }
    /** To String */
    public function __toString()
    {
        return "PASAJERO => Documento: {$this->pdocumento}, Nombre: {$this->pnombre}, Apellido: {$this->papellido}, Teléfono: {$this->ptelefono}, Viaje: {$this->idviaje}";
    }
}
