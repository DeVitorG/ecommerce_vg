<?php
$referencia = isset($_SERVER['HTTP_REFERER']) ? explode('/', str_replace(array('http://', 'https://'), '', $_SERVER['HTTP_REFERER'])) : false;
$referrer = is_array($referencia) ? $referencia[0] : $referencia;
if($referrer != $_SERVER['HTTP_HOST'] || $_SERVER['REQUEST_METHOD'] !== 'POST'){
	header('Location: http://'.$_SERVER['HTTP_HOST']);
	exit();
} else {
    include '../includes/config.php';
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $result = array();
    $result['status'] = false;
    if($id){
        $sql = "SELECT COUNT(*) FROM vendas WHERE ativos = '0' AND id_venda = $id";
        $rs = mysqli_query($conexao,$sql);
        $row = mysqli_num_rows($rs);
        if($row <= 0) $result['msg'] = 'A venda selecionada não foi encontrada.';
        else{
            $sql = mysqli_query($conexao,"UPDATE vendas SET ativos = '1' WHERE id_venda = $id");
            if ($sql){
                $result['status'] = true;
                $result['msg'] = "A venda foi excluída com sucesso";
            }
            else $result['msg'] = "Ocorreu um erro, por gentileza, tente novamente!";
        }
    } else $result['msg'] = 'Nenhuma venda foi selecionado';
    echo json_encode($result);
}
?> 

