<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Math
{	
	//Arredonta para baixo. O PHP 5.2.13 não oferece suporte nativo
	public static function round_down($value,$dec=0)
	{
		$dec = pow(10,$dec);
		return floor($value*$dec)/$dec;		
	}

	//Transforma segundos para minutos
	public static function secondsToMinutes($sec)
	{
		return sprintf("%02.2d:%02.2d", floor($sec/60),$sec%60);
	}

	//Transforma número em exibição de dinheiro
	public static function numberToMoney($value,$dec=2)
	{
		if($dec == 2) $value = Math::round_down($value,$dec);
		return number_format($value,$dec,',','.');
	}
}

?>