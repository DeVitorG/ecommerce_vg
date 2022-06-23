    <?php
    include '../includes/config.php';
    include '../includes/funcoes.php';
    if(isset($_POST) && isset($_POST['nome_produto']) && isset($_POST['valor'])) {
        $nome_produto = isset($_POST['nome_produto']) ?  $_POST['nome_produto'] : null;
        $valor = isset($_POST['valor']) ? brl2decimal($_POST['valor']) : null;
        if(!$nome_produto && !$valor){
          $mensagem = 'Todos os campos devem ser preenchidos para prosseguir!!';
          $status = true;
          $class = 'erro';
        }else{
            $sql = "INSERT INTO produtos (nome_produto, valor) VALUES ('$nome_produto','$valor')";
    
            if (mysqli_query($conexao, $sql)) {
                $mensagem = "Cadastro de produto efetuado com sucesso";
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
        <title>Cadastro de Produtos</title> 
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
                    <button class="incluir" onclick="window.location='<?=$host?>/produtos/incluir.php'">Incluir</button>
                    </div>
                    <div id="corpo">
                        <form action="" method="post">
            
                            <div id="input">
                                <label>Nome do Produto</label>
                                <input type="text" name="nome_produto" id="nome_produto">
                            </div>

                            <div id="input">
                                <label>Valor</label>
                                <input  name="valor" id="valor">   
                            </div>
                                
                            <input id="acao" type="submit" value="Cadastrar">


                        </form>
                    </div>
                    
                </div>
            </div>
            <?=($status ? '<div id="notify" class = "'.$class.'">'.$mensagem.'</div><script>notificacao();</script>' : "")?> 
        </body>
    </html>


        