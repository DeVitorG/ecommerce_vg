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
        $sql = "SELECT COUNT(*) FROM clientes WHERE ativo = '0' AND id_cliente = $id";
        $rs = mysqli_query($conexao,$sql);
        $row = mysqli_num_rows($rs);
        if($row <= 0) $result['msg'] = 'O cliente selecionado não foi encontrado.';
        else{
            $sql = mysqli_query($conexao,"UPDATE clientes SET ativo = '1' WHERE id_cliente = $id");
            if ($sql){
                $result['status'] = true;
                $result['msg'] = "O cliente foi excluído com sucesso";
            }
            else $result['msg'] = "Ocorreu um erro, por gentileza, tente novamente!";
        }
    } else $result['msg'] = 'Nenhum cliente foi selecionado';
    echo json_encode($result);
}
?> 

