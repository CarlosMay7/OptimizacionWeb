<?php
    foreach($errores as $key => $alerta){
        foreach ($alerta as $mensaje){
?>

<div class="alerta alerta__<?php echo $key; ?>">
    <?php echo $mensaje; ?>
</div>

<?php
        }//Fin foreach alertas
    }//Fin foreach mensaje
?>