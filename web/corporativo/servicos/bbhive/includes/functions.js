var xmlhttp = false;
	//verifica se estamos usando IE
	try{
		//se a vers�o Javascript for maior que 5.
		xmlhttp = new ActiveXobject("Msxml2.XMLHTTP");
		//alert("Estamos usando o IE");
	} catch (e) {
		//se n�o, ent�o use o objeto active x mais antigo.
			try{
				//se estivermos usando o IE
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				//alert("Estamos usando o IE");
			} catch (E) {
				//ou devemos esta usando um navegador diferente do IE.
				//alert("N�o � IE");
			}
	}		
	//se estivermos usando um navegador diferente do IE, criar uma inst�ncia
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
	var pagina 	 = "/corporativo/servicos/bbhive/"+urlPrincipal+"?true=0";
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
					var pagPrincipal = '/corporativo/servicos/bbhive/includes/url.php?Principal=true&Time='+TimeStamp+"&urlP="+urlPrincipal+"&exibicaoP="+exibPrincipal;

					makerequest(pagPrincipal, "url");

					LoadSimultaneo(urls, exibicoes);

				} else {
					//alert(ajax.responseText);
					var msgErro = "<div class='verdana_11_vermelho'>Ocorreu um erro inesperado, contate o administrador!!!</div>";
					exibeResultado.innerHTML = msgErro//ajax.responseText;;
				}
			}
		}
		ajax.send(valor);
	}		 
}

//Fun��o de arvore
/*
function elementoArvore(idTagFilho, idTagConteudo, idTagIcone, homeDestino, CaminhoImagem){
	
	var ImagemAberta	= "credito.gif";//configur�vel
	var ImagemFechada	= "debito.gif";//configur�vel
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
		//troca �cone
		TagIcone.childNodes[0].childNodes[0].src = CaminhoImagem+ImagemAberta;
		//chama conte�do
		var idMensagemFinal = idTagConteudo;
		var infoGet_Post	= "&1=1";//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "carregando";
		var idResultado		= idTagConteudo;
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
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
*/
function elementoArvore(idTagFilho, homeDestino){
	var idTag			= idTagFilho.replace("Tagfilho_","");	
	var OndeExibe 		= "conteudo_"+idTag;

		if(document.getElementById("cont_populado_"+idTag).value=="0"){
			//chama conte�do
			var idMensagemFinal = OndeExibe;
			var infoGet_Post	= "&1=1";//Se envio for POST, colocar nome do formul�rio
			var Mensagem		= "Carregando...";
			var idResultado		= OndeExibe;
			var Metodo			= "2";//1-POST, 2-GET
			var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
			OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,'',idMensagemFinal,'2','2');
		}
	
		//verifica o display
		if(document.getElementById(idTagFilho).style.display=="none"){
			document.getElementById(idTagFilho).style.display = "block";
			document.getElementById("icone_"+idTag).src = "/corporativo/servicos/bbhive/images/credito.gif";
		}else{
			document.getElementById(idTagFilho).style.display = "none";
			document.getElementById("icone_"+idTag).src = "/corporativo/servicos/bbhive/images/debito.gif";
		}
}

function populaFluxo(valor, id){
	var destino = document.getElementById('parAti_'+id).value = valor;
}

function atribuiAtividadesFluxo(){
	var elementosForm 	= document.formFluxo.length;
	var valor			= document.getElementById('atribuiAtividades').value.split("|");
	var tem				= 0;
	var cont			= 0;
	//--
	
	if(valor != -1){
		for($a=0; $a<elementosForm; $a++){
			if(document.formFluxo.elements[$a].type=="select-one"){
				//recorta nome
				var oNome = document.formFluxo.elements[$a].id.substring(0,4);
				if(oNome=="ati_"){
					//--Preciso varrer o SELECT e verificar se tem o mesmo profissional.
					elemento = document.formFluxo.elements[$a];
					//--
						for(h=0; h < elemento.length; h++){
							//--
							var dados 	= document.formFluxo.elements[$a].options[h].value;
							var vrDados	= dados.split("|");
							//--
							if(vrDados[3] == valor[3]){
								tem	 = vrDados[3];
								cont++;
								break;
							}
						}
					//--
					if(tem > 0){
						//alert(dados + " => " + vrDados[0] + " : " +tem );
//						document.formFluxo.elements[$a].options[h].selectedIndex;
						document.formFluxo.elements[$a].options[h].selected = true;
						populaFluxo(dados, vrDados[0]);
						//document.formFluxo.elements[$a].value = valor[3];
						tem = 0;
					}
				  //--alert(document.formFluxo.elements[$a].value + "=>" + valor);
				}
			}
		}
		//--
		if(cont==0){
			alert('O profissional selecionado n�o consta na lista de atividades!');
		}
	} else {
		alert('Selecione um profissional!');
	}
}

function acaoFluxo(homeDestino){
	var TimeStamp 	= new Date().getTime();
	var elementosForm 	= document.formFluxo.length;
	var error			= 0;
	var vrInputFluxo	= document.formFluxo.fluxos.value;
	
	//valida se o t�tulo e a descri��o est�o preenhidas
		if(document.formFluxo.bbh_flu_titulo.value==""){
			alert('Campo t�tulo � obrigat�rio!');
			error = error + 1;
		}
		//if(document.formFluxo.bbh_flu_observacao.value==""){
		//	alert('Campo descri��o � obrigat�rio!');
		//	error = error + 1;
		//}
		var compara = "parAti_";
		for($a=0; $a<elementosForm; $a++){
			//alert(document.formFluxo.elements[$a].id.substr(0,7));
			/*if(document.formFluxo.elements[$a].type=="text"){
				if(document.formFluxo.elements[$a].value==""){
					alert('Campo t�tulo � obrigat�rio!');
					error = error + 1;
					break;
				}
			} else if(document.formFluxo.elements[$a].type=="textarea"){
				if(document.formFluxo.elements[$a].value==""){
					alert('Campo descri��o � obrigat�rio!');
					error = error + 1;
					break;
				}
			} else {*/
				if (document.formFluxo.elements[$a].id == "atribuiAtividades") {
					continue;
				}

				if(document.formFluxo.elements[$a].value=="-1"){
					alert('Todos os campos devem ser selecionados!');
					error = error + 1;
					break;
				} else {
					if(document.formFluxo.elements[$a].type=="select-one"){
						
						//recorta nome
						var oNome = document.formFluxo.elements[$a].id.substring(0,4);
						if(oNome=="ati_"){			
						  vrInputFluxo = document.formFluxo.fluxos.value+","+document.formFluxo.elements[$a].value;
						  document.formFluxo.fluxos.value = vrInputFluxo;
						  //document.formFluxo.fluxos.value+= ","+document.formFluxo.elements[$a].value;
						}
					}
				}
			//}
		}
		
		if(error==0){
			var idMensagemFinal = 'insereFluxo';
			var infoGet_Post	= "formFluxo";//Se envio for POST, colocar nome do formul�rio
			var Mensagem		= "<span class='color'>Executando procedimento...</span>";
			var idResultado		= idMensagemFinal;
			var Metodo			= "1";//1-POST, 2-GET
			var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

			//location.href="#flu";
			OpenAjaxPostCmd(homeDestino+"&Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
			document.formFluxo.btAcaoAtribui.disabled = 1;
			document.formFluxo.btAcao.disabled = 1;
			/*for($a=0; $a<elementosForm; $a++){
				var Tipo = document.formFluxo.elements[$a].type;
					if((Tipo=="textarea")||(Tipo=="select-one")||(Tipo=="text")||(Tipo=="button")){
						document.formFluxo.elements[$a].disabled=1;
					}
				
			}*/
		} else {
			document.formFluxo.btAcao.disabled = 0;	
		}
}

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      //document.getElementById('f1_upload_form').style.visibility = 'hidden';
	  document.formUpload.submit();
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">Upload realizado com sucesso!<\/span><br/><br/>';
		 alert("ok");
      }
      else {
         result = '<span class="emsg">Houve um erro durante o envio do arquivo!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}

function excluiArquivo(homeDestino,arquivo,path,where){
	if(confirm("Deseja realmente remover o arquivo "+arquivo+"?")){
		document.removeArquivo.nome_arquivo.value = path;
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = where;
		var infoGet_Post	= "removeArquivo";//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "executando processo...";
		var idResultado		= idMensagemFinal;
		var Metodo			= "1";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		
		OpenAjaxPostCmd(homeDestino+"&Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
	}
}

function mensagem(homeDestino, valor, compl){
	if(valor.value!="-1"){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'loadMsg';
		var infoGet_Post	= "&bbh_flu_codigo="+valor.value+"&"+compl;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Carregando...";
		var idResultado		= 'corpo_msg';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "1";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		
		OpenAjaxPostCmd(homeDestino+"?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
	}
}

function excluiMensagem(pagina, nmForm){
	if(confirm('Tem certeza que deseja excluir esta mensagem?\n        Clique em OK em caso de confirma��o')){
		OpenAjaxPostCmd(pagina,'enviaMSG',nmForm,'Aguarde...','enviaMSG','1','2');
	}
}

//---->Fun��es para ativar cor no fundo.
function Ativa(valor){
		document.getElementById(valor).className = "ativo";
}
function Desativa(valor){
		document.getElementById(valor).className = "comum";
}

function trocaBack(tag, Classe){
	document.getElementById(tag).className=Classe;
}
//---->Fim das fun��es

function selecionaMsg(nmForm){//seleciona os checkbox do formul�rio
	var Form	= eval("document."+nmForm);
		if(document.getElementById('todos').checked == true){//se estiver selecionado, marca todos do formul�rio
			var nElementos = Form.length;
				if(Form.lixo.value!="0|0|0"){
					Form.lixo.value ='0|0|0';
				}

				for($a=0; $a<nElementos; $a++){
					if(Form.elements[$a].type=="checkbox"){
                        Form.elements[$a].checked = true;
						var vrCheck 	= Form.lixo.value+","+Form.elements[$a].value;
							Form.lixo.value = vrCheck;
					}
				}
		} else {//sen�o desmarca todos
			var nElementos = Form.length;
				for($a=1; $a<nElementos; $a++){
					Form.elements[$a].checked = false;
					Form.lixo.value ='0|0|0';
				}
		}
}

function verificaForm(homeDestino, nmForm){
	var Form		= eval("document."+nmForm);
	var nElementos  = Form.length;
	var temElemento	= 0;
	
	for($a=0; $a<nElementos; $a++){
		if(Form.elements[$a].type=="checkbox" && Form.elements[$a].checked==true){
			var vrCheck 	= Form.lixo.value+","+Form.elements[$a].value;
				Form.lixo.value = vrCheck;
				temElemento = 1;
		}
	}
	
	if(temElemento==0){
		if(Form.lixo.value=="0|0|0"){
			alert('Selecione alguma mensagem!');
		}
	} else {
		OpenAjaxPostCmd(homeDestino,'enviaMSG',nmForm,'Aguarde...','enviaMSG','1','2');
	}
}

function exibeOpcao(){
	
	if(document.getElementById('opcao').style.display=="none"){
		document.getElementById('opcao').style.display="block";
	} else {
		document.getElementById('opcao').style.display="none";	
	}
}

function edita(homeDestino, Tipo, Form){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'loadEdita';
		var infoGet_Post	= Form;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Carregando...";
		var idResultado		= 'resto';
		var Metodo			= Tipo;//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		OpenAjaxPostCmd(homeDestino+"?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function populaHiden(valor){
	document.getElementById("sexo").value = valor;
}

function gerenciaPerfil(homeDestino){
	if(document.getElementById('tbPerfil').style.display=="none"){
		document.getElementById('tbPerfil').style.display="block";
	
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'loadPerfil';
		var infoGet_Post	= "&1=1";//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Carregando...";
		var idResultado		= 'esquerda';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		OpenAjaxPostCmd(homeDestino+"&Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);	
	}
}

function gerencia(homeDestino, acao){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'loadPerfil';
		var infoGet_Post	= '&'+acao+"=true";//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Carregando...";
		var idResultado		= idMensagemFinal;
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		OpenAjaxPostCmd(homeDestino+"&Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function chamaUpload(homeDestino){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'upload';
		var infoGet_Post	= '&1=1';//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Carregando...";
		var idResultado		= idMensagemFinal;
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		OpenAjaxPostCmd(homeDestino+"?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function UploadFoto(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
	  document.formUpload.submit();
      return true;
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
			
			//s� entra se o campo for text ou select
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

function gerenciaTarefa(tagEsconde, tagExibe, tagTexto){
		var Esconde 	= tagEsconde.split(",");
		var qtdEsconde 	= Esconde.length;
		var exibe		= tagExibe.split("|");
		var tagExibe	= exibe[0];
		var txtExibe	= exibe[1];
		
			for($a=0; $a<qtdEsconde; $a++){
				document.getElementById(Esconde[$a]).className = 'hide';
			}
		document.getElementById(tagExibe).className = 'show';
		document.getElementById(tagTexto).innerHTML = '&nbsp;'+txtExibe;
}

function limpaSimples(campo, form){
	var oCampo = eval("document."+form+"."+campo);
	oCampo.value="";
}

//Fun��es criadas para exibir e fechar a descri��o da parte de arquivos.
function exibeDescricao(div){
	document.getElementById(div).style.visibility = 'visible';	
}
function fechaDescricao(div){
	document.getElementById(div).style.visibility = 'hidden';	
}
//T�rmino das fun��es.

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


function montaForm(nmForm, acao){
	//seleciona tudo que esta no form!!!
	var valoresForm		= CpForm(nmForm);
	showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?'+valoresForm+'|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');
}

function criaInput(tipo, tagInput, tagIcone){
	//dados principais
		var elementoA 		= document.createElement('a');
			elementoA.href 	= "#";
			elementoA.onclick=function(){
				remonta(tipo, tagInput, tagIcone);	
			}
		var icone			= document.createElement('img');
			icone.src		= '/corporativo/servicos/bbhive/images/input.gif';
			icone.align		= 'absmiddle';
			icone.border	= '0';
			elementoA.appendChild(icone);
			document.getElementById(tagIcone).innerHTML='';
			document.getElementById(tagIcone).appendChild(elementoA);
}

function remonta(tipo, tagInput, tagIcone){
		var pagina			= document.getElementById('pagBusca').value;
		var TimeStamp 		= new Date().getTime();
		var elementoA 		= document.createElement('a');
			elementoA.href 	= "#";
			elementoA.onclick=function(){
				OpenAjaxPostCmd(pagina,tagInput,'?tipo='+tipo+'&tagInput='+tagInput+'&tagIcone='+tagIcone+'&ts='+TimeStamp,'Carregando...',tagInput,'2','2');
			}
		var icone			= document.createElement('img');
			icone.src		= '/corporativo/servicos/bbhive/images/combo.gif';
			icone.align		= 'absmiddle';
			icone.border	= '0';
			elementoA.appendChild(icone);
			document.getElementById(tagIcone).innerHTML='';
			document.getElementById(tagIcone).appendChild(elementoA);
			document.getElementById(tagInput).innerHTML='&nbsp;<input name="'+tipo+'" type="text" class="formulario2" id="'+tipo+'" size="60" style="height:13px;" />';
}

function escondeBloco(valor, exibe, Title, txt, homeDestino){
	var Filhos = document.getElementById(valor);
	var qdtFilho = Filhos.childNodes.length;
	
		for($a=0; $a<qdtFilho;$a++){
			if(Filhos.childNodes[$a].className=="show"){
				Filhos.childNodes[$a].className="hide";
			}
		}
		
		document.getElementById(exibe).className="show";
		document.getElementById(Title).innerHTML="&nbsp;"+txt;

		if(document.getElementById(exibe).childNodes.length=="1"){
			
		//alert(document.getElementById(exibe).childNodes.length);
			///corporativo/servicos/bbhive/tarefas/ger_fluxo.php	
			var TimeStamp 	= new Date().getTime();
			var idMensagemFinal = exibe;
			var infoGet_Post	= '&1=1';//Se envio for POST, colocar nome do formul�rio
			var Mensagem		= "Carregando...";
			var idResultado		= idMensagemFinal;
			var Metodo			= "2";//1-POST, 2-GET
			var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

			OpenAjaxPostCmd(homeDestino+"&Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
		}
}

function populaCampo(campo, valor){
	document.getElementById(campo).value=valor;	
}

function paginacao(pag, homeDestino, exibe){
	var TimeStamp 	= new Date().getTime();
	var idMensagemFinal = exibe;
	var infoGet_Post	= '&page='+pag;//Se envio for POST, colocar nome do formul�rio
	var Mensagem		= "Carregando...";
	var idResultado		= idMensagemFinal;
	var Metodo			= "2";//1-POST, 2-GET
	var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
	
	makerequest('/corporativo/servicos/bbhive/includes/url.php?novo=true&Time='+TimeStamp+"&url="+homeDestino+infoGet_Post+"&exibicao="+exibe, "url");
	//--
	OpenAjaxPostCmd(homeDestino+"?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
	//--
}


function SomenteNumerico(elemento)
{
	if(isNaN(elemento.value))
	{
		alert("Digite apenas valores num�ricos");
		elemento.value = "";
		return false;
	}
	
	  
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = e.keyCode;
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode); // Valor para o c�digo da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inv�lida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

//MASCARA MOEDA
function maskIt(w,e,m,r,a){
	// Cancela se o evento for Backspace
	if (!e) var e = window.event
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	// Vari�veis da fun��o
	var txt  = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
	var mask = (!r) ? m : m.reverse();
	var pre  = (a ) ? a.pre : "";
	var pos  = (a ) ? a.pos : "";
	var ret  = "";
	if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;
	// Loop na m�scara para aplicar os caracteres
	for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
	if(mask.charAt(x)!='#'){
	ret += mask.charAt(x); x++; } 
	else {
	ret += txt.charAt(y); y++; x++; } }
	// Retorno da fun��o
	ret = (!r) ? ret : ret.reverse()        
	w.value = pre+ret+pos; }
	// Novo m�todo para o objeto 'String'
	String.prototype.reverse = function(){
	return this.split('').reverse().join(''); 
}
	
function validaExclusao(pagina,camada,values,msg,divcarga,metodo,tpmsg,mensagemConfirmacao){
	if(confirm(mensagemConfirmacao)){
		OpenAjaxPostCmd(pagina,camada,values,msg,divcarga,metodo,tpmsg);
	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//=========================================================================================================
function montaCampoBI(idEsconde, idExibe){
	document.getElementById(idEsconde).style.display = "none";
	document.getElementById(idExibe).style.display = "block";
}
function insereInput(idDest, nomeCampo){
	document.getElementById(idDest).innerHTML = "<input name='"+nomeCampo+"' type='text' class='back_Campos' id='"+nomeCampo+"' size='40'>";
}
function computaSelecao(valor){
	//if(document.getElementById(id).checked == true){
		document.getElementById('contador').value = parseInt(document.getElementById('contador').value) + (valor);
	//} else {
	//	document.getElementById('contador').value = parseInt(document.getElementById('contador').value) - 1;
	//}
}
function consultaAgrupado(pagina, idTag){
	OpenAjaxPostCmd(pagina,idTag,"","<strong>Aguarde...</strong>",idTag,"2","2");
}
/*
function geraPDFEditor(pagina, idTag, nmForm){
	OpenAjaxPostCmd(pagina,idTag,nmForm,"<strong>Aguarde...</strong>",idTag,"1","2");
}*/
function geraPDFEditor(){
	OpenAjaxPostCmd("/corporativo/servicos/bbhive/relatorios/editorHTML/gera.php?1","loadEditor","&","<strong>Aguarde...</strong>","loadEditor","2","2");
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

function listaArquivos(inicio, total, acao, idElemento){
	if(acao == 1){
		for(x=inicio; x<=total; x++){
			document.getElementById("td"+idElemento+x).style.backgroundColor='#CCFFCC';
		}
	} else if(acao == 0) {
		for(x=inicio; x<=total; x++){
			document.getElementById("td"+idElemento+x).style.backgroundColor='#FFFFFF';
		}
	} else {
		for(x=inicio; x<=total; x++){
			document.getElementById("td"+idElemento+x).style.backgroundColor='#FF9999';
		}
	}
}

function executaPDF(){
	//--
	var atual	= document.getElementById('atual').value;
	var anterior= 0;	
			
			
	if(atual > 1){
		anterior = atual-1;
		//--
		document.getElementById('tr'+anterior).className = "Processado";
		document.getElementById('td'+anterior).innerHTML = icon(1);
	}
			
	document.getElementById('td'+atual).innerHTML = icon(2);
	
	var TimeStamp 	= new Date().getTime();
	OpenAjaxPostCmd("/corporativo/servicos/bbhive/relatorios/painel/editor/executa.php?Ts="+TimeStamp,"loadImpressao","gerarpdf","<strong>Aguarde...</strong>","loadImpressao","1","2");
}

function reiniciaImpressao(){
//--
		document.getElementById('atual').value = 1;
		var limite	= document.getElementById('limite').value;
		
		for(a=1; a<=limite; a++){
			document.getElementById('tr'+a).className = "faltaProcessar";
			document.getElementById('td'+a).innerHTML = icon(3);
		}
		executaPDF();
}

function icon(tipo){
	if(tipo == 1){
		return '<img src="/corporativo/servicos/bbhive/images/visto.gif" width="14" height="11" />';
	} else if(tipo == 2){
		return '<img src="/corporativo/servicos/bbhive/images/painel/ajax-loader.gif" alt="" width="16" height="16" />';
	} else {
		return '<img src="/corporativo/servicos/bbhive/images/cancelar.gif" alt="" width="16" height="16" />';
	}
}

function submeterPDF(){
	document.downloadPDF.submit();	
}

function getFileExtension(filePath) { //v1.0
  fileName = ((filePath.indexOf('/') > -1) ? filePath.substring(filePath.lastIndexOf('/')+1,filePath.length) : filePath.substring(filePath.lastIndexOf('\\')+1,filePath.length));
  return fileName.substring(fileName.lastIndexOf('.')+1,fileName.length);
}

function checkFileUpload(form,extensions) { //v1.0
  document.MM_returnValue = true;
  erro = 0;
  if (extensions && extensions != '') {
    for (var i = 0; i<form.elements.length; i++) {
      field = form.elements[i];
      if (field.type.toUpperCase() != 'FILE') continue;
      if (field.value == '') {
        erro = 1;
		alert('Um Arquivo � Necess�rio!');
        document.MM_returnValue = false;field.focus();break;
      }
      if (extensions.toUpperCase().indexOf(getFileExtension(field.value).toUpperCase()) == -1) {
         erro = 1;
	    alert('O Arquivo tem que ser em formato PDF!');
        document.MM_returnValue = false;field.focus();break;
  	  }
	}
	  if(erro == 0){
		  form.submit();
	  }	
  }
  

}

function submeteArquivo(fluxo, compartilha, publico, autor){
	var complemento = '';
	if(document.getElementById('bbh_flu_codigo_sel')){
		complemento += '&bbh_flu_codigo_sel=' + document.getElementById('bbh_flu_codigo_sel').value;
	}
	if(document.getElementById('bbh_ati_codigo')){
		complemento += '&bbh_ati_codigo=' + document.getElementById('bbh_ati_codigo').value;
	}

//	alert(fluxo + ' - ' + compartilha);
//	window.top.location.href='/corporativo/servicos/bbhive/arquivos/gerencia.php';
	OpenAjaxPostCmd("/corporativo/servicos/bbhive/arquivos/regra.php?bbh_flu_codigo="+fluxo+"&bbh_arq_compartilhado="+compartilha+'&bbh_arq_publico='+publico+'&bbh_arq_autor='+autor + complemento,"ambienteRelatorio","","<strong>Aguarde...</strong>","ambienteRelatorio","2","2");
}

function selecionaTudo(){
   for (i=0;i<document.formArquivos.elements.length;i++)
      if(document.formArquivos.elements[i].type == "checkbox")
         document.formArquivos.elements[i].checked = 1
} 

function executaAcaoAtividade(){
	var id = document.getElementById('acaoDaVez').value;
	//--
	s = document.getElementById(id).value;
	eval(s);
	//--
}

function gerenciaCamposDetalhamento(campos){
	var campos = campos.split(",");
	//--
		for(a=0; a<campos.length; a++){
			var elemento = document.getElementById(campos[a]);
			//--
			if(elemento.style.display == 'none'){
				elemento.style.display = 'inline-block';
			} else {
				elemento.style.display = 'none';
			}
		}
	//--
}
function exibeLegenda(valor){
	document.getElementById('legenda').innerHTML = valor;
}
function gerenciaCSS(elemento){
	//--Somente comportamento de imagens dos �cones
	var id 		= elemento.id;
	var classe	= elemento.className;
	//--
		if(classe != id+"_Selecionado"){
			if(classe == id+"_Inativo"){
				elemento.className = id+"_Ativo";
			} else {
				elemento.className = id+"_Inativo";
			}
		}
	//--
}
function desabilitaClasse(elemento, outrosElementos){
	var id 		= elemento.id;
	var classe	= elemento.className;
	//--
	var outros  = outrosElementos.split(",");
	//--
		for(a=0; a<outros.length; a++){
			if(document.getElementById(outros[a])){
				//--
				var oElemento 	= document.getElementById(outros[a]);
				var outroId 	= oElemento.id;
				//--
				if((outroId != id)){
					oElemento.className = outroId+"_Inativo";
				}
			}
		}
}
//-->