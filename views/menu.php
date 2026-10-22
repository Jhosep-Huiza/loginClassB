<?php
session_start();

// Solo usuarios con sesión iniciada
if (empty($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Gourmet - Cafetería</title>
    <style>
        * { box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #0f172a, #1e1b4b);
            font-family: 'Segoe UI', Roboto, sans-serif;
            color: #f8fafc;
            margin: 0;
            padding: 24px 16px;
            display: flex;
            justify-content: center;
            min-height: 100vh;
        }
        .menu-container { width: 100%; max-width: 1000px; }
        .welcome-banner {
            background: linear-gradient(135deg, rgba(79,70,229,.2), rgba(124,58,237,.2));
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            margin-bottom: 32px;
            box-shadow: 0 10px 30px rgba(0,0,0,.3);
            backdrop-filter: blur(10px);
        }
        .welcome-banner h1 {
            margin: 0 0 8px;
            font-size: clamp(24px, 4vw, 32px);
            font-weight: 800;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .welcome-banner p { margin: 0; font-size: 14px; color: #cbd5e1; }
        .category-title {
            font-size: 18px;
            font-weight: 700;
            color: #a5b4fc;
            margin: 32px 0 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            padding-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }
        .product-card {
            background: rgba(30,41,59,.65);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 20px rgba(0,0,0,.2);
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            border-color: rgba(99,102,241,.5);
            box-shadow: 0 12px 30px rgba(0,0,0,.4);
        }
        .product-image {
            display: block;
            width: 100%;
            height: 160px;
            object-fit: cover;
            background: #1e293b;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .product-content { padding: 16px; display: flex; flex-direction: column; flex-grow: 1; }
        .product-info h3 { margin: 0 0 8px; font-size: 16px; color: #fff; font-weight: 600; }
        .product-info p { margin: 0 0 16px; font-size: 12px; color: #cbd5e1; line-height: 1.6; min-height: 58px; }
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,.08);
            padding-top: 12px;
        }
        .price { font-size: 16px; font-weight: 700; color: #38bdf8; white-space: nowrap; }
        .btn-buy {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            border: none;
            padding: 9px 14px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease;
            box-shadow: 0 4px 12px rgba(79,70,229,.2);
        }
        .btn-buy:hover { transform: scale(1.04); box-shadow: 0 6px 15px rgba(79,70,229,.35); }
        .top-actions { display:flex; justify-content:flex-end; margin-bottom:12px; }
        .btn-logout {
            color:#e2e8f0; text-decoration:none; font-size:13px;
            border:1px solid rgba(255,255,255,.16); padding:8px 12px;
            border-radius:9px; background:rgba(15,23,42,.35);
        }
        .btn-logout:hover { background:rgba(255,255,255,.08); }
        @media (max-width: 520px) {
            body { padding: 16px 12px; }
            .welcome-banner { padding: 24px 16px; }
            .menu-grid { grid-template-columns: 1fr; }
            .product-image { height: 190px; }
        }
    </style>
</head>
<body>
<div class="menu-container">
    <div class="top-actions">
        <?php if (!empty($_SESSION['usuario'])): ?>
            <a class="btn-logout" href="../controllers/AuthController.php?logout=1">Cerrar sesión</a>
        <?php endif; ?>
    </div>

    <header class="welcome-banner">
        <h1>☕ COFFEE EXPERIENCE</h1>
        <p>Explora nuestra exclusiva selección artesanal y realiza tu compra al instante.</p>
    </header>

    <section>
        <h2 class="category-title"><span>☕</span> Bebidas calientes</h2>
        <div class="menu-grid">
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0Hu8tdFiI44_KG0-XIZ2LdoblzEo2hIDTEseqlCcx_xs-bumqybiIX7WW&s=10" alt="Espresso Italiano" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Espresso Italiano</h3><p>Extracción intensa de granos seleccionados con una capa de crema avellanada perfecta.</p>
                </div><div class="product-footer"><span class="price">S/. 6.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="1"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSgZUKOk7qinpQRyVlwXrzO_0YPErm72An1fXyBRJWsvZzH0YToRQda9s&s=10" alt="Café Americano" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Café Americano</h3><p>Espresso clásico suavizado con agua caliente, ideal para balancear notas sutiles.</p>
                </div><div class="product-footer"><span class="price">S/. 7.50</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="2"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://www.cremashop.eu/content/www.crema.fi/media/brew-guide/cappuccino/illustration_a0843773f8f66f8f73d538ee472e9155.jpeg" alt="Capuccino Creme" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Capuccino Creme</h3><p>Equilibrio perfecto de espresso, leche vaporizada y una densa corona de espuma.</p>
                </div><div class="product-footer"><span class="price">S/. 9.50</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="3"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQNvVcGCW0CNHDxqftXOjyRL7LMPfqxS8tMs7nTnXZLcWcl94lEQI4K2Y5d&s=10" alt="Chocolate caliente" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Chocolate Caliente</h3><p>Chocolate cremoso preparado con leche caliente y un delicado toque de cacao.</p>
                </div><div class="product-footer"><span class="price">S/. 10.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="8"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
        </div>
    </section>

    <section>
        <h2 class="category-title"><span>❄️</span> Bebidas frías & frappés</h2>
        <div class="menu-grid">
            <article class="product-card">
                <img src="https://lux-gas.com/cdn/shop/articles/salted-caramel-iced-latte-cold-foam-n2o_b6efc998-d31c-4cba-8170-a3d85aca80b3.png?v=1781611101" alt="Iced Latte Caramel" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Iced Latte Caramel</h3><p>Café espresso vertido sobre leche fría, hielo y un toque artesanal de jarabe de caramelo.</p>
                </div><div class="product-footer"><span class="price">S/. 11.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="4"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOcU-ZrNq1D4pLom23Zvd1fNfYi9IdIpY8O1x9MNkt2qD0gNxZg8yBZyr9&s=10" alt="Frappé de Moka" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Frappé de Moka</h3><p>Bebida granizada de café blended con salsa de chocolate de la casa y crema batida.</p>
                </div><div class="product-footer"><span class="price">S/. 13.50</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="5"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://images.unsplash.com/photo-1572490122747-3968b75cc699?auto=format&fit=crop&w=900&q=85" alt="Frappé de fresa" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Frappé de Fresa</h3><p>Bebida fría y cremosa de fresa, mezclada con hielo y un toque de leche.</p>
                </div><div class="product-footer"><span class="price">S/. 12.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="10"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&w=900&q=85" alt="Té helado de durazno" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Té Helado de Durazno</h3><p>Té refrescante servido con hielo y un delicado sabor frutal a durazno.</p>
                </div><div class="product-footer"><span class="price">S/. 8.50</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="11"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
        </div>
    </section>

    <section>
        <h2 class="category-title"><span>🍰</span> Pastelería & postres</h2>
        <div class="menu-grid">
            <article class="product-card">
                <img src="https://perudelights.com/wp-content/uploads/2012/01/Chocolate-cake-12-1024x768.jpg" alt="Torta de fudge" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Torta de Fudge</h3><p>Bizcocho de chocolate con una suave cobertura de fudge, ideal para acompañar tu café.</p>
                </div><div class="product-footer"><span class="price">S/. 10.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="6"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRYbHKWLmOoyaAT3JSzSSpn4JusqaA33EqWnLvyp7r_yT-2TasyLLEg9Rm&s=10" alt="Torta de fresa" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Torta de Fresa</h3><p>Pastel suave con crema y fresas, una opción dulce y fresca para cualquier momento.</p>
                </div><div class="product-footer"><span class="price">S/. 9.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="7"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=900&q=85" alt="Torta tres leches" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Torta Tres Leches</h3><p>Bizcocho esponjoso bañado en tres leches, con una textura suave y cremosa.</p>
                </div><div class="product-footer"><span class="price">S/. 11.00</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="9"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
            <article class="product-card">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT6o4-iIVLqUkw3IyEgS84kL7iR2PYz_5nuW3KT3HagDw&s=10" alt="Pastel Red Velvet" class="product-image">
                <div class="product-content"><div class="product-info">
                    <h3>Pastel Red Velvet</h3><p>Pastel de cacao suave con su característico color rojo y una cremosa cobertura de queso.</p>
                </div><div class="product-footer"><span class="price">S/. 12.50</span>
                    <form action="checkout.php" method="POST"><input type="hidden" name="producto_id" value="12"><button type="submit" class="btn-buy">COMPRAR</button></form>
                </div></div>
            </article>
        </div>
    </section>
</div>
</body>
</html>