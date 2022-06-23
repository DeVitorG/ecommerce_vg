$(document).ready( function() {
    if ($('input').length) $('input').setMask();
    
	$('#telefone').unbind('keyup');
    
	// Telefone
	$('#telefone').bind('keyup', function(){
		if ($(this).val().length > 13) $(this).attr('alt','cel');
        else $(this).attr('alt','phone');
        $('#telefone').setMask();
    });

	//Valor
	$('#valor').attr('alt','decimal');
	$('#valor').setMask();


	// Lista
	$('#lista tbody tr').bind('click',function(){
		$('input[name="id"]').attr('checked', false);
		$('#lista tbody tr').removeClass('marcado');
		$(this).find('input[name="id"]').attr('checked', true);
		$(this).addClass('marcado');
		$('#opcoes button').attr('disabled',false);
	});

	
	


});
function validarCPF(cpf){
	cpf = cpf.replace(/[^\d]+/g,'');
	if(cpf == '') return false;
	if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") return false;
	add = 0;
	for (i=0; i < 9; i ++) add += parseInt(cpf.charAt(i)) * (10 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11) rev = 0;
	if (rev != parseInt(cpf.charAt(9))) return false;
	add = 0;
	for (i = 0; i < 10; i ++) add += parseInt(cpf.charAt(i)) * (11 - i);
	rev = 11 - (add % 11);
	if (rev == 10 || rev == 11) rev = 0;
	if (rev != parseInt(cpf.charAt(10))) return false;
	return true;
}
function validaCPF(cpf){
	var validacpf = validarCPF(cpf.value);
	if(!validacpf && cpf.value.length) alert('CPF NÃO É VÁLIDO!');
}
var tempo_notificacao=0;
function notificacao(msg,classe){
	if($('div#notify').length) $('div#notify').fadeOut(150,function(){$(this).remove()});                            
	$('<div id="notify" class = "' + classe + '">' + msg + '</div>').appendTo('body').fadeIn(150, function(){
		clearInterval(tempo_notificacao);
   		tempo_notificacao = window.setTimeout(function(){
			$('#notify').remove();
		},3000);
	});

}
function editar(url){
	window.location=url + '?id=' + $('input[name=id]:checked').val();
}
function excluir(url){
	var id = $('#lista input[name="id"]:checked').val();
	if(id != "" && confirm('Você deseja excluir o registro?')){
		 $.ajax({
			type: 'POST',
			url: url,
			data: {
				id: id
			},
			dataType: 'json',
			beforeSend: function(){
				carregando(true);
			},
			error: function(request, status, errorThrown){
				carregando(false);
				if(status != 'abort'){
					if(request.status == 0) alert('A conexão foi recusada, verifique se você está conectado à internet.');
					else if(request.status == 400) alert('Não é possível processar sua solicitação. Tente novamente em instantes.');
					else if(request.status == 401 || request.status == 403) alert('Você não tem autorização para realizar essa requisição.');
					else if(request.status == 404) alert('A página selecionada não foi encontrada.');
					else if(request.status == 408) alert('Tempo de solicitação esgotada! Verifique se está conectado à internet e tente novamente em instantes.');
					else if(request.status == 500 || request.status == 502) alert('Ocorreu um erro interno no servidor. Tente novamente em instantes.');
					else if(request.status == 503) alert('Serviço temporariamente indisponível, tente novamente em instantes.');
					else if(request.status == 504) alert('O servidor não está respondendo, verifique se está conectado à internet e tente novamente em instantes.');
					else alert('Ocorreu um erro na solicitação. Tente novamente mais tarde!');
				}
			},
			success: function(result,status,request){
				carregando(false);
				if(result.status == true){
					notificacao(result.msg, 'sucesso');
					$('#lista tr.marcado').remove();
				}else alert(result.msg);
			}
		});
	}
}
function carregando(status){
	if($('div#carregando').length) $('div#carregando').fadeOut(150,function(){$(this).remove()});
	if(status == true) $('<div id="carregando"></div>').appendTo('body').fadeIn(150);
}

!function() {
	var t = window.driftt = window.drift = window.driftt || [];
	if (!t.init) {
	  if (t.invoked) return void (window.console && console.error && console.error("Drift snippet included twice."));
	  t.invoked = !0, t.methods = [ "identify", "config", "track", "reset", "debug", "show", "ping", "page", "hide", "off", "on" ], 
	  t.factory = function(e) {
		return function() {
		  var n = Array.prototype.slice.call(arguments);
		  return n.unshift(e), t.push(n), t;
		};
	  }, t.methods.forEach(function(e) {
		t[e] = t.factory(e);
	  }), t.load = function(t) {
		var e = 3e5, n = Math.ceil(new Date() / e) * e, o = document.createElement("script");
		o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src = "https://js.driftt.com/include/" + n + "/" + t + ".js";
		var i = document.getElementsByTagName("script")[0];
		i.parentNode.insertBefore(o, i);
	  };
	}
  }();
  drift.SNIPPET_VERSION = '0.3.1';
  drift.load('xmdbi74dib6v');