<?php
include '../includes/config.php';
include '../includes/funcoes.php';
if(isset($_POST) && isset($_POST['nome']) && isset($_POST['cpf']) && isset($_POST['telefone'])) {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
    if(!$nome && !$cpf && !$telefone){
      $mensagem = 'Todos os campos devem ser preenchidos para prosseguir!!';
      $status = true;
      $class = 'erro';
    }else{
        $sql = "INSERT INTO clientes (nome, cpf, telefone) VALUES ('$nome','$cpf','$telefone')";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "Cadastro de cliente efetuado com sucesso";
            $status = true;
            $class = 'sucesso';
        } 
        else {
            $mensagem = $conexao->error;
            $status = true;
            $class = 'erro';

        }
    } 
}
else $status = false;
?>
<html>
    <head>
        <title>Cadastro de Clientes</title>
        <?php
        include '../includes/css_js.php';
        ?>
    </head>
    <body>
        <div id="site">
            <?php
            include '../includes/header.php';
            ?>
            <div id="conteudo">
                <div id="opcoes">
                    <button class="incluir" onclick="window.location='<?=$host?>/clientes/incluir.php'">Incluir</button>
                </div>
                <div id="corpo">
                    <form action="" method="post">
                        
                        <div id="input">
                            <label>Nome</label>
                            <input type="text" name="nome" id="nome">
                        </div>

                        <div id="input">
                            <label>CPF</label>
                            <input onchange="validaCPF(this);" alt="cpf" type="text" name="cpf" id="cpf">   
                        </div>
                        <div id="input">
                            <label>Telefone</label>
                            <input alt="phone" type="text" name="telefone" id="telefone">
                        </div>
                        <input id="acao" type="submit" value="Cadastrar">
                    </form>
                </div>
            </div>
        </div>
        <?=($status ? "<script>notificacao('".$mensagem."','".$class."');</script>" : "")?> 
    </body>
</html>
