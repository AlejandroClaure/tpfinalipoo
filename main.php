<?php
include_once "BaseDatos.php";
include_once "Empresa.php";
include_once "ResponsableV.php";
include_once "Pasajero.php";
include_once "Viaje.php";
include_once "TestViajes.php";

$test = new TestViajes();

/* ================================================
   Función auxiliar para leer entrada del usuario
   ================================================ */
function input($msg)
{
    echo $msg;
    return trim(fgets(STDIN));
}

/* ================================================
   MENÚ DE EMPRESAS
   ================================================ */
function menuEmpresa($test)
{
    do {
        echo "\n===== MENÚ EMPRESAS =====\n";
        echo "1) Alta empresa\n";
        echo "2) Modificar empresa\n";
        echo "3) Eliminar empresa\n";
        echo "4) Listar empresas\n";
        echo "0) Volver\n";

        $op = input("Opción: ");

        switch ($op) {
            case 1:
                $n = input("Nombre de la empresa: ");
                $d = input("Dirección: ");
                if ($test->altaEmpresa($n, $d)) echo "Empresa creada.\n";
                else echo "Error al crear empresa.\n";
                break;

            case 2:
                $id = input("ID empresa a modificar: ");
                $n = input("Nuevo nombre: ");
                $d = input("Nueva dirección: ");
                if ($test->modificarEmpresa($id, $n, $d)) echo "Empresa modificada.\n";
                else echo "No se pudo modificar.\n";
                break;

            case 3:
                $id = input("ID empresa a eliminar: ");
                if ($test->eliminarEmpresa($id)) echo "Empresa eliminada.\n";
                else echo "No se pudo eliminar.\n";
                break;

            case 4:
                $lista = Empresa::listar();
                echo "=== EMPRESAS ===\n";
                foreach ($lista as $e) echo $e . "\n";
                break;

            case 0:
                return;
        }
    } while (true);
}

/* ================================================
   MENÚ DE PASAJEROS
   ================================================ */
function menuPasajeros()
{
    do {
        echo "\n===== MENÚ PASAJEROS =====\n";
        echo "1) Alta pasajero\n";
        echo "2) Modificar pasajero\n";
        echo "3) Eliminar pasajero\n";
        echo "4) Listar pasajeros por viaje\n";
        echo "0) Volver\n";

        $op = input("Opción: ");

        switch ($op) {
            case 1:
                $dni = input("Documento: ");
                $nom = input("Nombre: ");
                $ape = input("Apellido: ");
                $tel = input("Teléfono: ");
                $idViaje = input("ID Viaje: ");

                $p = new Pasajero();
                $p->cargar($dni, $nom, $ape, $tel, $idViaje);

                if ($p->insertar()) echo "Pasajero insertado.\n";
                else echo "Error al insertar.\n";

                break;

            case 2:
                $dni = input("Documento del pasajero: ");

                $p = new Pasajero();
                if ($p->buscar($dni)) {
                    echo "Actual: " . $p . "\n";
                    $tel = input("Nuevo teléfono: ");
                    $p->setPtelefono($tel);

                    if ($p->modificar()) echo "Pasajero modificado.\n";
                    else echo "No se pudo modificar.\n";
                } else {
                    echo "Pasajero no encontrado.\n";
                }
                break;

            case 3:
                $dni = input("Documento a eliminar: ");
                $p = new Pasajero();
                if ($p->buscar($dni)) {
                    if ($p->eliminar()) echo "Pasajero eliminado.\n";
                    else echo "Error al eliminar.\n";
                } else echo "No existe ese pasajero.\n";
                break;

            case 4:
                $idv = input("ID del viaje: ");
                $lista = Pasajero::listar("idviaje = $idv");
                echo "=== PASAJEROS ===\n";
                foreach ($lista as $px) echo $px . "\n";
                break;

            case 0:
                return;
        }
    } while (true);
}

/* ================================================
   MENÚ DE VIAJES
   ================================================ */
function menuViajes($test)
{
    do {
        echo "\n===== MENÚ VIAJES =====\n";
        echo "1) Alta viaje\n";
        echo "2) Modificar viaje\n";
        echo "3) Eliminar viaje\n";
        echo "4) Mostrar viaje (con pasajeros)\n";
        echo "0) Volver\n";

        $op = input("Opción: ");

        switch ($op) {
            case 1:
                $dest = input("Destino: ");
                $max = input("Cantidad máxima: ");
                $idEmp = input("ID Empresa: ");
                $idResp = input("ID Responsable: ");
                $imp = input("Importe: ");

                if ($test->altaViaje($dest, $max, $idEmp, $idResp, $imp))
                    echo "Viaje creado.\n";
                else
                    echo "Error al crear viaje.\n";

                break;

            case 2:
                $id = input("ID Viaje a modificar: ");
                $dest = input("Nuevo destino: ");
                $max = input("Nueva cantidad máxima: ");
                $idEmp = input("Nuevo ID empresa: ");
                $idResp = input("Nuevo ID responsable: ");
                $imp = input("Nuevo importe: ");

                if ($test->modificarViaje($id, $dest, $max, $idEmp, $idResp, $imp))
                    echo "Viaje modificado.\n";
                else
                    echo "No se pudo modificar viaje.\n";

                break;

            case 3:
                $id = input("ID Viaje a eliminar: ");
                if ($test->eliminarViaje($id)) echo "Viaje eliminado.\n";
                else echo "No se pudo eliminar.\n";
                break;

            case 4:
                $id = input("ID Viaje: ");
                $v = new Viaje();
                if ($v->buscar($id)) {
                    echo $v . "\n";
                } else {
                    echo "Viaje no encontrado.\n";
                }
                break;

            case 0:
                return;
        }
    } while (true);
}

/* ================================================
   MENÚ PRINCIPAL
   ================================================ */

do {
    echo "\n============== MENÚ PRINCIPAL ==============\n";
    echo "1) Gestión de Empresas\n";
    echo "2) Gestión de Viajes\n";
    echo "3) Gestión de Pasajeros\n";
    echo "0) Salir\n";

    $opcion = input("Elegir opción: ");

    switch ($opcion) {
        case 1:
            menuEmpresa($test);
            break;

        case 2:
            menuViajes($test);
            break;

        case 3:
            menuPasajeros();
            break;

        case 0:
            echo "Saliendo...\n";
            exit;
    }
} while (true);
