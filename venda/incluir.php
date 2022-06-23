<?php
    include '../includes/config.php';
    include '../includes/funcoes.php';
    if(isset($_POST) && isset($_POST['clientes']) && isset($_POST['metodoPag']) && isset($_POST['parcelas']) && isset($_POST['produtos'])) {
        $clientes = isset($_POST['clientes']) ? $_POST['clientes'] : null;
        $metodoPag = isset($_POST['metodoPag']) ? $_POST['metodoPag'] : null;
        $parcelas = isset($_POST['parcelas']) ? $_POST['parcelas'] : null;
        $produtos = isset($_POST['produtos']) ? $_POST['produtos'] : null;

        if(!$clientes && !$metodoPag && !$parcelas && !$produtos){
          $mensagem = 'Todos os campos devem ser preenchidos para prosseguir!!';
          $status = true;
          $class = 'erro';
        }else{
            $sql = "INSERT INTO vendas (id_cliente, data_venda, metodo_pag, num_parc, id_produto) VALUES ('$clientes', now(),'$metodoPag','$parcelas', $produtos)";
    
            if (mysqli_query($conexao, $sql)) {
                $mensagem = "Cadastro de venda efetuado com sucesso";
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
    //Clientes
    $sql_clientes = "SELECT id_cliente, nome from clientes where ativo = 0";
    $clientes = mysqli_query($conexao,$sql_clientes);

    $sql_produtos = "SELECT id_produto, nome_produto from produtos where ativo = 0";
    $produtos = mysqli_query($conexao,$sql_produtos);
    
    // foreach($clientes as $key=>$cliente) { var_dump( $cliente["nome"]);}
?>
<html>
    <head>
        <title>Realizar Venda</title>
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
                <div id="corpo_1">
                    <form action="" method="post">
                    
                    <div class="select_input">
                        <label >Cliente:</label>
                        <select name="clientes" id="input" style="border-radius: 5px;">
                            <option value="-1">Selecione um cliente</option>
                            <?php foreach($clientes as $cliente): ?>
                                <option value="<?= $cliente["id_cliente"] ?>"><?= $cliente["nome"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="select_input">
                        <label >Pagamento:</label>
                        <select name="metodoPag" id="input" style="border-radius: 5px;">
                            <option value="-1">Selecione um método de pagamento</option>
                            <option value="v">Dinheiro</option>
                            <option value="c">Crédito</option>
                            <option value="d">Débito</option>
                        </select>
                    </div>
                    
                    <div class="select_input">
                        <label >Parcelas:</label>
                        <select name="parcelas" id="input" style="border-radius: 5px;">
                            <option value="-1">Selecione a parcela</option>
                            <option value="1">1x</option>
                            <option value="2">2x</option>
                            <option value="3">3x</option>
                            <option value="4">4x</option>
                            <option value="5">5x</option>
                            <option value="6">6x</option>
                            <option value="7">7x</option>
                        </select>

                        <div class="select_input">
                        <label >Produto:</label>
                        <select name="produtos" id="input" style="border-radius: 5px;">
                            <option value="-1">Selecione um produto</option>
                            <?php foreach($produtos as $produto): ?>
                                <option value="<?= $produto["id_produto"] ?>"><?= $produto["nome_produto"] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    </div>
                        <input id="acao" type="submit" value="Realizar Venda">
                    </form>
                </div>
            </div>
        </div>
        <?=($status ? "<script>notificacao('".$mensagem."','".$class."');</script>" : "")?> 
    </body>
</html>
