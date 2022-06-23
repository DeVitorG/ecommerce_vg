<?php
include '../includes/config.php';
$id = isset($_GET['id']) ? $_GET['id'] : null;
if(isset($_POST) && isset($_POST['nome_produto']) && isset($_POST['valor'])) {
	$nome_produto = isset($_POST['nome_produto']) ? $_POST['nome_produto'] : null;
	$valor = isset($_POST['valor']) ? $_POST['valor'] : null;
    if(!$nome_produto &&  !$valor){
        $mensagem = 'Todos os campos devem ser preenchidos para prosseguir!!';
        $status = true;
        $class = 'erro';
    }else{
        $sql = "UPDATE produtos SET nome_produto='$nome_produto', valor='$valor' WHERE id_produto=$id";

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

        <title>Edita Produtos</title>
    </head>
    <body>
        <?php
        include '../includes/css_js.php';
        $sql = "SELECT * FROM produtos WHERE id_produto=$id";
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
                    <button class="editar" onclick="editar('<?=$host?>/produtos/editar.php');" disabled>Editar</button>
                </div>
                <div id="corpo">
                    <?php
                        if($row>=0){
                    ?>
                <form action="" method="post">
                    
                    <div id="input">
                        <label>Nome do Produto</label>
                        <input type="text" name="nome_produto" id="nome_produto"value="<?=$user_data['nome_produto']?>">
                    </div>

                    <div id="input">
                        <label>Valor</label>
                        <input type="text" name="valor" id="valor"value="<?=$user_data['valor']?>">
                    </div>
                    <input id="acao" type="submit" value="Alterar">
                    </form>
                    <?php
                    }
                        else 
                        echo '<div id="sem_resultado">Produto não encontrado</div>';
                    ?>
                </div>
            </div>
        </div>
        <?=($status ? '<div id="notify" class = "'.$class.'">'.$mensagem.'</div><script>notificacao();</script>' : "")?> 
    </body>
</html>