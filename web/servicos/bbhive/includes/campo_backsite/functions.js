//
//
//
	function mostraOpcaoTipo(tipo){
		tipo		= parseInt(tipo);
		opcao_01	= document.getElementById('opcao_campo_01');
		opcao_02	= document.getElementById('opcao_campo_02');
		switch(tipo){
			case 1:
				opcao_01.style.display = 'block';
				opcao_02.style.display = 'block';
				break;
			case 2:
				opcao_01.style.display = 'none';
				opcao_02.style.display = 'none';
				break;
			default:
				opcao_01.style.display = 'none';
				opcao_02.style.display = 'none';
				break;
		}
	}
//
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
// FUNÇÃO QUE BUSCA O VALOR DE TODOS OS VALORES DOS CAMPOS ÚNICOS
//
	function validaFormDinamico(Form){
		var nmForm	= Form.name;
		var oCampo 	= document.getElementById("campos_obrigatorios").value.split("!@#");
		var txt		= "Campos obrigatórios:\n";
		var error	= 0;
		//--
		for(a=0; a<oCampo.length; a++){
			var vr 	= oCampo[a].split("|");
			var cp	= eval("document."+nmForm+"."+vr[0]+".value");
			//--
			if(retiraEspacos(cp)==""){
				error = 1;
				txt+= ".:: "+vr[1]+".\n";
			}
			//--
		}
		//--
		if(error>0){//
			alert(txt);
			return false;
		} else {
			eval("document."+nmForm+".submit()");
		}
	}
	/*function executaCampo(string_retorno,localPadrao){
		//separo os valores de cada plugin
		separaValores = string_retorno.split('#');
		valorUnico = '';
		valorObrigatorio = '';
		for(i=0;i<(separaValores.length);i++){
			tipoPlugin = separaValores[i].split('=');
			//plugin do Valor Único
			if(tipoPlugin[0]=='CAMPO_UNICO'){
				quebraTab = tipoPlugin[1].split('<%SEP_0%>');
				for(a=0;a<(quebraTab.length);a++){
					var valores = '';
					valorUnico += '<%SEP_0%>';
					quebra = quebraTab[a].split('<%SEP_1%>');
					quebraValor = quebra[0].split('<%SEP_2%>');
					for(b=0;b<(quebraValor.length);b++){
						quebra2 = quebraValor[b].split('<%SEP_3%>');
						valores += '<%SEP_2%>'+quebraValor[b]+'<%SEP_3%>'+document.getElementById(quebra2[0]).value;
					}
					valores = valores.substr(9);
					valorUnico += valores+'<%SEP_1%>'+quebra[1];
				}
			}
			//plugin do Valor Obrigatório
			if(tipoPlugin[0]=='CAMPO_OBRIGATORIO'){
				quebraValor = tipoPlugin[1].split('<%SEP_2%>');
				for(c=0;c<(quebraValor.length);c++){
					quebra2 = quebraValor[c].split('<%SEP_3%>');
					if(document.getElementById(quebra2[0]).value==''){
						alert('O '+quebra2[1]+' não pode estar vazio.');
						return false;
					}
				}
			}
		}
		//plugin do valor único
		if(valorUnico!=''){
			valorUnico = valorUnico.substr(9);
			document.getElementById('valorUnico').value=valorUnico;
		}
		//OpenAjaxPostCmd(localPadrao+'executa.php?','div_executa','form1','aguarde','1','1');
		OpenAjaxPostCmd(localPadrao,'div_executa','form1','aguarde','1','1');
	}*/
//
// PREENCHE DATAS
//
	function preencheData(tipo,id){
		switch(tipo){
			case 'data':
				dia = document.getElementById(id+'_dia').value;
				mes = document.getElementById(id+'_mes').value;
				ano = document.getElementById(id+'_ano').value;
				document.getElementById(id).value = ano+'-'+mes+'-'+dia;	
				break;
			case 'data_hora':
				dia  = document.getElementById(id+'_dia').value;
				mes  = document.getElementById(id+'_mes').value;
				ano  = document.getElementById(id+'_ano').value;
				hora = document.getElementById(id+'_hora').value;
				minu = document.getElementById(id+'_min').value;
				segu = document.getElementById(id+'_seg').value;
				document.getElementById(id).value = ano+'-'+mes+'-'+dia+' '+hora+':'+minu+':'+segu;	
				break;
			case 'hora':
				hora = document.getElementById(id+'_hora').value;
				minu = document.getElementById(id+'_min').value;
				segu = document.getElementById(id+'_seg').value;
				document.getElementById(id).value = hora+':'+minu+':'+segu;	
				break;
			case 'data_fim':
				dia = document.getElementById(id+'_dia_fim').value;
				mes = document.getElementById(id+'_mes_fim').value;
				ano = document.getElementById(id+'_ano_fim').value;
				document.getElementById(id).value = ano+'-'+mes+'-'+dia;	
				break;
			case 'data_hora_fim':
				dia  = document.getElementById(id+'_dia_fim').value;
				mes  = document.getElementById(id+'_mes_fim').value;
				ano  = document.getElementById(id+'_ano_fim').value;
				hora = document.getElementById(id+'_hora_fim').value;
				minu = document.getElementById(id+'_min_fim').value;
				segu = document.getElementById(id+'_seg_fim').value;
				document.getElementById(id).value = ano+'-'+mes+'-'+dia+' '+hora+':'+minu+':'+segu;	
				break;
			case 'hora_fim':
				hora = document.getElementById(id+'_hora_fim').value;
				minu = document.getElementById(id+'_min_fim').value;
				segu = document.getElementById(id+'_seg_fim').value;
				document.getElementById(id).value = hora+':'+minu+':'+segu;	
				break;
		}
	}
//
// MASCARA DOS CAMPO SIMPLES
//
	//FUNÇÃO PRINCIPAL
	function mascara_campo(o,f){
		v_obj=o
		v_fun=f
		setTimeout("execMascaraCampo()",1)
	}
	//FUNÇÃO AUXILIAR
	function execMascaraCampo(){
		v_obj.value=v_fun(v_obj.value)
	}
	//MASCARA DE NUMERO
	function campoNumero(v){
		return v.replace(/\D/g,"")
	}
	//MASCARA DE TELEFONE
	function campoTelefone(v){
		v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
		//v=v.replace(/^(\d\d)(\d)/g,"+$1$2") //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/^(\d\d\d)(\d\d)(\d)/g,"+$1($2) $3") //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
		return v
	}
	//MASCARA DE TELEFONE COM DDI
	function campoTelefoneDDI(v){
		v=v.replace(/\D/g,"")                 //Remove tudo o que não é dígito
		//v=v.replace(/^(\d\d)(\d)/g,"+$1$2") //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/^(\d\d\d)(\d\d)(\d)/g,"+$1($2) $3") //Coloca parênteses em volta dos dois primeiros dígitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca hífen entre o quarto e o quinto dígitos
		return v
	}
	//MASCARA DE WEB
	function campoWeb(v){
		v=v.replace(/^http:\/\/?/,"")
		dominio=v
		caminho=""
		if(v.indexOf("/")>-1)
			dominio=v.split("/")[0]
			caminho=v.replace(/[^\/]*/,"")
		dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
		caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"") 
		caminho=caminho.replace(/([\?&])=/,"$1")
		if(caminho!="")dominio=dominio.replace(/\.+$/,"")
		v="http://"+dominio+caminho
		return v
	}
	//MASCARA DE CNPJ
	function campoCNPJ(v){
		v=v.replace(/\D/g,"")                           //Remove tudo o que não é dígito
		v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro dígitos
		v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
		v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono dígitos
		v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um hífen depois do bloco de quatro dígitos
		return v
	}
	//MASCARA MOEDA
	function maskIt(w,e,m,r,a){
		// Cancela se o evento for Backspace
		if (!e) var e = window.event
		if (e.keyCode) code = e.keyCode;
		else if (e.which) code = e.which;
		// Variáveis da função
		var txt  = (!r) ? w.value.replace(/[^\d]+/gi,'') : w.value.replace(/[^\d]+/gi,'').reverse();
		var mask = (!r) ? m : m.reverse();
		var pre  = (a ) ? a.pre : "";
		var pos  = (a ) ? a.pos : "";
		var ret  = "";
		if(code == 9 || code == 8 || txt.length == mask.replace(/[^#]+/g,'').length) return false;
		// Loop na máscara para aplicar os caracteres
		for(var x=0,y=0, z=mask.length;x<z && y<txt.length;){
		if(mask.charAt(x)!='#'){
		ret += mask.charAt(x); x++; } 
		else {
		ret += txt.charAt(y); y++; x++; } }
		// Retorno da função
		ret = (!r) ? ret : ret.reverse()        
		w.value = pre+ret+pos; }
		// Novo método para o objeto 'String'
		String.prototype.reverse = function(){
		return this.split('').reverse().join(''); 
	}

	function campoDecimal(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
		var sep = 0;
		var key = '';
		var i = j = 0;
		var len = len2 = 0;
		var strCheck = '0123456789';
		var aux = aux2 = '';
		var whichCode = e.keyCode;
		if (whichCode == 13) return true;
		key = String.fromCharCode(whichCode); // Valor para o código da Chave
		if (strCheck.indexOf(key) == -1) return false; // Chave inválida
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
