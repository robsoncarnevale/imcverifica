<style>
	.painel-tamanho{
		width: 40%;
		margin: 3% auto;
	}
	.rotacao-texto{
		/*transform: rotate(270deg);*/
		writing-mode: vertical-rl;
		color: #2A6B5D;
		font-size: 70px;
	}
	.versus-padding{
		padding:10px;
	}
</style>



<div class="content-fluid container">
	<br>
	<form>
		<div class="panel panel-success painel-tamanho">
			<div class="panel-heading">Cálculadora de IMC</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-2">
						<b class="rotacao-texto">IMC</b>
					</div>
					<div class="col-md-10">
						<div class="row">
							<div class="col-md-11">
								<input type="text" class="form-control" placeholder="Digite seu peso" id="peso_individuo">
							</div>
						</div>
					</div>
					<br><br>
					<div class="col-md-10">
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" placeholder="Digite sua altura" id="altura_um_individuo">
							</div>
							<div class="col-md-3">
								<center><span class="glyphicon glyphicon-remove versus-padding"></span></center>
							</div>
							<div class="col-md-4">
							<input type="text" class="form-control" placeholder="Digite sua altura" id="altura_dois_individuo">
							</div>
						</div>
					</div>	
					<br><br><br>
					<div class="col-md-10">
						<div class="row">
							<button type="button" class="btn btn-success btn-sm col-md-11" onclick="calculo()">Cálcular</button>	
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="border border-success rounded-top">
			<center><img id="imagemtexto"/></center>
		</div>
	</form>
</div>
<script>

$('#peso_individuo').focus();	
$("#altura_um_individuo").blur(function(){
	$('#altura_dois_individuo').val($('#altura_um_individuo').val().replace(",", "."));
});

$("#altura_dois_individuo").blur(function(){
	$('#altura_um_individuo').val($('#altura_dois_individuo').val().replace(",", "."));
});

function calculo(){
	var a = $('#peso_individuo').val();
	var b = $('#altura_um_individuo').val();
	var c = $('#altura_dois_individuo').val();
	var calc = a/(b*c);
	var imc = parseFloat(calc).toFixed(2);
	

	if(imc<=18.5){
		$('#imagemtexto').attr('src','imagens/baixopeso.jpg')
	}else if(imc>=18.6 && imc<=24.9){
		$('#imagemtexto').attr('src','imagens/ideal.jpg')
	}else if(imc>=25 && imc<=29.9){
		$('#imagemtexto').attr('src','imagens/sobrepeso.jpg')
	}else if(imc>=30 && imc<=34.9){
		$('#imagemtexto').attr('src','imagens/obesidade.jpg')
	}else if(imc>=35 && imc<=39.9){
		$('#imagemtexto').attr('src','imagens/obesidadesev.jpg')
	}else if(imc>=40){
		$('#imagemtexto').attr('src','imagens/obesidademorb.jpg')
	}

}

</script>