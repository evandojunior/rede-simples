<?php
require_once("busca_dados.php");

$Nome = '&nbsp;'.$row_dados['bbh_usu_nome'];
	if($row_dados['bbh_usu_sexo']==1){
		$s  = "Masculino";
	} else {
		$s = "Feminino";
	}

	$Sexo 				= '&nbsp;'.$s;
	$TelComercial 		= '&nbsp;'.$row_dados['bbh_usu_tel_comercial'];
	$TelResidencial 	= '&nbsp;'.$row_dados['bbh_usu_tel_residencial'];
	$Celular 			= '&nbsp;'.$row_dados['bbh_usu_tel_celular'];
	$TelRecado 			= '&nbsp;'.$row_dados['bbh_usu_tel_recados'];
	$Fax 				= '&nbsp;'.$row_dados['bbh_usu_fax'];
	$EmailAlternativo 	= '&nbsp;'.$row_dados['bbh_usu_email_alternativo'];
	$Endereco 			= '&nbsp;'.$row_dados['bbh_usu_endereco'];
	$Cidade 			= '&nbsp;'.$row_dados['bbh_usu_cidade'];
	$Estado 			= '&nbsp;'.$row_dados['bbh_usu_estado'];
	$CEP 				= '&nbsp;'.$row_dados['bbh_usu_cep'];
	$Pais 				= '&nbsp;'.$row_dados['bbh_usu_pais'];
?>
<var style="display:none">txtSimples('bbh_usu_nome', '<?php echo $Nome; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_apelido', '<?php echo $row_dados['bbh_usu_apelido']; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_sexo', '<?php echo $Sexo; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_comercial', '<?php echo $TelComercial; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_residencial', '<?php echo $TelResidencial; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_celular', '<?php echo $Celular; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_recados', '<?php echo $TelRecado; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_fax', '<?php echo $Fax; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_email_alternativo', '<?php echo $EmailAlternativo; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_endereco', '<?php echo $Endereco; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_cidade', '<?php echo $Cidade; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_cep', '<?php echo $CEP; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_estado', '<?php echo $Estado; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_pais', '<?php echo $Pais; ?>')</var>
<var style="display:none">document.getElementById('btnEditar').style.display="block"</var>
<var style="display:none">document.getElementById('btnSalvar').style.display="none"</var>
<var style="display:none">document.getElementById('btnCancelar').style.display="none"</var>