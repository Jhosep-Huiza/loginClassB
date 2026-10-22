
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();
require_once "conexion.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Obtener y limpiar los datos del formulario
    $usuario_ingresado = trim($_POST["usuario"] ?? "");
    $password_ingresada = $_POST["password"] ?? "";

    if ($usuario_ingresado === "" || $password_ingresada === "") {
        $error = "Ingresa tu usuario y contraseña.";
    } else {
        try {
            // Buscar el usuario en la base de datos
            $stmt = $pdo->prepare(
                "SELECT id, usuario, password
                 FROM usuarios
                 WHERE usuario = :usuario
                 LIMIT 1"
            );

            $stmt->execute([
                "usuario" => $usuario_ingresado
            ]);

            $datos_usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar que el usuario exista y que su contraseña coincida
            if (
                $datos_usuario &&
                password_verify(
                    $password_ingresada,
                    $datos_usuario["password"]
                )
            ) {
                // Regenerar el identificador de sesión por seguridad
                session_regenerate_id(true);

                $_SESSION["usuario"] = $datos_usuario["usuario"];
                $_SESSION["usuario_id"] = $datos_usuario["id"];

                // Ingresar al menú de la cafetería
                header("Location: bienvenido.php");
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }

        } catch (PDOException $e) {
            error_log("Error de inicio de sesión: " . $e->getMessage());
            $error = "No se pudo iniciar sesión. Inténtalo nuevamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | Coffee Experience</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            font-family: Arial, Helvetica, sans-serif;
            color: #f8fafc;
            background:
                radial-gradient(circle at top left, #312e81 0, transparent 40%),
                linear-gradient(135deg, #0f172a, #1e1b4b);
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            padding: 38px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 22px;
            background: rgba(15, 23, 42, 0.88);
            box-shadow: 0 24px 65px rgba(0, 0, 0, 0.4);
        }

        .logo {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            border-radius: 18px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            font-size: 30px;
        }

        h1 {
            margin: 0;
            text-align: center;
            font-size: 27px;
        }

        .subtitle {
            margin: 10px 0 28px;
            color: #94a3b8;
            text-align: center;
            font-size: 14px;
            line-height: 1.6;
        }

        .field {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            color: #e2e8f0;
            font-size: 14px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #334155;
            border-radius: 11px;
            outline: none;
            background: #111c32;
            color: #ffffff;
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input::placeholder {
            color: #64748b;
        }

        input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        button {
            width: 100%;
            margin-top: 5px;
            padding: 15px;
            border: none;
            border-radius: 11px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, opacity 0.2s;
        }

        button:hover {
            transform: translateY(-1px);
            opacity: 0.95;
        }

        .error {
            margin-bottom: 20px;
            padding: 13px;
            border: 1px solid rgba(248, 113, 113, 0.35);
            border-radius: 10px;
            background: rgba(127, 29, 29, 0.25);
            color: #fca5a5;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer {
            margin-top: 25px;
            color: #64748b;
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 27px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="login-card">
        <div class="logo" aria-hidden="true">☕</div>

        <h1>Coffee Experience</h1>

        <p class="subtitle">
            Inicia sesión para acceder al menú de nuestra cafetería.
        </p>

        <?php if ($error !== ""): ?>
            <div class="error" role="alert">
                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="field">
                <label for="usuario">Usuario</label>
                <input
                    type="text"
                    id="usuario"
                    name="usuario"
                    placeholder="Ingresa tu usuario"
                    value="<?= htmlspecialchars($_POST["usuario"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                    autocomplete="username"
                    maxlength="50"
                    required
                    autofocus
                >
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Ingresa tu contraseña"
                    autocomplete="current-password"
                    required
                >
            </div>

            <button type="submit">Iniciar sesión</button>
        </form>

        <div class="footer">
            Coffee Experience &copy; <?= date("Y") ?>
        </div>
    </main>
</body>
</html>
