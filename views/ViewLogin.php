<?php session_start() ?>
<?php if (isset($_SESSION['id'])) : ?>
    <?php echo "Ya has iniciado sesion"; ?>

<?php else : ?>
    <?php
    if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        echo "<br>";
    }
    ?>
    <!-- Formulario para iniciar sesion -->
    <form method="post" action="../controllers/ControllerLogin.php" name="login">
        <div class="form-element">
            <label>Usuario</label>
            <input type="text" name="username" pattern="[a-zA-Z0-9]+" required />
        </div>
        <div class="form-element">
            <label>Contraseña</label>
            <input type="password" name="password" required />
        </div>

        <button type="submit" name="login" value="login">Log In</button>
    </form>
<?php endif ?>