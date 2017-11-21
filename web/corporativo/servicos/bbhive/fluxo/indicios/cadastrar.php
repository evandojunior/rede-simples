<?php
require_once("../../../../../Connections/bbhive.php");
require_once("../../../../../../database/config/globalFunctions.php");

if(!isset($_SESSION)){ session_start(); } 
/*echo "POST";
print_r($_POST);
echo "GET";
print_r($_GET);
*/
if( $_GET['bbh_pro_codigo'] == '0') exit;
$_SESSION['idProtocolo'] = $_GET['bbh_pro_codigo'];//$bbh_pro_codigo;
//----CADASTRO DE INDÍCIOS-----------------------------------------------
if(isset($_POST['insertIndicios'])){
	require_once("detalhamento/grava_dados.php");
	echo "<var style='display:none'>LoadSimultaneo('protocolos/cadastro/passo2.php?confirmaCadastroIndicios=true','conteudoGeral');</var>";
	exit;
}
//----------------------------------------------------------------------
//--EXCLUSÃO DE INDÍCIOS------------------------------------------------
if(isset($_POST['remIndicio'])){
	//--
	$deleteSQL = "delete from bbh_indicio where bbh_ind_codigo=".$_POST['bbh_ind_codigo'];

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);;
	//--
	echo "<var style='display:none'>LoadSimultaneo('protocolos/cadastro/passo2.php?confirmaCadastroIndicios=true','conteudoGeral');</var>";
	exit;
}
//----------------------------------------------------------------------

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;bbh_dep_codigo")||($indice=="bbh_dep_codigo")){	$bbh_dep_codigo= $valor; } 
		if(($indice=="amp;bbh_tip_codigo")||($indice=="bbh_tip_codigo")){	$bbh_tip_codigo= $valor; } 
	}

	 $query_ind = "select d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome from bbh_indicio i
 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
 		where bbh_pro_codigo = ".$_SESSION['idProtocolo']."
    order by d.bbh_dep_codigo, t.bbh_tip_codigo asc";
    list($ind, $rows, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind, $initResult = false);
	
	//descobre o departamento do protocolo, e faz com que os indícios sejam distribuídos apenas para o mesmo
	 $query_dpto = "select bbh_departamento.bbh_dep_codigo, bbh_dep_nome from bbh_protocolos inner join bbh_departamento
						on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
							where bbh_pro_codigo=".$_SESSION['idProtocolo'];
    list($dpto, $row_dpto, $totalRows_dpto) = executeQuery($bbhive, $database_bbhive, $query_dpto);
	
	//--
	$query_tipo = "select * from bbh_tipo_indicio where bbh_dep_codigo=".$row_dpto['bbh_dep_codigo']." and bbh_tipo_corp='1' order by 2 ASC";
    list($tipo, $rows, $totalRows_tipo) = executeQuery($bbhive, $database_bbhive, $query_tipo, $initResult = false);
	//--
	
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '1';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/servicos/bbhive/protocolos/indicios/formulario.php';


	$adicional = "";
	if( isset($_GET['tarefas'] ) ) $adicional = "tarefas=true&bbh_ati_codigo=".$_GET['bbh_ati_codigo']."&";
	$acao = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/detalhamento/grava_dados.php?".$adicional."','loadMsg','solicitacao','Aguarde carregando dados...','loadMsg','1','".$TpMens."');";
	
	$remove = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/cadastrar.php','loadMsg','removeRegistro','Aguarde carregando dados...','loadMsg','1','".$TpMens."');";
	
	
	$adicional = "";
	if( isset($_GET['tarefas'] ) ) $adicional = "tarefas=true&bbh_ati_codigo=".$_GET['bbh_ati_codigo']."&";
	$formulario = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/formulario.php?".$adicional."','carregaDuplicado','solicitacao','Aguarde carregando dados...','carregaDuplicado','1','".$TpMens."');";
	
	
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Acessou a página de cadastro de (".$_SESSION['componentesNome'].") do (".$_SESSION['protNome'].") número (".$_SESSION['idProtocolo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
?><form id="solicitacao" name="solicitacao"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-bottom:15px;">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" align="absmiddle" />&nbsp;<strong>Cadastro de <?php echo $_SESSION['componentesNome']; ?></strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td height="1" bgcolor="#EDEDED"></td>
      </tr>
      <tr>
        <td height="25" align="left" class="legandaLabel11"><strong>Departamento:</strong> <strong style="font-size:12px">
          <?php echo "&nbsp;" . $row_dpto['bbh_dep_nome']; ?>
          <input name="bbh_dep_codigo" type="hidden" id="bbh_dep_codigo" value="<?php echo $row_dpto['bbh_dep_codigo']; ?>" readonly="readonly" />
        </strong></td>
      </tr>
      <?php if($totalRows_tipo>0){?>
      <tr>
        <td height="20" align="left" bgcolor="#F5F5F5" class="legandaLabel11"><strong>Tipo de :</strong>
          <select name="codigo" id="codigo" class="verdana_11" style="width:400px;" onchange="if(this.value>0){<?php echo $formulario; ?>}">
            <option value="-1">----------------------------Selecione----------------------------</option>
            <?php while($row_tipo = mysqli_fetch_assoc($tipo)){
	$cd = $row_tipo['bbh_tip_codigo'];
	?>
            <option value="<?php echo $cd; ?>"><?php echo $row_tipo['bbh_tip_nome']; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td height="20" align="left" id="carregaDuplicado" class="legandaLabel11"><strong><?php echo $_SESSION['componentesNome']; ?></strong></td>
      </tr>
      <?php } else { ?>
      <tr>
        <td height="20" align="center" class="aviso">N&Atilde;O &Eacute; POSS&Iacute;VEL INSERIR IND&Iacute;CIOS PARA ESTE DEPARTAMENTO, CONTATE O ADMINISTRADOR DO SISTEMA.</td>
      </tr>
      <tr>
        <td height="20" align="right">
        <?PHP
		$adicional = "";
		if( isset($_GET['tarefas'] ) ) $adicional = "tarefas=true&bbh_ati_codigo=".$_GET['bbh_ati_codigo']."&";
		?>
        <input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/05_.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar2" value="&nbsp;Prosseguir" onclick="LoadSimultaneo('protocolos/cadastro/passo2.php?<?PHP echo $adicional; ?>naoCadastroIndicios=true','conteudoGeral');"/></td>
      </tr>
      <?php } ?>
      <?php if($totalRows_tipo>0){?>
      <tr>
        <td height="25" align="right">
        <div style="float:right">
          <input type="hidden" name="insertIndicios" id="insertIndicios" value="true" />
          <input name="cadastrar2" style="background:url(/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:2px;height:23px;width:120px;margin-right:1px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp; Cadastrar item" onclick="if(document.getElementById('codigo').value>0){ <?php echo $acao; ?>; } else { alert('Selecione o tipo!'); }" /></div>
         <div style="float:right" id="loadMsg" class="verdana_11">&nbsp;</div>
          </td>
      </tr>
      <?php } ?>
    </table></td>
  </tr>
</table></form>
<br />
<form id="removeRegistro" name="removeRegistro">
	<input name="bbh_ind_codigo" id="bbh_ind_codigo" type="hidden" value="0" readonly="readonly" />
  <input name="remIndicio" id="remIndicio" type="hidden" value="1" readonly="readonly" />
</form>