<?php
include_once "TestViajes.php";

$test = new TestViajes();

// 1. Crear empresa
$test->altaEmpresa("Viajes Patagonia", "San Martín 123");

// 2. Crear responsable
$resp = new ResponsableV();
$resp->cargar(0, "56789", "Profe", "Vivi");
$resp->insertar();

// 3. Crear viaje
$test->altaViaje("Bariloche", 40, 1, 1, 150000);

// 4. Crear pasajero
$p = new Pasajero();
$p->cargar("41589954", "Alejandro", "Claure", 2994580473, 1);
$p->insertar();

// 5. Mostrar viaje (incluye pasajeros)
$v = new Viaje();
$v->buscar(1);
echo $v;

// 6. Modificar pasajero
$p = new Pasajero();
if ($p->buscar("41589954")) {
    $p->setPtelefono(2994580475);
    $p->modificar();
}

// 7. Listar pasajeros del viaje actualizado
echo "PASAJEROS DEL VIAJE 1 (actualizados):\n";
$lista = Pasajero::listar("idviaje = 1");
foreach ($lista as $pa) {
    echo $pa . "\n";
}
/* Descomentar para probar
// 8. Eliminar pasajero
$p = new Pasajero();
if ($p->buscar("41589954")) {
    $p->eliminar();
}

// 9. Mostrar viaje nuevamente (ya sin pasajeros)
$v->buscar(1);
echo $v;

// 10. Eliminar viaje
$test->eliminarViaje(1);

// 11. Comprobar borrado
if (!$v->buscar(1)) echo "Viaje eliminado.\n";
 */
