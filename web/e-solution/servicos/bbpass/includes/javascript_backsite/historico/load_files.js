function pageload(hash) {
	function aposCarregamento(){
		var carregando 		= $('#div_fixa');
		var conteudoAjax 	= $('#load');
		
		//conteudoAjax.fadeIn(1000);//carrega conteúdo assíncrono
		carregando.fadeOut(500);//apaga mensagem de carregando
		acaoLeitura(conteudoAjax[0]);//le tag var
	};

	if(hash) {
		$("#load").load(decodeHex(hash), aposCarregamento);
	} else {
		$("#load").load('/e-solution/servicos/bbpass/home.php', aposCarregamento);// + ".php");//monta tudo que tem depois do #
	}
}
//Usado para retorno javascript
function acaoLeitura(conteudoAjax){
	//SÓ EXCLUSIVAMENTE PARA RETORNO JAVASCRIPT
	var scripts = conteudoAjax.getElementsByTagName("var");
		for(i=0; i < scripts.length; i++){
			s = scripts[i].innerHTML;
			eval(s);						
		}
}
//LOAD PADRÃO
function mostrarCarregando(){
  var carregando = $('#div_fixa');
  carregando.css('display', 'block').fadeIn(500);//exibe mensagem de carregando
};
//LIMPA
function limpaCarregando(){
  var carregando = $('#div_fixa');
  carregando.fadeOut(500);//exibe mensagem de carregando
};
$(document).ready(function(){
	var conteudoAjax = $('#load');
	//$(conteudoAjax).css('opacity', .100);
	$.historyInit(pageload);
	$("a[@rel='backsite']").click(function(){
		var hash = this.rev;//this.href;
		mostrarCarregando();//exibe mensagem para o usuário.

		hash = hash.replace(/^.*#/, '');//substitui caracteres indesejáveis
		$.historyLoad(encodeHex(hash));//grava no histório
		return false;
	});
});
function atualizaFoto(){
	alert('Foto atualizada com sucesso');	
}
function colocaFoto(imagem){
	document.getElementById('foto').src = imagem;
}
//ENVIO DE FORMULÁRIO VIA GET/POST
function enviaFORMULARIO(nmForm, ondeExibe){
	var action = document.getElementById(nmForm).action;//recupera a ação do formulário, somente o endereço
	var method = document.getElementById(nmForm).method;//recupera o método do formulário, somente o endereço

	$(nmForm).attr('action','javascript:void(0);');//nada, não precisa se preocupar
	 mostrarCarregando();//exibe ,mensagem de load

	 if(method.toLowerCase()=="post"){//POST
		 $.post(action ,CpForm(nmForm), function(data){//ação do formulário utilizando jquery, via POST
				//exibe informações do retorno do POST
				document.getElementById(ondeExibe).innerHTML = data;
				//recupera o conteúdo do objeto escrito pelo DOM
				var conteudoAjax 	= document.getElementById(ondeExibe);//$(eval(ondeExibe));
				//executa função que varre os dados em busca de variável padrão
				acaoLeitura(conteudoAjax);//le tag var
		 });
	 }else{//GET
		 $.get(action ,CpForm(nmForm),  function(data){//ação do formulário utilizando jquery, GET
				//exibe informações do retorno do POST
				document.getElementById(ondeExibe).innerHTML = data;
				//recupera o conteúdo do objeto escrito pelo DOM
				var conteudoAjax 	= document.getElementById(ondeExibe);//$(eval(ondeExibe));
				//executa função que varre os dados em busca de variável padrão
				acaoLeitura(conteudoAjax);//le tag var
				$(eval(ondeExibe)).html(data);//exibe informações do retorno do POST
		 }); 
	 }
	return null;
}

//ENVIO DE DADOS VIA GET
function enviaURL(objeto){
	objeto.href = "#"+encodeHex(objeto.rev);
	hash = objeto.rev.replace(/^.*#/, '');//substitui caracteres indesejáveis
	$.historyLoad(encodeHex(hash));//grava no histório
	return false;
}

//AÇÃO DE QUALQUER LUGAR
function voltarURL(pagina){
	var objeto  	= document.getElementById('retornoPadrao');
	var tagHREF		= document.createElement("a");
		tagHREF.id	= "linkDescarte";
		tagHREF.rev = pagina;
		tagHREF.href= "#"+encodeHex(tagHREF.rev);
		objeto.appendChild(tagHREF);
		//document.getElementById('linkDescarte').click();
		
		hash = tagHREF.rev.replace(/^.*#/, '');//substitui caracteres indesejáveis
		$.historyLoad(encodeHex(hash));//grava no histório
		
		//destrói o elemento
		objeto.removeChild(objeto.firstChild);
		return false;
}