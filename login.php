<?php
session_start();
$data = fgetcsv(fopen('users.txt', 'r'));
$text = '<p>Combinação nome de utilizador/password não existente.</p>';

for ($i = 0; $i + 2 < count($data); $i += 3) {
    if ($_POST['username'] === $data[$i] && $_POST['password'] === $data[$i + 1]) {
        $_SESSION['logged'] = True;
    }
}
if (!isset($_SESSION['logged'])) {
    $_SESSION['logged'] = False;
}


if ($_SESSION['logged'] === True) {
    header("Location: index.php");
}
else {
}
?>