<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Registro_ponto_model extends CI_Model {

/*    public function lista_colaboradores() {
        return $this->db->query
        (
        " 
        -- Consulta consolidada dos dados e cálculo da aderência com créditos gerados

        SELECT 
           ca.[id_cartao_ponto_pk]
          ,ca.[pis]
          ,ca.[usuario]
          ,relacao.[Nome]
          ,ca.[data]
          ,ca.[ent1]
          ,ca.[sai1]
          ,ca.[ent2]
          ,ca.[sai2]
          ,ca.[ent3]
          ,ca.[sai3]
          ,ca.[ent4]
          ,ca.[sai4]
          ,ca.[credito]
          ,ca.[atraso]
          ,ca.[falta]
          ,ca.[abono]
          ,ca.[obs]
          ,ca.[id_funcao_temp_fk]
          ,ca.[id_ocorrencia_fk]
          ,ca.[id_quadro_op_fk]
          ,colaborador.idsuperv
          ,superior.nome
          FROM [7401_6].[abs].[tb_cartao_ponto] ca
          INNER JOIN [7401_8].cp.import_relacao_nova_220118 relacao ON ca.pis = relacao.[Nro# PIS/PASEP]
          INNER JOIN dbo.tb_empregados colaborador ON right(login,6) = ca.usuario and codempresa=40
          LEFT JOIN dbo.tb_empregados SUPERIOR ON colaborador.idsuperv = superior.login
          "
        )
        ->result();
    }*/

    public function lista_colaboradores() {

        $data_inicial = '2018-02-01 00:00:00';
        $data_final = '2018-02-01 23:59:00';
        $this->db->query('SET NOCOUNT ON;');
        $sql = 'EXEC abs.sp_consulta_resgistro_ponto "'.$data_inicial.'", "'.$data_final.'"';
        return $this->db->query($sql)->result();
    }
    

    public function lista_supervisores(){
        return $this->db->query
        (
          "
          SELECT sup.[login], sup.[nome] FROM [7401_3].dbo.TB_EMPREGADOS SUP
            WHERE sup.codfuncao = '75' 
              OR sup.codfuncao= '76' 
              OR sup.codfuncao = '89' 
              AND sup.codempresa = '40' 
              AND sup.dtdemis IS NULL
            ORDER BY sup.nome
          "
        )
        ->return();
    }

/*
    public function paginacao(){

    DEFINE ('qtd_registros', 40);
    DEFINE ('range_paginas', 1);

    // Recebe o número da página
    $pagina_atual = (ISSET($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

    // Varifica a linha incial da consulta
    $linha_inicial = ($pagina_atual - 1) * qtd_registros;

    // Número de registro retornados pela consulta para paginação
    $sqlTotRegistros = "PRINT @rows";
    $stm = $pdo->prepare($sqlTotRegistros);
    $stm->execute();
    $total = $stm->fetch(PDO::FETCH_OBJ);

    // Atribuindo valor incial da primeira página
    $primeira_pagina = 1;

    // Atribuindo valor da ultima página
    $ultima_pagina = ceil($total-> @rows / qtd_registros);

    // Identifica a página anterior em relação a página atual
    $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual - 1 :;

    // Identifica a próxima página em relação a página atual
    $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual + 1 :;

    // Identifica qual será a página inicial do nosso range
    $range_inicial = (($pagina_atual - range_paginas) >= 1) ? $pagina_atual - range_paginas : 1;

    // Identifica qual será a página final do nosso range
    $range_final = (($pagina_atual + range_paginas) <= $ultima_pagina) ? $pagina_atual + range_paginas : $ultima_pagina;

    // Verifica se vai exibir o botão "Primeiro" e "Próximo"
    $exibir_botao_incio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder';

    // Verifica se vai exibir o botão "Anterior" e "Último"
    $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';

    } */
    

}
?>