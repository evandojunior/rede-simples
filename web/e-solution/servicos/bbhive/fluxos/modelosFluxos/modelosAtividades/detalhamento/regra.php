<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/detalhamento/regra.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','cadatraDep','Cadastrando dados...','cadastraModelo','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraDet")) {

//apaga todas as dependencias que eu sou sucessora
	$bbh_mod_ati_codigo = $_POST['bbh_mod_ati_codigo'];
	
	$deleteSQL = "DELETE FROM bbh_campo_detalhamento_atividade WHERE bbh_mod_ati_codigo = $bbh_mod_ati_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);

	//recebe o dado responsável pela inserção das dependencias
	foreach($_POST as $i=>$v){
		//cam_det_
		$campo = substr($i,0,8);
			if($campo == "cam_det_"){
				$idCampo = $v;
				//--
				mysqli_select_db($bbhive, $database_bbhive);
				$insertSQL = "INSERT INTO bbh_campo_detalhamento_atividade (bbh_mod_ati_codigo, bbh_cam_det_flu_codigo) VALUES ($bbh_mod_ati_codigo, $idCampo)";
                list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
				//--
			}
	}

	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=".$_POST['bbh_mod_flu_codigo']."','menuEsquerda|conteudoGeral')</var>";
exit;
}


	if(isset($_GET['nv'])){
		$con=0;
		foreach($_GET as $indice=>$valor){
			$con=$con+1;
			if($con==2){ $bbh_mod_flu_codigo = $valor;}
			if($con==3){ $bbh_mod_ati_codigo = $valor;}
		}
	} else {
		$bbh_mod_ati_codigo = $_GET['bbh_mod_ati_codigo'];
		$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
	}

	$query_det = "select bbh_cam_det_flu_codigo, bbh_cam_det_flu_titulo, 
				  (select count(*) from bbh_campo_detalhamento_atividade 
					where bbh_mod_ati_codigo=".$_GET['bbh_mod_ati_codigo']." AND bbh_cam_det_flu_codigo = cdf.bbh_cam_det_flu_codigo) as jaTem
				   from bbh_campo_detalhamento_fluxo as cdf
				  inner join bbh_detalhamento_fluxo as df on cdf.bbh_det_flu_codigo = df.bbh_det_flu_codigo 
				   where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
    list($det, $rows, $totalRows_det) = executeQuery($bbhive, $database_bbhive, $query_det, $initResult = false);
?>
<var style="display:none">txtSimples('tagPerfil', 'Depend&ecirc;ncia da atividade')</var>
<table width="590" border="0" cellspacing="0" cellpadding="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento detalhamentos deste modelo de atividade</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="2"></td>
  </tr>
</table>
<?php require_once('../cabecaModelo.php'); ?>
<?php require_once('../alternativas/cabecaAtividade.php'); ?>
<br>
<form name="cadatraDep" id="cadatraDep" style="margin-top:-1px;">
<table width="595" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Selecione os campos necess&aacute;rios para esta atividade</strong></td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="20" valign="top" align="right" id="cadastraModelo">&nbsp;</td>
          </tr>
          <tr>
            <td width="590" height="60" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"class="legandaLabel11" style="margin-top:2px;">
         <?php while($row_det = mysqli_fetch_assoc($det)){?>
              <tr>
                <td width="100%" height="20" colspan="3" valign="top" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;
                    <label>
                    <input type="checkbox" name="cam_det_<?php echo $row_det["bbh_cam_det_flu_codigo"];?>" id="cam_det_<?php echo $row_det["bbh_cam_det_flu_codigo"];?>" value="<?php echo $row_det["bbh_cam_det_flu_codigo"];?>" <?php echo $row_det["jaTem"]>0 ? "checked":"";?> />
                    </label>
                  <?php echo $row_det["bbh_cam_det_flu_titulo"]; ?></td>
              </tr>
              <tr>
                <td height="5" colspan="3" valign="middle"></td>
              </tr>
		<?php } ?>
            </table>
            <div align="center"><?php if($totalRows_det==0) { echo "Não há campos de detalhamento."; } ?></div>
            </td>
          </tr>
          
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="24" class="legandaLabel11"><div style="float:right;">
                <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/index.php?bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                                               <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Salvar informa&ccedil;&otilde;es" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" <?php if($totalRows_det==0) { echo "disabled"; } ?> onClick="return verificaDep('cadatraDep', document.getElementById('acaoForm').value);"/>
                                               &nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
        </table></td>
      </tr>
    </table>
      <input type="hidden" name="MM_insert" value="cadastraDet" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
     <input type="hidden" name="bbh_mod_ati_codigo" id="bbh_mod_ati_codigo" value="<?php echo $_GET['bbh_mod_ati_codigo']; ?>" />
     <input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
     <input type="hidden" name="tratado" id="tratado" value="">
</form>