<?php
session_start();

if(isset($_REQUEST['logar']))
{
    try
   {
       include 'includes/conexao.php';

       $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
       $stmt->bindParam(1, $_REQUEST['usuario']);
       $stmt->bindParam(2, sha1($_REQUEST['senha']));
       $stmt->execute();

       //caso o usuário seja encontrado no banco de dados...
       if($stmt->rowCount() > 0) {
           $dados_usuario = $stmt->fetchObject(); //pega todos os dados do usuário.

           $_SESSION['gescolar_dados_usuario'] = $dados_usuario; //coloca a variavel de sessao

           header("Location: index.php"); //redireciona para a página incial
       }else {
           header("Location: login.php?erro=true"); //caso login der errado
       }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}
?>
<link href="css/estilos.css" type="text/css" rel="stylesheet"/>

<style>
fieldset { width: 15%; margin-top:10%; }
</style>

<fieldset>
    <legend> Login </legend>

    <form method="post" action="login.php?logar=true" >
        <label> Usuário:
            <input name="usuario" type="text" required />
        </label>
        <label>Senha:
            <input name="senha" type="password" required />
        </label>
        <button type="submit">Entra</button>
    </form>
</fieldset>
      