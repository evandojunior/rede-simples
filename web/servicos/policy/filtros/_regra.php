<?php require_once("../includes/functions.php");

//verifica se os checks estão ok
$Sql="";
if(isset($_GET['chk_quem'])){
	$Conteudo = $_GET['pol_quem'];
	$Condicao = $_GET['condicao_quem'];
	
	if($Condicao=='contenha'){
	 	$AjusteCondicao = "LIKE '%$Conteudo%'";
	} elseif($Condicao=='inicio'){
	 	$AjusteCondicao = "LIKE '$Conteudo%'";
	} elseif($Condicao=='fim'){
	 	$AjusteCondicao = "LIKE '%$Conteudo'";
	} else {
		$AjusteCondicao = $Condicao." '$Conteudo'";
	}

	
	$Sql.= " and  pol_aud_usuario ".$AjusteCondicao;
	$Quem = $AjusteCondicao;
}

if(isset($_GET['chk_quando'])){
	$Sql.= " and  pol_aud_momento >= '".$_GET['data_inicio']."' and pol_aud_momento <='".$_GET['data_fim']."'";
	$Periodo = "Inicio: ".$_GET['data_inicio']." &nbsp;&nbsp;Fim:".$_GET['data_fim'];
}

if(isset($_GET['chk_onde'])){
	$Conteudo = $_GET['pol_onde'];
	$Condicao = $_GET['condicao_onde'];
	
	if($Condicao=='contenha'){
	 	$AjusteCondicao = "LIKE '%$Conteudo%'";
	} elseif($Condicao=='inicio'){
	 	$AjusteCondicao = "LIKE '$Conteudo%'";
	} elseif($Condicao=='fim'){
	 	$AjusteCondicao = "LIKE '%$Conteudo'";
	} else {
		$AjusteCondicao = $Condicao." '$Conteudo'";
	}
	
	$Sql.= " and  pol_aud_ip ".$AjusteCondicao;
	$Onde = $AjusteCondicao;
}

if(isset($_GET['chk_oque'])){
	$Conteudo1 = $_GET['pol_oque'];
 	$Condicao1 = $_GET['condicao_oque'];
	
		
	if($Condicao1=='contenha'){
	 	$AjusteCondicao1 = "LIKE '%".($_GET['pol_oque'])."%'";
	} elseif($Condicao1=='inicio'){
	 	$AjusteCondicao1 = "LIKE '".$Conteudo1."%'";
	} elseif($Condicao1=='fim'){
	 	$AjusteCondicao1 = "LIKE '%".$Conteudo1."'";
	} else {
	echo	$AjusteCondicao1 = $Condicao1."'".($_GET['pol_oque'])."'";
	}
  	
	$Sql.= " and pol_aud_acao ".$AjusteCondicao1;
	$oQue = $AjusteCondicao1;
}

if(isset($_GET['chk_relevancia'])){
	$Conteudo = $_GET['pol_relevancia'];
	$Condicao = $_GET['condicao_relevancia'];
	
	if($Condicao=='contenha'){
	 	$AjusteCondicao = "LIKE '%$Conteudo%'";
	} elseif($Condicao=='inicio'){
	 	$AjusteCondicao = "LIKE '$Conteudo%'";
	} elseif($Condicao=='fim'){
	 	$AjusteCondicao = "LIKE '%$Conteudo'";
	} else {
		$AjusteCondicao = $Condicao." '$Conteudo'";
	}
	
	$Sql.= " and  pol_aud_relevancia ".$AjusteCondicao;
 $Relev = $AjusteCondicao;

}
?>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Escolha a ordena&ccedil;&atilde;o desejada</strong>
    
    <span class="verdana_11_bold" id="voltar" style="float:right; margin-top:-15px;"><a href='#' onclick="return LoadFiltros(<?php echo $_GET['pol_apl_codigo']; ?>);">.: Voltar :.</a></span>
    </td>
  </tr>
  <tr>
    <td height="20" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
    <td  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
  </tr>

<?php if(isset($_GET['chk_quem'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Quem &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo str_replace("'","",$Quem);?></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_quando'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Quando &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo str_replace("'","",$Periodo);?></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_onde'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"> Onde &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo str_replace("'","",$Onde); ?></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_oque'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">O qu&ecirc; &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $_GET['pol_oque'];  ?></td>
    </tr>
<?php } ?>
<?php if(isset($_GET['chk_relevancia'])){ ?>
    <tr>
      <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;">Relev&acirc;ncia &nbsp;</td>
      <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo str_replace("'","",$Relev); ?></td>
    </tr>
<?php } ?>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
</table>
<form name="form1" id="form1">
<?php
if (isset($_GET)) {  
foreach($_GET as $chave=>$valor ) {
$$chave = $valor; 
 ?>
<input type="hidden" value="<?php echo $valor; ?>" id="" name="" />

<?php
  }
} 
?>

<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <?php $Ordem = "1"; ?>

    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_quem" id="chk_quem">
      </label></td>
      <td width="18%" height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_quem" class="verdana_9" id="order_quem" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==$Ordem){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Quem :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_quem" class="formulario2" id="estr_quem">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_quando" id="chk_quando">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_quando" class="verdana_9" id="order_quando" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==2){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Quando :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_quando" class="formulario2" id="estr_quando">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_onde" id="chk_onde">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;">
    <select name="order_onde" class="verdana_9" id="order_onde" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==3){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Onde :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_onde" class="formulario2" id="estr_onde">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_oque" id="chk_oque">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_oque" class="verdana_9" id="order_oque" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==4){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      O qu&ecirc; :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_oque" class="formulario2" id="estr_oque">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
        <input type="checkbox" name="chk_relevancia" id="chk_relevancia">
      </label></td>
      <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">
    <select name="order_relevancia" class="verdana_9" id="order_relevancia" style="float:left">
         <?php for($a=1; $a<=5; $a++) {?>
            <option <?php if($a==5){ echo 'selected'; } ?> value='<?php echo $a; ?>'><?php echo $a; ?></option>
         <?php } ?>   
    </select>
      Relev&acirc;ncia :&nbsp;</td>
      <td width="78%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
        <select name="estr_relevancia" class="formulario2" id="estr_relevancia">
          <option value="ASC">Crescente</option>
          <option value="DESC">Decrescente</option>
        </select>
      </td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
      <td align="right" bgcolor="#FFFFFF"><input name="sqlWhere" type="hidden" id="sqlWhere" value="<?php echo $Sql; ?>">
        <input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>">
          <input name="button" type="button" class="back_input" id="button" value="Avancar" onClick="return enviaRegra('/e-solution/servicos/policy/detalhes/detalhes.php');" style="cursor:pointer">
        &nbsp;</td>
    </tr>
  <tr>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>