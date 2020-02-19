<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Home extends CI_Controller {
	
	public function index() {			
		$data ["alert"] = $this->notification_output();	
		$this->load->model("Login_model");	
		$this->load->view("includes/header");
		$data["nome"] = $this->Login_model->nome();
		$this->load->view("includes/css/index_css");
		$this->load->view("includes/body",$data);	
		$this->load->view("includes/js/index_js");
		$this->load->view("includes/footer");
		$this->load->view("teste");

	}


	public function tabelas_dinamicas(){ //Página para teste dos relatórios do registro de ponto
		$data ["alert"] = $this->notification_output();
		$this->load->model("Login_model");	
		$this->load->view("includes/header");
		$data["nome"] = $this->Login_model->nome();
		$this->load->view("includes/css/index_css");
		$this->load->view("includes/js/index_js");
/*		$this->load->view("includes/footer"); */

		$this->load->view("tabelas_dinamicas");
		$this->load->model ('Registro_ponto_model');
		$data ["lista"] = $this->Registro_ponto_model->lista_colaboradores();		

		$this->load->view("includes/body",$data);
/*
		$this->load->model ('Registro_ponto_model');
		$data['supervisor'] = $this->Registro_ponto_model->lista_supervisores();
		$data ['menu'] = true;
		$data ["view"] = "tabelas_dinamicas";
		$data ["alert"] = $this->notification_output();	
		$data ['lista'] = $this->Registro_ponto_model->lista_colaboradores();
		$data ['supervisor'] = $this->registro_ponto_model->lista_supervisores() 
		$data ['pag'] = $this->Registro_ponto_model->paginacao();
		$this->load->view("includes/body",$data);
*/
	}
	
	/*=====================================================================
	 FUNÇÕES EXTRAS
	=====================================================================*/
	
	//Exibir notificação da sessão
	private function notification_output(){
		if($this->session->userdata("message")){
			if($this->session->userdata("accept")) $type_alert = "success";
			else $type_alert = "danger";
			$data='<script>$(document).ready(function(){$.toaster({ priority : "'.$type_alert.'", title : "Alerta", message : "'.$this->session->userdata("message").'"});});</script>';	
			$this->session->unset_userdata(array("message"=>"","accept"=>""));
			return $data;
		}
		return "";
	}
	
	//Configurar notificação da sessão
	private function notification_input($message,$accept){
		$this->session->set_userdata(array("message"=>$message,"accept"=>$accept));
	}
}