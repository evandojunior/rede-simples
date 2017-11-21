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

					//SÓ EXCLUSIVAMENTE PARA RETORNO JAVASCRIPT
						var scripts = exibeResultado.getElementsByTagName("var");
							for(i=0; i < scripts.length; i++){
								s = scripts[i].innerHTML;
								eval(s);						
							}
				} else {
					var msgErro = "<div class='verdana_11_vermelho'>Ocorreu um erro inesperado, contate o administrador!!!</div>";
					exibeResultado.innerHTML = ajax.responseText;//msgErro//
				}
			}
		}
		ajax.send(valor);
	}		 
}

function enviaEditor(pagina){
	OpenAjaxPostCmd(pagina,"loadEditor","editorForm","Salvando informações","loadEditor","1","2");
}