<?php
include 'includes/config.php';
?>
<html> 
    <head> 
        <tittle> 
            <?php
            include 'includes/css_js.php';
            ?>
    </head>
    <body>
        <div id="site">
            <?php
            include 'includes/header.php';
            ?>
            <div id="conteudo">
            <div id="opcoes">
                    <button class="incluir" onclick="window.location='<?=$host?>/clientes/incluir.php'">Incluir</button>
                    <button class="editar" onclick="editar('<?=$host?>/clientes/editar.php');" disabled>Editar</button>
                    <button class="excluir" onclick="excluir('<?=$host?>/clientes/excluir.php');" disabled>Excluir</button>
                </div>
                <div id="corpo"></div>
            </div>
        </div>
    </body>
</html>


     