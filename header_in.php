<nav
<div class="barra">
    <div id="logo">
        <p>LDMEats</p>
    </div>
<div>
    <input id="pesquisa" type="text" placeholder="Pesquisa">
</div>
    <div  id="botaoheader">
        <?php
        if ( isset($_SESSION['success']) && $_SESSION['success'] ) {?>
            <div id="user_atual">
            <?php echo $_SESSION['username']; ?>
            </div>
            <a href="logout.php">
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
