<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include("gerencia_aplicacao.php");

$aplicacao 				= new Aplicacao($database_bbpass, $bbpass);
$row_aplicacao   		= $aplicacao->row_Apl;
$totalRows_aplicacao 	= $aplicacao->totalRows_Apl;

//UTILIZAÇÃO DO OPEN AJAX CMD
	$pagina 	= "/servicos/bbpass/credencial/transfere/transfere.php";
	$camada 	= "enviaAplicacao";
	$values 	= "?id=xxx&ts=".time();
	$msg		= "Aguarde processando...";
	$divcarga	= "enviaAplicacao";
	$metodo 	= "2";
	$tpmsg		= "2";

	$acaoClick	=  "OpenAjaxPostCmd('$pagina','$camada','$values','$msg','$divcarga','$metodo','$tpmsg')";	
	$dirPadraoAut= "includes/bbpass/login.php";
?><table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="fonteDestaque">
  <tr>
    <td width="321" height="25" align="left" bgcolor="#FFFBF4" class="legendaLabel14" style="border-bottom:1px solid #FFECC7; border-top:1px solid #FFECC7; font-weight:bold">Aplica&ccedil;&otilde;es dispon&iacute;veis</td>
    <td width="259" align="left" bgcolor="#FFFBF4" class="legendaLabel14" style="border-bottom:1px solid #FFECC7; border-top:1px solid #FFECC7; font-weight:bold"><label id="enviaAplicacao"></label><label id="enviaLog" class="legendaLabel12"></label>&nbsp;</td>
  </tr>
  <tr>
    <td height="80" colspan="2" valign="top" bgcolor="#FFFFFF"><br />
    <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" class="legendaLabel12">
      <tr>
        <td height="1" width="92" align="center"></td>
        <td height="1" width="92" align="center"></td>
        <td height="1" width="92" align="center"></td>
        <td height="1" width="92" align="center"></td>
        <td height="1" width="92" align="center"></td>
        <td height="1" width="92" align="center"></td>
      </tr>
      <?php  $total=0;
	    if($totalRows_aplicacao>0){ ?>
      <tr>
       <?php $cont=0;
	         do { 
			  //só exibe ícone se todos os locks desta aplicação estiver na sessão,
			  //ou seja, autenticado
			  if($aplicacao->verificaLockAplicacao($database_bbpass, $bbpass, $row_aplicacao['bbp_adm_apl_codigo'])==0){
			 	$codApl = $row_aplicacao['bbp_adm_apl_codigo'];
				
	   			if($cont==6){
					$cont=0;
					echo "</tr>
						  <tr>
							<td height='20' colspan='6'></td>
						  </tr>
					      <tr>";
				}
	   		?>
      		<td align="center" valign="top">
            	<input name="envia" type="image" src="/datafiles/servicos/bbpass/images/sistema/logo/<?php echo $row_aplicacao['bbp_adm_apl_icone']; ?>"  title="<?php echo $row_aplicacao['bbp_adm_apl_nome']; ?>" onclick="<?php echo str_replace("xxx",$codApl,$acaoClick); ?>;populaFormAutenticacao('<?php echo $row_aplicacao['bbp_adm_apl_url'].$dirPadraoAut; ?>');"/>
				<br />
                    <?php echo $row_aplicacao['bbp_adm_apl_apelido']; ?>
            </td>
       <?php $cont++;$total++;
			 }
	   		} while($row_aplicacao = mysqli_fetch_assoc($aplicacao->myApl)); ?>
      </tr> 
      <?php } if($total==0) { ?>
      <tr>
        <td height="1" colspan="6" align="center" class="verdana_11">N&atilde;o h&aacute; aplica&ccedil;&otilde;es dispon&iacute;veis.</td>
        </tr>
      <?php } ?>
      <tr>
        <td height='20' colspan='6'></td>
      </tr>
    </table>
    </td>
  </tr>
</table>
<form name="envioAplAutenticada" id="envioAplAutenticada" method="get" action="" style="position:absolute" target="_blank">
	<input name="idCred" id="idCred" type="hidden" value="" />
</form>
<?php 
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página que exibe as aplicações disponíveis (Ambiente público).";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>