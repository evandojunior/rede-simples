// JavaScript Document
/*=========================================LOGIN E SENHA=================================*/
function verificaRepetido(url, tagProcessamento, tagReferencia){
	var asReferencias = tagReferencia.split(",");
	var qtReferencia  = asReferencias.length;
	var asVariaveis	  = "";
		
			for($a=0; $a<qtReferencia;$a++){
				var oValor  = document.getElementById(asReferencias[$a]).value;
				asVariaveis+= "&"+asReferencias[$a]+"="+oValor;
			}
	var TS		= new Date().getTime();
	mostrarCarregando();//exibe mensagem para o usu�rio.
	OpenAjaxPostCmd(url+"1=1"+asVariaveis+"&"+TS,tagProcessamento,'','',tagProcessamento,'2','2');
}
/*=========================================FIM LOGIN E SENHA=============================*/

/*========================================ASSINATURA DIGITAL=============================*/
function validaFormulario(campoValida, acaoFormulario){
	var cpf		= document.getElementById(campoValida);
	var erro	= 0;
	
		if(cpf.value==""){
			alert('CPF obrigatório.');
			erro = 1;
		}
		
		if(Verifica_CPF(cpf.value)==1){
			alert("CPF inválido");
			cpf.focus();
			erro = 1;
		}
		if(erro==0){
			eval(acaoFormulario);
		}
}
/*=======================================FIM ASSINATURA DIGITAL==========================*/

/*BIOMETRIA*/
function validadoComSucesso(param){
	alert("Usu�rio cadastrado com sucesso");
	history.back(-1);
}

function erro(param){
	alert("Houve uma falha ao se cadastrar o usuário. " + param);
	history.back(-1);
}
/*BIOMETRIA*/