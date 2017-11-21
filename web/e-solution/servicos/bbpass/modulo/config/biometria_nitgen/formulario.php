<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 
//--

if(isset($_POST['id']) && !empty($_POST['id'])){
	//Inicia sessão caso não esteja criada
	include("gerencia_biometria.php");
	$biometria 				= new Biometria();
	$modulo 				= new Modulo();
	//--
	$biometria->bbp_adm_lock_bio_email	= $_POST['bbp_adm_lock_bio_email'];
	$notIn = "";
	$resul = $biometria->verificaRepetido($database_bbpass, $bbpass, $notIn);//UPDATE
	//--
	if($resul>0){
	  echo "<var style='display:none'>
			 alert('Email já existente na base de dados!');
			</var>";
		exit;
	}
	//--	
	$biometria->bbp_adm_lock_bio_nome		= ($_POST['bbp_adm_lock_bio_nome']);
	$biometria->bbp_adm_lock_bio_email		= $_POST['bbp_adm_lock_bio_email'];
	$biometria->bbp_adm_lock_bio_digital	= $_POST['FIRTextData'];
	//--
	$biometria->cadastraDados($database_bbpass, $bbpass);
	//--
	
	//Policy=================================
	$_SESSION['relevancia']="10";
	$_SESSION['nivel']="2.5.1.1";
	// $Evento="Cadastrou o módulo ".$assinatura->bbp_adm_loc_nome;
	$Evento="Cadastrou o usuário ".$biometria->bbp_adm_lock_bio_nome." no módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_POST['bbp_adm_loc_codigo']);
	EnviaPolicy($Evento);
  //=======================================
	  echo "<var style='display:none'>
			 alert('Usuário cadastrado com sucesso');history.back(-1);
			</var>";
		exit;
}
//--
	$idUser = (int)$_GET['bbp_adm_lock_log_codigo'];
	$query_Login = "SELECT bbp_adm_lock_log_nome, bbp_adm_lock_log_email FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_codigo='$idUser'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);
//--
?><html>

<script type="text/javascript" src="../../../includes/javascript_backsite/ajax/ajax.js"></script>
<!-- NBioBSP Component -->
<OBJECT classid="CLSID:F66B9251-67CA-4d78-90A3-28C2BFAE89BF"		 
		height=0 width=0 VIEWASTEXT>
</OBJECT>
<script type="text/javascript">
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
function captura()
{	
	var err;
	var result = false;
	
	try // Exception handling
	{
		//--
		if(retiraEspacos(document.getElementById('bbp_adm_lock_bio_email').value)=='' || retiraEspacos(document.getElementById('bbp_adm_lock_bio_nome').value)==''){
			alert('Informe o nome e e-mail.');
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
			alert('Posicione o dedo');
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
		OpenAjaxPostCmd('formulario.php','mensagem','MainForm','Aguarde consultando dados...','mensagem',1,2);
		//document.MainForm.submit();
	}
	
	return (result);
}

</script>

<body style="background-image:none; background-color:#FFF">
<form action='formulario.php' name="MainForm" id="MainForm" method="post" OnSubmit="javascript:return false;">
<table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center" style="margin-top:10px;" bgcolor="#FFFFFF">
  <tr>
    <td width="158" height="25" align="right" class="legendaLabel11"><strong>Nome do usu&aacute;rio</strong> :&nbsp;</td>
    <td width="422" height="25" class="legendaLabel11" style="color:#060">&nbsp;<strong><?php echo $row_Login['bbp_adm_lock_log_nome']; ?></strong>
      <input name="bbp_adm_lock_bio_nome" type="hidden" class="back_Campos" id="bbp_adm_lock_bio_nome" size="50" value="<?php echo $row_Login['bbp_adm_lock_log_nome']; ?>" readonly/>
      <input type="hidden" name="bbp_adm_loc_codigo" id="bbp_adm_loc_codigo" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>" /></td>
  </tr>
  <tr>
    <td height="25" align="right" class="legendaLabel11"><strong>Email do usu&aacute;rio</strong> :&nbsp;</td>
    <td height="25" class="legendaLabel11" style="color:#060">&nbsp;<strong><?php echo $row_Login['bbp_adm_lock_log_email']; ?></strong>      <input name="bbp_adm_lock_bio_email" type="hidden" class="back_Campos" id="bbp_adm_lock_bio_email" value="<?php echo $row_Login['bbp_adm_lock_log_email']; ?>" size="40" readonly/></td>
  </tr>
  <tr>
    <td height="10" colspan="2" id="resultado3"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" id="mensagem" style="font-size:12px; color:#060">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2" align="right"><input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Cadastrar usu&aacute;rio" onClick="captura()" />
    &nbsp; </td>
  </tr>
</table>
<input type=hidden name="FIRTextData" id="FIRTextData">
    <textarea name="id" cols="70" rows="8" id="id" style="display:none"></textarea>
</form>
<br>
</body>
</html>