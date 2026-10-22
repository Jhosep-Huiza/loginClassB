<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <link rel="stylesheet" href="../resources/css/register.css">
</head>
<body>

    <main class="register-card">
        <h1 class="register-title">Create Account</h1>

        <form class="register-form" action="#" method="post" novalidate>

            <div class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-8 2.2-8 5v3h16v-3c0-2.8-3.6-5-8-5z"/>
                </svg>
                <input type="text" name="fullname" placeholder="Full name" autocomplete="name">
            </div>

            <div class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm9 7.5L4.5 7v.2L12 13l7.5-5.8V7L12 12.5z"/>
                </svg>
                <input type="email" name="email" placeholder="Email" autocomplete="email">
            </div>

            <div class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.4 0-8 2.2-8 5v3h16v-3c0-2.8-3.6-5-8-5z"/>
                </svg>
                <input type="text" name="username" placeholder="Username" autocomplete="username">
            </div>

            <div class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 8h-1V6a5 5 0 0 0-10 0v2H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zM9 6a3 3 0 0 1 6 0v2H9V6z"/>
                </svg>
                <input type="password" name="password" id="password" placeholder="Password" autocomplete="new-password">
                <button type="button" class="toggle-pass" data-target="password" aria-label="Mostrar contraseña">Show</button>
            </div>

            <div class="field">
                <svg class="field-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 8h-1V6a5 5 0 0 0-10 0v2H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V10a2 2 0 0 0-2-2zM9 6a3 3 0 0 1 6 0v2H9V6z"/>
                </svg>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" autocomplete="new-password">
                <button type="button" class="toggle-pass" data-target="confirm_password" aria-label="Mostrar contraseña">Show</button>
            </div>

            <label class="terms">
                <input type="checkbox" name="terms">
                <span class="check" aria-hidden="true"></span>
                <span>I accept the terms and conditions</span>
            </label>

            <button type="submit" class="btn-register">Sign up</button>

            <a href="login.php" class="back-login">Already have an account? Login</a>
        </form>
    </main>

    <script src="../resources/js/register.js"></script>
</body>
</html>