<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	//select para descobrir o total de registros na base
	$query_dep = "select d.bbh_dep_codigo, d.bbh_dep_nome from bbh_indicio i
				 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
				 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
				 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
				  group by d.bbh_dep_codigo
					order by d.bbh_dep_nome asc";
    list($dep, $rows, $totalRows_dep) = executeQuery($bbhive, $database_bbhive, $query_dep, $initResult = false);

	$query_tip = "	select t.bbh_tip_codigo, t.bbh_tip_nome from bbh_indicio i
						 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
						  group by t.bbh_tip_codigo
							order by t.bbh_tip_nome asc";
    list($tip, $rows, $totalRows_tip) = executeQuery($bbhive, $database_bbhive, $query_tip, $initResult = false);
	
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/central_indicios/busca_profissional/busca.php?Ts='.$TimeStamp;
	//Busca por iniciais
	$onClick  		= "onclick=\"OpenAjaxPostCmd('".$homeDestino."&inicia=x','resultBusca','&1=1','Consultando informa&ccedil;&otilde;es...','resultBusca','2','2');\"";
	//Carregamento da página automática
	$carregaPagina  = "OpenAjaxPostCmd('".$homeDestino."','resultBusca','&1=1','Carregando informa&ccedil;&otilde;es...','resultBusca','2','2');";
	//Busca pór formulário
	$acao 			= "OpenAjaxPostCmd('".$homeDestino."','resultBusca','form1','Carregando informa&ccedil;&otilde;es...','resultBusca','1','2');";
	//--
?><var style="display:none">txtSimples('tagPerfil', 'Consulta de <?php echo $_SESSION['componentesNome']; ?>')</var>
<form name="form1" id="form1" style="margin-top:-1px;">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="3" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca Central de <?php echo $_SESSION['componentesNome']; ?></strong></td>
      </tr>
      <tr>
        <td height="22" colspan="3" align="left" bgcolor="#FFFFFF" class="verdana_11"><?php 
		$nProt	= "35px";
		$nDtP	= "30px";
		$ofc	= "83px";
		$desc	= "35px";
		require_once("../../consulta/busca_protocolo.php"); ?></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" width="4%"><input type="checkbox" name="busca_tipo" id="busca_tipo" /></td>
        <td class="verdana_11">&nbsp;Por tipo :</td>
        <td class="verdana_11">
		<select name="bbh_tip_codigo" id="bbh_tip_codigo" class="verdana_9">
    	<?php while($row_tip = mysqli_fetch_assoc($tip)){ ?>
        	<option value="<?php echo $row_tip['bbh_tip_codigo']; ?>"><?php echo $row_tip['bbh_tip_nome']; ?></option>
        <?php } ?>
	    </select>
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7"><input type="checkbox" name="busca_cbarras" id="busca_cbarras" /></td>
        <td class="verdana_11">&nbsp;Por c&oacute;digo de barras :</td>
        <td class="verdana_11"><input name="bbh_ind_codigo_barras" type="text" class="back_Campos" id="bbh_ind_codigo_barras"  style="height:17px;border:#E3D6A4 solid 1px;" size="20"/></td>
      </tr>
      <tr>
        <td width="2%" height="22" align="center" bgcolor="#EFEFE7"><label>
          <input type="checkbox" name="busca_responsavel" id="busca_responsavel" />
        </label></td>
        <td width="21%" class="verdana_11">&nbsp;Por respons&aacute;vel :
        </td>
        <td width="77%" class="verdana_11"><input name="bbh_busca_responsavel" type="text" id="bbh_busca_responsavel" size="40" class="back_Campos"  style="height:17px;border:#E3D6A4 solid 1px;margin-left:0px;"/></td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7" class="verdana_11"><input type="checkbox" name="busca_departamento" id="busca_departamento" /></td>
        <td>&nbsp;Por departamento :</td>
        <td>
        
		<select name="bbh_dep_codigo" id="bbh_dep_codigo" class="verdana_9">
    	<?php while($row_dep = mysqli_fetch_assoc($dep)){ ?>
        	<option value="<?php echo $row_dep['bbh_dep_codigo']; ?>"><?php echo $row_dep['bbh_dep_nome']; ?></option>
        <?php } ?>
	    </select>
        </td>
      </tr>
      <tr>
        <td height="22" colspan="3" align="right" bgcolor="#EFEFE7" class="verdana_11"><input class="formulario2" id="web" type="button" value="Pesquisar" name="web"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="return <?php echo $acao; ?>"/>&nbsp;</td>
      </tr>
      <tr>
        <td height="1" colspan="3" align="right" bgcolor="#FFFFFF" class="verdana_11"></td>
      </tr>
  </table>
</form> 
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
      
<tr>
        <td width="56" height="1"></td>
        <td width="155" valign="top" height="1"></td>
        <td height="1"></td>
        <td width="55" height="1"></td>
        <td width="155" valign="top" height="1"></td>
      </tr>
      <tr>
        <td height="26" colspan="5" align="left" background="/corporativo/servicos/bbhive/images/back_msg.jpg"><label style="margin-left:5px"><a href="#" <?php echo str_replace("inicia=x","inicia=a",$onClick)?>>A</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=b",$onClick)?>>B</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=c",$onClick)?>>C</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=d",$onClick)?>>D</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=e",$onClick)?>>E</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=f",$onClick)?>>F</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=g",$onClick)?>>G</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=h",$onClick)?>>H</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=i",$onClick)?>>I</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=j",$onClick)?>>J</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=k",$onClick)?>>K</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=l",$onClick)?>>L</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=m",$onClick)?>>M</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=n",$onClick)?>>N</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=o",$onClick)?>>O</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=p",$onClick)?>>P</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=q",$onClick)?>>Q</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=r",$onClick)?>>R</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=s",$onClick)?>>S</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=t",$onClick)?>>T</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=u",$onClick)?>>U</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=v",$onClick)?>>V</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=x",$onClick)?>>X</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=y",$onClick)?>>Y</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=w",$onClick)?>>W</a></label>
            <label>-<a href="#" <?php echo str_replace("inicia=x","inicia=z",$onClick)?>>Z</a></label> 
            -&nbsp;
          <label><a href="#" <?php echo str_replace("inicia=x","inicia=true",$onClick)?>>todos</a></label>        </td>
      </tr>
      <tr>
        <td height="1" colspan="5" align="center" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
    </table>
<div id="resultBusca" class="verdana_12"></div>
<var style="display:none"><?php echo $carregaPagina;  ?></var>