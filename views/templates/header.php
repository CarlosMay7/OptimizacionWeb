<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <a href="/">
                <h1 class="header__logo">
                    Concentus
                </h1>
            </a>
            <div class="header__contenedor--enlace">
            <?php if(!isAuth()){ ?>
                <a href="/registro" class="header__enlace">Registro</a>
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
                <?php } else { ?>
                <a href="/logout" class="header__enlace">Cerrar Sesión</a>
                <?php if(isAdmin()){ ?>
                        <a href="/admin/inicio" class="header__enlace">Administrar</a> 
                <?php } ?>
            <?php } ?>


            </div>

        </nav>
        <p class = imagegallery__title>LOS MÁS DESTACADOS</p>

    </div>
</header>

<div class="barra">
    <div class="barra__contenido">
        <a class="barra__logo" href="/">
            <h2>
                Concentus
            </h2>
        </a>

        <nav class="navegacion">
        <a href="/nosotros" class="navegacion__enlace <?php echo pagina_actual("/nosotros") ? "navegacion__enlace--actual" : ""; ?>">Nosotros</a>
            <a href="/mis-conciertos" id = "mis-conciertos" class="navegacion__enlace <?php echo pagina_actual("/mis-conciertos") ? "navegacion__enlace--actual" : ""; ?>">Mis Conciertos</a>
            <a href="/conciertos" class="navegacion__enlace <?php echo pagina_actual("/conciertos") ? "navegacion__enlace--actual" : ""; ?>">Conciertos</a>
        </nav>
    </div>
</div>