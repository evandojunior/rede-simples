<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/administradores/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiAdm';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
$codigo = -1;
if(isset($_GET['bbh_adm_codigo'])){
	$codigo = $_GET['bbh_adm_codigo'];
}

$query_administrativo = "SELECT * FROM bbh_administrativo WHERE bbh_adm_codigo = '$codigo'";
list($administrativo, $row_administrativo, $totalRows_administrativo) = executeQuery($bbhive, $database_bbhive, $query_administrativo);

if ((isset($_POST['bbh_adm_codigo'])) && ($_POST['bbh_adm_codigo'] != "")) {

	  $deleteSQL = "DELETE FROM bbh_administrativo WHERE bbh_adm_codigo = ".$_POST['bbh_adm_codigo'];
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|administradores/index.php','menuEsquerda|conteudoGeral')</var>";
		  exit;
	}
?>
<form method="POST" name="excluiAdm" id="excluiAdm">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_admNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-administrador-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_admNome']; ?>
      <div style="float:right;"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');"><span 


class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Exclus&atilde;o do <?php echo strtolower($_SESSION['adm_admNome']); ?> </span></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%" id="erroDep" style="font-size:11px" class="aviso">Aten&ccedil;&atilde;o! Uma vez exclu&iacute;do a a&ccedil;&atilde;o n&atilde;o poder&aacute; ser revertida!</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td align="right" class="color">Nome&nbsp;:</td>
        <td height="23">&nbsp;
            <input name="bbh_adm_nome" type="text" class="back_Campos" id="bbh_adm_nome" value="<?php echo $row_administrativo['bbh_adm_nome'];  ?>" size="45" maxlength="255" disabled>
            <input type="hidden" name="bbh_adm_codigo" id="bbh_adm_codigo" value="<?php echo $row_administrativo['bbh_adm_codigo']; ?>"></td>
      </tr>
      <tr>
        <td align="right" valign="middle" class="color">E-Mail :</td>
        <td height="30" class="verdana_11_cinza">&nbsp;
            <input name="bbh_adm_identificacao" type="text" class="back_Campos" id="bbh_adm_identificacao" value="<?php echo $row_administrativo['bbh_adm_identificacao']; ?>" size="45" maxlength="255" disabled></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Data de nascimento :</td>
        <td height="24">&nbsp;
            <input name="bbh_adm_data_nascimento" type="text" class="back_Campos" id="bbh_adm_data_nascimento" value="<?php echo arrumadata($row_administrativo['bbh_adm_data_nascimento']); ?>" size="13" maxlength="10" disabled>
            <span class="verdana_11_cinza">(DD/MM/AAAA)</span></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Sexo : </td>
        <td>&nbsp;<?php if($row_administrativo['bbh_adm_sexo']==1){ echo "Feminino "; }else{ echo "Masculino"; } ?></td>
      </tr>
      <tr>
        <td width="18%">&nbsp;</td>
        <td width="82%" height="35">&nbsp;
              <input type="button" name="button2" id="button2" value="Cancelar" class="button" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');">
            <input type="button" name="button" id="button" value="Excluir" class="button" onclick="return validaForm('excluiAdm', 'bbh_adm_nome|Preencha o campo de nome,bbh_adm_identificacao|Coloque um e-mail v&aacute;lido,bbh_adm_data_nascimento|Informe sua data de nascimento', document.getElementById('acaoForm').value)" />
            <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>