<?php
include_once "acess_bd.php";

//buscar dados
if(isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $submit = $_POST ['submit'];

    $query1 = "SELECT * FROM administrador WHERE ('$username' = user_username)";
    $query2 = "SELECT * FROM cliente WHERE ('$username' = user_username)";

    $name_error = "O username já existe.";

    $result1 = pg_query($connection, $query1);
    $result2 = pg_query($connection, $query2);

    //caso não exista, insere registo na BD
    if (pg_num_rows($result1) > 0 || pg_num_rows($result2) > 0) {
        $name_error = "O username já existe.";
    } else {
        $query = "INSERT INTO administrador (user_username, user_password) VALUES ('$username', '$password')";
        $result = pg_query($connection, $query);
        echo "SAVED";
        //exit();
        header('location: Homepage_Administrador.php');
    }
}

//fecha ligação à BD
pg_close($connection);

?>