<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class DateBr {
	// Obtem os nomes da semana em português
	public static function day_week() {
		$day = date ( "N" );
		
		switch ($day) {
			case 1 :
				return "segunda";
				break;
			
			case 2 :
				return "terça";
				break;
			
			case 3 :
				return "quarta";
				break;
			
			case 4 :
				return "quinta";
				break;
			
			case 5 :
				return "sexta";
				break;
			
			case 6 :
				return "sábado";
				break;
			
			case 7 :
				return "domingo";
				break;
		}
	}
	
	// Gera uma array entre a data inicial e final inclusive
	public static function arrayDateRange($date_start, $date_end, $time = 'day') {
		$date_start = str_replace ( "/", "-", $date_start );
		$start = strtotime ( $date_start );
		$end = strtotime ( str_replace ( "/", "-", $date_end ) );
		$date_range = array ();
		$i = 1;
		while ( $start <= $end ) {
			$date_range [] = date ( "d/m/Y", $start );
			$start = strtotime ( $date_start . " +$i " . $time );
			$i ++;
		}
		return $date_range;
	}
	
	// Formata a data para o formato padrão de datas do SQL SERVER
	public static function formatDateToQuery($date) {
		$date = str_replace ( "/", "-", $date );
		return date ( "Ymd", strtotime ( $date ) );
	}
	
	// Obtem o mês e ano em português
	public static function mounth_year_br($date) {
		$date = str_replace ( "/", "-", $date );
		$date_time = strtotime ( $date );
		if ($date_time) {
			switch (date ( "n", $date_time )) {
				case 1 :
					return "janeiro de " . date ( "Y", $date_time );
					break;
				
				case 2 :
					return "fevereiro de " . date ( "Y", $date_time );
					break;
				
				case 3 :
					return "março de " . date ( "Y", $date_time );
					break;
				
				case 4 :
					return "abril de " . date ( "Y", $date_time );
					break;
				
				case 5 :
					return "maio de " . date ( "Y", $date_time );
					break;
				
				case 6 :
					return "junho de " . date ( "Y", $date_time );
					break;
				
				case 7 :
					return "julho de " . date ( "Y", $date_time );
					break;
				
				case 8 :
					return "agosto de " . date ( "Y", $date_time );
					break;
				
				case 9 :
					return "setembro de " . date ( "Y", $date_time );
					break;
				
				case 10 :
					return "outubro de " . date ( "Y", $date_time );
					break;
				
				case 11 :
					return "novembro de " . date ( "Y", $date_time );
					break;
				
				case 12 :
					return "dezembro de " . date ( "Y", $date_time );
					break;
			}
		}
	}
}

?>