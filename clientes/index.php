<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Clientes Cadastrados</title>
    </head>
    <body>
        <?php
        include_once '..\includes\config.php';
        include '../includes/css_js.php';
        $sql = "SELECT * FROM clientes WHERE ativo = '0'";
        $result = mysqli_query($conexao,$sql);
        ?>
    <div id="site">
            <?php
            include '../includes/header.php';
            ?>
            <div id="conteudo">
                <div id="opcoes">
                    <button class="incluir" onclick="window.location='<?=$host?>/clientes/incluir.php'">Incluir</button>
                    <button class="editar" onclick="editar('<?=$host?>/clientes/editar.php');" disabled>Editar</button>
                    <button class="excluir" onclick="excluir('<?=$host?>/clientes/excluir.php');" disabled>Excluir</button>
                </div>
            <div id="corpo">
                <table cellpadding="0" cellspacing="0" id="lista">
                 <thead>
                <tr>
                    <th scope="col">COD</th>
                    <th scope="col">NOME</th>
                    <th scope="col">CPF</th>
                    <th scope="col">TELEFONE</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    while($user_data = mysqli_fetch_array($result))
                    {
                        echo '<tr ondblclick="editar(\''.$host.'/clientes/editar.php\');">';
                        echo '<td><input type="radio" name="id" value="'.$user_data['id_cliente'].'" id="id_'.$user_data['id_cliente'].'">' .$user_data['id_cliente'].'</td>';
                        echo '<td>' .$user_data['nome'].'</td>';
                        echo '<td>' .$user_data['cpf'].'</td>';
                        echo '<td>' .$user_data['telefone'].'</td>';
                        echo '</tr>';
                    }
                ?>               
            </tbody>
            </div>
        </div>
    </div>
    </body>
</html>












