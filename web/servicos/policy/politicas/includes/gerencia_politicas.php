<?php
class gerenciaPoliticas{
	//somente combo de condição
	public function comboCondicao($nmCombo, $selecionado){
		//Inicio
		$select = '<select name="'.$nmCombo.'" id="'.$nmCombo.'" class="verdana_9" style="margin-left:5px;">';
		//Meio - opções
		$opcoes = array("=",">","<","<>","inicio","contenha","fim");
			foreach($opcoes as $indice=>$valor){
				$selected = $selecionado==$valor?"selected='selected'":"";
				$select.= '<option value="'.$valor.'" '.$selected.'>'.$valor.'</option>';
			}
		unset($opcoes);//destrói o array
		//Fim
		$select.= '</select>';
		return $select;	
	}
	//somente para checkbox -- UTILIZADO PARA CONDIÇÃO E ORDENAÇÃO
	public function checkBox($nmcheck, $selecionado){
		$checked = $selecionado!=""?"checked='checked'":"";
		$check = '<input type="checkbox" name="'.$nmcheck.'" id="'.$nmcheck.'" '.$checked.'>';
		
		return $check;
	}
	//somente para retorno de outra página
	public function inputPadrao($nmInput, $valor, $complemento){
		$input = '<input name="'.$nmInput.'" id="'.$nmInput.'" type="text" class="back_Campos" value="'.$valor.'" '.$complemento.'>';
		return $input;
	}
	//combo de Números
	public function comboNumerico($nmCombo, $max, $ordemAtual, $selecionado){
		//Inicio
		$select = '<select name="'.$nmCombo.'" id="'.$nmCombo.'" class="verdana_9" style="float:left">';
		//Meio - opções
			for($a=1; $a<=$max; $a++){	
				if($selecionado!=""){
					$selected = $selecionado==$a?"selected='selected'":"";
				} else {
					$selected = $ordemAtual==$a?"selected='selected'":"";
				}
				$select.= '<option value="'.$a.'" '.$selected.'>'.$a.'</option>';
			}
		//Fim
		$select.= '</select>';
		return $select;	
	}
	//combo ASC/DESC
	public function comboOrdenacao($nmCombo, $selecionado){
		//Inicio
		$select = '<select name="'.$nmCombo.'" id="'.$nmCombo.'" class="verdana_9" style="margin-left:5px;">';
		//Meio - opções
		$opcoes = array("ASC|Crescente","DESC|Decrescente");
			foreach($opcoes as $indice=>$valor){
				$valor = explode("|",$valor);
				$selected = $selecionado==$valor[0]?"selected='selected'":"";
				$select.= '<option value="'.$valor[0].'" '.$selected.'>'.$valor[1].'</option>';
			}
		unset($opcoes);//destrói o array
		//Fim
		$select.= '</select>';
		return $select;	
	}
}
?>