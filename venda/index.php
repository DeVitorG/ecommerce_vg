<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Vendas Realizadas</title>
    </head>
    <body>
        <?php
        include_once '..\includes\config.php';
        include '../includes/css_js.php';
        $sql = "SELECT v.id_venda, c.nome, p.nome_produto, p.valor FROM  vendas v, clientes c, produtos p WHERE v.id_cliente = c.id_cliente AND v.id_produto = p.id_produto AND ativos = '0'";
        $result = mysqli_query($conexao,$sql);
        ?>
    <div id="site">
            <?php
            include '../includes/header.php';
            ?>
            <div id="conteudo">
                <div id="opcoes">
                    <button class="incluir" onclick="window.location='<?=$host?>/venda/incluir.php'">Realizar venda</button>
                    <button class="excluir" onclick="excluir('<?=$host?>/venda/excluir.php');" disabled>Excluir venda</button>
                </div>
            <div id="corpo">
                <table cellpadding="0" cellspacing="0" id="lista">
                 <thead>
                <tr>
                    <th scope="col">COD</th>
                    <th scope="col">NOME</th>
                    <th scope="col">NOME_PRODUTO</th>
                    <th scope="col">VALOR</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    while($user_data = mysqli_fetch_array($result))
                    {
                        echo '<td><input type="radio" name="id" value="'.$user_data['id_venda'].'" id="id_'.$user_data['id_venda'].'">' .$user_data['id_venda'].'</td>';
                        echo '<td>' .$user_data['nome'].'</td>';
                        echo '<td>' .$user_data['nome_produto'].'</td>';
                        echo '<td>' .$user_data['valor'].'</td>';
                        echo '</tr>';
                    }
                ?>               
            </tbody>
            </div>
        </div>
    </div>
    </body>
</html>