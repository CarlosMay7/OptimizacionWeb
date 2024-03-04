<div class="alertas">
    <?php require_once __DIR__ . "/../templates/alertas.php"; ?>
</div>

<div class="elementos-busqueda">
    <form class="busqueda" action="/agregar" method="POST">  
        <textarea class="busqueda__barra" name="feeds" id="url" cols="30" rows="2" placeholder="Agregue su feed"><?php foreach($urls as $url){echo $url ?? "";}?></textarea>

        <button type="submit" class="busqueda__submit">Buscar</button>
    </form>  
    
    <form class="filtros" action="/" method="GET">
        <input type="search" class="filtrado" name="filtrado" value="<?= $busqueda; ?>" placeholder="Buscar relacionados">
        
        <select class="filtro" name="filtros" id="filtro" >
            <option class="filtro__opcion" value="newsDate" <?= $orden == "newsDate" ? "selected" : "";?>>Fecha</option>
            <option class="filtro__opcion" value="newsTitle" <?= $orden == "newsTitle" ? "selected" : "";?>>Título</option>
            <option class="filtro__opcion" value="categoryName" <?= $orden == "categoryName" ? "selected" : "";?>>Categoria</option>
        </select>
        
        <button class="busqueda__submit">Filtrar</button>
        <div class="actualizar">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-reload actualizar__icono" width="36" height="36" viewBox="0 0 24 24" stroke-width="1.5" stroke="#57017e" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                <path d="M20 4v5h-5" />
            </svg>
        </div>    
    </form>

    
</div>
    
<main class="feeds">
    <div class="feed <?= empty($datos) ? "feed--vacio" : ""; ?>" id="feed">
        <div class="feed__cuerpo">

            <?php
                if(!empty($datos)){
                    foreach($datos as $articulo) {
            ?>
                        <article class="articulo">
                            <a href="<?= $articulo["feedUrl"];?>" class="articulo__icono">
                                <img src="<?= $articulo["feedIcon"];?>" alt="Icono Feed">
                            </a>
                            <header>
                                <h3 class="articulo__titulo"><a href="<?= $articulo["feedUrl"];?>" class="articulo__link"><?= $articulo["newsTitle"];?></a></h3>
                                <p class="articulo__autor"><span class="articulo__autor--titulo">Feed: </span><?= $articulo["feedName"];?></p>
                                <p class="articulo__fecha"><span class="articulo__fecha--titulo">Fecha: </span><?= explode(',',$articulo["newsDate"])[0];?></p>
                                <p class="articulo__categoria"><span class="articulo__categoria--titulo">Categoria: </span><?= $articulo["categoryName"];?></p>
                                <p class="articulo__descripcion"><?= $articulo["newsDescription"];?></p>
                            </header>

                            <div class="articulo__imagen-contenedor">
                                <a href="<?= $articulo["newsUrl"];?>">
                                    <img class="articulo__imagen" src="<?=!empty($articulo['newsImage']) ? $articulo['newsImage'] : '/img/feedHub.png';?>">
                                </a>
                            </div>
                        </article>
            <?php
                    }
                } else {
            ?>
                <h2 class="no-feed">No se encontraron Feeds</h2>
            <?php
                }
            ?>
        </div>
    </div>        
</main>