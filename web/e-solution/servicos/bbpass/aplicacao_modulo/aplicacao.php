<?php
//dados dos módulos
require_once("gerencia_aplicacao.php");
	// echo $_SERVER['QUERY_STRING']; 
$modulos  = new AplicacaoModulo();

//=========ADICIONA MÓDULOS SOMENTE AO PROCESSAR A PRIMEIRA COLUNA=================================
	if(isset($_GET['addModulo'])){
		$modulos->bbp_adm_loc_codigo = $_GET['bbp_adm_loc_codigo'];
		$modulos->bbp_adm_apl_codigo = $_GET['bbp_adm_apl_codigo']; 
		$acao = $modulos->cadastraDados($database_bbpass, $bbpass);
		
		if($acao=1 ){
		    $order = " order by bbp_adm_lock_codigo ASC";
			$condicao = " Where bbp_adm_aplicacao.bbp_adm_apl_codigo = ".$modulos->bbp_adm_apl_codigo;
			$modulos->consultaAplicacoes($database_bbpass, $bbpass, $condicao, $order);
			$row_modulos= $modulos->row_Apl;
			
			//envia log confirmar com Robson
			$_SESSION['relevancia']="10";
			$_SESSION['nivel']="2.4.1";
			$Evento="Vínculou a aplicação ".$row_modulos['bbp_adm_apl_apelido']." ao módulo ".$modulo->bbp_adm_loc_nome;
			EnviaPolicy($Evento);
			unset($_GET['addModulo']);unset($condicao);
		 }
		//==========?==========
		
	}
	
	//=========EXCLUÍ MÓDULOS
	if(isset($_GET['exModulo']) && isset($_GET['bbp_adm_lock_codigo'])){
		$modulos->bbp_adm_lock_codigo = $_GET['bbp_adm_lock_codigo'];
		$modulos->excluiDados($database_bbpass, $bbpass);
		
		if($Result1=1){
		    $order = "order by bbp_adm_apl_nome ASC";
			$condicao = " Where bbp_adm_aplicacao.bbp_adm_apl_codigo = ".$_GET['bbp_adm_apl_codigo'];
			$modulos->consultaAplicacoes($database_bbpass, $bbpass, $condicao, $order);
			$row_modulos= $modulos->row_Apl;
			//envia log
			$_SESSION['relevancia']="5";
			$_SESSION['nivel']="2.4.3";
			$Evento="Excluiu a aplicação ".$row_modulos['bbp_adm_apl_apelido']." do módulo " . $modulo->bbp_adm_loc_nome;
			EnviaPolicy($Evento);
			unset($_GET['exModulo']);unset($condicao);
		}
		
	}
//=========ADICIONA MÓDULOS SOMENTE AO PROCESSAR A PRIMEIRA COLUNA=================================

/*===========================SELECT MÓDULOS==========================================*/
$condicao = " Where bbp_adm_loc_codigo = ".$_GET['bbp_adm_loc_codigo'];
$notIn	  = "";
$title	  = "Clique para remover esta aplicação";
$color	  = "#FF9966";
$lock_codigo	  = "bbp_adm_lock_codigo";
$order = " order by bbp_adm_lock_codigo ASC";

//disponíveis
if($adicionadas!=1){
	$notIn   = " Where bbp_adm_aplicacao.bbp_adm_apl_codigo not in (".$modulos->consultaCadastrados($database_bbpass, $bbpass, $condicao, "bbp_adm_apl_codigo").")";
	$condicao= "";
	$title	  = "Clique para adicionar esta aplicação";
	$color	  = "#FAFBFB";
	$lock_codigo	  = "";
	$order = " order by bbp_adm_apl_nome ASC";
}

//select 
$condicao			= $condicao . $notIn;
				      $modulos->consultaAplicacoes($database_bbpass, $bbpass, $condicao, $order);
$row_modulos   		= $modulos->row_Apl;
$totalRows_modulos 	= $modulos->totalRows_Apl;
/*===========================SELECT MÓDULOS==========================================*/
?><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#EEEEEE solid 1px;">
  <tr>
    <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>&nbsp;<?php echo $titulo; ?></strong></td>
    </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <?php if($totalRows_modulos>0) { ?>
  	<?php do { 
		$compl	= $lock_codigo!=""?"&exModulo=true&bbp_adm_lock_codigo=".$row_modulos[$lock_codigo]:"&addModulo=true";
	?>
  <tr onmouseover="javascript: this.style.backgroundColor='<?php echo $color; ?>';" onmouseout="javascript: this.style.backgroundColor='#FFF';" title="<?php echo $title; ?>">
    <td height="25" class="legendaLabel11"><a href="#" style="display:block" rev="/e-solution/servicos/bbpass/aplicacao_modulo/index.php?modelo=<?php echo $_GET['modelo']; ?>&bbp_adm_apl_codigo=<?php echo $row_modulos['bbp_adm_apl_codigo']; ?>&bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo'];  ?><?php echo $compl; ?>" onclick="enviaURL(this);" >&nbsp;<img src="/e-solution/servicos/bbpass/images/lista.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $row_modulos['bbp_adm_apl_apelido'];?></a></td>
    </tr>
     <?php } while($row_modulos = mysqli_fetch_assoc($modulos->myApl)); ?>
   <?php } else { ?> 
  <tr>
    <td height="25" class="legendaLabel11">N&atilde;o h&aacute; registros cadastrados</td>
  </tr>
   <?php } ?>
</table>
