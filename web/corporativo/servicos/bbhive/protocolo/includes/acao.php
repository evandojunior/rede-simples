<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="2" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">
    <div style="float:left">
    &nbsp;<img src="/corporativo/servicos/bbhive/images/acao.gif" border="0" align="absmiddle" />&nbsp;<strong>O que voc&ecirc; deseja fazer?</strong>
    </div>
    <div style="float:right" class="verdana_12" id="loadForm">&nbsp;</div>
    </td>
  </tr>
  
  <?php if(($codSta==1 || $codSta==7) && $RestringirSolicitacao=='0') {?>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="document.getElementById('acao').value='2'; <?php echo $acao; ?>">
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/receber.gif" width="16" height="16"></td>
    <td width="577" class="legandaLabel12">&nbsp;<?php echo $_SESSION['receberNome']; ?></td>
  </tr>
  <?php } ?>
  
  <?php if(($codSta==2 || $codSta==7) && ($RestringirProcesso == 0)) {
	  
	  $ClickDigitaliza = "OpenAjaxPostCmd('protocolo/includes/digitalizar.php?bbh_pro_codigo=".$bbh_pro_codigo."','conteudoDinamico','','Aguarde carregando...',conteudoDinamico,2,2);";
	  ?>  
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onClick="if(document.getElementById('DetalhamentoAtualizado')){ if(confirm('Existe(m) campo(s) disponível(is) para preenchimento, clique em OK caso o(s) mesmo(s) esteja(m) preenchido(s).')){<?php echo $ClickDigitaliza; ?>}} else {<?php echo $ClickDigitaliza; ?>}">
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/scanner.gif" width="16" height="16"></td>
    <td width="577" class="legandaLabel12">&nbsp;Digitalizar documentos</td>
  </tr>
  <?php } ?>
  <?php if(($codSta==2 || $codSta==7) && ($RestringirProcesso == 0)) {/*document.getElementById('acao').value='-1';OpenAjaxPostCmd('protocolo/includes/anexar_fluxo.php?bbh_pro_codigo=<?php echo $bbh_pro_codigo; ?>','conteudoDinamico','','Aguarde carregando...',conteudoDinamico,2,2);*/
  	$ClickAnexar = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php?bbh_pro_codigo=".$bbh_pro_codigo."','menuEsquerda|conteudoGeral');";
  ?>  
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'"  onClick="if(document.getElementById('DetalhamentoAtualizado')){ if(confirm('Existe(m) campo(s) disponível(is) para preenchimento, clique em OK caso o(s) mesmo(s) esteja(m) preenchido(s).')){<?php echo $ClickAnexar; ?>}} else {<?php echo $ClickAnexar; ?>}" >
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/relacionados.gif" alt="" border="0" align="absmiddle" /></td>
    <td width="577" class="legandaLabel12"><em>&nbsp;</em>Anexar <?php echo ($_SESSION['ProtNome']); ?> a um <?php echo $_SESSION['FluxoNome']; ?> j&aacute; distribu&iacute;do.</td>
  </tr>
  <?php } ?>
  <?php if(($codSta==2 || $codSta==7) && $RestringirProcesso=='0') {
  	$ClickIniciar = "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/regra.php?bbh_pro_codigo=".$bbh_pro_codigo."','menuEsquerda|colPrincipal');";
	  ?>   
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="if(document.getElementById('DetalhamentoAtualizado')){ if(confirm('Existe(m) campo(s) disponível(is) para preenchimento, clique em OK caso o(s) mesmo(s) esteja(m) preenchido(s).')){<?php echo $ClickIniciar; ?>}} else {<?php echo $ClickIniciar; ?>}">
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/iniciar.gif" alt="" border="0" align="absmiddle" /></td>
    <td width="577" class="legandaLabel12"><em>&nbsp;</em>Iniciar um processo a partir desta(e) <?php echo ($_SESSION['ProtNome']); ?>.</td>
  </tr>
  <?php } ?>
  <?php if($codSta==2 && $RestringirProcesso=='0'){
  	$ClickAguardando = "document.getElementById('acao').value='7'; $acao";//
	//--
	$ClickArquivar	= "executeDeferimentoProtocolo()";//"if(confirm(' Voce está ciente que ao arquivar este pedido\no mesmo não poderá ser mais recuperado para\n              fazer qualquer modificação?\n    Clique em OK em caso de confirmação')){ if(confirm('Você já adicionou um despacho para esta ação?\n    Clique em OK em caso de confirmação.')){ document.getElementById('acao').value='5';  $acao} } else { document.getElementById('acao').value=0;}";
	  ?>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="if(document.getElementById('DetalhamentoAtualizado')){ if(confirm('Existe(m) campo(s) disponível(is) para preenchimento, clique em OK caso o(s) mesmo(s) esteja(m) preenchido(s).')){<?php echo $ClickAguardando; ?>}} else {<?php echo $ClickAguardando; ?>}">
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/aguardando.gif " alt="" border="0" align="absmiddle" /></td>
    <td width="577" class="legandaLabel12"><em>&nbsp;</em>Aguardando</td>
  </tr>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="executeBlocoMotivoAcaoProtocolo('deferimento')">
    <td width="23" height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/acao.gif " alt="" border="0" align="absmiddle" /></td>
    <td width="577" class="legandaLabel12"><em>&nbsp;</em>Deferir <?php echo ($_SESSION['ProtNome']); ?></td>
  </tr>
      <tr bgcolor="#F0F0F0" id="area-motivo-deferimento" style="display: none">
          <td>&nbsp;</td>
          <td style="vertical-align:top" class="legandaLabel12">
              <strong>Motivo do deferimento:</strong><br>
              <textarea class="formulario2" name="motivo_deferimento" id="motivo_deferimento" cols="80" rows="3"></textarea>
              <div style="float:none; margin: 8px;">
                  <input name="avancar" style="background:url(/corporativo/servicos/bbhive/images/erro.gif);
                background-repeat:no-repeat;background-position:left;height:23px;width:120px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;"
                         type="button" class="back_input" id="cancelar-deferimento"
                         value="Cancelar" onclick="document.getElementById('area-motivo-deferimento').style.display = 'none'; document.getElementById('bloco-padrao-despacho-protocolo').style.display = '';" />

                  <input name="cadastrar" style="background:url(/e-solution/servicos/bbhive/images/disk.gif);
                background-repeat:no-repeat;background-position:left;height:23px;width:120px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;"
                         type="button" class="back_input" id="cadastrar" value="&nbsp;Confirmar" onclick="executeDeferimentoProtocolo();"/>
              </div>
          </td>
      </tr>
  <?php } ?> 
  <?php if(in_array($codSta, [2, 7])){
	  //--
	$ClickDevolver	= "document.getElementById('acao').value='1';$acao";//
	  ?>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="if(document.getElementById('DetalhamentoAtualizado')){ if(confirm('Existe(m) campo(s) disponível(is) para preenchimento, clique em OK caso o(s) mesmo(s) esteja(m) preenchido(s).')){<?php echo $ClickDevolver; ?>}} else {<?php echo $ClickDevolver; ?>}">
    <td height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/devolver.gif" alt="" border="0" align="absmiddle" /></td>
    <td class="legandaLabel12"><em>&nbsp;</em>Devolver <?php echo ($_SESSION['ProtNome']); ?></td>
  </tr>
  <?php } ?>
<?php if(in_array($codSta, [1, 2, 7]) && $RestringirSolicitacao=='0') { ?>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="executeBlocoMotivoAcaoProtocolo('indeferimento')">
    <td height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/indeferir.gif" alt="" border="0" align="absmiddle" /></td>
    <td class="legandaLabel12">&nbsp;Indeferir pedido</td>
  </tr>
  <tr bgcolor="#F0F0F0" id="area-motivo-indeferimento" style="display: none">
      <td>&nbsp;</td>
      <td style="vertical-align:top" class="legandaLabel12">
          <strong>Motivo do indeferimento:</strong><br>
          <textarea class="formulario2" name="motivo_indeferimento" id="motivo_indeferimento" cols="80" rows="3"></textarea>
          <div style="float:none; margin: 8px;">
          <input name="avancar" style="background:url(/corporativo/servicos/bbhive/images/erro.gif);
                background-repeat:no-repeat;background-position:left;height:23px;width:120px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;"
                 type="button" class="back_input" id="cancelar-indeferimento"
                 value="Cancelar" onclick="document.getElementById('area-motivo-indeferimento').style.display = 'none'; document.getElementById('bloco-padrao-despacho-protocolo').style.display = '';" />

          <input name="cadastrar" style="background:url(/e-solution/servicos/bbhive/images/disk.gif);
                background-repeat:no-repeat;background-position:left;height:23px;width:120px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;"
                 type="button" class="back_input" id="cadastrar" value="&nbsp;Confirmar" onclick="document.getElementById('acao').value='6'; executeIndeferimentoProtocolo();"/>
          </div>
      </td>
  </tr>
<?php } ?> 
<?php if(isset($CriouRelatorio) && $CriouRelatorio==1){ ?>
 <?php if(!isset($protegido)){ ?>
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="document.actionDownloadPDF<?php echo $cd; ?>.submit();">
    <td height="26" align="center" class="legandaLabel12" style="border-bottom:#09C solid 2px; border-left:#09C solid 2px; border-top:#09C solid 2px;">
<img src="/corporativo/servicos/bbhive/images/download.gif" alt="Download do arquivo" width="16" height="16" border="0"></td>
    <td class="legandaLabel12" style="border-bottom:#09C solid 2px; border-right:#09C solid 2px; border-top:#09C solid 2px;">&nbsp;<strong>Fazer download do <?php echo $_SESSION['relNome']; ?></strong></td>
  </tr>
 <?php } else { ?> 
  <tr>
    <td height="26" align="center" class="legandaLabel12">
<img src="/corporativo/servicos/bbhive/images/download.gif" alt="Download do arquivo" width="16" height="16" border="0"></td>
    <td class="legandaLabel12">&nbsp;<strong style="color:#999">Download protegido pelo autor</strong></td>
  </tr>
<?php }
} ?>  
  <tr style="cursor:pointer" onMouseMove="this.style.backgroundColor='#CCFFCC'" onMouseOut="this.style.backgroundColor='#ffffff'" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');">
    <td height="26" align="center" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/voltar.gif" alt="" width="14" height="15" /></td>
    <td class="legandaLabel12">&nbsp;Voltar para p&aacute;gina de <?php echo ($_SESSION['ProtNome']); ?></td>
  </tr>

</table>
<form name="formProtocolo" id="formProtocolo">
  <input type="hidden" name="bbh_pro_codigo" id="bbh_pro_codigo" value="<?php echo $bbh_pro_codigo; ?>" />
  <input type="hidden" name="acao" id="acao" value="0" />
  <input type="hidden" name="MM_Update" id="MM_Update" value="formProtocolo" />
  <textarea class="formulario2" name="pro_obs" id="pro_obs" cols="80" rows="3" style="display:none"></textarea>
</form>