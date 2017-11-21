<?php
//lista apenas os fluxos que este usuário está envolvido, depois jogo ele para página de consulta
$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_flu_titulo, 
ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido
  from bbh_atividade
  inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
   inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
      Where bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod']."
          # and bbh_flu_tarefa_pai is NULL 
            group by bbh_fluxo.bbh_flu_codigo
             HAVING concluido<100
			  order by bbh_fluxo.bbh_flu_codigo desc 
			  LIMIT 0,10";

list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
?>
<table width="172" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:0px;">
  <tr>
    <td height="28" align="left" background="/corporativo/servicos/bbhive/images/miniTop.jpg" class="verdana_12">
    <label style="margin-left:5px;">&nbsp;<strong>Fluxos</strong></label>
    </td>
  </tr>
  <tr>
    <td height="22" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#D7D7D7 solid 1px;">
<?php if($totalRows_Fluxos>0) { ?>  
    <table width="170">
    <tr>
      <td height="1" width="52" align="center"></td>
      <td height="1" width="52" align="center"></td>
      <td height="1" width="52" align="center"></td>
    </tr>
    <tr>
    <?php 
	$cont=0;
	$contaFlux=0;
	do { 
	 if($contaFlux<9){
		if($cont==3){
			echo '</tr>
			    <tr>
				  <td height="3" align="center"></td>
				  <td height="3" align="center"></td>
				  <td height="3" align="center"></td>
				</tr>
				<tr>';
			$cont=0;
		}
	?>
        <td width="50" height="31" align="center" class="tbTarefasMini">
            <a href="#0" style="cursor:pointer;" title="header=[<span class='verdana_11'><?php echo substr($row_Fluxos['bbh_flu_titulo'],0,19); ?>...</span>] body=[<span class='verdana_11'>Status: <?php echo $row_Fluxos['concluido']; ?>%<br>Clique para verificar todos os dados do fluxo</span>]" onclick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');">
                <img src="/corporativo/servicos/bbhive/images/btnFluxo.gif" border="0" style="margin-left:5px;" /><br />
            <?php echo $row_Fluxos['bbh_flu_codigo']; ?>
            </a>
        </td>
    <?php $cont = $cont + 1; $contaFlux=$contaFlux+1;
	 }
	} while($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>

      </tr>
    </table>
<?php } else { echo "<span class='verdana_9'>N&atilde;o h&aacute; registros dispon&iacute;veis.&nbsp;</span>"; } ?>    
    </td>
  </tr>
  <tr>
    <td height="10" align="right" style="border-left:#D7D7D7 solid 1px; border-bottom:#D7D7D7 solid 1px; border-right:#D7D7D7 solid 1px;" class="verdana_9">&nbsp;
    <?php if($totalRows_Fluxos>9) { ?>
    <a href="#" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php?envolvidos=true','menuEsquerda|conteudoGeral');">ver mais</a>&nbsp;
    <?php } ?>
    </td>
  </tr>
</table>
<br />