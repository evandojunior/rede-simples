<?PHP
function um_arquivo($name = '') {
 return preg_match('|/?.+[^/]$|', $name);
}
function lista_zip($nameZip, $nivel = 0) {
 $zip = new ZipArchive();
 $zip->open($nameZip);
 $files_zip = array();
 for ($i = 0; $i < $zip-> numFiles; $i++) {
  $conteudo = $zip->statIndex($i);
  $files_zip[] = $conteudo['name'];
 }
 return $files_zip;
}
function string2tree($array = array()) {
 global $pathTmp;
 deleteTree($pathTmp);
  @mkdir($pathTmp, 0777);
 foreach($array as $ponteiro) {
  $ponteiro = str_replace('\\', '/', $ponteiro);
  $ponteiro = $pathTmp.$ponteiro;
  if (um_arquivo($ponteiro)) {
   $fopen = fopen($ponteiro, 'w');
   fclose($fopen);
  } else {
   mkdir($ponteiro, 0777, true);
  }
 }
 return tree2array($pathTmp);
}
function deleteTree($path = '', $removePathRoot = true) {
 $path = rtrim($path, '/').'/';
 if (empty($path))
  return false;
 $dir = opendir($path);
 while (($file = readdir($dir)) !== false) {
  if ($file == '.' or $file == '..')
   continue;
  $file = $path.$file;
  if (!is_file($file)) {
   deleteTree($file);
  } else {
   unlink($file);
  }
 }
 if ($removePathRoot)
  rmdir($path);
 return true;
}
function tree2array($path = '') {
 $path = rtrim($path, '/').'/';
 if (empty($path))
  return false;
 $dir = opendir($path);
 $conteudo = array();
 $contagem = 0;
 while (($file = readdir($dir)) !== false) {
  if ($file == '.' or $file == '..')
   continue;
  if (!is_file($path.$file)) {
   $pathName = basename(rtrim($path.$file, '/'));
   $conteudo[''.$pathName.''] = tree2array($path.$file);
  } else {
   $conteudo[$contagem++] = $file;
  }
 }
 return $conteudo;
}
function array2tree($array = array(), $level = 0) {
 $total_de_arquivos = count($array);
 $contagem = 0;
 foreach($array as $indice => $array1) {
  $contagem++;
  for ($i = 0; $i < $level; $i++) {
   if ($i == 1 or($i % 2) == 0) {
    if (($level - 1) == $i and $total_de_arquivos == $contagem and(!is_array($array1)or count($array1) == 0))
     echo '\---';
    else
     echo '|---';
   } else {
    echo '----';
   }
  }
  if (is_array($array1)) {
   echo $indice.'<br/>';
   array2tree($array1, $level + 1);
  } else {
   echo $array1.'<br/>';
  }
 }
}

function copyTo($path, $local) {
 $path = rtrim($path, '/').'/';
 $local = rtrim($local, '/').'/';
 if (!file_exists($local)) {
  mkdir($local, 0777);
 }
 @chmod($local, 0777);
 $dir = opendir($path);
 while (false !== ($file = readdir($dir))) {
  if ($file == '.' or $file == '..')
   continue;
  if (!is_file($path.$file)){
   copyTo($path.$file, $local.$file);
  } else {
      if (!is_writable($path.$file)) {
          continue;
      }

      @chmod($path.$file, 0777);
      @copy($path.$file, $local.$file);
  }
 }
 closedir($dir);
}