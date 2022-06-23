<?php
function validarCPF($cpf){
	$cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
	if(strlen($cpf) != 11 || $cpf == "00000000000" || $cpf == "11111111111" || $cpf == "22222222222" || $cpf == "33333333333" || $cpf == "44444444444" || $cpf == "55555555555" || $cpf == "66666666666" || $cpf == "77777777777" || $cpf == "88888888888" || $cpf == "99999999999") return false;
	for($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--) $soma += $cpf[$i] * $j;
	$resto = $soma % 11;
	if($cpf[9] != ($resto < 2 ? 0 : 11 - $resto)) return false;
	for($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--) $soma += $cpf[$i] * $j;
	$resto = $soma % 11;
	return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
}
?>

<?php
	function brl2decimal($brl, $casasDecimais = 2) {
    // Se já estiver no formato USD, retorna como float e formatado
    if(preg_match('/^\d+\.{1}\d+$/', $brl))
        return (float) number_format($brl, $casasDecimais, '.', '');
    // Tira tudo que não for número, ponto ou vírgula
    $brl = preg_replace('/[^\d\.\,]+/', '', $brl);
    // Tira o ponto
    $decimal = str_replace('.', '', $brl);
    // Troca a vírgula por ponto
    $decimal = str_replace(',', '.', $decimal);
    return (float) number_format($decimal, $casasDecimais, '.', '');
}
?>

