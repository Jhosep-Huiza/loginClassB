```php
<?php
session_start();

require_once __DIR__ . "/conexion.php";

if (empty($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../bienvenido.php");
    exit();
}

$productos = [
    1  => ["nombre" => "Espresso Italiano", "precio" => 6.00],
    2  => ["nombre" => "Café Americano", "precio" => 7.50],
    3  => ["nombre" => "Capuccino Creme", "precio" => 9.50],
    4  => ["nombre" => "Iced Latte Caramel", "precio" => 11.00],
    5  => ["nombre" => "Frappé de Moka", "precio" => 13.50],
    6  => ["nombre" => "Torta de Fudge", "precio" => 10.00],
    7  => ["nombre" => "Torta de Fresa", "precio" => 9.00],
    8  => ["nombre" => "Chocolate Caliente", "precio" => 10.00],
    9  => ["nombre" => "Torta Tres Leches", "precio" => 11.00],
    10 => ["nombre" => "Frappé de Fresa", "precio" => 12.00],
    11 => ["nombre" => "Té Helado de Durazno", "precio" => 8.50],
    12 => ["nombre" => "Pastel Red Velvet", "precio" => 12.50]
];

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}

$productoId = filter_input(INPUT_POST, "producto_id", FILTER_VALIDATE_INT);
$nombre = trim($_POST["nombre"] ?? "");
$dni = trim($_POST["dni"] ?? "");
$telefono = trim($_POST["telefono"] ?? "");
$correo = trim($_POST["correo"] ?? "");
$cantidad = filter_input(INPUT_POST, "cantidad", FILTER_VALIDATE_INT);
$entrega = $_POST["entrega"] ?? "";
$direccion = trim($_POST["direccion"] ?? "");
$pago = $_POST["pago"] ?? "";
$observaciones = trim($_POST["observaciones"] ?? "");

$errores = [];

if (!$productoId || !isset($productos[$productoId])) {
    $errores[] = "El producto seleccionado no es válido.";
}

if ($nombre === "" || mb_strlen($nombre) > 120) {
    $errores[] = "Ingresa un nombre válido.";
}

if ($dni === "" || mb_strlen($dni) > 15) {
    $errores[] = "Ingresa un DNI válido.";
}

if ($telefono === "" || mb_strlen($telefono) > 20) {
    $errores[] = "Ingresa un teléfono válido.";
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || mb_strlen($correo) > 120) {
    $errores[] = "Ingresa un correo electrónico válido.";
}

if (!$cantidad || $cantidad < 1 || $cantidad > 20) {
    $errores[] = "La cantidad debe estar entre 1 y 20.";
}

if (!in_array($entrega, ["Recojo en cafetería", "Delivery"], true)) {
    $errores[] = "Selecciona un tipo de entrega válido.";
}

if ($entrega === "Delivery" && $direccion === "") {
    $errores[] = "Ingresa la dirección para el delivery.";
}

if (mb_strlen($direccion) > 255) {
    $errores[] = "La dirección es demasiado larga.";
}

if (!in_array($pago, ["Efectivo contra entrega", "Yape", "Plin"], true)) {
    $errores[] = "Selecciona un método de pago válido.";
}

if (mb_strlen($observaciones) > 2000) {
    $errores[] = "Las observaciones son demasiado largas.";
}

if (!empty($errores)) {
    http_response_code(400);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirmación de compra | Coffee Experience</title>
<style>
*{box-sizing:border-box}
body{
    margin:0;min-height:100vh;padding:30px 16px;
    display:flex;align-items:center;justify-content:center;
    font-family:Segoe UI,Arial,sans-serif;color:#f8fafc;
    background:radial-gradient(circle at top left,#312e81 0,transparent 38%),
    linear-gradient(135deg,#0f172a,#1e1b4b)
}
.card{
    width:100%;max-width:650px;padding:32px;
    background:rgba(30,41,59,.92);
    border:1px solid rgba(255,255,255,.12);
    border-radius:20px;box-shadow:0 20px 50px #0005
}
h1{margin-top:0;font-size:28px}
p{color:#cbd5e1;line-height:1.7}
.success{
    color:#86efac;background:#14532d55;
    border:1px solid #22c55e66;padding:16px;border-radius:12px
}
.error{
    color:#fecaca;background:#7f1d1d55;
    border:1px solid #f87171;padding:16px;border-radius:12px
}
.details{
    margin:22px 0;padding:18px;background:#0f172a;
    border:1px solid #334155;border-radius:12px
}
.line{
    display:flex;justify-content:space-between;gap:16px;
    padding:9px 0;border-bottom:1px solid #334155
}
.line:last-child{border-bottom:0}
.total{font-size:22px;color:#4ade80;font-weight:800}
a{
    display:inline-block;margin-top:18px;padding:13px 18px;
    border-radius:10px;background:#4f46e5;color:white;
    text-decoration:none;font-weight:700
}
a:hover{background:#6366f1}
</style>
</head>
<body>
<main class="card">

<?php if (!empty($errores)): ?>

    <h1>No se pudo procesar la compra</h1>
    <div class="error">
        <ul>
        <?php foreach ($errores as $error): ?>
            <li><?= h($error) ?></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <a href="javascript:history.back()">Volver al formulario</a>

<?php else: ?>

<?php
$producto = $productos[$productoId];
$precioUnitario = $producto["precio"];
$total = $precioUnitario * $cantidad;
$usuario = $_SESSION["usuario"];
$pedidoGuardado = false;
$errorBD = "";

try {
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        throw new RuntimeException(
            "No se encontró una conexión PDO válida en conexion.php."
        );
    }

    $sql = "INSERT INTO pedidos
        (producto_id, usuario, nombre, dni, telefono, correo,
         cantidad, precio_unitario, total, entrega, direccion,
         pago, observaciones)
        VALUES
        (:producto_id, :usuario, :nombre, :dni, :telefono, :correo,
         :cantidad, :precio_unitario, :total, :entrega, :direccion,
         :pago, :observaciones)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":producto_id" => $productoId,
        ":usuario" => $usuario,
        ":nombre" => $nombre,
        ":dni" => $dni,
        ":telefono" => $telefono,
        ":correo" => $correo,
        ":cantidad" => $cantidad,
        ":precio_unitario" => $precioUnitario,
        ":total" => $total,
        ":entrega" => $entrega,
        ":direccion" => $entrega === "Delivery" ? $direccion : "",
        ":pago" => $pago,
        ":observaciones" => $observaciones
    ]);

    $pedidoGuardado = true;
    $pedidoId = $pdo->lastInsertId();

} catch (Throwable $e) {
    error_log("Error al guardar pedido: " . $e->getMessage());
    $errorBD = "No fue posible registrar el pedido. Verifica la conexión y las columnas de la tabla pedidos.";
}
?>

<?php if ($pedidoGuardado): ?>

    <h1>¡Compra registrada!</h1>
    <div class="success">
        Tu pedido se registró correctamente. Gracias por elegir Coffee Experience.
    </div>

    <div class="details">
        <div class="line">
            <span>Número de pedido</span>
            <strong>#<?= h($pedidoId) ?></strong>
        </div>
        <div class="line">
            <span>Cliente</span>
            <strong><?= h($nombre) ?></strong>
        </div>
        <div class="line">
            <span>Producto</span>
            <strong><?= h($producto["nombre"]) ?></strong>
        </div>
        <div class="line">
            <span>Precio unitario</span>
            <strong>S/ <?= number_format($precioUnitario, 2) ?></strong>
        </div>
        <div class="line">
            <span>Cantidad</span>
            <strong><?= (int)$cantidad ?></strong>
        </div>
        <div class="line">
            <span>Entrega</span>
            <strong><?= h($entrega) ?></strong>
        </div>
        <?php if ($entrega === "Delivery"): ?>
        <div class="line">
            <span>Dirección</span>
            <strong><?= h($direccion) ?></strong>
        </div>
        <?php endif; ?>
        <div class="line">
            <span>Método de pago</span>
            <strong><?= h($pago) ?></strong>
        </div>
        <div class="line">
            <span>Total</span>
            <strong class="total">S/ <?= number_format($total, 2) ?></strong>
        </div>
    </div>

    <p>Conserva tu número de pedido para cualquier consulta.</p>
    <a href="../bienvenido.php">Volver al menú</a>

<?php else: ?>

    <h1>No se pudo guardar tu pedido</h1>
    <div class="error"><?= h($errorBD) ?></div>
    <p>Tu compra no ha sido confirmada en la base de datos.</p>
    <a href="../bienvenido.php">Volver al menú</a>

<?php endif; ?>
<?php endif; ?>

</main>
</body>
</html>
```
