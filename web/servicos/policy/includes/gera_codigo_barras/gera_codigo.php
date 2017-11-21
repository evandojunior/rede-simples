<?php
/*
Rotina para gerar códigos de barra padrão 2of5 ou 25.
Desenvolvido por: Jefferson Otoni
email     -> anjopuc@bol.com.br
Licença   -> GNU GENERAL PUBLIC LICENSE
Categoria -> Algoritmos
Contribuição -> Vanclei Picolli
email        -> vanclei@terra.com.br
versão 3.0
Versão 3.1 -> Adaptação Equipe Backsite 29/07/2009
####################
Orientado a Objeto
####################
*/
class WBarCode {
	//variaveis privadas
	var $_fino;
	var $_largo;
	var $_altura;

	//variaveis publicas
	var $BarCodes = array();
	var $texto;
	var $matrizimg;
	var $f1;
	var $f2;
	var $f;
	var $i;
	
		//============================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
			var $pen;//posição da caneta
			var $fino;//
			var $largo;//
			var $altura;//
			var $largura;//

			var $image;//
			var $branco;//
			var $preto;//
		//============================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
		
//Construtor da class
	function WBarCode($Valor, $destinoImagem){
		//============================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
			//header("Content-type: image/jpeg");
			$this->pen=0;
			$this->fino=1;
			$this->largo=3;
			$this->altura=50;
			$this->largura=200;
			$this->image 	= imagecreate($this->largura, $this->altura);//tamanho da imagem
			$this->branco  	= imagecolorallocate($this->image, 255,255,255);//BRANCO
			$this->preto 	= imagecolorallocate($this->image, 0,0,0);//PRETO
			
			$this->fino-=1;
			$this->largo-=1;
		//============================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD

		if (empty($this->BarCodes[0])){
			$this->BarCodes[0]="00110";//0 - fino, 1 - largo
			$this->BarCodes[1]="10001";
			$this->BarCodes[2]="01001";
			$this->BarCodes[3]="11000";
			$this->BarCodes[4]="00101";
			$this->BarCodes[5]="10100";
			$this->BarCodes[6]="01100";
			$this->BarCodes[7]="00011";
			$this->BarCodes[8]="10010";
			$this->BarCodes[9]="01010";

			for ($this->f1=9; $this->f1>=0; $this->f1=$this->f1-1){//====================inicio
			  
			  for ($this->f2=9; $this->f2>=0; $this->f2=$this->f2-1){//======inicio
				$this->f=$this->f1*10+$this->f2;
				$this->texto="";
				
				for ($this->i=1; $this->i<=5; $this->i=$this->i+1){//inicio
					$this->texto=$this->texto.substr($this->BarCodes[$this->f1],$this->i-1,1).
					substr($this->BarCodes[$this->f2],$this->i-1,1);
				}//=====================================================fim
				
				$this->BarCodes[$this->f]=$this->texto;
			  }//==============================================================fim
			}//==========================================================================FIM FOR
		  $this->BarCodes[$this->f]=$this->texto;
		}//FIM DO IF
		
		//Desenho da barra
		// Guarda inicial
		/*$this->matrizimg.= "
		<img src=p.gif width=$this->fino height=$this->altura border=0><img
		src=b.gif width=$this->fino height=$this->altura border=0><img
		src=p.gif width=$this->fino height=$this->altura border=0><img
		src=b.gif width=$this->fino height=$this->altura border=0><img
		";*/
			$this->image 	= imagecreate($this->largura, $this->altura);//tamanho da imagem
			$this->branco  	= imagecolorallocate($this->image, 255,255,255);//BRANCO
			$this->preto 	= imagecolorallocate($this->image, 0,0,0);//PRETO
		//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->preto);
			 $this->pen+=$this->fino+1;
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->branco);
			 $this->pen+=$this->fino+1;
			
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->preto);
			 $this->pen+=$this->fino+1;
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->branco);
			 $this->pen+=$this->fino+1;
		//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
		$this->texto=$Valor;
		if (strlen($this->texto)%2<>0){//se for ímpar
		  $this->texto="0".$this->texto;
		}
		// Draw dos dados
		while(strlen($this->texto)>0){//=========================================laço montando as barras
				 $this->i=intval(substr($this->texto,0,2));
				 $this->texto=substr($this->texto,strlen($this->texto)-(strlen($this->texto)-2));
				 $this->f=$this->BarCodes[$this->i];
				 
				for ($this->i=1; $this->i<=10; $this->i=$this->i+2){//INICIO DO FOR
						 if (substr($this->f,$this->i-1,1)=="0"){
								$this->f1  = $this->fino;
						  } else {
								$this->f1  = $this->largo;
						  }

					//$this->matrizimg.="src=p.gif width=$this->f1 height=$this->altura border=0><img";//PRETO
//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->f1,$this->altura,$this->preto);$this->pen+= $this->f1+1;//MOVE A CANETA
//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD

						   if (substr($this->f,$this->i+1-1,1)=="0"){
								$this->f2  = $this->fino;
						   }else{
								$this->f2  = $this->largo;
						   }

					//$this->matrizimg.= "src=b.gif width=$this->f2 height=$this->altura border=0><img ";//BRANCO
//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->f2,$this->altura,$this->branco);$this->pen+= $this->f2+1;//MOVE A CANETA
//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
					//imagefilledrectangle($image, $pen,0,$pen+$largo,$altura,$branco);$pen+=$largo+1
				}//=====================================================FIM DO FOR
		}//====================================================================FIMlaço montando as barras

		/*$this->matrizimg.= "src=p.gif width=$this->largo height=$this->altura border=0><img src=b.gif width=$this->fino height=$this->altura border=0><img
src=p.gif width=1 height=$this->altura border=0>";*/

		//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->largo,$this->altura,$this->preto);
			 $this->pen+=$this->largo+1;
			imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->branco);
			 $this->pen+=1;
			imagefilledrectangle($this->image, $this->pen,0,$this->pen,$this->altura,$this->preto);
		//=========================================INCREMENTADA POR ROBSON CRUZ 29/07/2009 9h37 - criação de imagem GD

//		return $this->matrizimg;
	  	$nomeImagem = $Valor.".png";//o valor dela
	 	ImagePNG($this->image, $destinoImagem.$nomeImagem);
		//ImageJpeg($this->image);
		//ImageDestroy($this->image);
    }//fim da function
}//fim da Class

/*================classe emerson*/
/*class Emerson{
	//variáveis públicas
	public $pen	=0;//posição da caneta
	public $fino	=1;
	public $largo	=3;
	public $altura	=50;
	public $largura=200;
	public $image;
	public $branco;
	public $preto;
	
	public function buscaImagem(){
	  if($this->image!=""){	//cria imagem padrão
		$this->image 	= imagecreate($largura,$altura);//tamanho da imagem
		$this->branco 	= imagecolorallocate($image, 255,255,255);//BRANCO
		$this->preto 	= imagecolorallocate($image, 0,0,0);//PRETO	
	  }
	}
	public function buscaPreto($largPreto){
		$this->fino-=1;
		$this->largo-=1;
		
		$this->preto = $largPreto;
		
		imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->preto);
		$this->pen+=$this->fino+1;
	}
	public function buscaBranco($largBranco){
		$this->fino-=1;
		$this->largo-=1;
		
		imagefilledrectangle($this->image, $this->pen,0,$this->pen+$this->fino,$this->altura,$this->branco);
		$this->pen+=$this->fino+1;
	}
}*/
/*================classe emerson*/
//$codigo = "999999";
//$bar = new WBarCode($codigo, $destinoImagem);
/*===================================================================================================================*/
//CHAMADA RESPONSÁVEL PELA GERAÇÃO DO CÓDIGO DE BARRAS
$bar = new WBarCode($codigo, $destinoImagem);
/*==================================================*/

?> 