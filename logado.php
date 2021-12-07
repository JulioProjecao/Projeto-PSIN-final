<?php

$obj_mysqli = new mysqli("127.0.0.1", "root", "", "cadastrologin");

if($obj_mysqli->connect_errno)
{
    echo "Ocorreu um erro na conexão com o banco de dados.";
    exit;
}

mysqli_set_charset($obj_mysqli, 'utf8');
$id = -1;
$nome = "";
$email = "";
$senha = "";
$cargo = "";
//Validando a existencia dos dados
if(isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"]) && isset($_POST["cargo"]))
{
    if(empty($_POST["nome"]))
        $erro = "Campo nome obrigatorio";
    else
        if(empty ($_POST["email"]))
            $erro = "Campo e-mail obrigatorio";
        else{
            $id    = $_POST["id"];
            $nome  = $_POST["nome"];
            $email = $_POST["email"];
            $senha = $_POST["senha"];
            $cargo = $_POST["cargo"];
            //Se o id for -1, vamos realizar o cadastro ou alteração dos dados enviados.
            if($id == -1)
            {
                $stmt = $obj_mysqli->prepare("INSERT INTO tb_login (nome,email,senha,cargo) VALUES(?,?,?,?)");
                $stmt->bind_param('ssss', $nome, $email, $senha, $cargo);
                
                if(!$stmt->execute()){
                    $erro = $stmt->error;
                }
                else{
                    header("Location:logado.php");
                    exit;
                }
            }
            
            else
            if(is_numeric($id) && $id >= 1){
                $stmt = $obj_mysqli->prepare("UPDATE tb_login SET nome =?,"
                        ." email =?, senha =?, cargo =? WHERE id = ? ");
                $stmt->bind_param('ssssi', $nome, $email, $senha, $cargo, $id);
                
                if(!$stmt->execute()){
                    $erro = $stmt->error;
                }
                else{
                    header("Location:logado.php");
                    exit;
                }
                
            }
            //retorna erro.
            else{ $erro = "Número inválido";
        }
}
}

else 
    
    if(isset ($_GET["id"]) && is_numeric($_GET["id"])){
        
        $id = (int)$_GET["id"];
        
        if(isset($_GET["del"])){
            $stmt = $obj_mysqli->prepare("DELETE FROM tb_login WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
            header("Location:logado.php");
            exit;
        }else{
            $stmt = $obj_mysqli->prepare("SELECT * FROM tb_login WHERE id= ?");
            
            $stmt->bind_param('i', $id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            $aux_query = $result->fetch_assoc();
            
            
            $email = $aux_query["email"];
            $senha = $aux_query["senha"];
            $cargo = $aux_query["cargo"];
            $stmt->close();
        }
    }
    ?>
<!-- DOCTYPE html -->
<html>
    <head>
        <title>CRUD com PHP</title>
        <link rel="stylesheet"  href="Estilo/style.css" >
    </head>
    <body>
        <?php
        if(isset($erro))
            echo '<div style="color:#F00">'.$erro.'</div><br/><br>';
        else
            if(isset($sucesso))
                echo '<div style="color:#00f">'.$sucesso.'</div><br><br/>';
        ?>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            
            <h1>Editar Dados</h1>
            Nome:<br/>
            <input type="text" name="nome" placeholder="Nome para Cadastro."
                   value="<?=$nome?>"><br/><br/>
            
             E-mail:<br/>
            <input type="email" name="email" placeholder="E-mail para Cadastro."
                   value="<?=$email?>"><br/><br/>
            
             Senha:<br/>
             <input type="password" name="senha" placeholder="senha para Cadastro."
                   value="<?=$senha?>"><br/><br/>
              Cargo:<br/>
             <input type="text" name="cargo" placeholder="Cargo na Empresa."
                   value="<?=$cargo?>"><br/><br/>
             <br/><br/>
             <input type="hidden" value="<?=$id?>" name="id">
             
             <button type="submit"><?=($id==1)?"Cadastrar":"Salvar"?></button>
             <a href="login.php">Encerrar Sessão</a>
        </form>
        <br>
        <br>
           
                 
        <table width="700px" border="1" cellspacing="0">
           
            <tr>  
            <h3>Lista de Funcionarios<h3/>            
                <td><strong>#</strong></td><br>
                <td><strong>Nome</strong></td>
                <td><strong>Email</strong></td>
                <td><strong>Senha</strong></td>
                <td><strong>Cargo</strong></td>
                <td><strong>#</strong></td>
                <td><strong>#</strong></td>
            </tr>
            <?php
            $result = $obj_mysqli->query("SELECT * FROM tb_login");
            while ($aux_query = $result->fetch_assoc())
            {
                echo '<tr>';
                echo '  <td>'.$aux_query["id"].'</td>';
                echo '  <td>'.$aux_query["NOME"].'</td>';
                echo '  <td>'.$aux_query["email"].'</td>';
                echo '  <td>'.$aux_query["senha"].'</td>';
                echo '  <td>'.$aux_query["cargo"].'</td>';
                echo '  <td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["id"].'">'
                        . 'Editar</a></td>';
                echo '<td><a href="'.$_SERVER["PHP_SELF"].'?id='.$aux_query["id"].'&del=true">'
                        . 'Excluir</a></td>';
                echo '</tr>';
            }
            ?>
            
        </table>
             
        
        </form>
    </body>
</html>
