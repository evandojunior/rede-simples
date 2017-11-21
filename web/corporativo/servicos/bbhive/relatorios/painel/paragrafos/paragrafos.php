<?php
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
	if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
}

$query_paragrafo = "SELECT bbh_modelo_paragrafo.bbh_mod_par_codigo FROM bbh_paragrafo INNER JOIN bbh_modelo_paragrafo ON bbh_modelo_paragrafo.bbh_mod_par_codigo = bbh_paragrafo.bbh_mod_par_codigo WHERE bbh_rel_codigo = $bbh_rel_codigo ORDER BY bbh_par_ordem";
list($paragrafo, $row_paragrafo, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo);
$not_in="";
	if($totalRows_paragrafo > 0){
	$not_in = " AND bbh_modelo_paragrafo.bbh_mod_par_codigo NOT IN(";
		do{
			$not_in .= $row_paragrafo['bbh_mod_par_codigo'].",";
		}while($row_paragrafo = mysqli_fetch_assoc($paragrafo));
		$not_in .= "0)";
	}

	$query_paragrafos = "SELECT bbh_modelo_paragrafo.*,bbh_usuario.bbh_usu_apelido 
	FROM bbh_modelo_paragrafo 
	
	INNER JOIN bbh_modelo_fluxo ON bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_modelo_paragrafo.bbh_mod_flu_codigo 
	INNER JOIN bbh_modelo_atividade ON bbh_modelo_atividade.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
	INNER JOIN bbh_atividade ON bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo 
	LEFT JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_modelo_paragrafo.bbh_usu_autor 
	
	WHERE bbh_atividade.bbh_ati_codigo = $bbh_ati_codigo 
	#AND bbh_mod_par_privado = 0 OR bbh_mod_par_privado = 1 and 
	and bbh_usu_autor = ".$_SESSION['usuCod']."
	 $not_in
	 GROUP BY bbh_mod_par_codigo
	 UNION 
		SELECT bbh_modelo_paragrafo.*,bbh_usuario.bbh_usu_apelido 
	   FROM bbh_modelo_paragrafo 
	   
	   INNER JOIN bbh_modelo_fluxo ON bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_modelo_paragrafo.bbh_mod_flu_codigo 
	   INNER JOIN bbh_modelo_atividade ON bbh_modelo_atividade.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
	   INNER JOIN bbh_atividade ON bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo 
	   LEFT JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_modelo_paragrafo.bbh_usu_autor 
	   
	   WHERE bbh_atividade.bbh_ati_codigo = $bbh_ati_codigo 
	   AND bbh_mod_par_privado = 0
		$not_in";

    list($modelo_paragrafos, $row_modelo_paragrafos, $totalRows_modelo_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_paragrafos);
?><link rel="stylesheet" type="text/css" href="../../../includes/relatorio.css">
<table width="560" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9" style="background:#FDFBE7;border:1px dashed #CCCCCC;">
<?php if($totalRows_modelo_paragrafos>0){ ?>     
	 <?php do { 
	 
				if($row_modelo_paragrafos['bbh_adm_codigo'] != ""){
					$autor = "Administrador";
				}else{
					$autor = $row_modelo_paragrafos['bbh_usu_apelido'];
				}
	 ?>  
  <tr>
          <td width="36%" height="32" style="padding:5px;"><span class="verdana_11"><input type="radio" name="radio" id="bbh_arq_codigo" value="<?php echo $row_modelo_paragrafos['bbh_mod_par_codigo']; ?>" onClick="javascript: window.top.document.getElementById('bbh_mod_par_codigo').value=this.value;window.top.document.getElementById('bbh_par_autor').value='<?php echo $autor; ?>';"><img src="/corporativo/servicos/bbhive/images/arrow_bottom.gif" border="0" align="absmiddle">&nbsp;<?php echo $nmPar = $row_modelo_paragrafos['bbh_mod_par_titulo']; ?></a></span></td>
          <td width="36%" height="32" style="padding:5px;">
            <span class="verdana_11">
            <?php 
				echo $autor;
			 ?>
    </span></td>
          <td width="28%" height="32" style="padding:5px;">
            <span class="verdana_11">
            <?php 
				if($row_modelo_paragrafos['bbh_mod_par_privado']==0){
					echo "Sim";
				}else{
					echo "N&atilde;o";
				}
			 ?>
    </span></td>
          </tr>
	<?php }while($row_modelo_paragrafos = mysqli_fetch_assoc($modelo_paragrafos)); ?>
<?php } else { ?>
     <tr>
     <td height="25" colspan="3"><span class="verdana_11">&nbsp;N&atilde;o existem par&aacute;grafos para adicionar ou relat&oacute;rio finalizado  </span></td>
     </tr>
<?php } ?>
    </table>