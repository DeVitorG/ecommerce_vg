<?php
include '../includes/config.php';
include '../includes/funcoes.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
if(isset($_POST) && isset($_POST['nome']) && isset($_POST['cpf']) && isset($_POST['telefone'])) {
	$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
	$cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
	$telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
    if(!$nome && !$cpf && !$telefone){
        $mensagem = 'Todos os campos devem ser preenchidos para prosseguir!!';
        $status = true;
        $class = 'erro';
    }else{
        $sql = "=UPDATE clientes SET nome='$nome', cpf='$cpf', telefone'$telefone' WHERE id_cliente=$id";

        if (mysqli_query($conexao, $sql)) {
            $mensagem = "Alteração concluída";
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
else $status=false;
?>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Edita Clientes</title>
    </head>
    <body>
        <?php
        include '../includes/css_js.php';
        $sql = "SELECT * FROM clientes WHERE id_cliente=$id";
        $result = $conexao->query($sql);
        $user_data = mysqli_fetch_assoc($result);
        $row = mysqli_num_rows($result);
        ?>
        <div id="site">
            <?php
            include '../includes/header.php';
            ?>
            <div id="conteudo">
                <div id="opcoes">
                    <button class="editar" onclick="editar('<?=$host?>/clientes/editar.php');" disabled>Editar</button>
                </div>
                <div id="corpo">
                    <?php
                        if($row>=0){
                    ?>
                    <form action="" method="post">
                        
                        <div id="input">
                        <label>Nome</label>
                            <input type="text" name="nome" id="nome" value="<?=$user_data['nome']?>">
                            
                        </div>

                        <div id="input">
                            <label>CPF</label>
                            <input onchange="validaCPF(this);" alt="cpf" type="text" name="cpf" id="cpf" value="<?=$user_data['cpf']?>">   
                        </div>
                        <div id="input">
                            <label>Telefone</label>
                            <input alt="phone" type="text" name="telefone" id="telefone" value="<?=$user_data['telefone']?>">
                        </div>
                        
                        <input id="acao" type="submit" value="Alterar">
                        
                    </form>
                    <?php
                    }
                        else 
                        echo '<div id="sem_resultado">Cliente não encontrado</div>';
                    ?>
                </div>
            </div>
        </div>
        <?=($status ? '<div id="notify" class = "'.$class.'">'.$mensagem.'</div><script>notificacao();</script>' : "")?> 
    </body>
</html>








