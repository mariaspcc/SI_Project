<nav
<div class="barra">
    <div id="logo">
        <p>LDMEats</p>
    </div>
    <div>
        <?php
        if ( isset($_SESSION['sucess']) && $_SESSION['sucess'] ) { ?>
            <a href="login.php">
                <input type="submit" value="Sair" name="logout">
            </a>
        <?php }
        else { ?>
            <a href="login.php">
                <input type="submit" value="Entrar" name="login">
            </a>
        <?php } ?>
    </div>

</div>
</nav>
