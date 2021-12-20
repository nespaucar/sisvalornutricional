<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>

<style>
	.shadow {
		box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  		position:relative;
  		z-index: 3;
	}
</style>

<div class="row boxfondo">
    <div class="col-sm-12">
        <div class="card-box">
            <div class="row m-b-30">
                <div class="col-sm-12">
                	<div class="form-inline">
						<div class="form-group">
							<div class="row">
								<div class="col-md-12">
									<select class="form-control input-xs" id="name" onchange="checkButtonAddStatus();" data-live-search="true"></select>
								</div>
							</div>
						</div>
						<input type="hidden" id="cadenaAlimentos" value="">
						<input type="hidden" id="cadenaCantidades" value="">						
						{!! Form::label('cantidad', 'Cantidad (g.)', array('class' => 'control-label')) !!}
						{!! Form::text('cantidad', null, array('class' => 'form-control input-xs text-right', 'id' => 'cantidad', 'placeholder' => 'gramos', 'onkeyup' => 'checkButtonAddStatus();', 'autocomplete' => 'off')) !!}
						{!! Form::button('<i class="fa fa-plus"></i> Añadir', array('class' => 'btn btn-info waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnAdd', 'onclick' => 'addAlimento();', 'disabled' => true)) !!}
						{!! Form::button('<i class="glyphicon glyphicon-refresh"></i> Reiniciar', array('class' => 'btn btn-danger waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnReiniciar', 'onclick' => 'resetAlimento();')) !!}
						{!! Form::button('<i class="glyphicon glyphicon-file"></i> Exportar', array('class' => 'btn btn-success waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnExportar', 'onclick' => '')) !!}
                	</div>
                </div>
            </div>
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Alimento</th>
							<th class="text-center">(g.)</th>
							<th class="text-center">ENERC</th>
							<th class="text-center">ENERC</th>
							<th class="text-center">WATER</th>
							<th class="text-center">PROCNT</th>
							<th class="text-center">FAT</th>
							<th class="text-center">CHOCDF</th>
							<th class="text-center">CHOAVL</th>
							<th class="text-center">FIBTG</th>
							<th class="text-center">ASH</th>
							<th class="text-center">CA</th>
							<th class="text-center">P</th>
							<th class="text-center">ZN</th>
							<th class="text-center">FE</th>
							<th class="text-center">CARTBQ</th>
							<th class="text-center">VITA</th>
							<th class="text-center">THIA</th>
							<th class="text-center">RIBF</th>
							<th class="text-center">NIA</th>
							<th class="text-center">VITC</th>
							<th class="text-center">AF</th>
							<th class="text-center">NA</th>
							<th class="text-center">K</th>
							<th class="text-center">x</th>
						</tr>
					</thead>
					<tbody id="tabla{{ $entidad }}">
						<tr id="emptyRow" data-id="" data-cantidad="">
							<td class="text-primary text-center" colspan="25">Seleccione al menos un alimento.</td>
						</tr>
					</tbody>
				</table>
			</div>
			<hr>
			<div class="row">
			    <div class="col-sm-12">
			        <div class="page-title-box">
			            <h4 class="page-title text-center">INFORMACIÓN NUTRICIONAL</h4>
			        </div>
			    </div>
			</div>
			<div class="container">
    				<?php $num = 0; ?>
    				@foreach($cards as $card)
    				<?php
    					if($num === 0) {
    						echo '<div class="row">';
    					}
    				?>
    				<div class="col-md-2">
    					<div class="panel panel-default shadow">
						  	<div class="panel-heading text-center text-bold" style="background-color:{{ $card['color'] }} !important; color: white !important;"><b>{{ $card['name'] }} {{ $card['id'] }} ({{ $card['unity'] }})</b></div>
						  	<div class="panel-footer result text-center" id="{{ $card['abrev'] }}">-</div>
						</div>
    				</div>
    				<?php
    					if($num === 5) {
    						echo '</div>';
    						$num = -1;
    					}
    				?>
    				<?php $num++; ?>
    				@endforeach
				</div>
			</div>
		</div>
    </div>
</div>

<script>
	$(document).ready(function() {
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		cargarSelectAlimentos();
		$('#cantidad').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: "", groupSize: 3, digits: 2 });
		$('#cantidad').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13') {
				if(!checkButtonAddStatus()) {
					addAlimento();
				} else {
					mostrarMensaje('Comprueba tus datos.', 'ERROR');
				}				
			}
		});		
	});

	function checkButtonAddStatus() {
		var prop = ($('#name').val() !== '' && $('#cantidad').val() !== '');
		$('#btnAdd').attr('disabled', !prop);
		return !prop;
	}

	function cargarSelectAlimentos() {
		$('.result').html('<img src="{{ asset('assets/images/load.gif') }}" alt=""></img>');
		$('#tabla{{ $entidad }}').html('<tr data-id="" data-cantidad="" id="emptyRow"><td class="text-primary text-center" colspan="25"><img src="{{ asset('assets/images/load.gif') }}" alt=""></img></td></tr>');
		$.ajax({
			url: 'alimento/cargarSelectAlimentos',
			data: {'_token': '{{ csrf_token() }}'},
			method: 'POST',
			beforeSend: function() {
				$('#name').html('<option value="">Cargando alimentos...</option>');				
			},
			success: function(e) {
				$('#name').html(e);
				$('#name').selectpicker();
				precargarTablaAlimentos();
			}
		});
	}

	function eliminarAlimento(btn, id) {
		(($(btn).parent()).parent()).remove();		
		reensamblarTablaAlimentos();
		mostrarMensaje('Alimento Eliminado Correctamente', 'OK');
	}

	function addAlimento() {
		var id = $('#name').val();
		var cantidad = $('#cantidad').val();
		var existe = false;
		$("#tabla{{ $entidad }} tr").each(function(){
			if(id == $(this).data('id')){
				existe = true;
			}
		});
		if(!existe){
			addAlimento2(id, cantidad);
		} else {
			mostrarMensaje('El alimento ya se agregó', 'ERROR');
		}
	}

	function addAlimento2(id, cantidad) {
		$.ajax({
			url: 'calculator/addAlimento',
			data: {'_token': '{{ csrf_token() }}', 'id': id, 'cantidad': cantidad},
			method: 'POST',
			dataType: 'JSON',
			success: function(e) {
				if(e.existe === 'S') {
					var fila =  `<tr data-cantidad="${e.cantidad}" data-id="${e.id}" id="${e.id}" align="center">
						<td class="text-left num">${e.id}</td>
						<td class="text-left descripcion">${e.descripcion}</td>
						<td class="text-left cantidad">${e.cantidad}</td>
						<td class="text-left energia_kcal">${e.energia_kcal}</td>
						<td class="text-left energia_kJ">${e.energia_kJ}</td>
						<td class="text-left agua">${e.agua}</td>
						<td class="text-left proteina">${e.proteina}</td>
						<td class="text-left grasa">${e.grasa}</td>
						<td class="text-left carbohidrato_total">${e.carbohidrato_total}</td>
						<td class="text-left carbohidrato_disponible">${e.carbohidrato_disponible}</td>
						<td class="text-left fibra_dietaria">${e.fibra_dietaria}</td>
						<td class="text-left ceniza">${e.ceniza}</td>
						<td class="text-left calcio">${e.calcio}</td>
						<td class="text-left fosforo">${e.fosforo}</td>
						<td class="text-left zinc">${e.zinc}</td>
						<td class="text-left hierro">${e.hierro}</td>
						<td class="text-left bcaroteno">${e.bcaroteno}</td>
						<td class="text-left vitaminaA">${e.vitaminaA}</td>
						<td class="text-left tiamina">${e.tiamina}</td>
						<td class="text-left riboflavina">${e.riboflavina}</td>
						<td class="text-left niacina">${e.niacina}</td>
						<td class="text-left vitaminaC">${e.vitaminaC}</td>
						<td class="text-left acido_folico">${e.acido_folico}</td>
						<td class="text-left sodio">${e.sodio}</td>
						<td class="text-left potasio">${e.potasio}</td>
						<td class="text-center">
							<a onclick="eliminarAlimento(this, ${e.id});" class="btn btn-xs btn-danger" type="button">
								<div class="glyphicon glyphicon-remove"></div>
							</a>
						</td>
					</tr>`;
					$("#tabla{{ $entidad }}").append(fila);
					reensamblarTablaAlimentos();
					$('#emptyRow').remove();
					$('#cantidad').val('');
					mostrarMensaje('Alimento Agregado Correctamente', 'OK');
				} else {
					mostrarMensaje('El alimento no se pudo agregar. No manipule los ID', 'ERROR');
				}					
			}
		});
	}

	function reensamblarTablaAlimentos() {
		var cadenaAlimentos = '';
		var cadenaCantidades = '';
		var cantRows = 0;
		$('#tabla{{ $entidad }} tr').each(function(index, el) {
			cadenaAlimentos += ($(this).data('id')===""?"":($(this).data('id') + ';'));
			cadenaCantidades += ($(this).data('cantidad')===""?"":($(this).data('cantidad') + ';'));
			cantRows++;
		});
		$('.num').each(function(index, el) {
			$(this).html((index + 1));
		});
		cadenaAlimentos = cadenaAlimentos.trim();
		cadenaCantidades = cadenaCantidades.trim();
		$("#cadenaAlimentos").val(cadenaAlimentos);
		$("#cadenaCantidades").val(cadenaCantidades);
		cambiarValoresSesion(cadenaAlimentos, cadenaCantidades);
		if(cantRows === 0) {
			$('.result').html('');
			resetAlimento();
		}
	}

	function resetAlimento() {
		$('#tabla{{ $entidad }}').html('<tr data-id="" data-cantidad="" id="emptyRow"><td class="text-primary text-center" colspan="25">Seleccione al menos un alimento.</td></tr>');
		$('.result').html('-');
	}

	function calcularSumas(empty) {
		$('.result').html('-');
		if(empty !== "") {
			var energia_kcal = 0;
			$('.energia_kcal').each(function(index, el) {
				energia_kcal += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var energia_kJ = 0;
			$('.energia_kJ').each(function(index, el) {
				energia_kJ += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var agua = 0;
			$('.agua').each(function(index, el) {
				agua += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var proteina = 0;
			$('.proteina').each(function(index, el) {
				proteina += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var grasa = 0;
			$('.grasa').each(function(index, el) {
				grasa += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var carbohidrato_total = 0;
			$('.carbohidrato_total').each(function(index, el) {
				carbohidrato_total += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var carbohidrato_disponible = 0;
			$('.carbohidrato_disponible').each(function(index, el) {
				carbohidrato_disponible += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var fibra_dietaria = 0;
			$('.fibra_dietaria').each(function(index, el) {
				fibra_dietaria += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var ceniza = 0;
			$('.ceniza').each(function(index, el) {
				ceniza += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var calcio = 0;
			$('.calcio').each(function(index, el) {
				calcio += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var fosforo = 0;
			$('.fosforo').each(function(index, el) {
				fosforo += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var zinc = 0;
			$('.zinc').each(function(index, el) {
				zinc += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var hierro = 0;
			$('.hierro').each(function(index, el) {
				hierro += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var bcaroteno = 0;
			$('.bcaroteno').each(function(index, el) {
				bcaroteno += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var vitaminaA = 0;
			$('.vitaminaA').each(function(index, el) {
				vitaminaA += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var tiamina = 0;
			$('.tiamina').each(function(index, el) {
				tiamina += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var riboflavina = 0;
			$('.riboflavina').each(function(index, el) {
				riboflavina += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var niacina = 0;
			$('.niacina').each(function(index, el) {
				niacina += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var vitaminaC = 0;
			$('.vitaminaC').each(function(index, el) {
				vitaminaC += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var acido_folico = 0;
			$('.acido_folico').each(function(index, el) {
				acido_folico += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var sodio = 0;
			$('.sodio').each(function(index, el) {
				sodio += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			var potasio = 0;
			$('.potasio').each(function(index, el) {
				potasio += parseFloat($.isNumeric($(this).html())?$(this).html():0.00);
			});
			$('#energia_kcal').html(energia_kcal.toFixed(2));
			$('#energia_kJ').html(energia_kJ.toFixed(2));
			$('#agua').html(agua.toFixed(2));
			$('#proteina').html(proteina.toFixed(2));
			$('#grasa').html(grasa.toFixed(2));
			$('#carbohidrato_total').html(carbohidrato_total.toFixed(2));
			$('#carbohidrato_disponible').html(carbohidrato_disponible.toFixed(2));
			$('#fibra_dietaria').html(fibra_dietaria.toFixed(2));
			$('#ceniza').html(ceniza.toFixed(2));
			$('#calcio').html(calcio.toFixed(2));
			$('#fosforo').html(fosforo.toFixed(2));
			$('#zinc').html(zinc.toFixed(2));
			$('#hierro').html(hierro.toFixed(2));
			$('#bcaroteno').html(bcaroteno.toFixed(2));
			$('#vitaminaA').html(vitaminaA.toFixed(2));
			$('#tiamina').html(tiamina.toFixed(2));
			$('#riboflavina').html(riboflavina.toFixed(2));
			$('#niacina').html(niacina.toFixed(2));
			$('#vitaminaC').html(vitaminaC.toFixed(2));
			$('#acido_folico').html(acido_folico.toFixed(2));
			$('#sodio').html(sodio.toFixed(2));
			$('#potasio').html(potasio.toFixed(2));
		}
			
	}

	function cambiarValoresSesion(cadenaAlimentos, cadenaCantidades) {
		$.ajax({
			url: 'calculator/cambiarValoresSesion',
			data: {'_token': '{{ csrf_token() }}', 'cadenaAlimentos': cadenaAlimentos, 'cadenaCantidades': cadenaCantidades},
			method: 'GET',
			beforeSend: function() {
				$('.result').html('<img src="{{ asset('assets/images/load.gif') }}" alt=""></img>');
			},
			success: function(e) {
				calcularSumas(cadenaAlimentos);
			}
		});
	}

	function precargarTablaAlimentos() {
		$.ajax({
			url: 'calculator/precargarTablaAlimentos',
			data: {'_token': '{{ csrf_token() }}'},
			method: 'POST',
			dataType: 'JSON',
			beforeSend: function() {
				$('.result').html('<img src="{{ asset('assets/images/load.gif') }}" alt=""></img>');
			},
			success: function(e) {
				$('#tabla{{ $entidad }}').html(e.tabla);
				$("#cadenaAlimentos").val(e.cadenaAlimentos);
				$("#cadenaCantidades").val(e.cadenaCantidades);				
				calcularSumas(e.cadenaAlimentos);
				checkButtonAddStatus();
			}
		});
	}
</script>