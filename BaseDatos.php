<?php

/**
 * Clase BaseDatos
 * Maneja la conexión y operaciones contra MySQL.
 * Compatible con los métodos utilizados en las clases Empresa, ResponsableV,
 * Pasajero y Viaje.
 */
class BaseDatos
{

    private $host = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $base = "bdviajes";

    private $conexion;
    private $resultado;
    private $error;

    /** Inicia la conexión */
    public function Iniciar()
    {
        $resp = true;
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->base);

        if ($this->conexion->connect_error) {
            $this->error = $this->conexion->connect_error;
            $resp = false;
        }
        return $resp;
    }

    /** Ejecuta una consulta SQL */
    public function Ejecutar($consulta)
    {
        $resp = true;
        $this->resultado = $this->conexion->query($consulta);

        if (!$this->resultado) {
            $this->error = $this->conexion->error;
            $resp = false;
        }
        return $resp;
    }

    /** Devuelve el último registro obtenido */
    public function Registro()
    {
        if ($this->resultado != null) {
            return $this->resultado->fetch_assoc();
        }
        return null;
    }

    /** Devuelve el último ID autoincremental insertado */
    public function devuelveIDInsercion()
    {
        return $this->conexion->insert_id;
    }

    /** Devuelve el último error */
    public function getError()
    {
        return $this->error;
    }
}
