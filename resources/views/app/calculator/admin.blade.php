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
						{!! Form::label('cantidad', 'Cantidad (g)', array('class' => 'control-label')) !!}
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
							<th>#</th>
							<th>Alimento</th>
							<th>Cantidad</th>
							<th>ENERC</th>
							<th>ENERC</th>
							<th>WATER</th>
							<th>PROCNT</th>
							<th>FAT</th>
							<th>CHOCDF</th>
							<th>CHOAVL</th>
							<th>FIBTG</th>
							<th>ASH</th>
							<th>CA</th>
							<th>P</th>
							<th>ZN</th>
							<th>FE</th>
							<th>CARTBQ</th>
							<th>VITA</th>
							<th>THIA</th>
							<th>RIBF</th>
							<th>NIA</th>
							<th>VITC</th>
							<th>NA</th>
							<th>K</th>
							<th>x</th>
						</tr>
					</thead>
					<tbody id="tabla{{ $entidad }}">
						<tr>
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
						  	<div class="panel-footer result text-center" id="{{ $card['abrev'] }}">Panel Content</div>
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
		checkButtonAddStatus();
		$('#cantidad').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: "", groupSize: 3, digits: 2 });
		$('#cantidad').keyup(function (e) {
			var key = window.event ? e.keyCode : e.which;
			if (key == '13' && !checkButtonAddStatus()) {
				addAlimento();
			}
		});
	});

	function checkButtonAddStatus() {
		var prop = ($('#name').val() !== '' && $('#cantidad').val() !== '');
		$('#btnAdd').attr('disabled', !prop);
		return !prop;
	}

	function cargarSelectAlimentos() {
		$.ajax({
			url: 'alimento/cargarSelectAlimentos',
			data: {'_token': '{{ csrf_token() }}'},
			method: 'POST',
			beforeSend: function() {
				$('#name').html('<option value="">Cargando alimentos...</option>');
				$('.result').html('<img src="{{ asset('assets/images/load.gif') }}" alt=""></img>');
			},
			success: function(e) {
				$('#name').html(e);
				$('.result').html('-');
				$('#name').selectpicker();
			}
		});
	}

	function eliminarAlimento(btn, id) {
		(($(btn).parent()).parent()).remove();		
		reensamblarTablaAlimentos();
	}

	function addAlimento() {
		var id = $('#name').val();
		var existe = false;
		$("#tabla{{ $entidad }} tr").each(function(){
			if(id == $(this).data('id')){
				existe = true;
			}
		});
		if(!existe){
			addAlimento2(id);
		} else {
			mostrarMensaje('El alimento ya se agregó', 'ERROR');
		}
	}

	function addAlimento2(id) {
		$.ajax({
			url: 'calculator/addAlimento',
			data: {'_token': '{{ csrf_token() }}', 'id': id},
			method: 'POST',
			dataType: 'JSON',
			success: function(e) {
				if(e.existe === 'S') {
					var fila =  `<tr data-id="${e.id}" id="${e.id}" align="center">
						<td style="vertical-align: middle; text-align: left;">${e.id}</td>
						<td style="vertical-align: middle; text-align: left;">${e.descripcion}</td>
						<td style="vertical-align: middle; text-align: left;">${e.id}</td>
						<td style="vertical-align: middle; text-align: left;">${e.energia_kcal}</td>
						<td style="vertical-align: middle; text-align: left;">${e.energia_kJ}</td>
						<td style="vertical-align: middle; text-align: left;">${e.agua}</td>
						<td style="vertical-align: middle; text-align: left;">${e.proteina}</td>
						<td style="vertical-align: middle; text-align: left;">${e.grasa}</td>
						<td style="vertical-align: middle; text-align: left;">${e.carbohidrato_total}</td>
						<td style="vertical-align: middle; text-align: left;">${e.carbohidrato_disponible}</td>
						<td style="vertical-align: middle; text-align: left;">${e.fibra_dietaria}</td>
						<td style="vertical-align: middle; text-align: left;">${e.ceniza}</td>
						<td style="vertical-align: middle; text-align: left;">${e.calcio}</td>
						<td style="vertical-align: middle; text-align: left;">${e.fosforo}</td>
						<td style="vertical-align: middle; text-align: left;">${e.zinc}</td>
						<td style="vertical-align: middle; text-align: left;">${e.hierro}</td>
						<td style="vertical-align: middle; text-align: left;">${e.bcaroteno}</td>
						<td style="vertical-align: middle; text-align: left;">${e.vitaminaA}</td>
						<td style="vertical-align: middle; text-align: left;">${e.tiamina}</td>
						<td style="vertical-align: middle; text-align: left;">${e.riboflavina}</td>
						<td style="vertical-align: middle; text-align: left;">${e.niacina}</td>
						<td style="vertical-align: middle; text-align: left;">${e.vitaminaC}</td>
						<td style="vertical-align: middle; text-align: left;">${e.acido_folico}</td>
						<td style="vertical-align: middle; text-align: left;">${e.sodio}</td>
						<td style="vertical-align: middle; text-align: left;">${e.potasio}</td>
						<td style="vertical-align: middle;"><a onclick="eliminarAlimento(this, ${e.id});" class="btn btn-xs btn-danger" type="button"><div class="glyphicon glyphicon-remove"></div></a>
						</td>
					</tr>`;
					$("#tabla{{ $entidad }}").append(fila);
					reensamblarTablaAlimentos();
					$('#cantidad').val('');
					mostrarMensaje('Alimento Agregado Correctamente', 'OK');
				} else {
					mostrarMensaje('El alimento no se pudo agregar. No manipule los ID', 'ERROR');
				}					
			}
		});
	}

	function reensamblarTablaAlimentos() {
		var cadena = '';
		$('#tabla{{ $entidad }} tr').each(function(index, el) {
			cadena += $(this).data('id') + ';';
		});
		$("#cadenaAlimentos").val(cadena);
	}

	function resetAlimento() {

	}
</script>