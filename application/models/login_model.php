<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Login_model extends CI_Model{
	//chama as validações de acesso e dados da sessao
	public function __construct(){		
		$this->load->library('user_agent');
		if ($this->agent->browser() == 'Chrome' ){
			$data['view']="includes/browser";
			$data['menu']=false;
			die($this->load->view("includes/body",$data,true));
		}else{
			if(!$this->valida_acesso()){
				$data['view']="includes/logoff";
				$data['menu']=true;
				$this->load->view("includes/body",$data);	
				$this->output->get_output();
			}else{
				if (!$this->session->userdata ( "login" )){
					$this->login();
				}
				echo $this->output->get_output();
			}
		}
	}
	
	//verifica os dados no BD e coloca na sessão caso ainda nao tenha
	public function login(){
		$result = $this->acesso();
		if ($result) {
			$this->session->set_userdata(array("nome"=>false,"acesso"=>false,"login"=>false));
			$sess_data = array (
					"nome" => $this->nome(),
					"acesso" => $result,
					"login" => true 
			);			
			$this->session->set_userdata($sess_data);			
		}else{
			$this->session->set_userdata(array("nome"=>false,"acesso"=>false,"login"=>false));
			$sess_data = array (
					"nome" => $this->nome(),
					"acesso" => "DEFAULT",
					"login" => true 
			);
			
			$this->session->set_userdata($sess_data);
		}
	}
	
	//verifica o perfil do usuario logado no SO, caso nao exista , retorna DEFAULT, caso comexe com 'C' retorna ADMINISTRADOR
	public function acesso(){
		if(ID_SISTEMA == 0) {
			return "ADMINISTRADOR";
		}else{		
			$this->db->select ("CASE WHEN COUNT(DESC_PERFIL) > 0 THEN MAX(DESC_PERFIL) ELSE 'PADRAO' END as acesso" );
			$this->db->join ( "BD_SUPORTE.CASI.TB_PERFIL_ACESSO pa", "pa.ID_SISTEMA_FK = sis.ID_SISTEMA_PK", "inner" );
			$this->db->join ( "BD_SUPORTE.CASI.TB_PERFIL_USUARIO pu", "pu.ID_PERFIL_FK = pa.ID_PERFIL_PK", "inner" );
			$this->db->join ( "BD_APOIO.dbo.tb_empregados", "right(login,6) = pu.LOGIN_FK", "left",false );
			$this->db->where ( "pu.LOGIN_FK", substr ( get_current_user (), 1 ) );
			$this->db->where ( "sis.ID_SISTEMA_PK", ID_SISTEMA );
			if($qr=$this->db->get("BD_SUPORTE.casi.TB_SISTEMA sis")->result()){
				return $qr[0]->acesso;
			}else{
				die("Você Não tem Permissão");
			}
			
		}
	}
	
	//valida o acesso de acordo com o controller e o metodo corrente na pagina comparando o acesso do perfil do usuario logado
	public function valida_acesso(){			
		$pasta=strtolower(trim($this->router->directory));
		$controller=strtolower(trim($this->router->directory.$this->router->class));
		$method=strtolower(trim($this->router->directory.$this->router->class).'/'.$this->router->method);	
		
		$acessos_permitidos_pelo_perfil_1=array("home","<=não remover o home da lista","nome do controller");
		$excecao_de_acesso_a_metodos_do_perfil_1=array("pasta_se_tive/controller/metodo1","pasta_se_tive/controller/metodo2");
		$acessos_permitidos_pelo_perfil2=array("home","<=não remover o home da lista","nome do controller");
		$excecao_de_acesso_a_metodos_do_perfil_1=array("pasta_se_tive/controller/metodo2");
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
	
	//pega o nome do usuario pela matricula
	public function nome(){
		return Nome::getNome();
	}
	
	public function log(){
		$method=strtolower(trim($this->router->directory.$this->router->class).'/'.$this->router->method);
		if($method!="home/index"){
			$this->db->set("usr_log",substr(get_current_user(),1));
			$this->db->insert("gproc.tb_log_acesso");
		}
	}
}
?>