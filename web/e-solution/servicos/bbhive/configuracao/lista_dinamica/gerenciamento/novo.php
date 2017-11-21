<?php
if(!isset($_SESSION)){session_start();}  

require_once("../../../includes/autentica.php");
require_once("../../../includes/functions.php");
require_once("../../../fluxos/modelosFluxos/detalhamento/includes/functions.php");

	$idMensagemFinal= 'carregaTipo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestinoII	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/novo.php';
	$homeDestino	= $homeDestinoII;
	
	$onClick ="OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao ="OpenAjaxPostCmd('".$homeDestinoII."','loadInser','cadatraModelo','Alterando dados...','loadInser','1','".$TpMens."');";
	//
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  		//recuperando as variáveis:
		$titulo	= ($_POST['bbh_cam_list_titulo']);
		$tipo	= $_POST['bbh_cam_list_tipo'];
		$valor	= ($_POST['bbh_cam_list_valor']);
		$mascara = preg_replace('|[^0-9.]|','',$_POST['mascara']);
		//--
		$query_campo_existente = sprintf("SELECT * FROM bbh_campo_lista_dinamica 
											WHERE bbh_cam_list_titulo = %s 
											  AND bbh_cam_list_tipo = %s
											   AND bbh_cam_list_valor = %s
											   AND bbh_cam_list_mascara = %s ", 
										GetSQLValueString($bbhive, $titulo, "text"),
										GetSQLValueString($bbhive, $tipo, "text"),
										GetSQLValueString($bbhive, $valor, "text"),
										GetSQLValueString($bbhive, $mascara, "text"));
        list($campo_existente, $row_campo_existente, $totalRows_campo_existente) = executeQuery($bbhive, $database_bbhive, $query_campo_existente);
		
	if($totalRows_campo_existente > 0){
	  		 echo $Erro ="<span class='aviso' style='font-size:11;margin-left:20px;'>J&aacute; existe uma opção com este valor.</span>";
		exit;
	}else{
	  $titulo = ($_POST['bbh_cam_list_titulo']);
	 $insertSQL = sprintf("INSERT INTO bbh_campo_lista_dinamica 
							(bbh_cam_list_titulo, bbh_cam_list_tipo, bbh_cam_list_valor, bbh_cam_list_ordem, bbh_cam_list_mascara) 
								VALUES (%s, %s, %s, %s, %s)",
						   GetSQLValueString($bbhive, $titulo, "text"),
						   GetSQLValueString($bbhive, $_POST['bbh_cam_list_tipo'], "text"),
						   GetSQLValueString($bbhive, ($_POST['bbh_cam_list_valor']), "text"),
						   GetSQLValueString($bbhive, ($_POST['bbh_cam_list_ordem']), "text"),
						   GetSQLValueString($bbhive, ($_POST['mascara']), "text"));

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	  $ultimoId= mysqli_insert_id($bbhive);
  
	$homeDestino = "/e-solution/servicos/bbhive/configuracao/lista_dinamica/gerenciamento/index.php";
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."?bbh_cam_list_titulo=".$titulo."','conteudoGeral','&1=1','Atualizando dados...','conteudoGeral','2','2');</var>";

	  exit;
	}
}
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','loadInser','form1','Cadastrando dados...','loadInser','1','".$TpMens."');";

	//--
	$identifique = (isset($_GET['mascara']) && $_GET['mascara'] != 'pai')?$_GET['mascara'].'.':"";


	// Comando abaixo deveria se protegido contra inject SQL =/
	$sqlOrdem = sprintf("SELECT max(bbh_cam_list_ordem) as ordem FROM bbh_campo_lista_dinamica where bbh_cam_list_titulo = '%s'", $_GET['nm']);
    list($exec, $row_lista, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlOrdem);

	
		$sql = "SELECT lista.bbh_cam_list_mascara
				FROM bbh_campo_lista_dinamica AS lista
				WHERE lista.bbh_cam_list_tipo = 'A' AND lista.bbh_cam_list_mascara LIKE '${identifique}__'
				ORDER BY RIGHT(lista.bbh_cam_list_mascara,2) DESC LIMIT 1";
        list($exec, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
		if($totalRows > 0){
			$fetch = mysqli_fetch_assoc($exec);
		}else{
			$fetch['bbh_cam_list_mascara'] = "";
		}
		
		$proximaMascara = explode('.', $fetch['bbh_cam_list_mascara']);
		$proximaMascara = (int)array_pop($proximaMascara);
		
		$mascara = $proximaMascara + 1;
		$mascara = ($mascara < 10)?'0'.$mascara:$mascara;
		$mascara = $identifique.$mascara;
		//exit($mascara);
		
		if(isset($_GET['mascara']) && $_GET['mascara']!='pai'){
			//Descobre quem é valor do pai
			$sql = "SELECT lista.bbh_cam_list_valor
					FROM bbh_campo_lista_dinamica AS lista
					WHERE lista.bbh_cam_list_tipo = 'A' AND lista.bbh_cam_list_mascara='".$_GET['mascara']."'";
            list($exec, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
			if($totalRows > 0){
				$fetch = mysqli_fetch_assoc($exec);
			}else{
				$fetch['bbh_cam_list_valor'] = "";
			}
		}
		
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" />Gerenciamento de op&ccedil;&otilde;es de lista din&acirc;mica</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $_GET['nm'];?>','menuEsquerda|colCentro');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
</table>
<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<form method="POST" action="" name="form1">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="0" class="borderAlljanela" style="margin-top:20px;">
  <tr class="legandaLabel11">
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11_bold">&nbsp;Nova op&ccedil;&atilde;o</td>
  </tr>
  <?php if(isset($_GET['mascara'])){?>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold"> Máscara :&nbsp;</td>
    <td align="left"><?php echo $mascara; ?></td>
  </tr>
  <?php } ?>
 <?php if(isset($_GET['mascara']) && $_GET['mascara']!='pai'){?>
  <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold"> Sub-máscara de  :&nbsp;</td>
    <td align="left"><?php echo $fetch['bbh_cam_list_valor']; ?></td>
  </tr>
 <?php } ?>
   <tr class="legandaLabel11">
    <td width="254" height="25" align="right" class="verdana_11_bold"> Valor :&nbsp;</td>
    <td align="left"><input name="bbh_cam_list_valor" type="text" class="back_Campos" id="bbh_cam_list_valor" size="60"></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">
      <input name="button" type="button" class="back_input" id="button" value="Cancelar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $_GET['nm'];?>','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
      
  <?php
//if( isset($tabelaCriada) && $tabelaCriada == 0){
//	$alerta = "return validaForm('form1', 'bbh_cam_list_valor|Valor obrigat&oacute;rio', document.getElementById('acaoForm').value)";
//}else{
	$alerta = "return validaForm('form1', 'bbh_cam_list_valor|Valor obrigat&oacute;rio', document.getElementById('acaoForm').value)";
//}
?>
      <input name="cadastra" type="button" class="back_input" id="cadastra" value="Cadastrar op&ccedil;&atilde;o" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="<?php echo $alerta; ?>"/>
       <input type="hidden" name="bbh_cam_list_titulo" id="bbh_cam_list_titulo" value="<?php echo $_GET['nm']; ?>" readonly/>
       <input type="hidden" name="bbh_cam_list_tipo" id="bbh_cam_list_tipo" value="<?php echo $_GET['tipo']; ?>" readonly/>
       <input type="hidden" name="bbh_cam_list_ordem" id="bbh_cam_list_ordem" value="<?php echo ((int)$row_lista['ordem']) + 1; ?>" readonly/>
      </td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="right" class="verdana_11_bold">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>

  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    <td width="640" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <tr class="legandaLabel11">
    <td height="22" align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="mascara" value="<?php echo $mascara; ?>" />
<input type="hidden" name="acaoForm" id="acaoForm" value="<?php echo $acao; ?>" />
<input type="hidden" name="cadastrado" id="cadastrado" value="<?php //echo $tabelaCriada; ?>" />

</form>
<?php
if( isset($detalhamento) )
mysqli_free_result($detalhamento);
?>
