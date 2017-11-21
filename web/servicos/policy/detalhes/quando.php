<?php 	require_once("../includes/autentica.php");

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_quando = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_quando = $_GET['pol_apl_codigo'];
}

mysql_select_db($database_policy, $policy);
$query_quando = "select DATE_FORMAT(pol_aud_momento, '%m/%Y') as MES,  COUNT(pol_apl_codigo) as ACESSOS  from pol_auditoria Where pol_apl_codigo = $colname_quando group by MES order by DATE_FORMAT(pol_aud_momento, '%Y/%m')";
$quando = mysql_query($query_quando, $policy) or die(mysql_error());
$row_quando = mysql_fetch_assoc($quando);
$totalRows_quando = mysql_num_rows($quando);

if(!isset($_SESSION['mesesCompletos'])){
	
	$TodosMeses = array();
	do{
		array_push($TodosMeses,$row_quando['MES']);
	}while($row_quando = mysql_fetch_assoc($quando));
	
	$_SESSION['mesesCompletos'] = $TodosMeses;
}

$quando = mysql_query($query_quando, $policy) or die(mysql_error());
?>
<table width="575" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="10" width="80" valign="top">&nbsp;</td>
    <td height="10" width="80" valign="top">&nbsp;</td>
    <td height="10" width="80" valign="top">&nbsp;</td>
    <td height="10" width="80" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
  <?php 
if ( $totalRows_quando > 0 ) { 
  		$contador=0;
  	 while ( $row_quando = mysql_fetch_assoc($quando) ) { 
		if ( $contador >= 4 ) {
			$contador = 0;
			echo '</tr>
			<tr><td colspan="4"></td></tr>
			     <tr>';
		} 
	?>
    <td width="80" height="70" align="center" valign="top" class="blocoOFF" id="bloco_<?php echo $row_quando['MES']; ?>" style="cursor:pointer;" onclick="location.href='regra.php?pol_apl_codigo=<?php echo $colname_quando; ?>&quando_dias=true&mes=<?php echo $row_quando['MES']?>'" onmouseover="TrocaFundoCalendario('bloco_<?php echo $row_quando['MES']; ?>');" onmouseout="TrocaFundoCalendario('bloco_<?php echo $row_quando['MES']; ?>');">
    
		<table width="115" align="center" cellpadding="0" cellspacing="0" style="margin-left:5px;margin-top:5px">
          <tr>
            <td width="25" rowspan="2" valign="middle">
            <a href="#"><img src="/e-solution/servicos/policy/images/calendario.gif" border="0" align="absmiddle" />        </a></td>
            <td width="183" height="20" valign="bottom" class="verdana_11">
              <a href="#">
              <?php 
			  $mes = substr($row_quando['MES'],0,2);
		echo RetornaMes($mes)." / <strong style='font-size:10px;'>".substr($row_quando['MES'],3)."</strong>"; ?>        
            </a></td>
          </tr>
          <tr>
            <td valign="top" class="verdana_11">
            <?php echo $b=$row_quando['ACESSOS']; ?> <?php if($row_quando['ACESSOS']<2){ ?>acesso<?php }else{ ?>acessos<?php } ?></td>
        </tr>
      </table>
   </td>
  <?php 
  	$contador+=1;
  }  ?>
  </tr>
<?php } else { ?>
  <tr>
    <td height="10" colspan="4" valign="top">N&atilde;o h&aacute; registros cadastrados</td>
  </tr>
<?php } ?>   
</table>