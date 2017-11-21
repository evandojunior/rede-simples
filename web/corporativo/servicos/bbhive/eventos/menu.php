<?php

$mesCorrente = date('m');

$query_Data = "select
 DATE_FORMAT(bbh_men_data_recebida, '%d') as dia,
 DATE_FORMAT(bbh_men_data_recebida, '%m') as mes,
 DATE_FORMAT(bbh_men_data_recebida, '%Y') as ano,
 count(DATE_FORMAT(bbh_men_data_recebida,'%d')) as Total, bbh_usu_codigo_destin 
  from bbh_mensagens
    Where DATE_FORMAT(bbh_men_data_recebida, '%m') = '$mesCorrente' and bbh_usu_codigo_destin= ".$_SESSION['usuCod']."  and bbh_men_exclusao_destinatario='0'
      group by DATE_FORMAT(bbh_men_data_recebida, '%d')";
list($Data, $row_Data, $totalRows_Data) = executeQuery($bbhive, $database_bbhive, $query_Data);

$dataMsg = array();
	for($a=1; $a<=31; $a++){
		$dataMsg[$a]="";
	}
	
	do{
	  if($row_Data['dia']<10){
	  	$dia = substr($row_Data['dia'],1);
	  } else {
	  	$dia = $row_Data['dia'];
	  }
		$dataMsg[$dia]=$row_Data['dia']."|".$row_Data['Total'];
	} while ($row_Data = mysqli_fetch_assoc($Data));
	
	//print_r($dataMsg);
?>
<table width="158" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-left:15px;">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" align="left" style="border-bottom:1px solid #EBEBDA;border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;"><?php
require_once("../includes/functions.php");
$pagetitle = 'calendar';
//if the $month and $year valuesdont exist, make then the current month and year.
if (!isset($month) && !isset($year)) {
    $month = date ("m");
    $year = date ("y");
}

// calculate the veiwed month.
$timestamp = mktime (0, 0, 0, $month, 1, $year);

//$monthname = RetornaMes(date("M", $timestamp));
$monthname = RetornaMes(date('M'));


// make a table with proper month.
echo ("<table boarder=0 cellpadding=3 cellspacing=0>");
echo ("<tr bgcolor=#F9F9F9><td colspan=7 align=center><font color=black><b>$monthname $year</b></font></td></tr>");
echo ("<tr bgcolor=#F9F9F9><td align=center width=20><b><font color=black>D</font></b></td><td align=center width=20><b><font color=black>S</font></b></td><td align=center width=20><b><font color=black>T</font></b></td><td align=center width=20><b><font color=black>Q</font></b></td><td align=center width=20><b><font color=black>Q</font></b></td><td align=center width=20><b><font color=black>S</font></b></td><td align=center width=20><b><font color=black>S</font></b></td></tr>\n");
$monthstart = date("w", $timestamp);

if ($monthstart ==0) {
    $monthstart=7;
}

$lastday = date("d", mktime (0, 0, 0, $month+1, 0, $year));
$startdate = -$monthstart;

for ($k = 1; $k<=6; $k++) {//print 6 rows.
echo ("<tr bgcolor=white>");
	for ($i = 1; $i <= 7; $i++) {//use 7 coloms
		$startdate++;
		if (($startdate <= 0) || ($startdate > $lastday)) {
			echo ("<td bgcolor=#FFFFFF> &nbsp</td>");
		} elseif (($startdate >= 1) && ($startdate <= $lastday)) {
				
				if($dataMsg[$startdate]!=""){
					$totalMsg = explode("|",$dataMsg[$startdate]);
					settype($totalMsg[1], "integer");
						if($totalMsg[1] > 1){
							$msg = "mensagens neste dia";
						} else {
							$msg = "mensagem neste dia";
						}
						
					echo ("<td align=center><a href='#' title='".$totalMsg[1]." $msg'><span class='verdana_11_bold color'>$startdate</span></a></td>");
				} else {
					echo ("<td align=center>$startdate</td>");
				}
			
			
			
			
		}
	}
    echo ("</tr>\n");
}

echo ("</table>\n");
?></td>
  </tr>
</table>
<br />