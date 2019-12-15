
 <?php
    include_once "acess_bd.php";?>
<nav
<div class="barra">
    <div id="logo">
        <?php
        if (isset($_SESSION['success'])) {
        $username = $_SESSION['username'];
        $administrador = "SELECT username FROM usergeral WHERE username='$username' AND administrador = true";
        $resultadmin = pg_query($connection, $administrador);
        $cliente = "SELECT username FROM usergeral WHERE username='$username' AND administrador = false";
        $resultcliente = pg_query($connection, $cliente);

        if (pg_affected_rows($resultadmin) == 1 && pg_affected_rows($resultcliente) == 0) { ?>
            <a href="Homepage_Administrador.php">
                <p>LDMEats</p>
            </a>
        <?php }
        else if (pg_affected_rows($resultadmin) == 0 && pg_affected_rows($resultcliente) == 1) { ?>
            <a href="Homepage_Cliente.php">
                <p>LDMEats</p>
            </a>
        <?php }}

        else { ?>
        <a href="Homepage_Geral.php">
            <p>LDMEats</p>
        </a>
        <?php }?>


    </div>
    <div id="botaoheader">
        <?php
        if (isset($_SESSION['success']) && $_SESSION['success']) { ?>
            <div id="user_atual">
                <?php
                $username = $_SESSION['username'];
                echo $username; ?>
            </div>
            <a href="logout.php">
                <input type="submit" value="Sair" name="logout">
            </a>
        <?php } else { ?>
            <a href="login.php">
                <input type="submit" value="Entrar" name="login">
            </a>
        <?php } ?>
    </div>

</div>
</nav>
