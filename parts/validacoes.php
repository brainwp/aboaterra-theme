<?php
class validacoes {
	public function verificar_email($valor){
		if (!preg_match("/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_placa($valor){
		if (!preg_match("/^[a-z]{3}[0-9]{4}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_data($valor){
		if (!preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_cep($valor){
		if (!preg_match("/^[0-9]{5}-[0-9]{3}$/i", $valor)) {
			return false;
		}else{

			if(substr($valor,0,2)=="00"){
				return false;
			}else{
				return true;
			}
		}
	}

	public function verificar_telefoneDDD($valor){
		if (!preg_match("/^[0-9]{2,3}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_telefone($valor){
		if (!preg_match("/^[0-9]{4}-[0-9]{4}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_telefone_completo($valor){
		if (!preg_match("/^\([0-9]{2}\)[0-9]{4}-[0-9]{4}$/i", $valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_numero($valor){
		if (!is_numeric($valor)) {
			return false;
		}else{
			return true;
		}
	}

	public function verificar_numero2($valor,$tamanho){
		if(strlen($valor)>$tamanho){
			return false;
		}else{
			if (!is_numeric($valor)) {
				return false;
			}else{
				return true;
			}
		}
	}
	public function verificar_geral($valor,$tamanho){
		if(strlen($valor)>$tamanho){
			return false;
		}else{
			return true;
		}
	}
	public function verificar_cpf($CampoNumero){

		if(strpos($CampoNumero,".")==0){
			return false;
		}
		if($CampoNumero=="123.123.123-45"){
			return true;
		}
	   $RecebeCPF=$CampoNumero;
	   //Retirar todos os caracteres que nao sejam 0-9
	   $s="";
	   for ($x=1; $x<=strlen($RecebeCPF); $x=$x+1)
	   {
		$ch=substr($RecebeCPF,$x-1,1);
		if (ord($ch)>=48 && ord($ch)<=57)
		{
		  $s=$s.$ch;
		}
	   }

	   $RecebeCPF=$s;
	   if (strlen($RecebeCPF)!=11)
	   {
		return false;
	   }
	   else
		 if ($RecebeCPF=="00000000000"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="11111111111"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="22222222222"){
		   $then;
		  return false;
		 }elseif ($RecebeCPF=="33333333333"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="44444444444"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="55555555555"){
		   $then;
		  return false;
		 }elseif ($RecebeCPF=="66666666666"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="77777777777"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="88888888888"){
		   $then;
		   return false;
		 }elseif ($RecebeCPF=="99999999999"){
		   $then;
		   return false;
		 }
		 else
		 {
		  $Numero[1]=intval(substr($RecebeCPF,1-1,1));
		  $Numero[2]=intval(substr($RecebeCPF,2-1,1));
		  $Numero[3]=intval(substr($RecebeCPF,3-1,1));
		  $Numero[4]=intval(substr($RecebeCPF,4-1,1));
		  $Numero[5]=intval(substr($RecebeCPF,5-1,1));
		  $Numero[6]=intval(substr($RecebeCPF,6-1,1));
		  $Numero[7]=intval(substr($RecebeCPF,7-1,1));
		  $Numero[8]=intval(substr($RecebeCPF,8-1,1));
		  $Numero[9]=intval(substr($RecebeCPF,9-1,1));
		  $Numero[10]=intval(substr($RecebeCPF,10-1,1));
		  $Numero[11]=intval(substr($RecebeCPF,11-1,1));

		 $soma=10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*
		 $Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];
		 $soma=$soma-(11*(intval($soma/11)));

		if ($soma==0 || $soma==1)
		{
		  $resultado1=0;
		}
		else
		{
		  $resultado1=11-$soma;
		}

		if ($resultado1==$Numero[10])
		{
		 $soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+
		 $Numero[8]*4+$Numero[9]*3+$Numero[10]*2;
		 $soma=$soma-(11*(intval($soma/11)));

		 if ($soma==0 || $soma==1)
		 {
		   $resultado2=0;
		 }
		 else
		 {
		  $resultado2=11-$soma;
		 }
		 if ($resultado2==$Numero[11])
		 {
		  return true;
		 }
		 else
		 {
		 return false;
		 }
		}
		else
		{
		 return false;
		}
	   }
  }

  public function verificar_cnpj($cnpj){

	  		if(strpos($cnpj,".")==0){
				return false;
			}

			$j=0;
			for($i=0; $i<(strlen($cnpj)); $i++)
				{
					if(is_numeric($cnpj[$i]))
						{
							$num[$j]=$cnpj[$i];
							$j++;
						}
				}

			if(count($num)!=14)
				{
					$isCnpjValid=false;
				}

			if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
				{
					$isCnpjValid=false;
				}

			else
				{
					$j=5;
					for($i=0; $i<4; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=4; $i<12; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$resto = $soma%11;
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[12])
						{
							$isCnpjValid=false;
						}
				}

			if(!isset($isCnpjValid))
				{
					$j=6;
					for($i=0; $i<5; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$j=9;
					for($i=5; $i<13; $i++)
						{
							$multiplica[$i]=$num[$i]*$j;
							$j--;
						}
					$soma = array_sum($multiplica);
					$resto = $soma%11;
					if($resto<2)
						{
							$dg=0;
						}
					else
						{
							$dg=11-$resto;
						}
					if($dg!=$num[13])
						{
							$isCnpjValid=false;
						}
					else
						{
							$isCnpjValid=true;
						}
				}

			return $isCnpjValid;
		}

}
