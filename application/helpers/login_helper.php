<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login{
	public static function getAcesso(){
		$ci=& get_instance();
		$default="'OPERADOR'";
		$liberados=array();
		if(!in_array(strtoupper(get_current_user()),$liberados)){
			$qr= $ci->db->query("
									 select isnull(max(desc_perfil),$default) perfil 
									 from Desenvolvimento.pret.tb_usuario u inner join Desenvolvimento.pret.tb_perfil p on p.id_perfil_pk=u.id_perfil_fk
									 where usr_login=".substr(get_current_user(),1)."
								 ")->row();
			return $qr->perfil;
		}else{
			return "MASTER";
		}
		return $default;
	} 
}