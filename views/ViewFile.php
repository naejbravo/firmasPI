<?php session_start(); ?>
<!-- El tipo de codificación de datos, enctype, DEBE especificarse como sigue -->
<?php if (isset($_SESSION['id'])) : ?>
    <form enctype="multipart/form-data" action="../controllers/ControllerFile.php" method="POST">
        <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero 
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
        <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
        Enviar este fichero: <input name="file" type="file" />
        <input type="submit" value="Enviar fichero" />
        <!-- Si la variable de sesion con nombre id no tiene nada, volvera a cargar index.php-->
    <?php else : ?>
        <?php header("location: ../index.php") ?>
    <?php endif ?>
    </form>