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
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//alert(xmlhttp.responseText);
				obj.innerHTML = xmlhttp.responseText;
			}
		}	
			xmlhttp.send(null);
	}
/*==============================================================================================================*/
/*===================================================*/
function limpaMsgPadrao(liberado){
	if(document.getElementById('msgLock')!=null){
		document.getElementById('msgLock').style.display='none';
		
		var idIcone = "iconLock_"+document.getElementById('idLockAcao').value;
		var tagIcone= document.getElementById(idIcone);
		
			if(liberado==1){
				tagIcone.src= tagIcone.src.replace("modulos_off","modulos_on");
			} else {
				tagIcone.src= tagIcone.src.replace("modulos_on","modulos_off");
			}
	}
}
/*==================================================*/

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

function trocaMenu(elemento, acaoClasse){
	if(acaoClasse=="ativa"){
		document.getElementById(elemento+"_esquerda").className = "barra_ferramentas_esquerda";
		document.getElementById(elemento+"_direita").className 	= "barra_ferramentas_direita";
	}else{
		document.getElementById(elemento+"_esquerda").className = "barra_ferramentas_esquerda_desativada";
		document.getElementById(elemento+"_direita").className 	= "barra_ferramentas_direita_desativada";
	}
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
//--
	function captura(end)
	{	
		var err;
		var result = false;
		
		try // Exception handling
		{
			//--
			if(retiraEspacos(document.getElementById('bbp_adm_lock_bio_email').value)==''){
				alert('Informe o e-mail.');
				return(false);	
			}
			//--
			DEVICE_AUTO_DETECT	= 255;
			var objNBioBSP = new ActiveXObject('NBioBSPCOM.NBioBSP.1');
			var objDevice = objNBioBSP.Device;
			var objExtraction = objNBioBSP.Extraction;
			objExtraction.WindowStyle = 1;
	
			// Open device. [AUTO_DETECT]
			// You must open device before capture.
			objDevice.Open(DEVICE_AUTO_DETECT);
			err = objDevice.ErrorCode;	// Get error code	
			if ( err != 0 )		// Device open failed
			{
				alert('Falha ao iniciar dispositivo!');
			}
			else
			{
				// Captura impressão do usuário
				alert('Posicione o dedo para identificação biométrica');
				objExtraction.Capture();
				err = objExtraction.ErrorCode;	// Recupera o código do rerro
			
				if ( err != 0 )		// Verifica se houve erro
				{
					alert('Falha na captura! Erro número : [' + err + ']');
				}
				else	// Capturou com sucesso
				{
					// Recupera texto codificado FIR data from NBioBSP module.
					document.MainForm.FIRTextData.value = objExtraction.TextEncodeFIR;
					//alert('Capturado com sucesso!');
					result = true;
				}
			
				// Close device. [AUTO_DETECT]
				objDevice.Close(DEVICE_AUTO_DETECT);
			}
					
			objExtraction = 0;
			objDevice = 0;		
			objNBioBSP = 0;
		}
		catch(e)
		{
			alert(e.message);
			return(false);
		}
		
		if ( result )
		{
			// Submit main form
			document.getElementById('id').value = document.MainForm.FIRTextData.value;
			//--
			OpenAjaxPostCmd(end+'/servicos/bbpass/modulos_autenticacao/modulos/biometria_nitgen/formulario.php','mensagemBio','MainForm','Aguarde consultando dados...','mensagemBio',1,2);
			//document.MainForm.submit();
		}
		
		return (result);
	}
	//--
	function compara(end)
	{	
		var err;
		var result = false;
		
		try // Exception handling
		{
			DEVICE_AUTO_DETECT	= 255;
			
			var objNBioBSP = new ActiveXObject('NBioBSPCOM.NBioBSP.1');
			var objDevice = objNBioBSP.Device;
			var objExtraction = objNBioBSP.Extraction;
			
			var objMatching = objNBioBSP.Matching;
			
			// Open device. [AUTO_DETECT]
			// You must open device before capture.
			objDevice.Open(DEVICE_AUTO_DETECT);
	
			err = objDevice.ErrorCode;	// Get error code	
			if ( err != 0 )		// Device open failed
			{
				alert('Falha ao iniciar dispositivo!');
			}
			else
			{
				objMatching.VerifyMatch(document.getElementById('digital').value,document.getElementById('digitalBanco').value);
	
			  if (objMatching.MatchingResult == '1') {
				document.MainForm.submit();
			  } else {
				alert ('A digital não confere');
				alert ('Tente novamente.');
			  }
			
				// Close device. [AUTO_DETECT]
				objDevice.Close(DEVICE_AUTO_DETECT);
			}
					
			objExtraction = 0;
			objDevice = 0;		
			objNBioBSP = 0;
		}
		catch(e)
		{
			alert(e.message);
			return(false);
		}
	}