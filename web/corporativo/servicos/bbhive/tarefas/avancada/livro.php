<form name="formLivro" id="formLivro" method="post" action="/corporativo/servicos/bbhive/tarefas/avancada/detalhamento/executa.php" style="margin-top:-1px;"><table width="595" border="0" cellspacing="0" cellpadding="0" id="exportaLivro" style="display:block">
          <tr>
            <td height="26" colspan="4" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><img src="/corporativo/servicos/bbhive/images/detalhe_tar.gif" width="16" height="16" align="absmiddle" />&nbsp;<strong><em>Campos de exibi&ccedil;&atilde;o na planilha</em></strong><em></em></td>
          </tr>
          <tr>
            <td width="33" height="22" align="center" bgcolor="#EFEFE7"><input name="phk_caso" type="checkbox" id="phk_caso" checked="checked" /></td>
            <td width="299" align="left" bgcolor="#FFFFFF">N&uacute;mero do caso</td>
            <td width="29" align="center" bgcolor="#EFEFE7"><input name="phk_dthrprot" type="checkbox" id="phk_dthrprot" checked="checked" /></td>
            <td width="234" align="left" bgcolor="#FFFFFF">Data e hora - <?php echo($_SESSION['ProtNome']); ?></td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_dtrecebido" type="checkbox" id="phk_dtrecebido" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Data de recebimento no departamento</td>
            <td align="center" bgcolor="#EFEFE7"><input name="phk_solicitante" type="checkbox" id="phk_solicitante" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Solicitante</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_noficio" type="checkbox" id="phk_noficio" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">N&uacute;mero do of&iacute;cio</td>
            <td align="center" bgcolor="#EFEFE7"><input name="phk_descricao" type="checkbox" id="phk_descricao" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Descri&ccedil;&atilde;o da solicita&ccedil;&atilde;o</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_dtoficio" type="checkbox" id="phk_dtoficio" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Data do of&iacute;cio</td>
            <td align="center" bgcolor="#EFEFE7"><input name="phk_nmperito" type="checkbox" id="phk_nmperito" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Nome do profissional</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_nprot" type="checkbox" id="phk_nprot" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">N&uacute;mero - <?php echo($_SESSION['ProtNome']); ?></td>
            <td align="center" bgcolor="#EFEFE7"><input name="phk_dtconclusao" type="checkbox" id="phk_dtconclusao" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Data da conclus&atilde;o do caso</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_nproc" type="checkbox" id="phk_nproc" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">N&uacute;mero do processo</td>
            <td align="center" bgcolor="#EFEFE7"><input name="phk_descproc" type="checkbox" id="phk_descproc" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Descri&ccedil;&atilde;o do processo</td>
          </tr>
          <tr>
            <td height="22" align="center" bgcolor="#EFEFE7"><input name="phk_despachos" type="checkbox" id="phk_despachos" checked="checked" /></td>
            <td align="left" bgcolor="#FFFFFF">Despachos - <?php echo($_SESSION['ProtNome']); ?></td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
          </tr>
          </table>
        <?php 
		$livro=true;
		require_once("detalhamento/livro.php"); ?>
<input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" />
        <input name="bbh_tip_flu_codigo" type="hidden" id="bbh_tip_flu_codigo" value="<?php echo $row_Fluxos['bbh_tip_flu_codigo']; ?>" />
        <input name="exporta" type="hidden" id="exporta" value="1" />
        <input class="formulario2" id="web2" type="submit" value="Gerar planilha" name="web2"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF"/>
</form>