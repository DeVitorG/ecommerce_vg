
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Produtos Cadastrados</title>
    </head>
    <body>
        <?php
        include_once '..\includes\config.php';
        include '../includes/css_js.php';
        $sql = "SELECT * FROM produtos WHERE ativo = '0'";
        $result = mysqli_query($conexao,$sql);
        ?>
    <div id="site">
            <?php
            include '../includes/header.php';
            ?>
            <div id="conteudo">
                <div id="opcoes">
                    <button class="incluir" onclick="window.location='<?=$host?>/produtos/incluir.php'">Incluir</button>
                    <button class="editar" onclick="editar('<?=$host?>/produtos/editar.php');" disabled>Editar</button>
                    <button class="excluir" onclick="excluir('<?=$host?>/produtos/excluir.php');" disabled>Excluir</button>
                </div>
            <div id="corpo">
                <table cellpadding="0" cellspacing="0" id="lista">
                 <thead>
                <tr>
                    <th scope="col">COD</th>
                    <th scope="col">NOME DO PRODUTO</th>
                    <th scope="col">VALOR</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    while($user_data = mysqli_fetch_assoc($result))
                    {
                        echo '<tr ondblclick="editar(\''.$host.'/produtos/editar.php\');">';
                        echo '<td><input type="radio" name="id" value="'.$user_data['id_produto'].'" id="id_'.$user_data['id_produto'].'">' .$user_data['id_produto'].'</td>';
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

