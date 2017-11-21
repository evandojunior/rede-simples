<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td width="189" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel16">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIVI.gif" border="0" align="absmiddle" />&nbsp;<strong>Relacionar <?php echo $r=$_SESSION['FluxoNome']; ?></strong></td>
    <td width="411" align="right" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">
	<a href="#" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo_p; ?>','menuEsquerda|conteudoGeral');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar para página de resumo deste <?php echo $_SESSION['FluxoNome']; ?></strong></span>     </a>
    &nbsp;</td>
  </tr>
  </table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ECFFEC" style="border-left:#E6E6E6 solid 1px;border-right:#E6E6E6 solid 1px;border-bottom:#E6E6E6 solid 1px;">
  <tr>
    <td width="25" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="2" class="legandaLabel16" style="color:#F60"><strong>&nbsp;<?php echo $numeroProcesso; ?></strong></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td width="23" align="center"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="552" class="legandaLabel16" style="color:#36C">&nbsp;<strong><?php echo $row_CabFluxo['bbh_flu_titulo']; ?></strong></td>
  </tr>
</table>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel12" style="margin-top:10px; margin-bottom:20px;">
  <tr>
    <td width="25" height="25" class="titulo_setor" align="center"><img src="/corporativo/servicos/bbhive/images/visualizar.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="3" class="titulo_setor legandaLabel12">&nbsp;<strong>Dados b&aacute;sicos</strong></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>C&oacute;digo :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><strong><?php echo $row_Fluxo['bbh_flu_codigo']; ?></strong></span></td>
    <td width="234" rowspan="6" align="left" valign="top">
      <fieldset style="margin-top:2px; margin-bottom:2px;">
        <legend class="legandaLabel11">Informa&ccedil;&otilde;es complementares</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong>Iniciado em <span style="color:#F60"><?php echo $dt=$row_Fluxo['bbh_flu_data_iniciado']; ?></span></strong></td>
          </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong>Final previsto <span style="color:#F60"><?php echo $dt=arrumadata($row_Fluxo['final']); ?></span></strong></td>
          </tr>
          <tr>
            <td width="12%" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" align="absmiddle"></td>
            <td width="88%">&nbsp;<strong><span style="color:#F60"><?php echo $a=$row_strArquivos['total']; ?></span>&nbsp;<?php echo strtolower($_SESSION['arqNome']); ?> compartilhado(s)</strong></td>
          </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong><span style="color:#F60"><?php echo $t=$row_strMinhasTarefas['total']; ?></span>&nbsp;<?php echo strtolower($_SESSION['TarefasNome']); ?></strong></td>
          </tr>
        </table>
      </fieldset>                
    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>T&iacute;tulo :&nbsp;</strong></td>
    <td width="244">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_flu_titulo']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Tipo :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo normatizaCep($row_Fluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxo['bbh_tip_flu_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Origem :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_dep_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Distribu&iacute;do por :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_usu_nome']; ?></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Situa&ccedil;&atilde;o :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['concluido']; ?>%</span></td>
  </tr>
  <tr>
    <td height="5"><span style="font-size:4px;">&nbsp;</span></td>
    <td width="97"><span style="font-size:4px;">&nbsp;</span></td>
    <td colspan="2"><span style="font-size:4px;">&nbsp;</span></td>
  </tr>
  <?php if(getCurrentPage() == "/corporativo/servicos/bbhive/consulta/regra.php"){
  
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Acessou a página de relação de (".$_SESSION['FluxoNome'].") código (".$bbh_flu_codigo.") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
  
  ?>
  <tr>
    <td height="5" colspan="4" align="center"><img src="/corporativo/servicos/bbhive/images/seta_verde.gif" width="48" height="48"><img src="/corporativo/servicos/bbhive/images/seta_laranja.gif" width="48" height="48"></td>
  </tr>
  <?php } ?>
</table>
