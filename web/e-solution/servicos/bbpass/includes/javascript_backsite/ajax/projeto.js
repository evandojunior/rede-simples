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
//função para alterar o fundo na barra de ferramentas lateral
function alteraBarra(lado1,lado2){

	var elemento1 = document.getElementById(lado1);
	var elemento2 = document.getElementById(lado2);
	
	if(elemento1.className == "barra_ferramentas_esquerda"){
		elemento1.className = "barra_ferramentas_esquerda_desativada";
	}else{
		elemento1.className = "barra_ferramentas_esquerda";	
	}
	
	if(elemento2.className == "barra_ferramentas_direita"){
		elemento2.className = "barra_ferramentas_direita_desativada";
	}else{
		elemento2.className = "barra_ferramentas_direita";	
	}
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

function Verifica_CPF(valor) {
		var CPF = valor; // Recebe o valor digitado no campo
		
		
		// Aqui começa a checagem do CPF
		var POSICAO, I, SOMA, DV, DV_INFORMADO;
		var DIGITO = new Array(10);
		DV_INFORMADO = CPF.substr(9, 2); // Retira os dois últimos dígitos do número informado
		
		// Desemembra o número do CPF na array DIGITO
		for (I=0; I<=8; I++) {
		  DIGITO[I] = CPF.substr( I, 1);
		}
		
		// Calcula o valor do 10º dígito da verificação
		POSICAO = 10;
		SOMA = 0;
		   for (I=0; I<=8; I++) {
			  SOMA = SOMA + DIGITO[I] * POSICAO;
			  POSICAO = POSICAO - 1;
		   }
		DIGITO[9] = SOMA % 11;
		   if (DIGITO[9] < 2) {
				DIGITO[9] = 0;
		}
		   else{
			   DIGITO[9] = 11 - DIGITO[9];
		}
		
		// Calcula o valor do 11º dígito da verificação
		POSICAO = 11;
		SOMA = 0;
		   for (I=0; I<=9; I++) {
			  SOMA = SOMA + DIGITO[I] * POSICAO;
			  POSICAO = POSICAO - 1;
		   }
		DIGITO[10] = SOMA % 11;
		   if (DIGITO[10] < 2) {
				DIGITO[10] = 0;
		   }
		   else {
				DIGITO[10] = 11 - DIGITO[10];
		   }
		
		// Verifica se os valores dos dígitos verificadores conferem
		DV = DIGITO[9] * 10 + DIGITO[10];
		   if (DV != DV_INFORMADO) {
			  return 1;
		   } 
}

function SomenteNumerico(elemento)
{
	if(isNaN(elemento.value))
	{
		alert("Digite apenas valores numéricos");	
		elemento.value = "";
	}
}