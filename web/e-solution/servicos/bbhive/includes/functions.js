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

	var pagina 	 = "/e-solution/servicos/bbhive/"+urlPrincipal+"?true=0";
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
					var pagPrincipal = '/e-solution/servicos/bbhive/includes/url.php?Principal=true&Time='+TimeStamp+"&urlP="+urlPrincipal+"&exibicaoP="+exibPrincipal;

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


//Fun��es para ativar cor no fundo.
function ativaCor(valor){
		document.getElementById(valor).className = "ativo";
}
function desativaCor(valor){
		document.getElementById(valor).className = "comum";
}


//Fun��o para pagina��o.
function paginacao(pag, homeDestino, exibe){
	var TimeStamp 	= new Date().getTime();
	var idMensagemFinal = exibe;
	var infoGet_Post	= '&page='+pag;//Se envio for POST, colocar nome do formul�rio
	var Mensagem		= "Carregando...";
	var idResultado		= idMensagemFinal;
	var Metodo			= "2";//1-POST, 2-GET
	var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

	OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

//Fun��o de arvore
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
			document.getElementById("icone_"+idTag).src = "/e-solution/servicos/bbhive/images/credito.gif";
		}else{
			document.getElementById(idTagFilho).style.display = "none";
			document.getElementById("icone_"+idTag).src = "/e-solution/servicos/bbhive/images/debito.gif";
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
			
			//s� entra se o campo for text ou select
			if((eval("document."+nmForm+"."+oCampo+".type")=="text") || (eval("document."+nmForm+"."+oCampo+".type")=="select-one")){
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

function verificaDep(nmForm, AcaoForm){
	var Form		= eval("document."+nmForm);
	var	qtCampos	= Form.length;

		for($a=0; $a<qtCampos; $a++){
			if(eval("document."+nmForm+".elements["+$a+"].type")=="checkbox"){
 				if(eval("document."+nmForm+".elements["+$a+"].checked")=="1"){
					var cadaCampo 	= eval("document."+nmForm+".elements["+$a+"].value");
						//popula o campo respons�vel pelo tratamento no php
					var cTratado		= document.getElementById('tratado');
						cTratado.value	= cTratado.value+", "+cadaCampo;
					//alert(cadaCampo);
				}
			}
			
		}
	
	eval(AcaoForm);
}


//==============Inicio das fun��es usadas no detalhamento de contas:
function showCampos(elemento)
{

	if(elemento.value != "")
	{
		document.form1.cadastra.disabled = 0;
	}else{
		document.form1.cadastra.disabled = 1;
	}
	
	//Essa fun��o eu utilizo para trazer os inputs dos campos dos modelos de detalhamento de campos.
	document.form1.tipoCampo.value = elemento.value;
	escondeCampos();

	//O campo tamanho deve ser sempre numerico
	document.form1.bbh_cam_det_flu_tamanho.onkeyup = function() { SomenteNumerico(this); };		
	
	switch(elemento.value)
	{
		case "correio_eletronico":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";
			document.form1.bbh_cam_det_flu_tamanho.value = 255;
		break;
		
		case "data":
			document.getElementById("VlPadraoData").style.display = "";		
		break;
		
		case "numero":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_flu_tamanho.value = 11;
			

			document.form1.bbh_cam_det_flu_default.onkeyup = function() { return(SomenteNumerico(this)); };		
			
		break;
		
		case "endereco_web":
		
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_flu_tamanho.value = 255;
			
		break;		

		case "lista_opcoes":
			document.getElementById("listagem").style.display = "";
			document.getElementById("listagemCriada").style.display = "";						

		break;	

		case "lista_dinamica":
			document.getElementById("listagemDinamica").style.display = "";


		break;
		
		case "numero_decimal":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_flu_tamanho.value = 16;


			document.form1.bbh_cam_det_flu_default.onkeypress = function() { return(MascaraMoeda(this,'.',',',event)); };
			

		break;
		
		case "texto_longo":
			document.getElementById("texto_longoColuna").style.display = "";
			document.getElementById("texto_longoLinha").style.display = "";	
			document.getElementById("texto_longoDefault").style.display = "";	
			document.form1.texto_longoLinhaI.value = 50;
			document.form1.texto_longoColunaI.value = 5;

		break;
		
		case "texto_simples":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_flu_tamanho.value = 255;

        case "hidden":
            document.getElementById("Tamanho").style.display = "none";
            document.getElementById("VlPadrao").style.display = "";
            document.form1.bbh_cam_det_flu_tamanho.value = 255;

        case "json":
            document.getElementById("Tamanho").style.display = "none";
            document.getElementById("VlPadrao").style.display = "";
		break;
	}
}

function showCamposProtocolo(elemento)
{

	if(elemento.value != "")
	{
		document.form1.cadastra.disabled = 0;
	}else{
		document.form1.cadastra.disabled = 1;
	}
	
	//Essa fun��o eu utilizo para trazer os inputs dos campos dos modelos de detalhamento de campos.
	document.form1.tipoCampo.value = elemento.value;
	escondeCampos();

	//O campo tamanho deve ser sempre numerico
	document.form1.bbh_cam_det_pro_tamanho.onkeyup = function() { SomenteNumerico(this); };		
	
	switch(elemento.value)
	{
		case "correio_eletronico":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";
			document.form1.bbh_cam_det_pro_tamanho.value = 255;
		break;
		
		case "data":
			document.getElementById("VlPadraoData").style.display = "";		
		break;
		
		case "numero":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_pro_tamanho.value = 11;
			

			document.form1.bbh_cam_det_pro_default.onkeyup = function() { return(SomenteNumerico(this)); };		
			
		break;
		
		case "endereco_web":
		
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_pro_tamanho.value = 255;
			
		break;		

		case "lista_opcoes":
			document.getElementById("listagem").style.display = "";
			document.getElementById("listagemCriada").style.display = "";						

		break;	

		case "lista_dinamica":
			document.getElementById("listagemDinamica").style.display = "";


		break;
		
		case "numero_decimal":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_pro_tamanho.value = 16;


			document.form1.bbh_cam_det_pro_default.onkeypress = function() { return(MascaraMoeda(this,'.',',',event)); };
			

		break;
		
		case "texto_longo":
			document.getElementById("texto_longoColuna").style.display = "";
			document.getElementById("texto_longoLinha").style.display = "";	
			document.getElementById("texto_longoDefault").style.display = "";	
			document.form1.texto_longoLinhaI.value = 50;
			document.form1.texto_longoColunaI.value = 5;

		break;
		
		case "texto_simples":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_det_pro_tamanho.value = 255;
		break;


        case "json":
            document.getElementById("Tamanho").style.display = "none";
            document.getElementById("VlPadrao").style.display = "";
        break;
	}
}

function showCamposCentral(elemento)
{

	if(elemento.value != "")
	{
		document.form1.cadastra.disabled = 0;
	}else{
		document.form1.cadastra.disabled = 1;
	}
	
	//Essa fun��o eu utilizo para trazer os inputs dos campos dos modelos de detalhamento de campos.
	document.form1.tipoCampo.value = elemento.value;
	escondeCampos();

	//O campo tamanho deve ser sempre numerico
	document.form1.bbh_cam_ind_tamanho.onkeyup = function() { SomenteNumerico(this); };		
	
	switch(elemento.value)
	{
		case "correio_eletronico":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";
			document.form1.bbh_cam_ind_tamanho.value = 255;
		break;
		
		case "data":
			document.getElementById("VlPadraoData").style.display = "";		
		break;
		
		case "numero":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_ind_tamanho.value = 11;
			

			document.form1.bbh_cam_ind_default.onkeyup = function() { return(SomenteNumerico(this)); };		
			
		break;
		
		case "endereco_web":
		
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_ind_tamanho.value = 255;
			
		break;		

		case "lista_opcoes":
			document.getElementById("listagem").style.display = "";
			document.getElementById("listagemCriada").style.display = "";						

		break;	

		case "lista_dinamica":
			document.getElementById("listagemDinamica").style.display = "";


		break;
		
		case "numero_decimal":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_ind_tamanho.value = 16;


			document.form1.bbh_cam_ind_default.onkeypress = function() { return(MascaraMoeda(this,'.',',',event)); };
			

		break;
		
		case "texto_longo":
			document.getElementById("texto_longoColuna").style.display = "";
			document.getElementById("texto_longoLinha").style.display = "";	
			document.getElementById("texto_longoDefault").style.display = "";	
			document.form1.texto_longoLinhaI.value = 50;
			document.form1.texto_longoColunaI.value = 5;

		break;
		
		case "texto_simples":
			document.getElementById("Tamanho").style.display = "";
			document.getElementById("VlPadrao").style.display = "";	
			document.form1.bbh_cam_ind_tamanho.value = 255;

		break;
	}
}


function escondeCampos()
{
	document.getElementById("Tamanho").style.display = "none";
	document.getElementById("VlPadrao").style.display = "none";
	document.getElementById("VlPadraoData").style.display = "none";
	document.getElementById("listagem").style.display = "none";
	document.getElementById("texto_longoColuna").style.display = "none";
	document.getElementById("texto_longoLinha").style.display = "none";
	document.getElementById("listagemCriada").style.display = "none";
	document.getElementById("texto_longoDefault").style.display = "none";
	document.getElementById("listagemDinamica").style.display = "none";

	if(document.form1.bbh_cam_det_flu_default){
		document.form1.bbh_cam_det_flu_default.onkeypress = function() {};	
		document.form1.bbh_cam_det_flu_default.onkeyup = function() {};	
		document.form1.bbh_cam_det_flu_default.value = "";
	} else if(document.form1.bbh_cam_det_pro_default){
		document.form1.bbh_cam_det_pro_default.onkeypress = function() {};	
		document.form1.bbh_cam_det_pro_default.onkeyup = function() {};	
		document.form1.bbh_cam_det_pro_default.value = "";
	}else{
		document.form1.bbh_cam_ind_default.onkeypress = function() {};	
		document.form1.bbh_cam_ind_default.onkeyup = function() {};	
		document.form1.bbh_cam_ind_default.value = "";
	}
	
}

function AddListagem()
{
	var listagem = document.getElementById("listagemI").value;
	var menuCriado = document.getElementById("menuCriado");
	document.getElementById("listagem").style.display = "none";
	document.getElementById("listagem").style.display = "";
	document.getElementById("listagemCriada").style.display = "none";
	document.getElementById("listagemCriada").style.display = "";
	
	var optionsI = document.createElement("option");

	optionsI.appendChild(document.createTextNode(listagem));
	optionsI.value = document.createTextNode(listagem);
	optionsI.id = document.createTextNode(listagem);

	var lista_vazia = menuCriado.childNodes[menuCriado.childNodes.length-1].id;	
	 for(x = 0; x < document.form1.menuCriado.length;x++)
	 {
		var valor = document.form1.menuCriado.options[x].id;  

		if(valor == "lista_vazia")
		{
			document.form1.menuCriado.removeChild(document.form1.menuCriado.options[x]);

		}	
	 }
	  

	menuCriado.appendChild(optionsI);
	document.form1.menuCriadoValores.value += listagem + "|";
	document.getElementById("listagemI").value = "";
	
	
}

function RemListagem()
{

	var menuCriado = document.getElementById("menuCriado");
	var Indice = menuCriado.selectedIndex;
	var optionDeletado = menuCriado.options[Indice].text;
	
  for(x = 0; x < document.form1.menuCriado.length;x++)
  {
	var valor = document.form1.menuCriado.options[x].text;  
	if(valor == optionDeletado)
	{
		document.form1.menuCriado.removeChild(document.form1.menuCriado.options[x]);
	}	
	if(document.form1.menuCriado.length == 0)
	{
		var optionsI = document.createElement("option");
	
		optionsI.appendChild(document.createTextNode("Listagem vazia"));
		optionsI.value = document.createTextNode("lista_vazia");
		optionsI.id = "lista_vazia";
		document.getElementById("listagemCriada").style.display = "none";
		document.getElementById("listagemCriada").style.display = "";
		
		document.form1.menuCriado.appendChild(optionsI);
		document.form1.menuCriado.style.width = "200";

	}
  }
  //Existe um hidden que guarda os valores dos campos adicionados na lista:
  var valoresInput = document.form1.menuCriadoValores.value;
  valoresInput = valoresInput.split("|");
  novosValoresInput = "";

  for(x = 0; x < valoresInput.length-1; x++)
  {

	if(!(valoresInput[x] == optionDeletado))
	{

		novosValoresInput += valoresInput[x] + "|";
		
	}
  }
  
 	 document.form1.menuCriadoValores.value = novosValoresInput; 
	
	
}

function cadListagem(e)
{

	if(event.keyCode == 13)
	{
		AddListagem();
		document.form1.listagemI.focus();
	}	
}


function SomenteNumerico(elemento)
{

	
	if(isNaN(elemento.value))
	{
		alert("Digite apenas valores num�ricos");	
		elemento.value = "";
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


//==============Fim

//Fun��es utilizadas na adi��o e remo��o de perfis na parte de usu�rios
function carregaAdicionados(){
	
		var usuCod			= document.getElementById("usuCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/usuarios/perfil/adicionados.php?Ts='+TimeStamp;
		var idMensagemFinal = 'adicionados';
		var infoGet_Post	= '&usuario='+usuCod;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		
		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function carregaDisponiveis(valor){
	
		var usuCod			= document.getElementById("usuCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/usuarios/perfil/disponivel.php?'+valor+'=true&Ts='+TimeStamp;
		var idMensagemFinal = 'disponiveis';
		var infoGet_Post	= '&usuario='+usuCod;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function AdicionaPerfil(codPerfil){	
	
		var usuCod			= document.getElementById("usuCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/usuarios/perfil/adicionados.php?add=1&Ts='+TimeStamp;
		var idMensagemFinal = 'adicionados';
		var infoGet_Post	= '&usuario='+usuCod+'&perfil='+codPerfil;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function RemovePerfil(codPerfil){
		
		var usuCod			= document.getElementById("usuCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/usuarios/perfil/adicionados.php?del=1&Ts='+TimeStamp;
		var idMensagemFinal = 'adicionados';
		var infoGet_Post	= '&usuario='+usuCod+'&perfil='+codPerfil;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}
//==============Fim

function MascaraData(evento, objeto){
	var keypress=(window.event)?event.keyCode:evento.which;
	campo = eval (objeto);
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

//Fun��es utilizadas na adi��o e remo��o de usu�rios na parte de perfis
function per_carregaAdicionados(){
	
		var perfCod			= document.getElementById("perfCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/perfis/usuarios/adicionados.php?Ts='+TimeStamp;
		var idMensagemFinal = 'per_adicionados';
		var infoGet_Post	= '&perfil='+perfCod;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes
		
		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function per_carregaDisponiveis(valor){
	
		var perfCod			= document.getElementById("perfCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/perfis/usuarios/disponivel.php?'+valor+'=true&Ts='+TimeStamp;
		var idMensagemFinal = 'per_disponiveis';
		var infoGet_Post	= '&perfil='+perfCod;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function per_AdicionaPerfil(codUsuario){	
	
		var perfCod			= document.getElementById("perfCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/perfis/usuarios/adicionados.php?add=1&Ts='+TimeStamp;
		var idMensagemFinal = 'per_adicionados';
		var infoGet_Post	= '&perfil='+perfCod+'&usuario='+codUsuario;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function per_RemovePerfil(codUsuario){
		
		var perfCod			= document.getElementById("perfCod").value;
		var TimeStamp 		= new Date().getTime();
		var homeDestino		= '/e-solution/servicos/bbhive/perfis/usuarios/adicionados.php?del=1&Ts='+TimeStamp;
		var idMensagemFinal = 'per_adicionados';
		var infoGet_Post	= '&perfil='+perfCod+'&usuario='+codUsuario;//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
		var idResultado	    = idMensagemFinal;//'menHistorico';
		var Metodo			= "2";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}
//==============Fim

//Fun��o para efetuar a exclus�o das mensagens na parte administrativa
function enviaMensagem(homeDestino){
	if(document.getElementById('bbh_usu_codigo_destin').value!="-1" && document.getElementById('bbh_flu_codigo').value!="-1"){
		var TimeStamp 	= new Date().getTime();
		var idMensagemFinal = 'loadMsg';
		var infoGet_Post	= "formMsg";//Se envio for POST, colocar nome do formul�rio
		var Mensagem		= "Enviando...";
		var idResultado		= 'enviaMSG';
		var Metodo			= "1";//1-POST, 2-GET
		var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

		OpenAjaxPostCmd(homeDestino+"?Ts="+TimeStamp,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
	} else {
		alert('Escolha o destinat�rio e/ou fluxo!');	
	}
}


function selecionaMsg(nmForm){//seleciona os checkbox do formul�rio
	var Form	= eval("document."+nmForm);
		if(document.getElementById('todos').checked==1){//se estiver selecionado, marca todos do formul�rio
			var nElementos = Form.length;
				if(Form.lixo.value!="0|0|0"){
					Form.lixo.value ='0|0|0';
				}
				for($a=1; $a<nElementos; $a++){
					Form.elements[$a].checked=1;
					if(Form.elements[$a].type=="checkbox"){
						var vrCheck 	= Form.lixo.value+","+Form.elements[$a].value;
							Form.lixo.value = vrCheck;
					}
				}
		} else {//sen�o desmarca todos
			var nElementos = Form.length;
				for($a=1; $a<nElementos; $a++){
					Form.elements[$a].checked=0;
					Form.lixo.value ='0|0|0';
				}
		}
}

function verificaForm(homeDestino, Form){
	var Form		= eval("document."+Form);
	var nElementos  = Form.length;
	var temElemento	= 0;
	
	for($a=1; $a<nElementos; $a++){
		if(Form.elements[$a].type=="checkbox" && Form.elements[$a].checked==1){
			var vrCheck 	= Form.lixo.value+","+Form.elements[$a].value;
				Form.lixo.value = vrCheck;		
				temElemento = 1;
		}
	}
	
	if(temElemento==0){
		if(Form.lixo.value=="0"){
			alert('Selecione alguma mensagem!!!');
		}
	} else {
		enviaMensagem(homeDestino);	
	}
}
//==============Fim
//Fun��es criadas para exibir e fechar a descri��o da parte de arquivos.
function exibeDescricao(div){
	document.getElementById(div).style.display = '';	
}
function fechaDescricao(div){
	document.getElementById(div).style.display = 'none';	
}
//T�rmino das fun��es.
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


// Exclusivo para Pacote Rede Simples
function listenerOptionSelected(element) {
	if (element.value != "redeSimples") {
		return openInputUploadSecurityKey('none');
	}

	return openInputUploadSecurityKey('block');
}

function openInputUploadSecurityKey(action) {
	var containerUpload = document.getElementById("securityKeyRedeSimples");
    containerUpload.style.display = action;

    if (action != 'block') {
    	return;
	}
}

function sendFileSecurityKey() {
	var inputFileSecurity = document.getElementById("securityKey");

	if (inputFileSecurity.value === "") {
		return alert("É necessário adicionar um arquivo antes de clicar no Enviar.");
	}

	var formFile = document.forms.namedItem("atualizaProtocolo");

	if (Validate(formFile)) {
        formFile.action = "/e-solution/servicos/bbhive/configuracao/upload.php";
        formFile.method = "POST";
        formFile.submit();
    }
}

var _validFileExtensions = [".pem"];
function Validate(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    }
                }

                if (!blnValid) {
                    alert("Arquivo, " + sFileName + " é inválido, extensões permitidas: " + _validFileExtensions.join(", "));
                    return false;
                }
            }
        }
    }

    return true;
}

function listenerTestarComunicacaoRedeSimples() {
    document.getElementById('resComunicacaoRedeSimples').innerHTML = "Aguarde, consultando servidor...";

    var TimeStamp 		= new Date().getTime();
    var homeDestino		= '/e-solution/servicos/bbhive/configuracao/index.php?Ts='+TimeStamp;
    var idMensagemFinal = 'resComunicacaoRedeSimples';
    var infoGet_Post	= '&testeComunicacaoRedeSimples=true';//Se envio for POST, colocar nome do formul�rio
    var Mensagem		= "Consultando dados";
    var idResultado	    = idMensagemFinal;//'menHistorico';
    var Metodo			= "2";//1-POST, 2-GET
    var TpMens			= "2";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

    OpenAjaxPostCmd(homeDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}