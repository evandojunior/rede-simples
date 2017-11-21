<?php
require_once("../../../../Connections/bbhive.php");
include("../../../../../database/config/globalFunctions.php");

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "editaSMTP")) {

		$emailOrigem 	= ($_POST['bbh_set_email_origem']);
		$smtp			= ($_POST['bbh_set_smtp']);
		$usuario		= ($_POST['bbh_set_usuario']);
		$senha			= ($_POST['bbh_set_senha']);
		$subject 		= ($_POST['bbh_set_titulo_origem']);
		$assunto  		= ($_POST['bbh_set_assunto']);

    $query_email = "UPDATE bbh_setup SET bbh_set_email_origem='$emailOrigem', bbh_set_smtp='$smtp', bbh_set_usuario='$usuario', bbh_set_senha='$senha', bbh_set_titulo_origem='$subject', bbh_set_assunto='$assunto'";
    list($res, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_email);
	 exit;
}

$query_email = "SELECT * FROM bbh_setup limit 1";
list($email, $row_email, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_email);
			 
// form
	$homeSMTP= '/e-solution/servicos/bbhive/configuracao/dados_smtp.php';
	$acaoSMTP = "OpenAjaxPostCmd('".$homeSMTP."','loadSMTP','editaSMTP','Atualizando dados...','loadSMTP','1','2');";
	
//
?>
<form method="POST" name="editaSMTP" id="editaSMTP">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="71%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Dados de SMTP</strong>
    </td>
    <td width="29%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" id="loadSMTP">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" colspan="2">

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="100%" height="22" align="center">
            	
            	<div id="msgCabeca">
                	<table width="98%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="25" align="right"><strong>URL de execu&ccedil;&atilde;o:</strong></td>
                        <td colspan="2" align="left"><label for="execucao"></label>
                        <input name="execucao" type="text" id="execucao" size="80" class="verdana_11" readonly="readonly" value="<?php echo "http://".$_SERVER['HTTP_HOST']."/e-solution/servicos/bbhive/atrasadas.php";?>" style="font-weight:bold" /></td>
                      </tr>
                      <tr>
                        <td width="128" height="25" align="right"><strong>E-mail de origem :&nbsp;</strong></td>
                        <td colspan="2" align="left">
                        <input class="back_Campos" name="bbh_set_email_origem" type="text" id="bbh_set_email_origem" size="80"  value="<?php echo $row_email['bbh_set_email_origem']; ?>"></td>
                      </tr>
                      <tr>
                        <td width="128" height="25" align="right"><strong>T&iacute;tulo :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="bbh_set_titulo_origem" type="text" id="bbh_set_titulo_origem" size="80" value="<?php echo $row_email['bbh_set_titulo_origem']; ?>"></td>
                      </tr>
                      <tr>
                        <td width="128" height="25" align="right"><strong>Assunto :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="bbh_set_assunto" type="text" id="bbh_set_assunto" size="80" value="<?php echo $row_email['bbh_set_assunto']; ?>"></td>
                      </tr>
                      <tr>
                        <td height="25" align="right"><strong>SMTP :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="bbh_set_smtp" type="text" id="bbh_set_smtp" size="80" value="<?php echo $row_email['bbh_set_smtp']; ?>" /></td>
                      </tr>
                      <tr>
                        <td width="128" height="25" align="right"><strong>Usu&aacute;rio :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="bbh_set_usuario" type="text" id="bbh_set_usuario" size="80" value="<?php echo $row_email['bbh_set_usuario']; ?>"></td>
                      </tr>
                      <tr>
                        <td width="128" height="25" align="right"><strong>Senha :&nbsp;</strong></td>
                        <td colspan="2" align="left"><input class="back_Campos" name="bbh_set_senha" type="password" id="bbh_set_senha" size="80" value="<?php echo $row_email['bbh_set_senha']; ?>"></td>
                      </tr>
                      <tr>
                        <td height="25" colspan="3" align="right"><strong>&nbsp;</strong>
                         <input type="button" name="button" id="button" value="Atualizar SMTP" class="button" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return validaForm('editaSMTP', 'bbh_set_email_origem|Preencha o campo de email,bbh_set_titulo_origem|Coloque um t&iacute;tulo,bbh_set_assunto|Coloque um assunto,bbh_set_usuario| Coloque um usu&aacute;rio, bbh_set_senha| Coloque uma senha,bbh_set_smtp| Coloque o SMTP', document.getElementById('acaoForm').value)" />
                         <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acaoSMTP; ?>" />                        </td>
                      </tr>
                    </table>

              </div>
            </td>
          </tr>
          
          </table>
      </td>
    </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<input type="hidden" name="MM_update" value="editaSMTP" />
</form>