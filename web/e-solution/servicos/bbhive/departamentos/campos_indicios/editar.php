<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1'; //Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/departamentos/campos_indicios/editar.php';
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','cadatraDep','Cadastrando dados...','cadastraModelo','1','".$TpMens."');";
	
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "cadastraDet")) {
	//--Recupera tudo do POST
	$error = 1;
	//--Dados da tabela de campos deste tipo 
		foreach($_POST as $i=>$v){
			if(substr($i,0,8) == "cam_det_"){
				$error--;
			}
		}
	if($error > 0){
		echo '<span style="color:#F00">Selecione no mínimo um campo para exibição!</span>';
		exit;
	}
	//--
	
	//--Dados para tabela Tipo Indicio
	$nvId 				= $_POST['codigo'];
	$bbh_tip_nome 		= apostrofo(($_POST['bbh_tip_nome']));
	$bbh_dep_codigo		= $_SESSION['idDepto'];
	$bbh_tip_descricao 	= apostrofo(($_POST['bbh_tip_descricao']));
	$bbh_tip_ativo 		= $_POST['bbh_tip_ativo'];
	$bbh_tipo_corp 		= $_POST['bbh_tipo_corp'];
	//--
	$updateTp = "UPDATE bbh_tipo_indicio SET bbh_tip_nome='$bbh_tip_nome', bbh_tip_descricao='$bbh_tip_descricao', bbh_tip_ativo='$bbh_tip_ativo', bbh_tipo_corp='$bbh_tipo_corp' WHERE bbh_tip_codigo=$nvId";
    list($rs, $rows, $totalRows_dep) = executeQuery($bbhive, $database_bbhive, $updateTp, $initResult = false);

	//--Remove todos os campos adicionados
    $deleteSQL = "DELETE FROM bbh_campo_tipo_indicio WHERE bbh_tip_codigo=$nvId";
    list($Result1, $rows, $totalRows_dep) = executeQuery($bbhive, $database_bbhive, $deleteSQL, $initResult = false);

		foreach($_POST as $i=>$v){
			if(substr($i,0,8) == "cam_det_"){
				//--
				$ordem = $_POST['ordem_'.$v];
				$error--;
				//--
				mysqli_select_db($bbhive, $database_bbhive);
				$insertSQL = "REPLACE INTO bbh_campo_tipo_indicio (bbh_tip_codigo, bbh_cam_ind_codigo,bbh_ordem_exibicao) VALUES ('$nvId', '$v', '$ordem')\n";
				$Result1 = mysqli_query($bbhive, $insertSQL) or die(mysqli_error($bbhive));
				//--
			}
		}
	//--
	echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_indicios/regra.php','menuEsquerda|conteudoGeral');</var>";
	exit;
}

	$bbh_dep_codigo = $_SESSION['idDepto'];
	$query_departamentos = "SELECT d.* FROM bbh_departamento d Where d.bbh_dep_codigo=$bbh_dep_codigo";
    list($departamentos, $row_departamentos, $totalRows_departamentos) = executeQuery($bbhive, $database_bbhive, $query_departamentos);
	
	//--
	$query_campos_detalhamento = "SELECT * FROM bbh_campo_indicio ORDER BY bbh_cam_ind_ordem";
    list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);
	//--
	
	$query_Tipo = "SELECT * FROM bbh_tipo_indicio where bbh_tip_codigo = ".$_GET['bbh_tip_codigo'];
    list($Tipo, $row_Tipo, $totalRows_Tipo) = executeQuery($bbhive, $database_bbhive, $query_Tipo);
	//--

	$query_Selecionados = "SELECT * FROM bbh_campo_tipo_indicio where bbh_tip_codigo = ".$_GET['bbh_tip_codigo'];
    list($Selecionados, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Selecionados, $initResult = false);
	$adicionado = array();
	//--
	while($row_Selecionados = mysqli_fetch_assoc($Selecionados)){
		$adicionado[trim($row_Selecionados['bbh_cam_ind_codigo'])] = trim($row_Selecionados['bbh_ordem_exibicao']);
	}
?>
<var style="display:none">txtSimples('tagPerfil', 'Depend&ecirc;ncia da atividade')</var>
<form name="cadatraDep" id="cadatraDep" style="margin-top:-1px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" colspan="4" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> <strong>Gerenciamento campos deste departamento</strong></td>
    <td width="5%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_indicios/regra.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="5">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" />&nbsp;<strong><?php echo $row_departamentos['bbh_dep_nome']; ?></strong></td>
  </tr>
  <tr>
    <td height="8" colspan="5"></td>
  </tr>
  <tr>
    <td height="25" colspan="5"></td>
  </tr>
  <tr>
    <td width="22%" height="25" align="right" bgcolor="#F5F5F5"><strong>T&iacute;tulo do tipo :&nbsp;</strong></td>
    <td height="25" colspan="4" bgcolor="#F5F5F5"><input class="back_Campos" name="bbh_tip_nome" type="text" id="bbh_tip_nome" size="60" maxlength="255" value="<?php echo $row_Tipo['bbh_tip_nome']; ?>"></td>
  </tr>
  
  <tr>
    <td height="25" align="right"><strong>P&uacute;blico :&nbsp;</strong></td>
    <td width="36%" height="25"><label for="bbh_tip_ativo"></label>
      <select name="bbh_tip_ativo" id="bbh_tip_ativo" class="verdana_11">
        <option value="1" <?php echo $row_Tipo['bbh_tip_ativo']=="1"?" selected":""; ?>>Sim</option>
        <option value="0" <?php echo $row_Tipo['bbh_tip_ativo']=="0"?" selected":""; ?>>N&atilde;o</option>
    </select></td>
    <td width="21%" align="right"><strong>Corporativo :&nbsp;</strong></td>
    <td width="38%"><select name="bbh_tipo_corp" id="bbh_tipo_corp" class="verdana_11">
      <option value="1" <?php echo $row_Tipo['bbh_tipo_corp']=="1"?" selected":""; ?>>Sim</option>
      <option value="0" <?php echo $row_Tipo['bbh_tipo_corp']=="0"?" selected":""; ?>>N&atilde;o</option>
    </select></td>
    <td height="25">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="25" align="right" bgcolor="#F5F5F5"><strong>Descri&ccedil;&atilde;o do tipo :&nbsp;</strong></td>
    <td height="25" colspan="4" bgcolor="#F5F5F5"><textarea class="formulario2" name="bbh_tip_descricao" id="bbh_tip_descricao" cols="80" rows="2"><?php echo $row_Tipo['bbh_tip_descricao']; ?></textarea></td>
  </tr>
</table>

<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;</strong>Selecione os campos necess&aacute;rios exibi&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="20" valign="top" align="right" id="cadastraModelo">&nbsp;</td>
          </tr>
          <tr>
            <td width="590" height="60" valign="top">
            <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"class="legandaLabel11" style="margin-top:2px;">
         <?php 
		 $j=0;
		 while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)) { $j++;
		 	$idcampo = $row_campos_detalhamento['bbh_cam_ind_codigo'];
			$nome	 = $row_campos_detalhamento['bbh_cam_ind_titulo'];
			//--
			$ck = array_key_exists($idcampo, $adicionado) ? "checked" : "";
			$od = array_key_exists($idcampo, $adicionado) ? $adicionado[$idcampo] : "";
			//--
			$s = 0;
		 ?>
              <tr>
                <td width="100%" height="20" colspan="3" valign="top" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;
                    <label>
                    <input type="checkbox" name="cam_det_<?php echo $idcampo; ?>" id="cam_det_<?php echo $idcampo; ?>" value="<?php echo $idcampo; ?>" <?php echo $ck;?> />
                    </label>
                    <select name="ordem_<?php echo $idcampo; ?>" id="ordem_<?php echo $idcampo; ?>" class="verdana_11">
                    	<?php for($a=1; $a<=$totalRows_campos_detalhamento; $a++){ ?>
                        	<option value="<?php echo $a; ?>" <?php 
							if($od == $a){
								echo "selected";
								$s = 1;
							} elseif($j == $a && $s == 0){
								echo "selected";
							}?>><?php echo $a<10?"0".$a:$a; ?></option>
                        <?php } ?>
                    </select>
                    
                  <?php echo $nome; ?></td>
              </tr>
              <tr>
                <td height="5" colspan="3" valign="middle"></td>
              </tr>
		<?php } ?>
            </table>
            <div align="center">
            	<?php echo $totalRows_campos_detalhamento==0 ? "Não há registros." : "";?>
            </div>
            </td>
          </tr>
          
          <tr>
            <td height="5"></td>
          </tr>
          <tr>
            <td height="24" class="legandaLabel11"><div style="float:right;">
                <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|departamentos/campos_indicios/regra.php','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
                                               <input name="insereModelo" type="button" class="back_input" id="insereModelo" value="Atualizar informa&ccedil;&otilde;es" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onClick="return validaForm('cadatraDep', 'bbh_tip_nome|Preencha o título do tipo', document.getElementById('acaoForm').value);"/>
                                               &nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5"></td>
          </tr>
        </table></td>
      </tr>
    </table>
	<input type="hidden" name="MM_update" value="cadastraDet" />
     <input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
  <input type="hidden" name="codigo" id="codigo" value="<?php echo $_GET['bbh_tip_codigo']; ?>" />
</form>