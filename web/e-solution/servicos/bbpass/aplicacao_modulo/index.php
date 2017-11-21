<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/aplicacao/gerencia_aplicacao.php"); 

require_once("gerencia_aplicacao.php");

$Tipo 		  = $_GET['modelo']=="aplicacao"?1:2;//Tipo 1 = aplicacao // Tipo 2 = módulo

$tituloPagina = $Tipo==1? "Atribuição de módulos na aplicação: ":"Atribuição de aplicações no módulo :";

/*===============================INICIO AUDITORIA POLICY=========================================*/
if($Tipo==1){
	$aplicacao 	  = new Aplicacao();//instância do módulo
	$aplicacao->dadosAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_apl_codigo']);	
	/*===============================AUDITORIA POLICY=========================================*/
	$Evento="Acessou a página que vincula módulos à aplicação " . $aplicacao->bbp_adm_apl_apelido;
}else{
	$modulo 	  = new Modulo();//instância do módulo
	$modulo->dadosModulo($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']);	
	/*===============================AUDITORIA POLICY=========================================*/
	$Evento="Acessou a página que vincula aplicações ao módulo ".$modulo->bbp_adm_loc_nome.".";
}
$_SESSION['relevancia']="5";
$_SESSION['nivel']="1.4";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
$nmAplModulo  = $Tipo==1?$aplicacao->bbp_adm_apl_apelido : $modulo->bbp_adm_loc_nome;
?>
<?php require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/cad_apl.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong><?php echo $tituloPagina . " <span style='color:#690'>" . $nmAplModulo."</span>"; ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
          <tr>
            <td height="10" colspan="2" class="legendaLabel11"></td>
          </tr>
          <tr>
            <td width="382" height="25" valign="top" class="legendaLabel11">
				<?php   //INFORMAÇÕES ADICIONADAS
					if($Tipo==1){//Aplicacao
						$adicionadas = 1;
						$disponiveis = 0;
						$titulo 	 = "Módulo adicionados";
						include("modulo.php");
					} else {
						$adicionadas = 1;
						$disponiveis = 0;
						$titulo = "Aplicações adicionadas";
						include("aplicacao.php");
					}
				?>
            </td>
            <td width="382" valign="top" class="legendaLabel11">
				<?php  //INFORMAÇÕES DISPONÍVEIS
					if($Tipo==1){//Aplicacao
						$adicionadas = 0;
						$disponiveis = 1;
						$titulo 	 = "Módulo disponíveis";
						include("modulo.php");	
					} else {
						$adicionadas = 0;
						$disponiveis = 1;
						$titulo = "Aplicações disponíveis";
						include("aplicacao.php");
					}
				?>
            </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
