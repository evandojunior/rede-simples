<?php

if (!function_exists("executeQuery")) {
    function executeQuery($linkConnection, $database, $querySQL, $initResult = true)
    {
        mysqli_select_db($linkConnection, $database);
        $result = mysqli_query($linkConnection, $querySQL) or die(mysqli_error($linkConnection));

        return [
            $result,
            $initResult ? @mysqli_fetch_assoc($result) : null,
            @mysqli_num_rows($result)
        ];
    }
}

if (!function_exists("arrumadata")) {
    function arrumadata($data_errada)
    {
        return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
    }
}

if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($linkConnection, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

        $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($linkConnection, $theValue) : mysqli_escape_string($linkConnection, $theValue);

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

if (!function_exists("listDynamicFormType")) {
    function listDynamicFormType()
    {
        return [
            "correio_eletronico" => "Correio eletrônico",
            "data" => "Data",
            "time_stamp" => "Data / Hora atual",
            "horario_editavel" => "Data / Hora editável",
            "endereco_web" => "Endereço web",
            "lista_opcoes" => "Lista de opções",
            "lista_dinamica" => "Lista dinâmica",
            "numero" => "Número",
            "numero_decimal" => "Número decimal",
            "texto_longo" => "Texto longo",
            "texto_simples" => "Texto simples",
            "hidden" => "Campo oculto",
            "json" => "Integração de sistemas (JSON)"
        ];
    }
}

if (!function_exists("parseDynamicFormType")) {
    function parseDynamicFormType()
    {
        $type = $_POST['bbh_cam_det_flu_tipo'];

        switch($type)
        {
            case "correio_eletronico":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['bbh_cam_det_flu_default'];
                break;

            case "data":
                $tamanho = '';
                $valor_padrao = !empty($_POST['theDate']) ?
                    substr($_POST['theDate'], 6, 4) . "-" . substr($_POST['theDate'], 3, 2) . "-" . substr($_POST['theDate'], 0, 2):
                    '';
                break;

            case "numero":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['bbh_cam_det_flu_default'];
                break;

            case "endereco_web":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['bbh_cam_det_flu_default'];
                break;

            case "lista_opcoes":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['menuCriadoValores'];
                break;

            case "lista_dinamica":
                $tamanho = 255;
                $valor_padrao = $_POST['menuListagemDinamica'];
                break;

            case "numero_decimal":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = str_replace(",", ".", str_replace(".", "", $_POST['bbh_cam_det_flu_default']));
                break;

            case "texto_longo":
                $linha = empty($_POST['texto_longoLinhaI']) ? 50 : $_POST['texto_longoLinhaI'];
                $coluna = empty($_POST['texto_longoColunaI']) ? 5 : $_POST['texto_longoColunaI'];

                $tamanho = $linha . "|" . $coluna;
                $valor_padrao = $_POST['bbh_cam_det_flu_defaultLongo'];
                break;

            case "texto_simples":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['bbh_cam_det_flu_default'];
                break;

            case "json":
            case "hidden":
                $tamanho = $_POST['bbh_cam_det_flu_tamanho'];
                $valor_padrao = $_POST['bbh_cam_det_flu_default'];
                break;

            case "horario":
                $tamanho = '';
                $valor_padrao = $_POST['hh'] . ":" . $_POST['mm'] . ":" . $_POST['ss'];
                break;
            case "time_stamp":
                $tamanho = '';
                $valor_padrao = '';
                break;
            case "horario_editavel":
                $tamanho = '';
                $valor_padrao = '';
                break;
        }

        return [$tamanho, $valor_padrao];
    }
}

if (!function_exists("retornaTitulo")) {
    function retornaTitulo($tipo)
    {
        switch ($tipo) {
            case "correio_eletronico":
                return "Correio eletrônico";
                break;

            case "data":
                return "Data";
                break;

            case "numero":
                return "Número";
                break;

            case "endereco_web":
                return "Endereço web";
                break;

            case "lista_opcoes":
                return "Lista de opções";
                break;

            case "lista_dinamica":
                return "Lista de dinâmica";
                break;

            case "numero_decimal":
                return "N&uacute;mero decimal";
                break;

            case "texto_longo":
                return "Texto longo";
                break;

            case "texto_simples":
                return "Texto simples";
                break;

            case "time_stamp":
                return "Hora data atual";
                break;

            case "horario_editavel":
                return "Hora data editável";
                break;

            case "hidden":
                return "Campo oculto";
                break;

            case "json":
                return "JSON";
                break;
        }
    }
}

if (!function_exists("trataCaracteres")) {
    function trataCaracteres($texto)
    {
        /* função que gera uma texto limpo pra virar URL:
           - limpa acentos e transforma em letra normal
           - limpa cedilha e transforma em c normal, o mesmo com o ñ
           - transforma espaços em hifen (-)
           - tira caracteres invalidos
          by Micox - elmicox.blogspot.com - www.ievolutionweb.com
        */
        //desconvertendo do padrão entitie (tipo &aacute; para á)
        $texto = html_entity_decode(strtolower($texto));
        //tirando os acentos preg_replace("/\n/", " ", $textoComTag);
        $texto = preg_replace('/[aáàãâä]/', 'a', $texto);
        $texto = preg_replace('/[eéèêë]/', 'e', $texto);
        $texto = preg_replace('/[iíìîï]/', 'i', $texto);
        $texto = preg_replace('/[oóòõôö]/', 'o', $texto);
        $texto = preg_replace('/[uúùûü]/', 'u', $texto);
        //parte que tira o cedilha e o ñ
        $texto = preg_replace('/ç/', 'c', $texto);
        $texto = preg_replace('/ñ/', 'n', $texto);
        //trocando espaço em branco por underline
        $texto = preg_replace('/( )/', '_', $texto);
        $texto = preg_replace('/[ ]/', '_', $texto);
        //tirando outros caracteres invalidos
        $texto = preg_replace('/[^a-z0-9\-]/', '_', $texto);
        //trocando duplo espaço (hifen) por 1 hifen só
        $texto = preg_replace('/[--]/', '_', $texto);
        $texto = preg_replace('/[-]/', '_', $texto);

        return strtolower($texto);
    }
}

if (!function_exists("descobreValorDinamico")) {
    function descobreValorDinamico($nomeCampo, $tipoCampo, $tamanhoCampo, $obrigatorio, $campoDefault)
    {
        //Função que descobre o valor da tabela a ser criada, o tipo, etc.
        $nome = "`" . $nomeCampo . "`";
        switch ($tipoCampo) {
            case "texto_simples":
            case "hidden":

                $tipo = " varchar";
                if ($tamanhoCampo > 255) {
                    $tamanho = "(" . 255 . ")";
                } else {
                    $tamanho = "(" . $tamanhoCampo . ")";
                }

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "correio_eletronico":

                $tipo = " varchar";

                if ($tamanhoCampo > 255) {
                    $tamanho = "(" . 255 . ")";
                } else {
                    $tamanho = "(" . $tamanhoCampo . ")";
                }

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "data":

                $tipo = " date";
                $tamanho = "";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "endereco_web":

                $tipo = " varchar";

                if ($tamanhoCampo > 255) {
                    $tamanho = "(" . 255 . ")";
                } else {
                    $tamanho = "(" . $tamanhoCampo . ")";
                }

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;
            case "time_stamp":

                $tipo = " datetime";
                $tamanho = "";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "horario_editavel":

                $tipo = " datetime";
                $tamanho = "";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "lista_opcoes":

                $tipo = " varchar";
                $tamanho = "(" . 255 . ")";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }
                break;
            case "lista_dinamica":

                $tipo = " varchar";
                $tamanho = "(" . 255 . ")";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }
                break;

            case "numero":

                $tipo = " int";

                if ($tamanhoCampo > 11) {
                    $tamanho = "(" . 11 . ")";
                } else {
                    $tamanho = "(" . $tamanhoCampo . ")";
                }

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "numero_decimal":

                $tipo = " double";

                if ($tamanhoCampo > 16) {
                    $tamanho = "(" . 16 . ",2)";
                } else {
                    $tamanho = "(" . $tamanhoCampo . ",2)";
                }

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }

                if ($campoDefault != "") {
                    $tamanho .= " default '" . $campoDefault . "'";
                }
                break;

            case "json":
            case "texto_longo":

                $tipo = " blob";
                $tamanho = "";

                if ($obrigatorio == 1) {
                    $tamanho .= " NOT NULL";
                }
                break;
        }

        return $nome . $tipo . $tamanho;
    }
}

if (!function_exists("Real")) {
    function Real($valor)
    {
        return number_format($valor, 2, ',', '.');;
    }
}


if (!function_exists("parseDynamicFormToArray")) {
    function parseDynamicFormToArray($bbhive, $database_bbhive, $formData)
    {
        $codigo_modelo_fluxo 	= $formData['bbh_mod_flu_codigo'];

        //Campos com preenchimento no início do processo
        $inicioProcesso         = isset($formData['cadastroInicio']) ? " AND bbh_cam_det_flu_preencher_inicio='1'" : "";

        //RecordSet dos campos
        $query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo
                                        INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo
                                        WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = {$codigo_modelo_fluxo} AND bbh_cam_det_flu_disponivel='1' {$inicioProcesso}";
        list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

        $listFields = [];
        while ($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)) {
            $tipoDeCampo = $row_campos_detalhamento['bbh_cam_det_flu_tipo'];
            $nomeFisico = $row_campos_detalhamento['bbh_cam_det_flu_nome'];

            switch ($tipoDeCampo) {
                case "correio_eletronico":
                case "endereco_web":
                case "lista_opcoes":
                case "lista_dinamica":
                case "texto_longo":
                case "texto_simples":
                case "hidden":
                case "json":
                    $valor = sprintf("'%s'", $formData[$nomeFisico]);
                    break;

                case "data":
                    $valor = !empty($formData[$nomeFisico]) ? substr($formData[$nomeFisico], 6, 4) . "-" . substr($formData[$nomeFisico], 3, 2) . "-" . substr($formData[$nomeFisico], 0, 2):
                        "NULL";
                    break;

                case "time_stamp":
                    $valor = sprintf("'%s'", $formData['TS'.$nomeFisico]);
                    break;

                case "horario_editavel":
                    $data = sprintf(
                        '%s-%s-%s',
                        substr($formData['Data'.$nomeFisico], 6, 4),
                        substr($formData['Data'.$nomeFisico], 3, 2),
                        substr($formData['Data'.$nomeFisico], 0, 2)
                    );
                    $am_pm = $formData['am_pm'.$nomeFisico];
                    $hora = $formData[$nomeFisico . "HH"];
                    $minuto = $formData[$nomeFisico . "MM"];
                    $segundo = $formData[$nomeFisico . "SS"];

                    $hora = $hora != 12 ? 12 + $hora : 12;
                    if($am_pm == 'AM') {
                        $hora = $hora != 12 ? $hora : "00";
                    }

                    $valor = sprintf("'%s'", $data . " ". $hora . ":" . $minuto . ":" . $segundo);
                    break;

                case "numero":
                    $valor = !empty($_POST[$nomeFisico]) ? $_POST[$nomeFisico] : "NULL";
                    break;

                case "numero_decimal":
                    $valor = !empty($_POST[$nomeFisico]) ? str_replace(",", ".", str_replace(".", "", $_POST[$nomeFisico])) : "NULL";
                    break;
            }

            $listFields[$nomeFisico] = $valor;
        }

        return $listFields;
    }
}

if (!function_exists("saveDynamicFormFromArray")) {
    function saveDynamicFormFromArray($bbhive, $database_bbhive, $formData)
    {
        $nomeTabelaFisica 		= $formData['nome_tabela'];
        $bbh_flu_codigo 		= $formData['bbh_flu_codigo'];

        // Checa se existe dado, pois senão será sempre UPDATE
        $query_tabela_fisica = "SELECT * FROM $nomeTabelaFisica WHERE bbh_flu_codigo = {$bbh_flu_codigo}";
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
        if($totalRows_tabela_fisica == 0) {
            $sqlInsercao = "INSERT INTO $nomeTabelaFisica(bbh_flu_codigo) VALUES({$bbh_flu_codigo})";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
        }

        $fields = parseDynamicFormToArray($bbhive, $database_bbhive, $formData);
        $fieldsWithValues = '';
        foreach ($fields as $nameField => $valueField) {
            $fieldsWithValues .= sprintf(", %s = %s", $nameField, $valueField);
        }

        // Atualiza informando todos os campos dinâmicos
        $sqlUpdate = sprintf(
            "UPDATE %s SET %s WHERE bbh_flu_codigo = %s",
            $nomeTabelaFisica,
            substr($fieldsWithValues, 1),
            $bbh_flu_codigo
        );

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlUpdate);
        return $Result1;
    }
}

if (!function_exists("parseDynamicProtocolDataType")) {
    function parseDynamicProtocolDataType($type, $arrayFields, $arrayValues)
    {
        $valorPadrao = $arrayValues[$arrayFields['bbh_cam_det_pro_nome']];
        $editListagem 	= $arrayValues['bbh_cam_det_pro_default'];
        $campo_exibido = empty($valorPadrao) ? $editListagem : $valorPadrao;

        switch($type)
        {
            //================Campo texto simples
            case "texto_simples":
                $defaultValue = !empty($campo_exibido) ? $campo_exibido : "Sem preenchimento";
                break;

            //====================Campo Data
            case "data":
                $defaultValue = !empty($valorPadrao) ? retornaData($valorPadrao) : "Sem preenchimento";
                break;

            //=====================Campo Hora editável
            case "horario_editavel";
                if(!empty($valorPadrao)) {
                    $defaultValue = null;
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
                    $manha_tarde = $hora <= 11 ? 'am' : 'pm';
                    $defaultValue = mysql_date_para_humano($valorPadrao) . " " . $hora_exibe . ":" . $minuto . ":" . $segundo . " " . $manha_tarde;
                }
                $defaultValue = !empty($defaultValue) ? $defaultValue : "Sem preenchimento";
                break;

            //================Campo tipo TimeStamp
            case "time_stamp":
                $defaultValue = !empty($valorPadrao) ? mysql_datetime_para_humano($valorPadrao) : "Sem preenchimento";
                break;

            //=============Endereço web
            case "endereco_web":
                $defaultValue = !empty($valorPadrao) ? '<a href="'.$valorPadrao . '" target="_blank">' . $valorPadrao. '</a>' : "Sem preenchimento";
                break;

            //=============E-mail
            case "correio_eletronico":
                $defaultValue = !empty($valorPadrao) ? '<a href="'.$valorPadrao . '" target="_blank">' . $valorPadrao. '</a>' : "Sem preenchimento";
                break;
            //========Lista de opções
            case "lista_opcoes":
                $defaultValue = !empty($valorPadrao) ? $valorPadrao : "Sem preenchimento";
                break;
            //======= Lista Dinamica
            case "lista_dinamica":
                $defaultValue = null;
                if($valorPadrao != "")
                {
                    if( preg_match("|([0-9]{2}\.?)+\s.*|", trim($valorPadrao)) )
                    {
                        $valorPadrao = array_shift( $d = explode(' ', $valorPadrao));
                        $defaultValue = "<var id='container' style='display:none;'>descobreParentes('$valorPadrao','containerDV')</var>";
                        $defaultValue .="<div id='containerDV'>&nbsp;</div>";
                    }
                    else
                    {
                        $defaultValue =$valorPadrao;
                    }
                }

                $defaultValue = !empty($defaultValue) ? $defaultValue : "Sem preenchimento";
                break;

            //======Número decimal
            case "numero_decimal":
                $defaultValue = !empty($valorPadrao) ? Real($valorPadrao) : "Sem preenchimento";
                break;
            //====Número inteiro
            case "numero":
                $defaultValue = !empty($valorPadrao) ? $valorPadrao : "Sem preenchimento";
                break;


            //=========Texto longo
            case "texto_longo":
                $defaultValue = !empty($valorPadrao) ? nl2br($valorPadrao) : "Sem preenchimento";
                break;
            //Este é o fim até que alguém invente um tipo de dado novo
        }

        return $defaultValue;
    }
}

if (!function_exists("resolveDiretorio")) {
    function resolveDiretorio($dirOnde)
    {
        $dirOnde = str_replace("/servicos/", "", $dirOnde);    //servicos
        $dirOnde = str_replace("/corporativo", "", $dirOnde);    //corporativo
        $dirOnde = str_replace("/e-solution", "", $dirOnde);    //e-solution
        $dirOnde = explode("/", $dirOnde);
        return $dirOnde[0];
    }
}

if (!function_exists("detalhaDiretorio")) {
    function detalhaDiretorio($dirOnde)
    {
        if (strpos($dirOnde, "corporativo") > 0) {
            return "corporativo/";
        }
        if (strpos($dirOnde, "e-solution") > 0) {
            return "e-solution/";
        }
    }
}

if (!function_exists("recursiveArrayToList")) {
    function recursiveArrayToList(Array $array = array())
    {
        if (file_exists(__DIR__ . "/../../vendor/autoload.php")){
            require_once  __DIR__ . "/../../vendor/autoload.php";

            if(class_exists(\Project\BBHive\Services\RedeSimples\Helper\ViabilidadeTemplate::class)){
                return recursiveArrayCallback($array);
            }
        }

        $html = '<ul style="-webkit-padding-start: 7px;">';
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $value = recursiveArrayToList($value);
                }

                $html .= sprintf("<li style=\"margin: 5px;\"><strong>%s:</strong> %s</li>", $key, $value);
            }
        $html .='</ul>';

        return $html;
    }
}

if (!function_exists("recursiveArrayCallback")) {
    function recursiveArrayCallback(Array $array = array())
    {
        require_once __DIR__ . "/../../vendor/autoload.php";
        $viabilidade = new \Project\BBHive\Services\RedeSimples\Helper\ViabilidadeTemplate($array);
        $content = $viabilidade->view();

        $html = "";
        foreach($content as $title => $value) {
            $html .= is_array($value) ? sprintf("<div style=\"margin-top: 3px;teste\"><strong>%s: </strong>%s</div>", $title, parseKeyAndValueToHtml($value))
                    : sprintf("<div style=\"margin-top: 3px;teste2\"><strong>%s: </strong>%s</div>", $title, $value);
        }

        return $html;
    }
}

if (!function_exists("parseKeyAndValueToHtml")) {
    function parseKeyAndValueToHtml(Array $array)
    {
        $html = "";
        foreach($array as $key => $value) {
            $html .= sprintf("<div class=\"sub-item\" style=\"margin-left: 15px; margin-top: 3px;\"><strong>%s: </strong>%s</div>", $key, $value);
        }

        return $html;
    }
}

if (!function_exists("getCurrentPage")) {
    function getCurrentPage()
    {
        $serverPage = !empty($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : $_SERVER['REQUEST_URI'];
        if (strpos($serverPage, "?") !== false) {
            $serverPage = explode("?", $serverPage);
            $serverPage = $serverPage[0];
        }

        return $serverPage;
    }
}

if (!function_exists("isCurrentPage")) {
    function isCurrentPage($page)
    {
        return getCurrentPage() == $page;
    }
}

if (!function_exists("apostrofo")) {
    function apostrofo($txt)
    {
        return str_replace("'", "`", $txt);
    }
}

if (!function_exists("converte")) {
    function converte($term)
    {
        return strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    }
}

if (!function_exists("isHtml")) {
    function isHtml($string)
    {
        return preg_match("/<[^<]+>/", $string, $m) != 0;
    }
}