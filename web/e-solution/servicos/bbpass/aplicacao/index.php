<?php
if(!isset($_SESSION)){session_start();}

include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 

//Inicia sessão caso não esteja criada
include("gerencia_aplicacao.php");

/*============================PAGINAÇÃO + SELECT===================================*/
$page 		= "1";
$nElements 	= "100";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbpass/aplicacao/index.php?1=1';

//busca registros
$compPaginacao 			= " LIMIT $Inicio,$nElements";
$aplicacao 				= new Aplicacao();
						  $aplicacao->consultaAplicacao($database_bbpass, $bbpass, $compPaginacao);
$row_aplicacao   		= $aplicacao->row_Apl;
$totalRows_aplicacao 	= $aplicacao->totalRows_Apl;

$pages 			= ceil($aplicacao->totalAplicacao($database_bbpass, $bbpass)/$nElements);
/*============================PAGINAÇÃO==========================================*/
?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Gerenciamento de aplica&ccedil;&otilde;es</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>&nbsp;Aplica&ccedil;&atilde;o</strong></td>
            <td width="277" class="fundoTitulo legendaLabel12"><strong>Descri&ccedil;&atilde;o da aplica&ccedil;&atilde;o</strong></td>
            <td width="149" class="fundoTitulo  legendaLabel12"><strong>Aplica&ccedil;&atilde;o ativa</strong></td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11"><a href="#" rev="/e-solution/servicos/bbpass/aplicacao/novo.php" onclick="enviaURL(this);" title="Clique para cadastrar uma aplicação"><img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Nova</a></td>
          </tr>
          <tr>
            <td height="5" colspan="7"></td>
          </tr>
  <?php if($totalRows_aplicacao>0){ 
  		 do {
  			?>       
          <tr>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<img src="/e-solution/servicos/bbpass/images/lista.gif" width="16" height="16" border="0" align="absbottom">&nbsp;<?php echo $apl =  $row_aplicacao['bbp_adm_apl_apelido']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<?php echo $obs = $row_aplicacao['bbp_adm_apl_observacao']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" align="center" class="legendaLabel11"><?php 
				if($row_aplicacao['bbp_adm_apl_ativo']){
					echo "Sim";	
				}else{
					echo "<strong>N&atilde;o</strong>";
				}
			 ?></td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="#" rev="/e-solution/servicos/bbpass/aplicacao_modulo/index.php?bbp_adm_apl_codigo=<?php echo $row_aplicacao['bbp_adm_apl_codigo']; ?>&modelo=aplicacao" onclick="enviaURL(this);" title="Clique para associar esta aplicação a um módulo">
                	<img src="/e-solution/servicos/bbpass/images/cad_apl.gif" width="16" height="16" border="0" align="absmiddle">
                </a>
            </td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="<?php echo $row_aplicacao['bbp_adm_apl_url']; ?>?abandona=sim" target="_blank" title="acessar aplicação">
                	<img src="/e-solution/servicos/bbpass/images/url.gif" width="16" height="16" border="0" align="absmiddle">
                </a>
            </td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="#" rev="/e-solution/servicos/bbpass/aplicacao/edita.php?bbp_adm_apl_codigo=<?php echo $row_aplicacao['bbp_adm_apl_codigo']; ?>" onclick="enviaURL(this);" title="Editar aplicação">
                	<img src="/e-solution/servicos/bbpass/images/btn_editar.gif" width="15" height="16" border="0" align="absmiddle">
                </a>
            </td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="#" rev="/e-solution/servicos/bbpass/aplicacao/excluir.php?bbp_adm_apl_codigo=<?php echo $row_aplicacao['bbp_adm_apl_codigo']; ?>" onclick="enviaURL(this);" title="Excluir aplicação" >
                	<img src="/e-solution/servicos/bbpass/images/btn_excluir.gif" width="14" height="16" border="0" align="absmiddle">
                </a>
            </td>
          </tr>
     <?php } while($row_aplicacao = mysqli_fetch_assoc($aplicacao->myApl));
	 	  } else { ?>     
          <tr>
            <td height="25" colspan="7" align="center" class="legendaLabel11">N&atilde;o &aacute; registros cadastrados</td>
          </tr>
     <?php } ?>
          <tr>
            <td height="25" colspan="7" class="legendaLabel11"><?php include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/paginacao/paginacao.php");?></td>
          </tr>     
      </table>
    </td>
  </tr>
</table>
<?php 
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de gerenciamento de aplicações.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>