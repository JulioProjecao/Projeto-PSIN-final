<?php
session_start();

$obj_mysqli = new mysqli("127.0.0.1", "root", "", "cadastrologin");

if ($obj_mysqli->connect_errno)
{
    echo "Ocorreu um erro na conexão com o banco de dados.";
    exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');

$email = $_POST['email'];
$senha = $_POST['senha'];

//validando o email e a senha

$result = $obj_mysqli->query("SELECT * FROM tb_login where email = '$email' and senha = '$senha' ");
if(mysqli_num_rows($result) >0){
$_SESSION['email'] = $email;
$_SESSION['senha'] = $senha;
header('location:logado.php');
}
else{
    unset ($_SESSION['email']);
    unset ($_SESSION['senha']);
    
    header('location:index.php');
}
?>



