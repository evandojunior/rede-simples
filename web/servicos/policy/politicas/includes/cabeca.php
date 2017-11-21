<?php
if($_SERVER['PHP_SELF']!="/e-solution/servicos/policy/politicas/regra3.php"){
	//le arquivo xml do banco e cria sessão temporária
	mysql_select_db($database_policy, $policy);
	$query_politica = "SELECT * FROM pol_politica WHERE pol_pol_codigo =".$_GET['pol_pol_codigo'];
	$politica = mysql_query($query_politica, $policy) or die(mysql_error());
	$row_politica = mysql_fetch_assoc($politica);
	$totalRows_politica = mysql_num_rows($politica);
}
?>
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                      <tr>
                        <td height="25" colspan="2" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong><?php 
						if($_SERVER['PHP_SELF']=="/e-solution/servicos/policy/politicas/exclui.php"){
							echo "Exclus&atilde;o de filtro";
						}else if($_SERVER['PHP_SELF']=="/e-solution/servicos/policy/detalhes/regra.php"){
							echo "Pol&iacute;ticas do evento";
						}else{
							echo "Atualiza&ccedil;&atilde;o de filtro";							
						}
						?>
                       </strong></td>
                      </tr>

                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">T&iacute;tulo&nbsp;:&nbsp;</td>
                        <td width="82%" height="25" align="left" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><label>
                          <?php echo $row_politica['pol_pol_titulo']; ?>
                        </label></td>
                      </tr>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Autor&nbsp;:&nbsp;</td>
                        <td height="25" align="left" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><label>
                        <?php echo $row_politica['pol_usu_identificacao']; ?>
                        </label></td>
                      </tr>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Criado em&nbsp;:&nbsp;</td>
                        <td height="25" align="left" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><label>
                        
                          <?php echo arrumaDate(substr($row_politica['pol_pol_criacao'],0,10)); ?>
                        </label></td>
                      </tr>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Descri&ccedil;&atilde;o&nbsp;:&nbsp;</td>
                        <td height="25" align="left" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><label>
                             <?php echo $row_politica['pol_pol_descricao']; ?>
                        </label>
                   
                        
                        </td>
                      </tr>
                      <?php 
					  if($_SERVER['PHP_SELF']=="/e-solution/servicos/policy/politicas/exclui.php"){
					  ?>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
                        <td height="25" align="right" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><label>
                        
                          <input name="pol_pol_codigo" type="hidden" id="pol_pol_codigo" value="<?php echo $_GET['pol_pol_codigo']; ?>" />
                          <input name="button" type="button" class="back_input" id="button2" value="Voltar" style="cursor:pointer" onclick="javascript:history.go(-1);"/>
                          <input type="button" name="inserir" id="inserir" value="Excluir" class="back_input" onclick="javascript: if(confirm('Tem certeza que deseja excluir este registro?\nClique em Ok em caso de confirma&ccedil;&atilde;o.')){document.form1.submit()}"/>
                          <input type="hidden" name="MM_update" value="form1" />
                          <input name="id_file" type="hidden" id="id_file" value="<?php echo $_GET['id_file']; ?>" />
                        </label></td>
                      </tr>
                      <?php }?>
                      <tr>
                        <td height="5" colspan="2" align="right" bgcolor="#FFFFFF"></td>
                        </tr>
                    </table>