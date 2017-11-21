<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#CCFFCC" class="verdana_11"><input type="checkbox" name="ck_prot" id="ck_prot"  <?php echo pesquisaVetor("0", "ck_prot", ""); ?><?php if(isCurrentPage("/corporativo/servicos/bbhive/tarefas/avancada/regra3.php")){ ?>onClick="if(this.checked==true){computaSelecao(1)} else {computaSelecao(-1)}"<?php } ?>/></td>
        <td width="96%" class="verdana_11">&nbsp;N&ordm;. - <?php echo ($_SESSION['ProtNome']); ?>:
          <input name="bbh_pro_codigo" type="text" class="back_Campos" id="bbh_pro_codigo"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:<?php echo $nProt; ?>" value="<?php echo pesquisaVetor("1", "ck_prot", ""); ?>" size="20" maxlength="20"/></td>
    </tr>
      <tr>
        <td height="22" align="center" bgcolor="#CCFFCC" class="verdana_11"><input type="checkbox" name="ck_data" id="ck_data" <?php echo pesquisaVetor("0", "ck_data", ""); ?> <?php if(isCurrentPage("/corporativo/servicos/bbhive/tarefas/avancada/regra3.php")){ ?>onClick="if(this.checked==true){computaSelecao(1)} else {computaSelecao(-1)}"<?php } ?>/></td>
        <td class="verdana_11">&nbsp;Data do cadastro:
        <input name="bbh_pro_momento" type="text" class="back_Campos" id="bbh_pro_momento"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:<?php echo $nDtP; ?>;" value="<?php echo pesquisaVetor("1", "ck_data", ""); ?>" size="13" maxlength="10" onkeypress="MascaraData(event, this)"/></td>
      </tr>

      <tr>
        <td height="22" align="center" bgcolor="#CCFFCC" class="verdana_11"><input type="checkbox" <?php echo pesquisaVetor("0", "ck_tit", ""); ?> name="ck_tit" id="ck_tit"  <?php if(isCurrentPage("/corporativo/servicos/bbhive/tarefas/avancada/regra3.php")){ ?>onClick="if(this.checked==true){computaSelecao(1)} else {computaSelecao(-1)}"<?php } ?> /></td>
        <td class="verdana_11">&nbsp;<?php echo ($_SESSION['ProtOfiNome']);?> :
        <input name="bbh_pro_titulo" value="<?php echo pesquisaVetor("1", "ck_tit", ""); ?>" type="text" class="back_Campos" id="bbh_pro_titulo"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:<?php echo $ofc; ?>;" size="20"/></td>
      </tr>

      <?php /*
      <tr>
        <td height="22" align="center" bgcolor="#CCFFCC" class="verdana_11"><input type="checkbox" name="ck_desc" id="ck_desc"  <?php if(isCurrentPage("/corporativo/servicos/bbhive/tarefas/avancada/regra3.php")){ ?>onClick="if(this.checked==true){computaSelecao(1)} else {computaSelecao(-1)}"<?php } ?> /></td>
        <td class="verdana_11">&nbsp;Descri&ccedil;&atilde;o :
          <input name="bbh_pro_descricao" type="text" class="back_Campos" id="bbh_pro_descricao"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:<?php echo $desc; ?>;" size="20"/></td>
      </tr>*/ ?>
  </table>
  