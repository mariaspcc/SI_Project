<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];

//abrir o users.txt em csv e transformá-lo em array, em que cada palavra está num índice
$data = fgetcsv(fopen('users.txt', 'r'));
//variáveis ficam true caso email inserido já esteja registado (variável $e) ou o username já esteja a ser usado ($u)
$e = False;
$u = False;

//função que corre caso não haja informações iguais às registadas
function registo($username, $password, $email)
{
    //escrever no ficheiro users.txt, tendo no início uma vírgula para separar da palavra já registada anteriormente
    //e vírgulas entre cada variável
    $filename = 'users.txt';
    $line_to_write = ',' . $username . ',' . $password . ',' . $email;
    file_put_contents($filename, $line_to_write, FILE_APPEND);

    //mandar o mail que confirma que a pessoa se registou e vai para a página inicial
    sendMail($username, $email);
    header("Location: index.php");
}

//função de mandar o mail
function sendMail($username, $email)
{
    $message = "Olá, " . $username . "!
    Acabaste de te registar no site da nossa organização, a Patas Fofas.
    A partir de agora poderás submeter e ver as fotos submetidas por outros utilizadores.
    
    Boas festas,
    Patas Fofas";

    mail($email,
        'Registo em Patas Fofas',
        $message);
}

//verificação da exitência de mail ou username registado que sejam iguais aos inseridos
//se sim, a variável correspondente fica True
for ($i = 0; $i + 2 < count($data); $i += 3) {
    if ($email === $data[$i + 2]) {
        $e = True;
    }
    if ($username === $data[$i]) {
        $u = True;
    }
}

//criação da variável texto que é usada no caso de haver emails e nomes de utilizador iguais
//a variável $erro passa para 1 quando isso acontece e é usado para de seguida saber se é necessário fazer a página html ou nao
if ($e && $u) {
    $text = '<p>Este mail e nome de utilizador já foram utilizados no registo de outra conta.</p>';
    $erro = 1;
} else if ($e) {
    $text = '<p>Este mail já foi utilizado no registo de outra conta.</p>';
    $erro = 1;
} else if ($u) {
    $text = '<p>Este nome de utilizador já foi utilizado no registo de outra conta.</p>';
    $erro = 1;
}

//se existir erro, há criação da página html
if ($erro === 1) {
    ?>

    <!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Patas Fofas</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>
    <?php include 'header.php'; ?>
    <main>
        <div class="erro">
            <div>
                <?php
                echo $text;
                echo '<a href="register.php"><button type="button">Voltar</button></a>';
                ?>
            </div>
        </div>
    </main>

    <hr>
    <?php include 'footer.php'; ?>
    <script src="JavaScript/todas.js"></script>
    </body>
    </html>

    <?php
} //se não existir erro corre a função de registo e vai para a página inicial
else {
    registo($username, $password, $email);
    header('Location: index.php');
}
?>