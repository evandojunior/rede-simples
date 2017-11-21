<?php
$readOnly = isset($readOnly) ? $readOnly : "";

			if($tamanho > 50)
			{
				$size = "50";
			}else{
				$size = $tamanho;
			}
					
					
				switch($tipoDeCampo)
				{

                    case "hidden":
                        echo '<input type="hidden" id="' . $nomeFisico . '" value="' . $campo_exibido . '" class="back_input" name="' . $nomeFisico . '" maxlength="'.$tamanho.'" size="'.$size.'" '.$readOnly.'/>';
                        break;
		
					//================Campo texto simples
					case "correio_eletronico":
						echo '<input type="text" id="' . $nomeFisico . '" value="' . $campo_exibido . '" class="back_input" name="' . $nomeFisico . '" maxlength="'.$tamanho.'" size="'.$size.'" '.$readOnly.' title="'.$observacao.'" />';
					
					break;
					case "texto_simples":
						echo '<input type="text" id="' . $nomeFisico . '" value="' . $campo_exibido . '" class="back_input" name="' . $nomeFisico . '" maxlength="'.$tamanho.'" size="'.$size.'" '.$readOnly.' title="'.$observacao.'" />';
					break;
					
					//====================Campo Data
					case "data":
					echo '<input name="'.$nomeFisico.'" type="text" class="back_input"  id="'.$nomeFisico.'" size="13" value="'.retornaData($campo_exibido).'" onKeyPress="MascaraData(event, this)" maxlength="10" '.$readOnly.' title="'.$observacao.'" />';
					echo '<input type="button" style="width:33px;height:21px;" class="botao_calendar" onClick="displayCalendar(document.updateFluxo.'.$nomeFisico.',\'dd/mm/yyyy\',this)" '.$readOnly.'/>';					
					break;

					//=====================Campo Hora editável
					case "horario_editavel";

					if($valorPadrao != "")
					{
						$Data = mysql_date_para_humano($valorPadrao);
					}else{
						$Data = date('d') . "/" . date('m') . "/" . date('Y');
					}
					
					echo '<input name="Data'.$nomeFisico.'" type="text" class="back_input"  id="Data'.$nomeFisico.'" size="13" value="'.$Data.'" onKeyPress="MascaraData(event, this)" maxlength="10" '.$readOnly.' title="'.$observacao.'" />';
					echo '<input type="button" style="width:33px;height:21px;" class="botao_calendar" onClick="displayCalendar(document.updateFluxo.Data'.$nomeFisico.',\'dd/mm/yyyy\',this) '.$readOnly.'" title="'.$observacao.'" />';					

							echo '&nbsp;&nbsp;&nbsp;';
					if($valorPadrao != "")
					{
							$horario = mysql_datetime_para_humano($valorPadrao);
							//02/01/2008 19:31:00
							$hora = substr($horario,11,2);
							$minuto = substr($horario,14,2);
							$segundo = substr($horario,17,2);
							
							switch($hora)
							{
								case 13: $hora_exibe = "01";
								break;
								
								case 14: $hora_exibe = "02";
								break;
								
								case 15: $hora_exibe = "03";
								break;
								
								case 16: $hora_exibe = "04";
								break;
								
								case 17: $hora_exibe = "05";
								break;
								
								case 18: $hora_exibe = "06";
								break;
								
								case 19: $hora_exibe = "07";
								break;
								
								case 20: $hora_exibe = "08";
								break;
								
								case 21: $hora_exibe = "09";
								break;
								
								case 22: $hora_exibe = "10";
								break;
								
								case 23: $hora_exibe = "11";
								break;
								
								case 24: $hora_exibe = "00";
								break;
								
								default: $hora_exibe = $hora;
								break;
							}
							
						}else{
						$hora_exibe = date('h');
						$hora = date('H');
						$minuto = date('i');
						$segundo = date('s');
						}
							$valoresHorario = explode(":",$valorPadrao);	
							echo '<select name="'.$nomeFisico.'HH" id="'.$nomeFisico.'HH" class="formulario2" class="back_input" '.$readOnly.' title="'.$observacao.'" >';
							for($x = 0; $x <= 12; $x++)
							{
								if($x < 10)
								{
									$x = 0 . $x;
								}
								if($x == $hora_exibe)
								{
									echo '<option value="'.$x.'" selected>'.$x.'</option>';							
								}else{
									echo '<option value="'.$x.'">'.$x.'</option>';							
								}
								
							}
							echo '</select>';
							
							echo '&nbsp;:&nbsp;';
							
							echo '<select name="'.$nomeFisico.'MM" id="'.$nomeFisico.'MM" class="formulario2" class="back_input" '.$readOnly.' title="'.$observacao.'" >';
							for($x = 0; $x < 60; $x++)
							{
								if($x < 10)
								{
									$x = 0 . $x;
								}
								if($x == $minuto)
								{
									echo '<option value="'.$x.'" selected>'.$x.'</option>';							
								}else{
									echo '<option value="'.$x.'">'.$x.'</option>';							
								}
								
							}
							echo '</select>';
							
							echo '&nbsp;:&nbsp;';
							
							echo '<select name="'.$nomeFisico.'SS" id="'.$nomeFisico.'SS" class="back_input" '.$readOnly.' title="'.$observacao.'" >';
							for($x = 0; $x < 60; $x++)
							{
								if($x < 10)
								{
									$x = 0 . $x;
								}
								if($x == $segundo)
								{
									echo '<option value="'.$x.'" selected>'.$x.'</option>';							
								}else{
									echo '<option value="'.$x.'">'.$x.'</option>';							
								}
								
							}
							echo '</select>';
							
							echo '&nbsp;&nbsp;&nbsp;';
							if($hora <= 11)
							{
								$am = 'selected';
								$pm = '';
							}else{
								$am = '';
								$pm = 'selected';
							}
							echo '<select name="am_pm' . $nomeFisico. '" class="back_input" '.$readOnly.' title="'.$observacao.'" >';
									echo '<option value="AM" ' .$am. '>AM</option>';
									echo '<option value="PM" ' .$pm. '>PM</option>';
							echo '</select>';

					break;
					
					//================Campo tipo TimeStamp
					case "time_stamp":
						echo date('d') . "/" . date("m") . "/" . date("Y") . " " . date("H") . ":" . date("i") . ":" . date("s");
						$dataBanco = date('Y') . "-" . date("m") . "-" . date("d") . " " . date("H") . ":" . date("i") . ":" . date("s");
						echo '<input type="hidden" name="TS' . $nomeFisico . '" id="TS' . $nomeFisico . '" value="' . $dataBanco . '" '.$readOnly.' title="'.$observacao.'" />';
					break;
					
					//=============Endereço web
					case "endereco_web":
						
							echo '<input type="text" name="'.$nomeFisico . '" id="$nomeFisico" value="' . $valorPadrao . '" title="'.$observacao.'"  class="back_input" maxlength="'.$tamanho.'" size="'.$size.'" '.$readOnly.' />';
						break;		
						

					//========Lista de opções
					case "lista_opcoes":
						//Pergunto se existe $editListagem, pois é uma necessidade de utilizar esta inclusão em dois arquivos. Na edição eu pego o valor definido anteriormente, e devo mostra-lo como default no combo.
						if($editListagem != "") 
						{
								$valoresLista = explode("|",$editListagem);
		
									echo '<select name="'.$nomeFisico.'" class="back_input" id="'.$nomeFisico.'" '.$readOnly.' title="'.$observacao.'" >';
												for($x = 0; $x < count($valoresLista) -1; $x++)
												{
													if($valoresLista[$x] == $valorPadrao)
													{
														echo '<option value="'.$valoresLista[$x].'" selected>'.$valoresLista[$x].'</option>';												
													}else{
														echo '<option value="'.$valoresLista[$x].'">'.$valoresLista[$x].'</option>';												
													}
												}
		
									echo '</select>';
						}else{
								$valoresLista = explode("|",$valorPadrao);
		
									echo '<select name="'.$nomeFisico.'" class="formulario2" id="'.$nomeFisico.'" '.$readOnly.' title="'.$observacao.'" >';
												for($x = 0; $x < count($valoresLista)-1; $x++)
												{
													echo '<option value="'.$valoresLista[$x].'">'.$valoresLista[$x].'</option>';												
												}
									echo '</select>';
						
						}

					
					break;	
					
					//========Lista dinâmica
					case "lista_dinamica":		
						
						//-- Faz uma pesquisa para saber qual tipo de tabela é: S:Simples A:Àrvore
						$sql = "
						SELECT bbh_cam_list_tipo
						FROM `bbh_campo_lista_dinamica`
						WHERE bbh_cam_list_titulo = '$editListagem'
						GROUP BY bbh_cam_list_titulo
						ORDER BY bbh_cam_list_titulo
						";
                        list($exec, $fetch, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
						//
						if( $fetch['bbh_cam_list_tipo'] == 'S' )
						{
							$sql = "
							SELECT bbh_cam_list_codigo, bbh_cam_list_valor
							FROM `bbh_campo_lista_dinamica`
							WHERE bbh_cam_list_titulo = '$editListagem'
							ORDER BY bbh_cam_list_titulo";
                            list($exec, $fetch, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);

							echo '<select name="'.$nomeFisico.'" class="formulario2" id="'.$nomeFisico.'" '.$readOnly.' title="'.$observacao.'" >';
							while( $fetch = mysqli_fetch_assoc($exec) )
							{
								echo '<option value="'.$fetch['bbh_cam_list_valor'].'"';
								echo (isset($valorPadrao) && $valorPadrao == $fetch['bbh_cam_list_valor'])?' selected="selected"':'';
								echo '>'.$fetch['bbh_cam_list_valor'].'</option>';	
							}
							echo '</select>';
						}
						else
						if( $fetch['bbh_cam_list_tipo'] == 'A' )
						{	
							$mostre = explode(' ', $valorPadrao);
							array_shift($mostre);
							$mostre = implode(' ', $mostre);
							echo '<input type="text" title="'.$observacao.'"  name="'.$nomeFisico.'_mostra" class="back_input" id="'.$nomeFisico.'_mostra" value="'.$mostre.'" readonly="readonly" onclick="windowOpen(\''.$nomeFisico.'\',\''.$editListagem.'\');" style="curso:point;width:600px;"/>';
							echo '<input type="hidden" name="'.$nomeFisico.'" class="back_input" id="'.$nomeFisico.'" value="'.$valorPadrao.'" />';
						}
						
					break;	
					
					//======Número decimal
					  case "numero_decimal":	
					  			$valor = Real($valorPadrao);
								if($valor == "0,00")
								{
									$valor = "";
								}
								echo '<input type="text" title="'.$observacao.'"  name="'.$nomeFisico.'" id="'.$nomeFisico.'" value="' . $valor . '" class="back_input" maxlength="'.$tamanho.'" onkeyPress="return(MascaraMoeda(this,\'.\',\',\',event));" size="30" '.$readOnly.'/>';
						break;
					//====Número inteiro
						case "numero":
							echo '<input type="text" title="'.$observacao.'"  name="'.$nomeFisico.'" id="'.$nomeFisico.'" value="' . $valorPadrao . '" class="back_input" maxlength="'.$tamanho.'" onKeyUp="SomenteNumerico(this);" size="30" '.$readOnly.'/>';
						break;
				
				//=========Texto longo
				case "texto_longo":
					echo '<textarea name="'.$nomeFisico.'" id="'.$nomeFisico.'" cols="49" title="'.$observacao.'"  rows="5" class="back_input" '.$readOnly.'>'.$valorPadrao.'</textarea>';
				break;

				case "json":
                    if(!empty($valorPadrao)) {
                        $objJson = json_decode(str_replace("`", "\"", $valorPadrao), true);
                        echo recursiveArrayToList($objJson);
                    }else{
                        echo "Sem preenchimento";
                    }
                    break;
				
				//Este é o fim até que alguém invente um tipo de dado novo			
					
				}

?>
