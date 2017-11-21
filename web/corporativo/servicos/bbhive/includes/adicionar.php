<?php
	$query_Procedimentos = "select bbh_perfil.bbh_per_codigo, bbh_usu_codigo, 
      round(sum(bbh_per_fluxo)) as bbh_per_fluxo, 
      round(sum(bbh_per_mensagem)) as bbh_per_mensagem,
      round(sum(bbh_per_arquivos)) as bbh_per_arquivos,
      round(sum(bbh_per_equipe)) as bbh_per_equipe,
      round(sum(bbh_per_tarefas)) as bbh_per_tarefas,
      round(sum(bbh_per_relatorios)) as bbh_per_relatorios,
      round(sum(bbh_per_protocolos)) as bbh_per_protocolos,
      round(sum(bbh_per_central_indicios)) as bbh_per_central_indicios
    from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                     group by bbh_usu_codigo";
    list($Procedimentos, $row_Procedimentos, $totalRows_Procedimentos) = executeQuery($bbhive, $database_bbhive, $query_Procedimentos);
	
	$temItens = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="26" colspan="3" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><img src="/corporativo/servicos/bbhive/images/bt_novo.gif" alt="" width="24" height="24" border="0" align="absmiddle" /><strong>&nbsp;Adicionar</strong></td>
  </tr>
  <tr>
    <td height="5" colspan="3"></td>
  </tr>
  
      <tr>
        <td height="22">
         <?php if($row_Procedimentos['bbh_per_fluxo']>=1){ 	$temItens = 1;?>
            <span class="verdana_9">&nbsp;<a href="#" onClick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/regra.php','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/listaIVI.gif" border="0" align="absmiddle" />
                &nbsp;<?php echo $a=$_SESSION['FluxoNome']; ?></a></span>
          <?php } ?>      
                </td>
        <td>
        <?php if($row_Procedimentos['bbh_per_mensagem']>=1){ 	$temItens = 1;?>
        <span class="verdana_9"><a href="#@"  onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaEntrada=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita');">&nbsp;<img src="/corporativo/servicos/bbhive/images/escrever-email.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> &nbsp;<?php echo $b=$_SESSION['MsgNome']; ?></a></span>
        <?php } ?>
        </td>
        <td>
        <?php if($row_Procedimentos['bbh_per_arquivos']>=1){ 	$temItens = 1;?>
        <span class="verdana_9"><a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;arquivos=1|arquivos/novo.php?|includes/colunaDireita.php?fluxosDireita=1&amp;arquivos=1&amp;equipeArquivos=1','menuEsquerda|colCentro|colDireita');">&nbsp;<img src="/corporativo/servicos/bbhive/images/upload.gif" border="0" align="absmiddle" /> &nbsp;<?php echo $c=$_SESSION['arqNome']; ?></a></span>
         <?php } ?>
        </td>
      </tr>
  <?php if($temItens== 0){?>
      <tr>
        <td height="22" colspan="3"><span class="verdana_9">&nbsp;N&atilde;o h&aacute; itens para adicionar</span></td>
  	</tr>
 <?php } ?> 
</table>
