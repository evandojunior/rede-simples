<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//TROCA DE RESPONSÁVEL=====================================================================================
	if(isset($_POST['bbh_trocaResponsavel'])){
		$bbh_ind_codigo_barras	= $_POST['bbh_ind_codigo_barras'];
		$bbh_ind_responsavel	= $_SESSION['MM_User_email'];
		$bbh_ind_dt_recebimento	= date("Y-m-d H:i:s");
		
		if(strlen($bbh_ind_codigo_barras) > 0){
			$atingidas = 0;
			
			$sql 	= "select bbh_ind_codigo from bbh_indicio i
						 inner join bbh_protocolos p on i.bbh_pro_codigo = p.bbh_pro_codigo
						 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
						 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
						 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
						   Where bbh_ind_codigo_barras = '$bbh_ind_codigo_barras'";
			$query_ind = str_replace("CAMPOS", $campos, $sql);
            list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind);
				if($totalRows_ind>0){ ?>
				<script type="text/javascript">
					window.top.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1|central_indicios/indicio.php?bbh_ind_codigo=<?php echo $row_ind['bbh_ind_codigo']; ?>','menuEsquerda|conteudoGeral');
				</script>
				<?php exit; } else { ?>
				<script type="text/javascript">
					alert('O código de barras inválido!');
					window.top.showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|central_indicios/troca.php','menuEsquerda|colPrincipal');
				</script>	
				<?php exit; }
		} else {
		?>
			<script type="text/javascript">
                alert('O código de barras não pode ser vazio!');
				window.top.showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|central_indicios/troca.php','menuEsquerda|colPrincipal');
            </script>
        <?php
		exit;
		}
	}
//========================================================================================================

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Acessou a página de troca de responsabilidade do indício - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
?>
<link rel="stylesheet" type="text/css" href="../../includes/relatorio.css">
<script type="text/javascript" src="../../includes/functions.js"></script>
<script type="text/javascript">
	function validaForm(){
		var returnval;
		if(retiraEspacos(document.getElementById('bbh_ind_codigo_barras').value)==''){
			alert('Código de barras não pode ser vazio!');
			document.getElementById('bbh_ind_codigo_barras').focus();
			returnval = false;
		} else {
			returnval = true;
		}
      return returnval;
	}
</script> 
<form name="trocaResponsavel"  method="post" action="formTroca.php" onSubmit="return validaForm()">
<table width="550" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
  <tr>
    <td width="511" height="25" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/trocar.gif" width="18" height="18" border="0" align="absmiddle" style="margin-left:2px;"/>&nbsp;<strong>Trocar responsabilidade do ind&iacute;cio</strong></td>
  </tr>
  <tr>
    <td height="22" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><strong>Digite o c&oacute;digo de barras</strong> :&nbsp;<input name="bbh_ind_codigo_barras" type="text" class="back_Campos" id="bbh_ind_codigo_barras"  style="height:17px;border:#E3D6A4 solid 1px;" size="40"/>
    
    <input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/busca_indicios.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="submit" class="back_input" id="cadastrar2" value="&nbsp;Pesquisar"/>
    </td>
  </tr>
  <tr>
    <td height="22" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;border-bottom:#cccccc solid 1px;">&nbsp;</td>
  </tr>
  </table>
   <input name="bbh_trocaResponsavel" id="bbh_trocaResponsavel" type="hidden" value="1" />
</form>
<br>
  <script type="text/javascript">document.getElementById('bbh_ind_codigo_barras').focus();</script> 