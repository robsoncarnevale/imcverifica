<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Log_model extends CI_Model {
	
	/**
	 *
	 * @param int $id - id da ocorrencia
	 * @param int $usr - matricula do usuario que distribuiu
	 * @param int $op - login do operador
	 * @param bool $redist- se é distribuição ou redistribuição
	 * @return boolean
	 */
	public function log_distibuicao($id, $usr, $op, $redist) {
		$data ['ocorrencia_fk'] = $id;
		$data ['usr_log'] = $usr;
		$data ['usr_dist'] = $op;
		$data ['redist'] = $redist;
		
		$this->db->set ( $data );
		
		if ($this->db->insert ( "pret.tb_log_distribuicao" )) {
			return true;
		}
		
		return false;
	}
	
	/**
	 *
	 * @param int $id        	
	 * @param int $usr        	
	 * @param int $st        	
	 * @param DateTime $agnd        	
	 * @param int $proto        	
	 * @param bool $obs        	
	 * @return boolean
	 */
	public function log_tratamento($id, $usr, $st, $agnd, $proto, $obs) {
		$data ['id_ocorrencia_fk'] = $id;
		$data ['usr_tratamento'] = $usr;
		$data ['st_anterior'] = $st;
		$data ['st_atual'] = $st;
		$data ['dt_agendamento'] = $agnd;
		$data ['protocolo'] = $proto;
		$data ['obs'] = $obs;
		
		$this->db->set ( $data );
		
		if ($this->db->insert ( "pret.tb_log_tratamento" )) {
			return true;
		}
		
		return false;
	}
	
	public function getLog($pag = 0, $data) {
		$reg = (($pag == 0 ? 1 : $pag) - 1) * 25;
		
		if ($data ['item'] != 0) {
			$this->db->where ( "item_fk", $data ['item'] );
		}
		
		if ($data ['origem'] != 0) {
			$this->db->where ( "tipo_origem_fk", $data ['origem'] );
		}
		
		if ($data ['natureza'] != 0) {
			$this->db->where ( "natureza_fk", $data ['natureza'] );
		}
		
		if ($data ['ocorrencia'] != "") {
			$this->db->where ( "id_ocorrencia_pk", $data ['ocorrencia'] );
		}
		
		if ($data ['acao'] != 0) {
			$this->db->where ( "acao", $data ['acao'] );
		}
		
		if ($data ['operador'] != 0) {
			$this->db->where ( "usr_tratamento", $data ['operador'] );
		}
		
		if ($data ['datai'] != "" && $data ['dataf'] != "") {
			$this->db->where ( "dt_log between '" . $data ['datai'] . "' and '" . $data ['dataf'] . "'" );
		} elseif ($data ['dataf'] == "") {
			$this->db->where ( "dt_log >=", $data ['datai'] );
		} elseif ($data ['datai'] == "") {
			$this->db->where ( "dt_log <=", $data ['dataf'] );
		}
		
		$this->db->join ( "pret.tb_ocorrencia", "id_ocorrencia_pk=id_ocorrencia_fk", "inner" );
		$this->db->order_by ( "dt_log desc OFFSET $reg rows fetch next 25 rows only", null, false );
		if ($data ['tipo'] == 1) {
			$qr = $this->db->where ( "acao <>", 3 )->get ( "pret.tb_log_tratamento" )->result ();
		} else {
			$qr = $this->db->where ( "acao", 3 )->get ( "pret.tb_log_tratamento" )->result ();
		}
		// echo $this->db->last_query();
		return $qr;
	}
	
	public function getLogCount($data) {
		if ($data ['item'] != 0) {
			$this->db->where ( "item_fk", $data ['item'] );
		}
		
		if ($data ['origem'] != 0) {
			$this->db->where ( "tipo_origem_fk", $data ['origem'] );
		}
		
		if ($data ['natureza'] != 0) {
			$this->db->where ( "natureza_fk", $data ['natureza'] );
		}
		
		if ($data ['ocorrencia'] != "") {
			$this->db->where ( "id_ocorrencia_pk", $data ['ocorrencia'] );
		}
		
		if ($data ['acao'] != 0) {
			$this->db->where ( "acao", $data ['acao'] );
		}
		
		if ($data ['operador'] != 0) {
			$this->db->where ( "usr_tratamento", $data ['operador'] );
		}
		
		if ($data ['datai'] != "" && $data ['dataf'] != "") {
			$this->db->where ( "dt_log between '" . $data ['datai'] . "' and '" . $data ['dataf'] . "'" );
		} elseif ($data ['dataf'] == "") {
			$this->db->where ( "dt_log >=", $data ['datai'] );
		} elseif ($data ['datai'] == "") {
			$this->db->where ( "dt_log <=", $data ['dataf'] );
		}
		
		$this->db->select ( "count(*) total", false );
		$this->db->join ( "pret.tb_ocorrencia", "id_ocorrencia_pk=id_ocorrencia_fk", "inner" );
		
		if ($data ['tipo'] == 1) {
			$qr = $this->db->where ( "acao <>", 3 )->get ( "pret.tb_log_tratamento" )->row ();
		} else {
			$qr = $this->db->where ( "acao", 3 )->get ( "pret.tb_log_tratamento" )->row ();
		}
		
		return $qr->total;
	}
}