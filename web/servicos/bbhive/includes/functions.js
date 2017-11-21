var xmlhttp = false;
	//verifica se estamos usando IE
	try{
		//se a versão Javascript for maior que 5.
		xmlhttp = new ActiveXobject("Msxml2.XMLHTTP");
		//alert("Estamos usando o IE");
	} catch (e) {
		//se não, então use o objeto active x mais antigo.
			try{
				//se estivermos usando o IE
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				//alert("Estamos usando o IE");
			} catch (E) {
				//ou devemos esta usando um navegador diferente do IE.
				//alert("Não é IE");
			}
	}		
	//se estivermos usando um navegador diferente do IE, criar uma instância
	//Javascript do objeto.
		if(!xmlhttp && typeof XMLHttpRequest != 'undefined'){
			xmlhttp = new XMLHttpRequest();
			//alert("Estamos no IE");
		}
		
	function makerequest(serverPage, objID){
		var obj = document.getElementById(objID);
		xmlhttp.open("GET", serverPage, false);
		xmlhttp.onreadystatechange = function(){
			//alert(xmlhttp.responseText)
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//alert(xmlhttp.responseText);
				obj.innerHTML = xmlhttp.responseText;
				//document.getElementById("url").value="1";
			}
		}	
			xmlhttp.send(null);
	}
/*==============================================================================================================*/

function showHome(urlPrincipal, exibPrincipal, urls,exibicoes) {

	var pagina 	 = "/servicos/bbhive/"+urlPrincipal+"?true=0";
	var camada 	 = exibPrincipal;//"conteudoGeral";
	var values 	 = "&1=1";
	var msg		 = "<span class='verdana_9'><strong>Carregando...</strong></span>";
	var divcarga = exibPrincipal;//"conteudoGeral";
	var metodo	 = "2";
	var tpmsg	 = "2";
	var urls	 = urls;
	var exibicoes= exibicoes;

	if(document.getElementById) {
		var ajax = openAjax();
		if(tpmsg=='1'){
			var exibeLoading = document.getElementById(divcarga);
		}
		var exibeResultado = document.getElementById(camada);
		if(metodo=='1'){
			ajax.open("POST", pagina, true);
			ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
			ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
			ajax.setRequestHeader("Pragma", "no-cache");
			valor = CpForm(values)
		}else{
			valor = null
			ajax.open("GET", pagina + values + "&TimeStamp="+TimeStamp, true);
		}
		ajax.onreadystatechange = function() {
			if(ajax.readyState == 1) {
				if(tpmsg=='1'){
					exibeLoading.style.display = 'inline';
					exibeLoading.innerHTML = msg
				}else{
					exibeResultado.innerHTML = msg
				}
			}
			if(ajax.readyState == 4) {
				if(tpmsg=='1'){
					exibeLoading.innerHTML = ""
					exibeLoading.style.display = 'none';
				}else{
					exibeResultado.innerHTML = ""
				}
				if(ajax.status == 200) {
					var resultado = null;
					resultado = ajax.responseText;
					resultado = resultado.replace(/\+/g," ");
					resultado = unescape(resultado);
					exibeResultado.innerHTML = resultado;
					
				//if(divcarga=="conteudoGeral"){
					var TimeStamp 		= new Date().getTime();
					var pagPrincipal = '/servicos/bbhive/includes/url.php?Principal=true&Time='+TimeStamp+"&urlP="+urlPrincipal+"&exibicaoP="+exibPrincipal;

					makerequest(pagPrincipal, "url");

					LoadSimultaneo(urls, exibicoes);

				} else {
					//alert(ajax.responseText);
					var msgErro = "<div class='verdana_11_vermelho'>Ocorreu um erro inesperado, contate o administrador!</div>";
					exibeResultado.innerHTML = msgErro//ajax.responseText;;
				}
			}
		}
		ajax.send(valor);
	}		 
}


//Funções para ativar cor no fundo.
function ativaCor(valor){
		document.getElementById(valor).className = "ativo";
}
function desativaCor(valor){
		document.getElementById(valor).className = "comum";
}


//Função para paginação.
function paginacao(pag, homeDestino, exibe){
	var TimeStamp 	= new Date().getTime();
	var idMensagemFinal = exibe;
	var infoGet_Post	= '&page='+pag;//Se envio for POST, colocar nome do formulário
	var Mensagem		= "Carregando...";
	var idResultado		= idMensagemFinal;
	var Metodo			= "2";//1-POST, 2-GET
	var TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes

	OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

//Função de arvore
function elementoArvore(idTagFilho, idTagConteudo, idTagIcone, homeDestino, CaminhoImagem){
	
	var ImagemAberta	= "credito.gif";//configurável
	var ImagemFechada	= "debito.gif";//configurável
	var OndeExibe 		= document.getElementById(idTagFilho);
	var TdFilho			= OndeExibe.childNodes[0];
	var TagIcone		= document.getElementById(idTagIcone);
	var UrlLocal		= document.URL;

	if(TdFilho.childNodes.length==0){
		//exibe camada de elemento
		var TXT = "<div class='verdana_9' style='margin-left:15px;'><strong>Carregando...</strong></div>";
			TdFilho.innerHTML = TXT;
		//troca classe	
		OndeExibe.className = "show";
		//troca ícone
		TagIcone.childNodes[0].childNodes[0].src = CaminhoImagem+ImagemAberta;
		//chama conteúdo
		var idMensagemFinal = idTagConteudo;
		var infoGet_Post	= "&1=1";//Se envio for POST, colocar nome do formulário
		var Mensagem		= "carregando";
		var idResultado		= idTagConteudo;
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,'',idMensagemFinal,'2','2');
	}
	
	if(TdFilho.childNodes.length>0){
		//verifica se troca imagem e css
		if(TagIcone.childNodes[0].childNodes[0].src=="http://"+UrlLocal.split("/")[2]+CaminhoImagem+ImagemFechada){
			OndeExibe.className = "show";
			TagIcone.childNodes[0].childNodes[0].src = CaminhoImagem+ImagemAberta;
			
		} else {
			OndeExibe.className = "hide";
			TagIcone.childNodes[0].childNodes[0].src = CaminhoImagem+ImagemFechada;
		}
	}
}

function validaForm(nmForm, osCampos, AcaoForm){
	var Form		= eval("document."+nmForm);
	var Campos		= osCampos.split(",");
	var	qtCampos	= Campos.length;
	var erros		= 0;

		for($a=0; $a<qtCampos; $a++){
			var cadaCampo 	= Campos[$a].split("|");
			var	oCampo		= cadaCampo[0];
			var msg			= cadaCampo[1];

		//só entra se o campo for text ou select
			if((eval("document."+nmForm+"."+oCampo+".type")=="text") || (eval("document."+nmForm+"."+oCampo+".type")=="select-one")||(eval("document."+nmForm+"."+oCampo+".type")=="password")||(eval("document."+nmForm+"."+oCampo+".type")=="textarea")){
				if((eval("document."+nmForm+"."+oCampo+".value")=="") || (eval("document."+nmForm+"."+oCampo+".value")=="-1")){
					alert(msg);
					erros = erros + 1;
					break;
				}
			}
		}

		if(erros==0){
			eval(AcaoForm);
		}
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function SomenteNumerico(elemento){
	if(isNaN(elemento.value)){
		alert("Digite apenas valores numéricos");	
		elemento.value = "";
	}
}
function MascaraData(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);
	campo.value = campo.value.replace(/[^\d\/]/gi,'');
	if (campo.value == '00/00/0000 00:00:00')
	{
		campo.value=""
	}

	caracteres = '0123456789';
	separacao1 = '/';
	separacao2 = ' ';
	
	conjunto1 = 2;
	conjunto2 = 5;
	
	if ((caracteres.search(String.fromCharCode (keypress))!=-1) && campo.value.length < (19))
	{
		if (campo.value.length == conjunto1 )
		campo.value = campo.value + separacao1;
		else if (campo.value.length == conjunto2)
		campo.value = campo.value + separacao1;
	}
	else
		event.returnValue = false;
}

function retiraEspacos(string) {        
	var i = 0;        
	var final = '';        
		while (i < string.length) {                
			if (string.charAt(i) == ' ') {                        
				final += string.substr(0, i);                       
				string = string.substr(i+1, string.length - (i+1));           
				i = 0;                
			}else {                       
				i++;                
			}        
		}        
	return final + string;
}

function populaCamposTexto(valor){
	if(valor == '-1'){
		document.getElementById('cp1').innerHTML = 'Campo1';
		document.getElementById('cp2').innerHTML = 'Campo2';	
		document.getElementById('bbh_tip_codigo').value = "";
	} else {
		var vr = valor.split('**');
		document.getElementById('bbh_tip_codigo').value = vr[0];
		//--
		var txt = vr[1].split('*|*');
		document.getElementById('cp1').innerHTML = txt[0];
		document.getElementById('cp2').innerHTML = txt[1];
	}
}