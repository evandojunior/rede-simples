<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/departamentos/excluir.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'excluiDept';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
$codigo = -1;
if(isset($_GET['bbh_dep_codigo'])){
	$codigo = $_GET['bbh_dep_codigo'];
}

$query_depto = "SELECT * FROM bbh_departamento WHERE bbh_dep_codigo = '$codigo'";
list($depto, $row_depto, $totalRows_depto) = executeQuery($bbhive, $database_bbhive, $query_depto);

if ((isset($_POST['bbh_dep_codigo'])) && ($_POST['bbh_dep_codigo'] != "")) {

	$query_valida = "SELECT bbh_usu_codigo FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_departamento.bbh_dep_codigo = ".$_POST['bbh_dep_codigo'];
    list($valida, $row_valida, $totalRows_valida) = executeQuery($bbhive, $database_bbhive, $query_valida);

	  if($totalRows_valida==0){
	  $deleteSQL = "DELETE FROM bbh_departamento WHERE bbh_dep_codigo = ".$_POST['bbh_dep_codigo'];
	  list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|departamentos/index.php','menuEsquerda|conteudoGeral')</var>";
		  exit;
		  }else{
		 $Erro ="<span class='aviso' style='font-size:11;'>N&atilde;o &eacute; poss&iacute;vel excluir um departamento se h&aacute; usu&aacute;rios nele.</span>";
  		echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
	}
?>
<form method="POST" name="excluiDept" id="excluiDept">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_deptoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-departamento-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_deptoNome']; ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/index.php','menuEsquerda|colCentro');"><span 


class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Exclus&atilde;o do <?php echo $_SESSION['adm_deptoNome']; ?> </span></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%" id="erroDep">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="18%" align="right" class="color">Nome&nbsp;:</td>
        <td width="82%" height="40">&nbsp;
            <input name="bbh_dep_nome" type="text" class="back_Campos" id="bbh_dep_nome" value="<?php echo $row_depto['bbh_dep_nome'];  ?>" size="45" maxlength="255" disabled>
              <input type="hidden" name="bbh_dep_codigo" id="bbh_dep_codigo" value="<?php echo $row_depto['bbh_dep_codigo']; ?>"></td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td>&nbsp;
            <textarea disabled class="formulario2" name="bbh_dep_obs" id="bbh_dep_obs" cols="44" rows="7"><?php if(isset($_POST['bbh_dep_obs'])){ echo $_POST['bbh_dep_obs']; } else { echo $row_depto['bbh_dep_obs']; }?>
  </textarea>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;
              <input type="button" name="button2" id="button2" value="Cancelar" class="button" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/index.php','menuEsquerda|colCentro');">
            <input type="button" name="button" id="button" value="Excluir" class="button" onclick="return validaForm('excluiDept', 'bbh_dep_nome|Preencha o nome do departamento', document.getElementById('acaoForm').value)"> <input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</form>