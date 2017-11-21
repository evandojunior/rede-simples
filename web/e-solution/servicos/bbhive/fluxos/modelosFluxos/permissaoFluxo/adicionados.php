<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	
if(isset($_GET['bbh_per_flu_codigo'])){
	$deleteSQL = "DELETE FROM bbh_permissao_fluxo WHERE bbh_per_flu_codigo = ".$_GET['bbh_per_flu_codigo'];

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/permissaoFluxo/adicionados.php?bbh_mod_flu_codigo='.$_GET['bbh_mod_flu_codigo'];
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."','adicionados','&1=1','Atualizando dados...','cadastraModelo','2','1');</var>";
	exit;
}	

	$query_adicionados = "select bbh_per_flu_codigo, bbh_mod_flu_codigo, bbh_per_nome from bbh_permissao_fluxo
      inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
       Where bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']."
          group by bbh_permissao_fluxo.bbh_per_codigo
            order by bbh_per_nome asc";
    list($adicionados, $row_adicionados, $totalRows_adicionados) = executeQuery($bbhive, $database_bbhive, $query_adicionados);
	
	$idMensagemFinal= 'cadastraModelo';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/permissaoFluxo/adicionados.php?bbh_mod_flu_codigo='.$_GET['bbh_mod_flu_codigo']."&bbh_per_flu_codigo=xxx";
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','cadastraModelo','&1=1','Cadastrando dados...','cadastraModelo','2','1');";
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
<?php if($totalRows_adicionados>0) { ?> 
  <?php do{ ?>
  <tr>
    <td width="240" height="22">&nbsp;<img src="/e-solution/servicos/bbhive/images/marcador.gif" />&nbsp;<?php echo $row_adicionados['bbh_per_nome']; ?></td>
    <td width="30" align="center"><a href="#" onClick="return <?php echo str_replace('bbh_per_flu_codigo=xxx','bbh_per_flu_codigo='.$row_adicionados['bbh_per_flu_codigo'],$acao);?>"><img src="/e-solution/servicos/bbhive/images/var_alerta.gif" width="14" height="14" border="0" /></a></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/e-solution/servicos/bbhive/images/separador.gif"></td>
  </tr>
  <?php } while ($row_adicionados = mysqli_fetch_assoc($adicionados)); ?>
<?php } else { ?>
  <tr>
    <td colspan="2" align="center">N&atilde;o h&aacute; registros dispon&iacute;veis</td>
  </tr>
<?php } ?>
</table>
<var style='display:none'>OpenAjaxPostCmd('/e-solution/servicos/bbhive/fluxos/modelosFluxos/permissaoFluxo/nAdicionados.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','nAdicionados','&1=1','Carregando dados...','cadastraModelo','2','1');</var>
<var style="display:none">txtSimples('totPermi', '<?php echo $totalRows_adicionados; ?>')</var>