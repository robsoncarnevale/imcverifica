<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Login_hook {
	public function Login(){	
		$ci =& get_instance();
		if(!$this->valida_acesso()){
			$data['view']="includes/logoff";
			$data['menu']=true;
			$ci->load->view("includes/body",$data);	
			$ci->output->get_output();
		}else{
			if (!$ci->session->userdata ( "login" )){
				$this->logar();
			}
			echo $ci->output->get_output();
		}
	}
	
	public function logar(){
		$ci =& get_instance();
		$result = $this->acesso();
		if ($result) {
			$ci->session->set_userdata(array("nome"=>false,"acesso"=>false,"login"=>false));
			$sess_data = array (
					"nome" => $this->nome(),
					"acesso" => $result,
					"login" => true 
			);			
			$ci->session->set_userdata($sess_data);			
		}else{
			$ci->session->set_userdata(array("nome"=>false,"acesso"=>false,"login"=>false));
			$sess_data = array (
					"nome" => $this->nome(),
					"acesso" => "DEFAULT",
					"login" => true 
			);			
			$ci->session->set_userdata($sess_data);
		}
	}
	
	public function acesso(){
		if(ID_SISTEMA == 0) {
			return "ADMINISTRADOR";
		}else{
			if(substr(get_current_user(),0,1)=="c" || substr(get_current_user(),0,1)=="C"){
				return "ADMINISTRADOR";
			}else{
				$ci =& get_instance();
				$db=$ci->load->database("default",true);
				$db->select ("CASE WHEN COUNT(DESC_PERFIL) > 0 THEN MAX(DESC_PERFIL) ELSE 'PADRAO' END as acesso" );
				$db->join ( "BD_SUPORTE.CASI.TB_PERFIL_ACESSO pa", "pa.ID_SISTEMA_FK = sis.ID_SISTEMA_PK", "inner" );
				$db->join ( "BD_SUPORTE.CASI.TB_PERFIL_USUARIO pu", "pu.ID_PERFIL_FK = pa.ID_PERFIL_PK", "inner" );
				$db->join ( "BD_APOIO.dbo.tb_empregados", "right(login,6) = pu.LOGIN_FK", "left",false );
				$db->where ( "pu.LOGIN_FK", substr ( get_current_user (), 1 ) );
				$db->where ( "sis.ID_SISTEMA_PK", ID_SISTEMA );
				$qr=$db->get("BD_SUPORTE.casi.TB_SISTEMA sis")->result();
				
				if($qr){				
					return $qr[0]->acesso;
				}else{
					die("Você Não tem Permissão");
				}
			}
		}
	}
	
	public function valida_acesso(){	
		
		$ci =& get_instance();
		
		$pasta=strtolower(trim($ci->router->directory));
		$controller=strtolower(trim($ci->router->directory.$ci->router->class));
		$method=strtolower(trim($ci->router->directory.$ci->router->class).'/'.$ci->router->method);	
		
		$acessos_permitidos_pelo_perfil_1=array("home","<=não remover o home da lista","nome do controller");
		$excecao_de_acesso_a_metodos_do_perfil_1=array("pasta_se_tive/controller/metodo1","pasta_se_tive/controller/metodo2");
		$acessos_permitidos_pelo_perfil2=array("home","<=não remover o home da lista","nome do controller");
		$excecao_de_acesso_a_metodos_do_perfil_2=array("pasta_se_tive/controller/metodo2");
		$acessos_permitidos_pelo_perfil_default=array("home","<=não remover o home da lista","nome do controller");
		$excecao_de_acesso_a_metodos_do_perfil_default=array("pasta_se_tive/controller/metodo1");
		
		switch ($this->acesso()){
			case "ADMINISTRADOR":return true;break;
			case "PERFIL DO SCAI 1":if(in_array($controller,$acessos_permitidos_pelo_perfil_1) && !in_array($method,$excecao_de_acesso_a_metodos_do_perfil_1) ) return true;break;
			case "PERFIL DO SCAI 2":if(in_array($controller,$acessos_permitidos_pelo_perfil_2) && !in_array($method,$excecao_de_acesso_a_metodos_do_perfil_2) ) return true;break;
			default:if(in_array($controller,$acessos_permitidos_pelo_perfil_default) && !in_array($method,$excecao_de_acesso_a_metodos_do_perfil_default)) return true;break;
		}
		
		return false;			
	}
	
	//pega o nome do usuario atual pela matricula
	public function nome(){
		return Nome::getNome();
	}
}