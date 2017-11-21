<?php 	require_once("../includes/autentica.php"); ?>
<?php

$colname_quando_dia = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_quando_dia = $_GET['pol_apl_codigo'];
}

mysqli_select_db($policy, $database_policy);
$query_quando_dia = "select DATE_FORMAT(pol_aud_momento, '%d') as dia, DATE_FORMAT(pol_aud_momento, '%W') as semana, DATE_FORMAT(pol_aud_momento, '%m') as mes,  DATE_FORMAT(pol_aud_momento, '%Y') as ano, DATE_FORMAT(MAX(pol_aud_momento), '%T') as ultimoacesso, COUNT(pol_apl_codigo) as ACESSOS  FROM pol_auditoria  WHERE DATE_FORMAT(pol_aud_momento, '%m/%Y') = '".$_GET['mes']."'  and pol_apl_codigo=$colname_quando_dia GROUP BY dia ORDER BY dia ASC, ultimoacesso desc";
$quando_dia = mysqli_query($policy, $query_quando_dia) or die(mysql_error());
$row_quando_dia = mysqli_fetch_assoc($quando_dia);
$totalRows_quando_dia = mysqli_num_rows($quando_dia);

$MesAnterior = "";
$ProximoMes = "";
$TodosMeses = $_SESSION['mesesCompletos'];
$TotalMeses = count($TodosMeses);
$cont = 0;
	for($a=0; $a<$TotalMeses; $a++){
		if($TodosMeses[$a]==$_GET['mes']){
			if($a>0){
				$MesAnterior = $TodosMeses[$a-1];
//					echo  $TodosMeses[$a-1];					
					//if($a<$TotalMeses){
					if(array_key_exists($a+1,$TodosMeses)){
							if(isset($TodosMeses[$a+1])){
								$ProximoMes = $TodosMeses[$a+1];
							} else {
								$ProximoMes ="";
							}
					} else {
						$ProximoMes = "";
					}
			} elseif($a==0){
				$MesAnterior = "";

//					if($a<$TotalMeses){
					if(array_key_exists($a+1,$TodosMeses)){
						$ProximoMes = $TodosMeses[$a+1];
					}
			}
			$cont  = $cont +1;
		}
	}
	//print_r($TodosMeses);
	//echo $TotalMeses;
	//echo $MesAnterior."<hr>";
	//echo $ProximoMes;
	$Link = "/e-solution/servicos/policy/detalhes/regra.php?pol_apl_codigo=".$_GET['pol_apl_codigo']."&quando_dias=true&mes=";
?>
<table width="97%" cellpadding="4" cellspacing="0">
<tr>
  <td height="0" colspan="3" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">
<?php if($MesAnterior!=""){ ?>  
  &nbsp;<a href="<?php echo $Link.$MesAnterior; ?>"><img src="/e-solution/servicos/policy/images/voltarmes.gif" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;&nbsp;
<?php } else {?>
  &nbsp;<img src="/e-solution/servicos/policy/images/voltarmes_off.gif" border="0" align="absmiddle" />&nbsp;&nbsp;&nbsp;&nbsp;
<?php } ?>  
  
<?php
$mes = substr($_GET['mes'],0,2);
echo "<strong style='color:#006600'>".RetornaMes($mes).", ".substr($_GET['mes'],3)."</strong>";
?>
&nbsp;&nbsp;&nbsp;&nbsp;<?php if($ProximoMes!=""){ ?><a href="<?php echo $Link.$ProximoMes; ?>"><img src="/e-solution/servicos/policy/images/adiantarmes.gif" border="0" align="absmiddle" /></a><?php } else { ?>
<img src="/e-solution/servicos/policy/images/adiantarmes_off.gif" border="0" align="absmiddle" />
<?php } ?>
&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999999">Hoje &eacute; dia <?php
 $dia 	 = date('d');
 $MES 	 = date('m');
 $ano	 = date('Y');
 echo $dia." de ".RetornaMes($MES)." de ".$ano;
 ?></span></td>
</tr>
<?php do { ?>
  <tr id="linha_<?php echo $row_quando_dia['dia']; ?>" onmouseover="return Popula('linha_<?php echo $row_quando_dia['dia']; ?>')" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&detalhes=true&dia=<?php echo $row_quando_dia['dia'].$row_quando_dia['mes'].$row_quando_dia['ano']; ?>'" onmouseout="return Desativa('linha_<?php echo $row_quando_dia['dia']; ?>')" title="header=[<span class='verdana_11'>Informa&ccedil;&otilde;es adicionais</span>] body=[<span class='verdana_11'><?php echo "Clique e veja detalhes dos acessos deste dia."; ?></span>]">
    <td width="32%" align="left" style="border-bottom:1px dotted #003333;">
    &nbsp;<img src="/e-solution/servicos/policy/images/dia.gif" border="0" align="absmiddle" />&nbsp;&nbsp;&nbsp;<strong style="color:#336600;"><?php echo $row_quando_dia['dia']."  ".substr(strtolower(RetornaSemana($row_quando_dia['semana'])),0,3); ?></strong></td>
    <td width="33%" align="left" class="verdana_11_cinza" style="border-bottom:1px dotted #003333;"><?php echo $row_quando_dia['ACESSOS']; ?> 
      <?php if($row_quando_dia['ACESSOS']<2){ ?>
      acesso
      <?php }else{ ?>
      acessos      <?php } ?></td>
    <td width="35%" align="left" class="verdana_11_cinza" style="border-bottom:1px dotted #003333;">&uacute;ltimo acesso &agrave;s <?php echo $row_quando_dia['ultimoacesso']; ?></td>
  </tr>
  <?php } while ($row_quando_dia = mysqli_fetch_assoc($quando_dia)); ?>
<tr>
  <td colspan="3">&nbsp;</td>
</tr>
</table>
<?php
mysqli_free_result($quando_dia);
?>