<tr class="legandaLabel11">
            <td width="33%" style="padding-bottom:2px;" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;
                
            </td>
            <td width="33%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
            <td width="4%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
            <td width="4%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
            <td width="11%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
            <td colspan="4" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
           <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/novo.php?nm=<?php echo $row_gerenciamentoArvore['bbh_cam_list_titulo'];?>&tipo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_tipo'];?>&mascara=pai','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Nova op&ccedil;&atilde;o" border="0" align="absmiddle" /></a>
            </td>
          </tr>
          <tr class="legandaLabel11">
            <td align="left" class="verdana_11_bold">&nbsp;M&aacute;scara</td>
            <td height="25" colspan="4" align="left" class="verdana_11_bold">T&iacute;tulo (op&ccedil;&atilde;o)</td>
            <td width="5%" align="center">&nbsp;</td>
            <td width="5%" align="center">&nbsp;</td>
            <td width="5%" align="center">&nbsp;</td>
            <td width="5%" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td height="1" colspan="9" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
              <?php while($row_gerenciamentoArvore = mysqli_fetch_assoc($gerenciamentoArvore)) {
                  $ord = $row_gerenciamentoArvore['bbh_cam_list_ordem'];
                  if (empty($ord)) {
                    continue;
                  }
                  ?>
              <tr class="legandaLabel11">
                <td align="left" >&nbsp;<?php echo $m=$row_gerenciamentoArvore['bbh_cam_list_mascara']; ?></td>
                <td height="25" colspan="4" align="left" ><?php echo $v=$row_gerenciamentoArvore['bbh_cam_list_valor']; ?></td>
                <td align="center">&nbsp;</td>
                <td align="center">
                    <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/novo.php?nm=<?php echo $row_gerenciamentoArvore['bbh_cam_list_titulo'];?>&tipo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_tipo'];?>&mascara=<?php echo $row_gerenciamentoArvore['bbh_cam_list_mascara']?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
                    <img src="/e-solution/servicos/bbhive/images/debito.gif" alt="Inserir registro neste n&iacute;vel" border="0" align="absmiddle" />
                    </a>
                </td>
                <td align="center">
                  <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/editar.php?bbh_cam_list_codigo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_codigo']; ?>&nm=<?php echo $row_gerenciamentoArvore['bbh_cam_list_titulo'];?>&tipo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_tipo'];?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
                    <img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar op&ccedil;&atilde;o" border="0" align="absmiddle" />          </a>
                </td>
                <td align="center">
                  <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/excluir.php?bbh_cam_list_codigo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_codigo']; ?>&nm=<?php echo $row_gerenciamentoArvore['bbh_cam_list_titulo'];?>&tipo=<?php echo $row_gerenciamentoArvore['bbh_cam_list_tipo'];?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
                <img src="/e-solution/servicos/bbhive/images/excluir.gif" alt="Excluir op&ccedil;&atilde;o" border="0" align="absmiddle" /></a> 
                </td>
            </tr>
            <tr>
                <td height="1" colspan="12" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
            </tr>
            <?php }
              ?>
            <tr class="legandaLabel11">
                <td height="5" colspan="9" align="center">
                    <?php include('../../includes/paginacao/paginacao.php');?>
                </td>
             </tr>