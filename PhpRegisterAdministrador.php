<?php
include_once "acess_bd.php";

//buscar dados
if(isset($_POST['register'])) {
    $username = $_POST['a_username'];
    $password = $_POST['a_password'];

    $query1="SELECT * FROM usergeral WHERE ('$username' = username)";
    $result1 = pg_query($connection, $query1);

    $name_error = "O username já existe.";

    //caso não exista, insere registo na BD
    if (pg_affected_rows($result1)> 0) {
        $name_error = "O username já existe.";
    } else {
        $query = "INSERT INTO usergeral (username, password, administrador) VALUES ('$username', '$password', true)";
        $result = pg_query($connection, $query);
        $query2 = "INSERT INTO administrador (usergeral_username) VALUES ('$username')";
        $result2 = pg_query($connection, $query2);

        //echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
}

//fecha ligação à BD
pg_close($connection);

?>