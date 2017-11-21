<?php 


//if(!isset($codSta)){
	if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	include("includes/functions.php");
//}<a href="includes/functions.php">functions.php</a>

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	if(($indice=="amp;bbh_mod_flu_codigo")||($indice=="bbh_mod_flu_codigo")){ 	$bbh_mod_flu_codigo= $valor; } 
	if(($indice=="amp;cadastraDet")||($indice=="cadastraDet")){ 	$cadastraDet= $valor; } 
	if(($indice=="amp;edtDet")||($indice=="edtDet")){ 	$edtDet= $valor; } 
}

$idMensagemFinal= 'conteudoDetalhamento';
$infoGet_Post	= 'updateFluxoDet';//Se envio for POST, colocar nome do formulário
$Mensagem		= 'Carregando dados...';
$idResultado	= $idMensagemFinal;
$Metodo			= '1';//1-POST, 2-GET
$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
$homeDestino	= '/corporativo/servicos/bbhive/fluxo/detalhamento/edita.php?bbh_mod_flu_codigo=' . $bbh_mod_flu_codigo;
$homeDestinoII	= '/corporativo/servicos/bbhive/fluxo/detalhamento/regra.php';

$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";

$homeDestino2  = '/corporativo/servicos/bbhive/fluxo/detalhamento/lista.php?';

$infoGet_Post2 = 'bbh_mod_flu_codigo=' . $bbh_mod_flu_codigo . '&bbh_flu_codigo=' . $bbh_flu_codigo;
$Metodo2 	   = '2';
$onClick2 	   = "OpenAjaxPostCmd('".$homeDestino2."','".$idResultado."','".$infoGet_Post2."','".$Mensagem."','".$idMensagemFinal."','".$Metodo2."','".$TpMens."')";


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	//====Fazendo a atualização
    // Define formulário com cadastro através de um mode de fluxo
    $_POST['bbh_flu_codigo'] = $_POST['bbh_flu_codigo'] != 0 ? $_POST['bbh_flu_codigo'] : $bbh_flu_codigo;

    // Salva conteúdo de formulário dinâmico
    saveDynamicFormFromArray($bbhive, $database_bbhive, $_POST);

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1.1";
	$Evento="Atualizou o detalhamento (".$bbh_flu_codigo.") de ".$_SESSION['FluxoNome']."  - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/ 

//=====

 //CASO EU VENHA DIRETO DO CADASTRO DE FLUXO/APÓS OPERAÇÃO REDIRECIONA PARA PÁGINA INDEX DO FLUXO
 //if($_POST['MM_cadastroDetalhamento']){
	echo "<var style='display:none'>
		showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=".$bbh_flu_codigo."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
		</var>";
	exit;
 //}
 
 
$homeDestino = '/corporativo/servicos/bbhive/fluxo/detalhamento/lista.php?';
$infoGet_Post = '&bbh_flu_codigo=' . $bbh_flu_codigo . '&bbh_mod_flu_codigo=' . $bbh_mod_flu_codigo;
$Metodo = '2';
 echo "<var style='display:none'>document.getElementById('fluxo').innerHTML='<span class=\"verdana_12\">&nbsp;Carregando dados...</span>'</var>";//limpa o campo descrição
 echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')</var>"; 
 exit;

}

//Pegando o código do modelo do fluxo e o nome da tabela
$codigo_modelo_fluxo = $bbh_mod_flu_codigo;	
$bbh_flu_codigo = $bbh_flu_codigo;	
$nome_tabela = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";
	
//Dados do detalhamento
$query_detalhamento = "SELECT * FROM bbh_detalhamento_fluxo WHERE bbh_mod_flu_codigo = $codigo_modelo_fluxo";
list($detalhamento, $row_detalhamento, $totalRows_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_detalhamento);

if($row_detalhamento['bbh_det_flu_tabela_criada'] == 1 ){
		//Campos com preenchimento no início do processo
		$inicioProcesso= isset($cadastroInicio) ? " AND bbh_cam_det_flu_preencher_inicio='1'" : "";
		
		//RecordSet dos campos
		$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo  INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo  WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_cam_det_flu_disponivel='1' $inicioProcesso";
        list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);
		
		//Tabela física		
		$nome_tabela = "bbh_modelo_fluxo_". $codigo_modelo_fluxo ."_detalhado";
		$query_tabela_fisica = "SELECT * FROM $nome_tabela WHERE bbh_flu_codigo = " . $bbh_flu_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		
		//precisa verificar se é inicio de um fluxo, se for devo montar tudo com base nos campos e não na tabela
		if($bbh_flu_codigo==0){
			//é inicio e não edição então deve pegar dos campos
			$totalRows_tabela_fisica = 1;
		}
		
		?>
<?php if(isset($edtDet)){ ?>
	<form name="updateFluxoDet" id="updateFluxoDet">
<?php } ?>		
		<table width="100%" border="0" cellspacing="2" cellpadding="2">
		
<?php	
if($totalRows_tabela_fisica>0){
    	//RecordSet dos campos da tabela dinâmica
		while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
			
			//Atributos de uma tabela dinâmica
			$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_det_flu_tipo']; 
			$nomeFisico 	= $row_campos_detalhamento['bbh_cam_det_flu_nome'];
			$titulo 		= $row_campos_detalhamento['bbh_cam_det_flu_titulo'];
			$observacao 	= $row_campos_detalhamento['bbh_cam_det_flu_descricao'];
			
			
				if($bbh_flu_codigo==0){
					//é inicio e não edição então deve pegar dos campos
					$valorPadrao 	= $row_tabela_fisica['bbh_cam_det_flu_default']; 
				} else {
					$valorPadrao 	= $row_tabela_fisica[$nomeFisico]; 
				}
			
			$editListagem 	= $row_campos_detalhamento['bbh_cam_det_flu_default']; 
			$tamanho 		= $row_campos_detalhamento['bbh_cam_det_flu_tamanho']; 
			
			if($valorPadrao == "")
			{
				$campo_exibido = $editListagem;
			}else{
				$campo_exibido = $valorPadrao;
			}

			if ($tipoDeCampo == 'hidden') {
                include('includes/formDinamico.php');
			    continue;
            }


			?>
			
			
          <tr>
            <td width="38%" align="left" valign="middle" class="verdana_11_bold" style="padding-top:10px;"><?php echo $titulo; ?> :&nbsp;            
            <div style="margin-top:5px;margin-left:40px;font-family:Verdana, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;">
            <?php
				//Inclusão que isola o algoritmo que exibe cada tipo de campo
				include('includes/formDinamico.php'); 
				
			?>
            </div>            </td>
          </tr>
		
		
<?php		} 
}
?>

<?php if(isset($cadastraDet) && (getCurrentPage()!="/corporativo/servicos/bbhive/fluxo/regra3.php")){ ?>
          <tr>
            <td align="right" valign="middle" class="verdana_11_bold" style="padding-top:10px;"><span class="verdana_11_bold" style="padding-top:10px;">
              <input name="avancar" style="background:url(/corporativo/servicos/bbhive/images/erro.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:5px; cursor:pointer" type="button" class="back_input" id="cadastrar2" value="Avan&ccedil;ar sem cadastrar" onclick="javascript: if(confirm('Atenção: ao prosseguir sem cadastrar estas informações, as mesmas deverão ser cadastradas em momento posterior.\nClique em Ok e caso de confirmação.')){ showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita') }"/>
            </span>&nbsp;
<input name="cadastrar" style="background:url(/e-solution/servicos/bbhive/images/disk.gif);background-repeat:no-repeat;background-position:left;height:23px;width:180px;margin-right:5px; cursor:pointer" type="button" class="back_input" id="cadastrar" value="&nbsp;Cadastrar informa&ccedil;&otilde;es" onclick="return <?php echo $onClick; ?>"/></td>
          </tr>
<?php } elseif (getCurrentPage()!="/corporativo/servicos/bbhive/fluxo/regra3.php") { ?>
 <?php if($totalRows_tabela_fisica > 0) {?>
          <tr>
            <td align="right" valign="middle" class="verdana_11_bold" style="padding-top:10px;">
            <div style="float:right">
            <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');">
            <img src="/corporativo/servicos/bbhive/images/cancel.gif" width="78" height="21" border="0" />
            </a>
            &nbsp;
            <a href="#@" onclick="return <?php echo $onClick; ?>"><img src="/corporativo/servicos/bbhive/images/edit.gif" alt="" width="78" height="21" border="0" /></a>
            </div>
            <div style="float:right" id="conteudoDetalhamento" class="verdana_12">
            	&nbsp;
            </div>
                          </td>
          </tr>
  <?php } else { ?>
          <tr>
            <td align="center" valign="middle" class="verdana_11_bold" style="padding-top:10px;">
            Não há campos cadastrados para este <?php echo $_SESSION['FluxoNome']; ?>
             </td>
          </tr>
  <?php } ?>
<?php } ?>
</table>	
<?php
}else{ //Se não tiver tabela dinâmica criada.
	echo "<div class='verdana_11'>&nbsp;<img src='/corporativo/servicos/bbhive/images/alerta.gif' align='absmiddle' />&nbsp;N&atilde;o existem detalhamentos para este " . $_SESSION['FluxoNome'] ."<div>";
}

if(isset($cadastraDet)){ ?>
 <input type="hidden" name="MM_cadastroDetalhamento" value="form1" />
<?php } ?>

<?php if(isset($cadastroInicio) && $totalRows_campos_detalhamento >0){?>
	<input type="hidden" name="cadastroInicio" id="cadastroInicio" value="form1" />
<?php } ?>
<input type="hidden" name="nome_tabela" value="<?php echo $nome_tabela; ?>" />
<input type="hidden" name="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
<input type="hidden" name="bbh_mod_flu_codigo" value="<?php echo $codigo_modelo_fluxo; ?>" />
<input type="hidden" name="MM_update" value="form1" />

<?php if(isset($edtDet)){ ?>
	</form>
<?php } ?>	