<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Nome {
	public static function getNome(){
		$ci=get_instance();
		$ci->db->select("nome");
		$ci->db->where('login',get_current_user());
		$nome=$ci->db->get("dbo.tb_empregados")->result();
		$arr=explode(" ",$nome[0]->nome);
		$tam=count($arr);
		return strtolower($arr[0].' '.$arr[$tam-1]);
	}
		
	public static function nome_dividir($nome) {
		$arr=explode(" ",$nome);
		$tam=count($arr);
		return $arr[0].' '.$arr[$tam-1];
	}
	
	public static function getNomeMat($mat){
		$ci=& get_instance();
		$qr=$ci->db->select("login+' - '+nome nome")->where('login',$mat)->get("dbo.tb_empregados")->row();
		return $qr->nome;			
	} 
}

?>