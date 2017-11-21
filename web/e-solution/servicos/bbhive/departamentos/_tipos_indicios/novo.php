<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

if(isset($_POST['MM_insert'])){
	if(valida_repetido($database_bbhive, $bbhive, "bbh_tipo_indicio", "bbh_tip_nome='".apostrofo(mysqli_fetch_assoc($_POST['bbh_tip_nome']))."' AND bbh_dep_codigo=".$_POST['bbh_dep_codigo'])==0){
		
	$cp1 	= $_POST['cp1'];
	$cp2 	= $_POST['cp2'];
	$campos = $cp1."*|*".$cp2;
	
	  $insertSQL = sprintf("INSERT INTO bbh_tipo_indicio (bbh_tip_nome, bbh_dep_codigo, bbh_tip_descricao, bbh_tip_ativo, bbh_tip_campos) VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($bbhive, apostrofo(($_POST['bbh_tip_nome'])), "text"),
						   GetSQLValueString($bbhive, $_POST['bbh_dep_codigo'], "int"),
						   GetSQLValueString($bbhive, apostrofo(($_POST['bbh_tip_descricao'])), "text"),
						   GetSQLValueString($bbhive, isset($_POST['bbh_tip_ativo']) ? 1 : 0 , "text"),
						  GetSQLValueString($bbhive, $campos, "text"));
	  list($Result1, $rows, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $insertSQL, $initResult = false);
	  
		echo '<var style="display:none">LoadSimultaneo("perfil/index.php?perfil=1&menuEsquerda=1|departamentos/tipos_indicios/index.php","menuEsquerda|conteudoGeral")</var>';
		
	} else {
		echo '<span style="color:#F00">Já existe um registro com este título para este departamento!</span>';
	}
 exit;
}
	//select para descobrir o total de registros na base
	$query_dep = "select *
				  from bbh_departamento d
					 order by bbh_dep_nome asc";
    list($dep, $rows, $totalRows_dep) = executeQuery($bbhive, $database_bbhive, $query_dep, $initResult = false);
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/departamentos/tipos_indicios/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraTipo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="535" height="26" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/tipos_indicios.gif" width="16" height="16" border="0" align="absmiddle" />
      
      Cadastro de tipos de ind&iacute;cios</td>
    <td width="60" height="26" align="right" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/index.php','menuEsquerda|conteudoGeral');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="right"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/tipos_indicios/index.php','menuEsquerda|conteudoGeral');"></a>&nbsp;</td>
    <td height="25" align="center">&nbsp;</td>
  </tr>
</table><form method="POST" name="cadastraTipo" id="cadastraTipo">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#E1E1E1 solid 1px;margin-bottom:2px;" class="legandaLabel11">
              <tr>
                <td height="25" colspan="2" style="border-bottom:#E1E1E1 solid 1px;">
                  <table width="100%" style="background:#DFEFDF; border:#FFF solid 1px; height:100%;" class="legandaLabel11">
                    <tr>
                        <td align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/detalhesIndicios.gif" width="16" height="16" align="absbottom">&nbsp;<strong style="color:#339900">Novo</strong></td>
                    </tr>
                  </table>  
                </td>
              </tr>
              <tr>
                <td height="22" colspan="2" valign="middle" class="verdana_12" id="menLoad" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td height="22" align="right"><img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" /> Departamento :&nbsp;</td>
                <td height="22" align="left">
						<select name="bbh_dep_codigo" id="bbh_dep_codigo" class="verdana_9">
                         <?php while($row_dep = mysqli_fetch_assoc($dep)){?>
                            <option value="<?php echo $row_dep['bbh_dep_codigo']; ?>"><?php echo $row_dep['bbh_dep_nome']; ?></option>
                         <?php } ?>  
                        </select>
                </td>
              </tr>
              <tr>
                <td width="141" height="22" align="right" valign="middle">T&iacute;tulo do tipo :&nbsp;</td>
                <td width="452" align="left" valign="middle"><input class="back_Campos" name="bbh_tip_nome" type="text" id="bbh_tip_nome" size="45" maxlength="255"></td>
              </tr>
              <tr>
                <td height="22" align="right" valign="middle">T&iacute;tulo do campo1 :&nbsp;</td>
                <td align="left" valign="middle"><input name="cp1" type="text" class="back_Campos" id="cp1" value="" size="45" maxlength="255"></td>
              </tr>
              <tr>
                <td height="22" align="right" valign="middle">T&iacute;tulo do campo2 :&nbsp;</td>
                <td align="left" valign="middle"><input name="cp2" type="text" class="back_Campos" id="cp2" value="" size="45" maxlength="255"></td>
              </tr>
              <tr>
                <td width="141" height="22" align="right" valign="middle">&nbsp;</td>
                <td width="452" align="left" valign="middle"><input name="bbh_tip_ativo" type="checkbox" id="bbh_tip_ativo" checked>
                Publicado</td>
              </tr>
              <tr>
                <td height="60" align="right" valign="top">Descri&ccedil;&atilde;o do tipo :&nbsp;</td>
                <td height="60" align="left" valign="top"><textarea class="formulario2" name="bbh_tip_descricao" id="bbh_tip_descricao" cols="50" rows="3"></textarea></td>
  </tr>
              <tr>
                <td width="141" height="22" align="right" valign="middle">&nbsp;</td>
                <td width="452" align="right" valign="middle"><?php if($totalRows_dep>0){ ?><input type="button" name="button" id="button" value="Cadastrar" class="back_input" onclick="return validaForm('cadastraTipo', 'bbh_tip_nome|Preencha o título do indício', document.getElementById('acaoForm').value)"><?php } else { ?><span style="color:#F00">Cadastre um departamento antes de cadastrar um tipo de indício</span><?php } ?>
                &nbsp;</td>
              </tr>
              </table>
<input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" />
	<input type="hidden" name="MM_insert" value="cadastraTipo" />
</form>