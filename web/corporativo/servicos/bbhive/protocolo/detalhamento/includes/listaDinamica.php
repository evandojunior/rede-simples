<?php

			if($tamanho > 50)
			{
				$size = "50";
			}else{
				$size = $tamanho;
			}
					
					
				switch($tipoDeCampo)
				{				
		
					//================Campo texto simples
					case "texto_simples":
					if($campo_exibido != "")
					{
						echo $campo_exibido;
					}else{
						echo "Sem preenchimento";
					}
					break;
					
					//====================Campo Data
					case "data":
					if($valorPadrao != "")
					{
						echo retornaData($valorPadrao);					
					}else{
						echo "Sem preenchimento";
					}
					break;

					//=====================Campo Hora editável
					case "horario_editavel";
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
							if($hora <= 11)
							{
								$manha_tarde = 'am';
							}else{
								$manha_tarde = 'pm';
							}
					echo mysql_date_para_humano($valorPadrao) . " " . $hora_exibe . ":" . $minuto . ":" . $segundo . " " . $manha_tarde;
							
					}else{
					  	echo "Sem preenchimento";
			        }

					break;
					
					//================Campo tipo TimeStamp
					case "time_stamp":
						if($valorPadrao != "")
						{
							$horario = mysql_datetime_para_humano($valorPadrao);
						}else{
							$horario = "";
						}
						if($valorPadrao != "")
						{
							echo $horario;
						}else{
					  	echo "Sem preenchimento";
				        }
				break;
					
					//=============Endereço web
					case "endereco_web":
						if($valorPadrao != "")
						{
							echo '<a href="'.$valorPadrao . '" target="_blank">' . $valorPadrao. '</a>';
						}else{
					  	echo "Sem preenchimento";
				        }
						break;		
					
					//=============E-mail
					case "correio_eletronico":
						if($valorPadrao != "")
						{
							echo '<a href="'.$valorPadrao . '" target="_blank">' . $valorPadrao. '</a>';
						}else{
					  	echo "Sem preenchimento";
				        }
						break;		
						

					//========Lista de opções
					case "lista_opcoes":
					
					
					if($valorPadrao != "")
					{
						if(isset($row_campos_detalhamento['bbh_cam_ind_nome']) && $row_campos_detalhamento['bbh_cam_ind_nome'] == 'bbh_ind_sigilo')
						{
							//
							// Lê as confirgurações
							$xmlParse = simplexml_load_file( $_SESSION['caminhoFisico']."/../database/servicos/bbhive/nivel_informacao.xml" );
							foreach( $xmlParse as $value ){ $values[ (int) $value['nivel'] ] = (string) $value['valor']; }
							// Fim das configurações
							//
							echo $values[ $valorPadrao ];
						}
						elseif(isset($row_campos_detalhamento['bbh_cam_ind_nome']) && $row_campos_detalhamento['bbh_cam_ind_nome'] == 'bbh_ind_confiabilidade_fonte')
						{
							$sql = "select ci.bbh_cam_ind_default as campo from bbh_campo_indicio as ci where ci.bbh_cam_ind_nome = 'bbh_ind_confiabilidade_fonte'";
                            list($cp, $row_cp, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
							//
							if(!empty($row_cp['campo'])){
								$valoresLista = explode("|",$row_cp['campo']);
								for($x = 0; $x < count($valoresLista); $x++)
								{
									if(substr($valoresLista[$x],0,1) == $valorPadrao)
									{
										echo $valoresLista[$x];	
										break;						
									}
								}
							}
							//echo $valorPadrao;	
						}
						elseif(isset($row_campos_detalhamento['bbh_cam_ind_nome']) && $row_campos_detalhamento['bbh_cam_ind_nome'] == 'bbh_ind_veracidade_informacao')
						{
							$sql = "select ci.bbh_cam_ind_default as campo from bbh_campo_indicio as ci where ci.bbh_cam_ind_nome = 'bbh_ind_veracidade_informacao'";
                            list($cp, $row_cp, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
							//
							if(!empty($row_cp['campo'])){
								$valoresLista = explode("|",$row_cp['campo']);
								for($x = 0; $x < count($valoresLista); $x++)
								{
									if(substr($valoresLista[$x],0,1) == $valorPadrao)
									{
										echo $valoresLista[$x];	
										break;						
									}
								}
							}
							//echo "V: ". $valorPadrao;								
						}
						else
						{
							echo $valorPadrao;		
						}
					}else{
					  	echo "Sem preenchimento";
				    }
					break;			
					
					//======= Lista Dinamica
					case "lista_dinamica":
					if($valorPadrao != "")
					{
						if( preg_match("|([0-9]{2}\.?)+\s.*|", trim($valorPadrao)) )
						{
							$time = time()+rand();
							$valorPadrao = array_shift( $d = explode(' ', $valorPadrao));
							echo "<var id='container' style='display:none;'>descobreParentes('$valorPadrao','containerDV$time')</var>";
							echo "<div id='containerDV$time'>&nbsp;</div>";
						}
						else
						{
							echo $valorPadrao;
						}
					}else{
					  	echo "Sem preenchimento";
				    }
					break;				
					
					//======Número decimal
					  case "numero_decimal":	
					  if($valorPadrao != "")
					  {
						  echo	$valor = Real($valorPadrao);
					  }else{
					  	echo "Sem preenchimento";
					  }
				break;
					//====Número inteiro
						case "numero":
						if($valorPadrao != "")
						{
							echo $valorPadrao;
						}else{
						  	echo "Sem preenchimento";
						}
						break;

				
				//=========Texto longo
				case "texto_longo":
						if($valorPadrao != "")
						{
							echo nl2br($valorPadrao);
						}else{
						  	echo "Sem preenchimento";
						}
				break;


                    //=========JSON
                    case "json":
                        if($valorPadrao != "") {
                            $objJson = json_decode(str_replace("`", "\"", $valorPadrao), true);
                            echo recursiveArrayToList($objJson);
                        }else{
                            echo "Sem preenchimento";
                        }
                        break;
				
				//Este é o fim até que alguém invente um tipo de dado novo			
					
				}

?>