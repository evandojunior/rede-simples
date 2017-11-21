<?php
if(!isset($_SESSION)){session_start();}
//recuperação de variáveis do GET e SESSÃO
if (isset($_GET["page"])) {
	require_once("../../includes/autentica.php");
	require_once("../../includes/functions.php");
	require_once("../../fluxos/modelosFluxos/detalhamento/includes/functions.php");
}

//var_dump($_GET);

//-- SQL Paginação
$query_listaDinamica = "SELECT count(*) FROM bbh_campo_lista_dinamica group by bbh_cam_list_titulo asc ";
list($listaDinamica, $rows, $totalRows_listaDinamica) = executeQuery($bbhive, $database_bbhive, $query_listaDinamica, $initResult = false);
 //$totalRows_listaDinamica = $totalRows_listaDinamica[0];
 
//--Paginação
$page 		= "1";
$nElements 	= "500";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbhive/configuracao/lista_dinamica/index.php?Ts='.$_SERVER['REQUEST_TIME'];
$exibe			= 'conteudoGeral';
$pages 			= ceil($totalRows_listaDinamica/$nElements);


//-- SQL lista
$query_listaDinamica = "SELECT * FROM bbh_campo_lista_dinamica group by bbh_cam_list_titulo asc limit $Inicio,$nElements";
list($listaDinamica, $row_listaDinamica, $totalRows_listaDinamica) = executeQuery($bbhive, $database_bbhive, $query_listaDinamica);


?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr>
    <td>
    
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de lista din&acirc;mica</td>
  </tr>
  <tr>
    <td height="8"></td>
  </tr>
</table>

<div style="position:absolute; margin-left:-2px;" id="carregaTipo"></div>
<div style="position:absolute;" id="loadInser" class="legandaLabel11"></div>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  
  <tr class="legandaLabel11">
    <td width="17%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td width="67%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td colspan="4" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">
      <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">
        <img src="/e-solution/servicos/bbhive/images/novo.gif" alt="Nova lista din&acirc;mica" border="0" align="absmiddle" /></a>
    </td>
  </tr>
  <tr class="legandaLabel11">
    <td align="left" class="verdana_11_bold">T&iacute;tulo</td>
    <td height="25" align="left" class="verdana_11_bold">Tipo</td>
    <td width="4%" align="center">&nbsp;</td>
    <td width="4%" align="center">&nbsp;</td>
    <td width="4%" align="center">&nbsp;</td>
    <td width="4%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="1" colspan="6" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
   <?php if ($totalRows_listaDinamica > 0) { // Show if recordset not empty ?>
      <?php do { ?>
      <tr class="legandaLabel11">
        <td align="left" ><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $row_listaDinamica['bbh_cam_list_titulo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">&nbsp;<?php echo $t=$row_listaDinamica['bbh_cam_list_titulo']; ?></a></td>
        <td height="25" align="left" ><?php 
			if($row_listaDinamica['bbh_cam_list_tipo'] == 'S'){
				echo "Simples"; 
			}else{
				echo "&Aacute;rvore";
			}
			?>          &nbsp; &nbsp;</td>
        <?php 
			// SQL quantidade de registros
			$query_quantidade = "SELECT count(*) as total
							FROM bbh_campo_lista_dinamica
							where bbh_cam_list_titulo = '".$row_listaDinamica['bbh_cam_list_titulo']."'";
            list($Quantidade, $row_quantidade, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_quantidade);

			?>
        <td align="center"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/gerenciamento/index.php?bbh_cam_list_titulo=<?php echo $row_listaDinamica['bbh_cam_list_titulo']; ?>','menuEsquerda|conteudoGeral');" style="color:#0099FF"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" alt="H&aacute; <?php echo $row_quantidade['total'];?> registro(s) nesta lista" border="0" align="absmiddle" /></a></td>
        <td align="left"><?php echo $total=($row_quantidade['total']-1);?></td>
        <td align="center"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/editar.php?bbh_cam_list_codigo=<?php echo $row_listaDinamica['bbh_cam_list_codigo']; ?>&nm=<?php echo $row_listaDinamica['bbh_cam_list_titulo'];?>','menuEsquerda|conteudoGeral');" style="color:#0099FF"> <img src="/e-solution/servicos/bbhive/images/editar.gif" alt="Editar lista din&acirc;mica" border="0" align="absmiddle" /></a></td>
        <td align="center">
          <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/excluir.php?bbh_cam_list_codigo=<?php echo $row_listaDinamica['bbh_cam_list_codigo']; ?>&nm=<?php echo $row_listaDinamica['bbh_cam_list_titulo'];?>','menuEsquerda|conteudoGeral');" style="color:#0099FF">
            <img src="/e-solution/servicos/bbhive/images/excluir.gif" alt="Excluir lista din&acirc;mica" border="0" align="absmiddle" /></a> 
        </td>
  </tr>
    <tr>
   		<td height="1" colspan="9" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
    </tr>
 	<?php }while($row_listaDinamica = mysqli_fetch_assoc($listaDinamica)) ;
	  }
	?>
 
   <?php if ($totalRows_listaDinamica == 0) { ?>
  <tr class="legandaLabel11">
    <td height="25" colspan="6" align="left">&nbsp;&nbsp;<img src="/e-solution/servicos/bbhive/images/alerta.gif" width="13" height="11" align="absmiddle"> N&atilde;o existem listas criadas. Caso deseja criar uma nova, clique <a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=2|configuracao/lista_dinamica/novo.php','menuEsquerda|conteudoGeral');" style="color:#0099FF">aqui</a></td>
  </tr>
  <?php } ?>

 <tr class="legandaLabel11">
    <td height="22" colspan="6" align="center">&nbsp;</td>
  </tr>
  <tr class="legandaLabel11">
    <td height="5" colspan="6" align="center">
		<?php include('../includes/paginacao/paginacao.php');?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
<?php
mysqli_free_result($listaDinamica);
?>
<br />
