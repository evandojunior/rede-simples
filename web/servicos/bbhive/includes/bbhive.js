// JavaScript Document
TimeStamp 		= new Date().getTime();

function openAjax() {

	var ajax;
	try{
		ajax = new XMLHttpRequest();
	}catch(ee){
		try{
			ajax = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				ajax = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(E){
				ajax = false;
			}
		}
	}
	return ajax;
}

function CpForm(FormName){

	comp = "document." + FormName;
	var frm = eval(comp);
	Cps = "";	
	for (i=0; i<frm.length; i++){
		if(frm.elements[i].type == "select-multiple")
		{

			for($x = 0; $x < frm.elements[i].options.length;$x++)
			{
				if(frm.elements[i].options[$x].selected)
				{
					 Cps = Cps + frm.elements[i].name +"="+ frm.elements[i].options[$x].value + "&";
				}
			}
		}
		if(frm.elements[i].type == "radio"){
				if(frm.elements[i].checked)
				{
					Cps = Cps + frm.elements[i].name + "=" + escape(frm.elements[i].value) + "&";	
				}
	
		}else if(frm.elements[i].type == "checkbox"){
			if(frm.elements[i].checked)
				{
					Cps = Cps + frm.elements[i].name + "=" + escape(frm.elements[i].value) + "&";	
				}
		}else{
				Cps = Cps + frm.elements[i].name + "=" + frm.elements[i].value + "&";
		}
		
		//Cps = Cps + frm.elements[i].name + "=" + frm.elements[i].value + "&";
	}
	Cps = Cps.substring(0,Cps.length -1);
	return Cps;
}

function OpenAjaxPostCmd(pagina,camada,values,msg,divcarga,metodo,tpmsg) { 

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
			var Ts = new Date().getTime();
			ajax.open("GET", pagina + values + "&Ts="+Ts, true);
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
					exibeLoading.innerHTML = "";
					exibeLoading.style.display = 'none';
				}else{
					exibeResultado.innerHTML = "";
				}
				if(ajax.status == 200) {

					var resultado = null;
					resultado = ajax.responseText;
					resultado = resultado.replace(/\+/g," ");
					resultado = unescape(resultado);

					exibeResultado.innerHTML = resultado;

					//S� EXCLUSIVAMENTE PARA RETORNO JAVASCRIPT
						var scripts = exibeResultado.getElementsByTagName("var");
							for(i=0; i < scripts.length; i++){
								s = scripts[i].innerHTML;
								eval(s);						
							}
				} else {
					var msgErro = "<div class='verdana_11_vermelho'>Ocorreu um erro inesperado, contate o administrador!!!</div>";
					exibeResultado.innerHTML = ajax.responseText;//msgErro//
					//LoadSimultaneo('perfil/index.php?perfil=1|protocolos/regra.php','menuEsquerda|conteudoGeral');
					//LoadSimultaneo('protocolos/regra.php','conteudoGeral');
				}
			}
		}
		ajax.send(valor);
	}		 
}

function txtSimples(tagDestino, valor){
	document.getElementById(tagDestino).innerHTML=valor;
}

function TrocaFundo(divFerramenta){
	elemento = document.getElementById(divFerramenta);

	if(elemento.className == "FundoNaoSelecionado"){
		document.getElementById(divFerramenta).className = "FundoSelecionado";
	}else{
		document.getElementById(divFerramenta).className = "FundoNaoSelecionado";
	}
}

function LoadInicial(Destino, TagEscreve){
	var TimeStamp 		= new Date().getTime();
		if(Destino.split("?").length>1){
			ajuste="&";
		} else {
			ajuste="?";	
		}
	var PaginaDestino	= "/servicos/bbhive/"+Destino+ajuste+"TimeStamp="+TimeStamp+"&";
	var idMensagem		= TagEscreve;
			//cria objeto onde ser� exibida a mensagem
			var CriaElemento		= document.getElementById(idMensagem);
			var Elemento 			= document.createElement("div");
				Elemento.id 		= "loadImage_"+TagEscreve;
				Elemento.className 	= "loadImage";
//alert(CriaElemento.childNodes.length);
					if(CriaElemento.childNodes.length==0){
						CriaElemento.appendChild(Elemento);
					} else {
						var Filho = CriaElemento.childNodes[0];
						CriaElemento.insertBefore(Elemento, Filho);
					}
				idMensagemFinal = "loadImage_"+TagEscreve;
			//fim da cria��o do objeto
	var infoGet_Post	= "1=1";//Se envio for POST, colocar nome do formul�rio
	var Mensagem		= "&nbsp;";
	var idResultado		= idMensagem;
	var Metodo			= "2";//1-POST, 2-GET
	var TpMens			= "1";//1-Troca conte�do sem apagar anterior , 2-Troca conte�do apagando o anterior antes

	OpenAjaxPostCmd(PaginaDestino,idResultado,infoGet_Post,Mensagem,idMensagemFinal,Metodo,TpMens);
}

function LoadSimultaneo(urls,exibicoes){
	var TimeStamp 	= new Date().getTime();
	var Pagina	 	= urls.split("|");
	var TagExibicao = exibicoes.split("|");
	var QtdPag		= Pagina.length;
	//alert(urls);
	//grava url na sess�o
	makerequest('/servicos/bbhive/includes/url.php?novo=true&Time='+TimeStamp+"&url="+urls+"&exibicao="+exibicoes, "url");
	
		for($pag=0; $pag<QtdPag; $pag++){
			var PagDestino  = Pagina[$pag];//recupero a p�gina de destino			
			var OndeExibe	= TagExibicao[$pag];//recupero id de onde ser� exbido a p�gina
			//alert(PagDestino+"="+OndeExibe);
			LoadInicial(PagDestino,OndeExibe);//envio solicita��o ass�ncrona
		}
}

//
opouo = false;

function windowOpen(value,titulo)
{
	opouo = false;
	var _win = window.open('','Arvore','width=500,height=500,scrolling=0');
		
		if(!_win)
		{
			alert('A janela n�o pode ser aberta, talv�s voc� esteja usando um bloqueador de POP-UP. Desabilite-o e tente novamente!');
			return false;
		}
		
		_win.document.open();
		_win.document.write('<script type="text/javascript">opener.opouo=true;function popula(value){opener.document.getElementById("'+value+'").value = value;value = value.split(\' \');t=value.shift();value = value.join(\' \');opener.document.getElementById("'+value+'_mostra").value = value;window.close();}</script>');
		_win.document.write('<style stype="text/css">body{margin:0;padding:0;}*{border:0;}<\/style>');
		_win.document.write('<ifr'+'ame src="/servicos/bbhive/includes/lista_arvore.php?='+value+'&='+titulo+'" style="width:100%;height:100%;">'+'</if'+'rame>');
		_win.document.close();
}

function descobreParentes(maskara, container)
{
	DivCcontainer = document.getElementById(container);
	DivCcontainer.innerHTML = 'Aguarde, montando �rvore...';
	
	_url = '/servicos/bbhive/includes/monta_arvore.php?='+maskara;
	
	ajax = openAjax();
	ajax.open("GET", _url, true);
	ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	ajax.setRequestHeader("Pragma", "no-cache");
	ajax.onreadystatechange = function()
	{
			if(ajax.readyState == 4)
			{
				if( ajax.status == 200 )
				{	
					DivCcontainer = document.getElementById(container);
					DivCcontainer.innerHTML = ajax.responseText;
				}
			}
	}
	ajax.send();
}
