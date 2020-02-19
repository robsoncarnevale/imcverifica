<div class="content-fluid container">
	<br>

		<div class="col-lg-12">

			<h3 align="center">
				Relatório de Ponto
			</h3>
			<br>

 			<table class="table table-striped datatable" id="tabelas_dinamicas">
				<thead>
                    <tr>
<!--                    <th>
			               <th><input type="checkbox" id="check-all" class="flat"></th>
						</th> -->
                        <th>Usuário</th>
                        <th>Nome</th>
                        <th>Data</th>
                        <th>Jornada</th>
                        <th>Aderência</th>                                                   
                        <th>Entrada</th>

                        <!-- Intervalo 1 -->
                        <th>Int Saída</th> 
                        <th>Int Retorno</th>

                        <!-- Lanche/Almoço -->
                        <th>Luc Saída</th> 
                        <th>Luc Retorno</th>

                        <!-- Intervalo 2 -->
                        <th>Int Saída</th> 
                        <th>Int Retorno</th>

                        <!-- Fim de trabalho -->
                        <th>Saída</th>

                        <!-- Conasolidado -->
                        <th>Crédito</th>
                        <th>Atraso</th>
                    </tr>
				</thead>
				<tbody>
                    <?php foreach ($lista as $resgistros => $registro):?>
                    <tr>

                   <!-- <td>
					        <th><input type="checkbox" id="check-all" class="flat"></th>
						</td> -->
                        <td><?php echo "P"."$registro->usuario";?></td>
                        <td><?php echo "$registro->Nome";?></td>
                        <td><?php echo "$registro->data";?></td>
                        <td><?php echo "$registro->jornada";?></td>
                        <td><?php echo "$registro->aderencia_hora";?></td>
                        <td><?php echo "$registro->ent1";?></td>
                        <td><?php echo "$registro->sai1";?></td>
                        <td><?php echo "$registro->ent2";?></td>
                        <td><?php echo "$registro->sai2";?></td>
                        <td><?php echo "$registro->ent3";?></td>
                        <td><?php echo "$registro->sai3";?></td>
                        <td><?php echo "$registro->ent4";?></td>
                        <td><?php echo "$registro->sai4";?></td>
                        <td><?php echo "$registro->credito";?></td>                       
                        <td><?php echo "$registro->atraso";?></td>
                    </tr>
                    <?php endforeach;?>
				</tbody>
			</table>

        </div>
</div>
<script>
	$('#registro_ponto').DataTable();
</script>


<!--

<div class="col-xs-6">
    <div id="tabelas_dinamicas_length" class="dataTables_length">
        <label>
            <select class="form-control input-sm" name="tabelas_dinamicas_length" aria-controls="tabelas_dinamicas">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="40">40</option>
                <option value="100">100</option>
            </select>
            por página
        </label>
    </div>
</div>

-->
<!--
<div class="col-xs-6">
    <div id="tabelas_dinamicas_length" class="dataTables_length">
        <label for='supervisor'>Supervisor:</label>
            <select id="supervisor" class="form-control input-sm" name="supervisor" aria-controls="tabelas_dinamicas">
                <option value="Todos">Todos</option>
                <?php foreach ($supervisor as $sup => $super):?>
                    <option value="<?php echo $super->login?>"><?php echo $super->nome?></option>
                <?php endforeach;?>
            </select>
        </label>
    </div>
</div>


<div class="col-xs-6">
    <div id="tabelas_dinamicas_filter" class="dataTables_filter">
        <label>
            Filtrar
            <input class="form-control input-sm" type="search" placeholder="" aria-controls="tabelas_dinamicas"></input>
        </label>
    </div>
</div>


-->

