<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/e-solution/servicos/bbhive/perfis/novo.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'cadastraPerfil';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "cadastraPerfil")) {

	$novonome = ($_POST['bbh_per_nome']);

	$query_validacao = "SELECT * FROM bbh_perfil WHERE bbh_per_nome = '$novonome'";
    list($validacao, $row_validacao, $totalRows_validacao) = executeQuery($bbhive, $database_bbhive, $query_validacao);

	if($totalRows_validacao==0){
	
	//mini bloco de validações
	$nomeperfil = "0";
	$obsperfil	= "0";
	$fluxperfil	= "0";
	$msgperfil	= "0";
	$arqperfil	= "0";
	$equiperfil	= "0";
	$tarperfil	= "0";
	$reltperfil	= "0";
	$protperfil	= "0";
	$bbh_per_matriz  = "-1";
	$bbh_per_unidade = "0";
	$bbh_per_corp= "0";
	$bbh_per_pub= "0";
		
	if(isset($_POST['bbh_per_nome'])){	
		$nomeperfil = ($_POST['bbh_per_nome']);
	}
	if(isset($_POST['bbh_per_observacao'])){	
		$obsperfil	= ($_POST['bbh_per_observacao']);
	}
	if(isset($_POST['bbh_per_fluxo'])){
		$fluxperfil	= ($_POST['bbh_per_fluxo']);
	}
	if(isset($_POST['bbh_per_mensagem'])){	
		$msgperfil	= ($_POST['bbh_per_mensagem']);
	}
	if(isset($_POST['bbh_per_arquivos'])){	
		$arqperfil	= ($_POST['bbh_per_arquivos']);
	}
	if(isset($_POST['bbh_per_equipe'])){	
		$equiperfil	= ($_POST['bbh_per_equipe']);
	}
	if(isset($_POST['bbh_per_tarefas'])){	
		$tarperfil	= ($_POST['bbh_per_tarefas']);
	}
	if(isset($_POST['bbh_per_relatorios'])){	
		$reltperfil	= ($_POST['bbh_per_relatorios']);
	}
	if(isset($_POST['bbh_per_protocolos'])){	
		$protperfil	= ($_POST['bbh_per_protocolos']);
	}
	if(isset($_POST['bbh_per_protocolos'])){	
		$protperfil	= ($_POST['bbh_per_protocolos']);
	}
	
	if(isset($_POST['bbh_per_corp'])){	
		$bbh_per_corp	= ($_POST['bbh_per_corp']);
	}
	
	if(isset($_POST['bbh_per_pub'])){	
		$bbh_per_pub	= ($_POST['bbh_per_pub']);
	}
	
	if(isset($_POST['bbh_per_unidade'])){	
		$bbh_per_unidade	= ($_POST['bbh_per_unidade']);
	}
	
	  $insertSQL = sprintf("INSERT INTO bbh_perfil (
	  bbh_per_nome, bbh_per_observacao, bbh_per_fluxo, bbh_per_mensagem, bbh_per_arquivos, bbh_per_equipe, bbh_per_tarefas, 
	  bbh_per_relatorios, bbh_per_protocolos, bbh_per_central_indicios, bbh_per_bi, bbh_per_geo, bbh_per_peoplerank, 
	  bbh_per_matriz, bbh_per_unidade, bbh_per_corp, bbh_per_pub
	  ) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($bbhive, $nomeperfil, "text"),
						   GetSQLValueString($bbhive, $obsperfil, "text"),
						   GetSQLValueString($bbhive, $fluxperfil, "text"),
						   GetSQLValueString($bbhive, $msgperfil, "text"),
						   GetSQLValueString($bbhive, $arqperfil, "text"),
						   GetSQLValueString($bbhive, $equiperfil, "text"),
						   GetSQLValueString($bbhive, $tarperfil, "text"),
						   GetSQLValueString($bbhive, $reltperfil, "text"),
						   GetSQLValueString($bbhive, $protperfil, "text"),
						   GetSQLValueString($bbhive, isset($_POST['bbh_per_central_indicios']) ? 1 : 0, "text"),
						   GetSQLValueString($bbhive, isset($_POST['bbh_per_bi']) ? 1 : 0, "text"),
						   GetSQLValueString($bbhive, isset($_POST['bbh_per_geo']) ? 1 : 0, "text"),
						   GetSQLValueString($bbhive, isset($_POST['bbh_per_peoplerank']) ? 1 : 0, "text"),
						   GetSQLValueString($bbhive, $bbh_per_matriz, "text"),
						   GetSQLValueString($bbhive, $bbh_per_unidade, "text"),
						   GetSQLValueString($bbhive, $bbh_per_corp, "text"),
						   GetSQLValueString($bbhive, $bbh_per_pub, "text")
						   );
	list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	
	  $insertGoTo = "index.php";
	  if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
	  }
	  
	  echo "<var style='display:none'>LoadSimultaneo('perfil/index.php?perfil=2&menuEsquerda=1|perfis/index.php','menuEsquerda|conteudoGeral')</var>";
	  exit;
	  //header(sprintf("Location: %s", $insertGoTo));
	} else {
		 $Erro ="<span class='aviso' style='font-size:11;'>J&aacute; existe um perfil com a denomina&ccedil;&atilde;o: ".$novonome."</span>";
		 		 
  		 echo "<var style='display:none'>txtSimples('erroDep', '".$Erro."')</var>";
		exit;
	}
}

//
// Lê as confirgurações
$xmlParse = simplexml_load_file( $_SESSION['caminhoFisico']."/../database/servicos/bbhive/nivel_informacao.xml" );
foreach( $xmlParse as $value ){ $values[ (int) $value['nivel'] ] = (string) $value['valor']; }
// Fim das configurações
//

?><form method="POST" name="cadastraPerfil" id="cadastraPerfil">
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_perfNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" width="14" height="14" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_perfNome']; ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Cria&ccedil;&atilde;o de perfil</td>
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
        <td width="82%">&nbsp;
          <input class="back_Campos" name="bbh_per_nome" type="text" id="bbh_per_nome" size="45" maxlength="255"></td>
      </tr>
      <tr>
        <td height="8" colspan="2" align="right" valign="top" class="color"></td>
        </tr>
      <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es : </td>
        <td><table class="verdana_9" style="margin-left:6px; border:#E1EDFF 1px solid;" width="450" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="10">&nbsp;</td>
            <td width="197"><input name="bbh_per_fluxo" type="checkbox" id="bbh_per_fluxo" value="1" />
              <img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" alt="" width="16" height="16" align="absmiddle" />&nbsp;<?php echo $_SESSION['adm_FluxoNome']; ?></td>
            <td width="169"><input name="bbh_per_tarefas" type="checkbox" id="bbh_per_tarefas" value="1" />
              <img src="/e-solution/servicos/bbhive/images/tarefa.gif" alt="" width="16" height="16" align="absmiddle" /> Tarefas</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="bbh_per_mensagem" type="checkbox" id="bbh_per_mensagem" value="1" />
              <img src="/e-solution/servicos/bbhive/images/ger-mensagens-16px.gif" alt="" width="16" height="16" align="absmiddle" />&nbsp;<?php echo $_SESSION['adm_MsgNome']; ?></td>
            <td><input name="bbh_per_relatorios" type="checkbox" id="bbh_per_relatorios" value="1" />
              <img src="/e-solution/servicos/bbhive/images/relatorio.gif" alt="" width="16" height="16" align="absmiddle" /> Relat&oacute;rios</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><input name="bbh_per_arquivos" type="checkbox" id="bbh_per_arquivos" value="1" />
              <img src="/e-solution/servicos/bbhive/images/arquivos16px.gif" alt="" width="16" height="16" align="absmiddle" /> GED</td>
            <td><input name="bbh_per_protocolos" type="checkbox" id="bbh_per_protocolos" value="1" />
              <img src="/e-solution/servicos/bbhive/images/ger-protocolos-16px.gif" alt="" width="16" height="16" align="absmiddle" /><?php echo $_SESSION['adm_protNome']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_equipe" type="checkbox" id="bbh_per_equipe" value="1" />
              <img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" alt="" width="16" height="16" align="absmiddle" /> Equipe</td>
            <td><input name="bbh_per_central_indicios" type="checkbox" id="bbh_per_central_indicios" value="1" />
            <img src="/e-solution/servicos/bbhive/images/central_indicios.gif" alt="" width="16" height="16" align="absmiddle" />
            Central de informa&ccedil;&otilde;es</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_corp" type="checkbox" id="bbh_per_corp" value="1" />
              <img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" alt="" width="16" height="16" align="absmiddle" /> Sem acesso corporativo</td>
            <td><input name="bbh_per_pub" type="checkbox" id="bbh_per_pub" value="1" />
              <img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" alt="" width="16" height="16" align="absmiddle" /> Sem acesso Publico</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_peoplerank" type="checkbox" id="bbh_per_peoplerank" value="1" />
              <img src="/e-solution/servicos/bbhive/images/peoplerank.gif" alt="" width="16" height="16" align="absmiddle" /> Peoplrank</td>
            <td><input name="bbh_per_bi" type="checkbox" id="bbh_per_bi" value="1" />
              <img src="/e-solution/servicos/bbhive/images/bi.gif" alt="" width="16" height="16" align="absmiddle" /> BI</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="22"><input name="bbh_per_geo" type="checkbox" id="bbh_per_geo" value="1" />
              <img src="/e-solution/servicos/bbhive/images/geoprocessamento.gif" alt="" width="16" height="16" align="absmiddle" /> GEO</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="8" colspan="2" align="right" valign="top" class="color"></td>
        </tr>
            <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es na Matriz&nbsp;:</td>
        <td>&nbsp;
        	<select name="bbh_per_matriz"  id="bbh_per_matriz" class="back_Campos" style="width:200px">
            <?PHP //
			reset( $values );
							
			//
			foreach( $values as $indice => $value )
			{
//				$select = ($indice==$row_perfil['bbh_per_matriz'])?' selected':'';
				echo sprintf( "<option value='%s'>%s</option>", $indice, $value);
			}
			?>
            </select>
        </td>
      </tr>
      <tr>
        <td align="right" valign="top" class="color">Permiss&otilde;es na Unidade&nbsp;:</td>
        <td>&nbsp;
        	<select name="bbh_per_unidade" id="bbh_per_unidade" class="back_Campos" style="width:200px">
			<?PHP //
			reset( $values );
							
			//
			foreach( $values as $indice => $value )
			{
//				$select = ($indice==$row_perfil['bbh_per_unidade'])?' selected':'';
				echo sprintf( "<option value='%s'>%s</option>", $indice, $value);
			}
			?>
            </select>
        </td>
      </tr>

      <tr>
        <td align="right" valign="top" class="color">Descri&ccedil;&atilde;o&nbsp;:</td>
        <td >&nbsp;<textarea class="formulario2" name="bbh_per_observacao" id="bbh_per_observacao" cols="44" rows="7"><?php if(isset($_POST['bbh_per_observacao'])){ echo $_POST['bbh_per_observacao']; }?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="35">&nbsp;<input type="button" name="button2" id="button2" value="Cancelar" class="button" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');" /> 
          <input type="button" name="button" id="button" value="Cadastrar" class="button" onClick="return validaForm('cadastraPerfil', 'bbh_per_nome|Preencha o nome do perfil', document.getElementById('acaoForm').value)"><input name="acaoForm" id="acaoForm" type="hidden" value="<?php echo $acao; ?>" /></td>
      </tr>
      
      <tr>
        <td colspan="2" id="menLoad">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
  <input type="hidden" name="MM_insert" value="cadastraPerfil" />
</form>