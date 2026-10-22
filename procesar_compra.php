
<?php
session_start();
require_once "conexion.php";

if (empty($_SESSION["usuario"])) {
    header("Location: index.php");
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

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: bienvenido.php");
    exit();
}

$producto_id = filter_input(INPUT_POST, "producto_id", FILTER_VALIDATE_INT);

if (!$producto_id || !isset($productos[$producto_id])) {
    header("Location: bienvenido.php");
    exit();
}

$producto = $productos[$producto_id];
$errores = [];
$nombre = "";
$dni = "";
$telefono = "";
$correo = "";
$cantidad = 1;
$entrega = "Recojo en cafetería";
$direccion = "";
$pago = "Efectivo contra entrega";
$observaciones = "";

function h($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Completar compra | Coffee Experience</title>
<style>
*{box-sizing:border-box}
body{
    margin:0;padding:30px 16px;min-height:100vh;
    font-family:Segoe UI,Arial,sans-serif;color:#f8fafc;
    background:radial-gradient(circle at top left,#312e81 0,transparent 38%),
    linear-gradient(135deg,#0f172a,#1e1b4b)
}
.container{max-width:900px;margin:auto}
.top{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:22px}
a{color:#c4b5fd;text-decoration:none}
a:hover{text-decoration:underline}
.card{
    background:rgba(30,41,59,.82);border:1px solid rgba(255,255,255,.1);
    border-radius:20px;padding:28px;box-shadow:0 20px 50px #0004
}
h1{margin:0 0 8px;font-size:clamp(23px,4vw,32px)}
.subtitle{color:#cbd5e1;margin:0 0 24px;line-height:1.6}
.product{
    display:flex;justify-content:space-between;align-items:center;gap:16px;
    background:#0f172a;padding:18px;border:1px solid #334155;border-radius:14px;
    margin-bottom:26px
}
.product small{display:block;color:#94a3b8;margin-top:5px}
.price{font-size:23px;font-weight:800;color:#38bdf8;white-space:nowrap}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.field{display:flex;flex-direction:column;gap:8px}
.field.full{grid-column:1/-1}
label{font-size:13px;font-weight:700;color:#e2e8f0}
input,select,textarea{
    width:100%;padding:13px 14px;border-radius:10px;
    border:1px solid #475569;background:#0f172a;color:#f8fafc;
    font:inherit;outline:none
}
input:focus,select:focus,textarea:focus{
    border-color:#818cf8;box-shadow:0 0 0 3px #6366f133
}
textarea{resize:vertical;min-height:90px}
select option{background:#0f172a;color:#fff}
.hint{color:#94a3b8;font-size:12px;line-height:1.5}
.total{
    display:flex;justify-content:space-between;align-items:center;gap:12px;
    border-top:1px solid #475569;margin-top:25px;padding-top:20px
}
.total strong{font-size:24px;color:#4ade80}
button{
    width:100%;margin-top:22px;padding:15px;border:0;border-radius:11px;
    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    color:#fff;font-size:15px;font-weight:800;cursor:pointer
}
button:hover{filter:brightness(1.12)}
.error{
    background:#7f1d1d55;border:1px solid #f87171;padding:13px;
    border-radius:10px;margin-bottom:18px;color:#fecaca
}
@media(max-width:600px){
    .card{padding:20px}
    .grid{grid-template-columns:1fr}
    .field.full{grid-column:auto}
    .product{align-items:flex-start;flex-direction:column}
}
</style>
</head>
<body>
<div class="container">
    <div class="top">
        <a href="bienvenido.php">← Volver al menú</a>
        <span>☕ COFFEE EXPERIENCE</span>
    </div>

    <main class="card">
        <h1>Completa tu compra</h1>
        <p class="subtitle">Ingresa tus datos para preparar y registrar tu pedido.</p>

        <div class="product">
            <div>
                <strong><?= h($producto["nombre"]) ?></strong>
                <small>Producto seleccionado · Código <?= (int)$producto_id ?></small>
            </div>
            <div class="price">S/ <?= number_format($producto["precio"], 2) ?></div>
        </div>

        <form action="views/confirmar_compra.php" method="POST">
            <input type="hidden" name="producto_id" value="<?= (int)$producto_id ?>">

            <div class="grid">
                <div class="field full">
                    <label for="nombre">Nombre completo *</label>
                    <input id="nombre" name="nombre" type="text" maxlength="120"
                           placeholder="Ej. André Meza Barriga" required>
                </div>

                <div class="field">
                    <label for="dni">DNI *</label>
                    <input id="dni" name="dni" type="text" maxlength="15"
                           placeholder="Ingresa tu DNI" required>
                </div>

                <div class="field">
                    <label for="telefono">Teléfono *</label>
                    <input id="telefono" name="telefono" type="tel" maxlength="20"
                           placeholder="Tu número de contacto" required>
                </div>

                <div class="field full">
                    <label for="correo">Correo electrónico *</label>
                    <input id="correo" name="correo" type="email" maxlength="120"
                           placeholder="correo@ejemplo.com" required>
                </div>

                <div class="field">
                    <label for="cantidad">Cantidad *</label>
                    <input id="cantidad" name="cantidad" type="number"
                           min="1" max="20" value="1" required>
                    <span class="hint">Puedes pedir entre 1 y 20 unidades.</span>
                </div>

                <div class="field">
                    <label for="entrega">Tipo de entrega *</label>
                    <select id="entrega" name="entrega" required>
                        <option value="Recojo en cafetería">Recojo en cafetería</option>
                        <option value="Delivery">Delivery a domicilio</option>
                    </select>
                </div>

                <div class="field full" id="direccion-container" hidden>
                    <label for="direccion">Dirección de entrega *</label>
                    <input id="direccion" name="direccion" type="text"
                           maxlength="255" placeholder="Calle, número, distrito">
                </div>

                <div class="field full">
                    <label for="pago">Método de pago *</label>
                    <select id="pago" name="pago" required>
                        <option value="Efectivo contra entrega">Efectivo contra entrega</option>
                        <option value="Yape">Yape</option>
                        <option value="Plin">Plin</option>
                    </select>
                    <span class="hint">Si eliges Yape o Plin, confirma el pago con la cafetería.</span>
                </div>

                <div class="field full">
                    <label for="observaciones">Observaciones (opcional)</label>
                    <textarea id="observaciones" name="observaciones"
                              placeholder="Indicaciones para preparar o entregar tu pedido"></textarea>
                </div>
            </div>

            <div class="total">
                <span>Total estimado</span>
                <strong id="total">S/ <?= number_format($producto["precio"], 2) ?></strong>
            </div>

            <button type="submit">CONFIRMAR COMPRA</button>
        </form>
    </main>
</div>

<script>
const entrega = document.getElementById("entrega");
const direccionContainer = document.getElementById("direccion-container");
const direccion = document.getElementById("direccion");
const cantidad = document.getElementById("cantidad");
const total = document.getElementById("total");
const precioUnitario = <?= json_encode($producto["precio"]) ?>;

function actualizarEntrega() {
    const esDelivery = entrega.value === "Delivery";
    direccionContainer.hidden = !esDelivery;
    direccion.required = esDelivery;
    if (!esDelivery) direccion.value = "";
}

function actualizarTotal() {
    let unidades = Number.parseInt(cantidad.value, 10);
    if (!Number.isFinite(unidades)) unidades = 1;
    unidades = Math.max(1, Math.min(20, unidades));
    total.textContent = "S/ " + (precioUnitario * unidades).toFixed(2);
}

entrega.addEventListener("change", actualizarEntrega);
cantidad.addEventListener("input", actualizarTotal);
actualizarEntrega();
actualizarTotal();
</script>
</body>
</html>

