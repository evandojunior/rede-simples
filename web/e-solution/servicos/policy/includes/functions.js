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
		if(frm.elements[i].type == "radio"){
				if(frm.elements[i].checked){
					Cps = Cps + frm.elements[i].name + "=" + escape(frm.elements[i].value) + "&";	
				}
	
		}else if(frm.elements[i].type == "checkbox"){
			if(frm.elements[i].checked){
					Cps = Cps + frm.elements[i].name + "=" + escape(frm.elements[i].value) + "&";	
			}
		}else{
				Cps = Cps + frm.elements[i].name + "=" + escape(frm.elements[i].value) + "&";
		}
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
			ajax.open("GET", pagina + values, true);
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

					//SÓ EXCLUSIVAMENTE PARA RETORNO JAVASCRIPT
						var scripts = exibeResultado.getElementsByTagName("var");
							for(i=0; i < scripts.length; i++){
								s = scripts[i].innerHTML;
								eval(s);						
							}
				} else {
					exibeResultado.innerHTML = "Erro inesperado, contate o administrador";
				}
			}
		}
		ajax.send(valor);
	}		 
}


function TrocaFundo(divFerramenta)
{
	
	elemento = document.getElementById(divFerramenta);

	if(elemento.className == "ferramentasUsuarioON")
	{
		document.getElementById(divFerramenta).className = "ferramentasUsuarioOFF";
	}else{
		document.getElementById(divFerramenta).className = "ferramentasUsuarioON";

	}


}

function TrocaFundoCalendario(bloco)
{
	elemento = document.getElementById(bloco);
	if(elemento.className == "blocoON")
	{
		document.getElementById(bloco).className = "blocoOFF";
	}else{
		document.getElementById(bloco).className = "blocoON";
	}
}

function exibeExporta(valor, complemento){
	var TimeStamp = new Date().getTime();
	var OndeExibe = valor;
	var URLDestino= "/e-solution/servicos/policy/detalhes/impressao.php?TimeStamp="+TimeStamp+"&";
	var Form_GET  = "pol_aud_codigo="+valor+"&"+complemento;
	var MsgCliente= "<div style='position:absolute; background:#fff'><strong>Carregando...</strong></div>";
	
	if(document.getElementById('aplicacao').value!=""){
		var antigo = document.getElementById('aplicacao').value;
			document.getElementById(antigo).innerHTML="";
	}
	
	document.getElementById('aplicacao').value=valor;
	
	OpenAjaxPostCmd(URLDestino, OndeExibe,Form_GET, MsgCliente,OndeExibe,'2','2');
}

function FechaJanela(valor){
	document.getElementById(valor).innerHTML="";
}

function enviaPDF(){
	document.form_pdf.submit();
	/*
	var TimeStamp = new Date().getTime();
	var OndeExibe = "exportaPDF";
	var URLDestino= "/e-solution/servicos/policy/includes/gera_pdf.php?TimeStamp="+TimeStamp+"&";
	var Form_GET  = "form_pdf";
	var MsgCliente= "<div style='position:absolute; background:#fff'><strong>Carregando...</strong></div>";

	OpenAjaxPostCmd(URLDestino, OndeExibe,Form_GET, MsgCliente,OndeExibe,'1','2');*/
}

//Filtros
function LoadFiltros(valor){
		var TimeStamp = new Date().getTime();
	var OndeExibe = "filtro";
	var URLDestino= "/e-solution/servicos/policy/filtros/filtro.php?TimeStamp="+TimeStamp+"&";
	var Form_GET  = "pol_apl_codigo="+valor;
	var MsgCliente= "<div style='position:absolute; background:#fff'><strong>Carregando...</strong></div>";
	
	OpenAjaxPostCmd(URLDestino, OndeExibe,Form_GET, MsgCliente,OndeExibe,'2','2');
}

function LoadCondicao(valor, ondeEscreve, complemento){
	
	if(document.getElementById(ondeEscreve+'Ok').value=="1"){
		document.getElementById(ondeEscreve).innerHTML = '<input name="pol_'+ondeEscreve+'" type="text" class="back_Campos" size="40">';
		document.getElementById(ondeEscreve+'Ok').value = "0";
	} else {
		var TimeStamp = new Date().getTime();
		var OndeExibe = ondeEscreve;
		var URLDestino= "/e-solution/servicos/policy/filtros/filtro_agrupado.php?TimeStamp="+TimeStamp+"&";
		var Form_GET  = "pol_apl_codigo="+valor+"&"+complemento;
		var MsgCliente= "<img src='/e-solution/servicos/policy/images/snake.gif' />";
			document.getElementById(ondeEscreve+'Ok').value = "1";
			
		OpenAjaxPostCmd(URLDestino, OndeExibe,Form_GET, MsgCliente,OndeExibe,'2','2');
	}
}

function enviaRegra(chamaPagina){
	valor = CpForm('form1')	;
	
	var TimeStamp = new Date().getTime();
	var OndeExibe = "filtro";
	var URLDestino= chamaPagina+"?TimeStamp="+TimeStamp+"&";
	var Form_GET  = valor;
	var MsgCliente= "<div style='position:absolute; background:#fff'><strong>Carregando...</strong></div>";

	OpenAjaxPostCmd(URLDestino, OndeExibe,Form_GET, MsgCliente,OndeExibe,'2','2');
}

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
function EditaObs(editFormAction){
//	alert(document.form1.action);
	document.form1.action=editFormAction;
//	alert(document.form1.action);
	var original   = document.getElementById('original');
	var caixa      = document.getElementById('caixa');
	var bototes    = document.getElementById('botoes');
	var exporta    = document.getElementById('exportapdf');
	original.style.display   = "none";
	caixa.style.visibility      = "visible";
	bototes.style.visibility    = "visible";
	exporta.setAttribute("disabled","disabled");
	exporta.setAttribute("src","/e-solution/servicos/policy/images/pdfdesativado.gif");
	exporta.setAttribute("title","Não é possível gerar PDF no modo de edição");

}
function FechaObs(){
//	alert(document.form1.action);
	document.form1.action='../includes/gera_pdf.php';
//	alert(document.form1.action);
	var original   = document.getElementById('original');
	var caixa      = document.getElementById('caixa');
	var bototes    = document.getElementById('botoes');
	var exporta = document.getElementById('exportapdf');
	original.style.display      = "";
	caixa.style.visibility      = "hidden";
	bototes.style.visibility    = "hidden";
	exporta.removeAttribute("disabled","disabled");
	exporta.setAttribute("src","/e-solution/servicos/policy/images/pdf.gif");
	exporta.setAttribute("title","Clique aqui para exportar as informações para PDF");
	
}

//Valida se o conteúdo do objeto.value é número
function SomenteNumerico(elemento)
{
	if(isNaN(elemento.value))
	{
		alert("Digite apenas valores numéricos");	
		elemento.value = "";
	}
}
