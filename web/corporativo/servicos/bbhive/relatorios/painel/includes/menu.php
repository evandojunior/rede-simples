<table width="280" border="0" cellspacing="0" cellpadding="0" style="margin-left:10px; margin-top:10px; <?php if(strpos($_SERVER['HTTP_USER_AGENT'],"Firefox")>0){ ?>display:table-cell;<?php } else { ?>display:inline;<?php } ?>" onMouseOver="javascript: this.className='comFundo'" onMouseOut="javascript: this.className='semFundo'" onClick="<?php echo $onClick; ?>">
  <tr>
    <td width="62" height="60">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/<?php echo $icone; ?>" width="48" height="46" /></td>
    <td width="228"><strong class="verndana_12"><?php echo $titulo; ?></strong>
      <br>
    <span class="verdana_11"><?php echo $legenda; ?></span></td>
  </tr>
</table>