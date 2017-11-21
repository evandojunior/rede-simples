<?php
require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php");
$modulo 				= new Modulo();
						  $modulo->consultaModulo($database_bbpass, $bbpass, "");
$row_modulo		   		= $modulo->row_Mod;
$totalRows_modulo	 	= $modulo->totalRows_Mod;

?><table width="162" height="300" border="0" cellspacing="0" cellpadding="0" class="legendaLabel12" align="center">
  <tr>
    <td height="20" class="legendaLabel12">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="legendaLabel12">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="legendaLabel12" style="border-bottom:1px solid #FFECC7;">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="center" bgcolor="#FFFBF4" class="legendaLabel12" style="border-bottom:1px solid #FFECC7;font-weight:bold">Credenciais</td>
  </tr>
  <tr>
    <td height="3"></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #CCC;">
      <tr>
        <td height="300" valign="top"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="legendaLabel12">
          <tr>
            <td colspan="2" height="5"></td>
          </tr>
    <?php if($totalRows_modulo>0){ 
			do{
				$id			= $row_modulo['bbp_adm_loc_codigo'];
				$icone 		= $row_modulo['bbp_adm_loc_icone'];
				$diretorio 	= "modulos_off";
				$tituloLock	= "Clique para autenticar neste módulo.";
				
				if(array_key_exists($row_modulo['bbp_adm_loc_codigo'],$_SESSION['modulosLiberados'])){
					$diretorio 	= "modulos_on";
					$tituloLock	= "Módulo autenticado com sucesso.";
				}
	?>     
          <tr onmouseout="trocaMenu(<?php echo $id; ?>,'desativa');" onmouseover="trocaMenu(<?php echo $id; ?>,'ativa');" style="cursor:pointer" title="<?php echo $tituloLock; ?>">
            <td width="29%" height="45" align="center" class="barra_ferramentas_esquerda_desativada" id="<?php echo $id; ?>_esquerda"><img src="/datafiles/servicos/bbpass/images/sistema/<?php echo $diretorio; ?>/<?php echo $icone; ?>" width="36" height="36" border="0" id="iconLock_<?php echo $id; ?>" /></td>
            <td width="71%" align="left" class="barra_ferramentas_direita_desativada" id="<?php echo $id; ?>_direita">
            	<a href="#@" rev="/servicos/bbpass/modulos_autenticacao/index.php?id=<?php echo $row_modulo['bbp_adm_loc_codigo']; ?>" rel="backsite" class="li_a_padrao"><?php echo $nm = $row_modulo['bbp_adm_loc_nome']; ?></a>
            </td>
          </tr>
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
     <?php } while($row_modulo = mysqli_fetch_assoc($modulo->myMod));
	 } ?>
        </table></td>
      </tr>
    </table>
	
	</td>
  </tr>
</table>