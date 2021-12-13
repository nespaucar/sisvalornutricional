<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="row boxfondo">
    <div class="col-sm-12">
        <div class="card-box">

            <div class="row m-b-30">
                <div class="col-sm-12">
					{!! Form::open(['route' => $ruta["listarestadocuentareporte"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'form-inline', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
					{!! Form::hidden('page', 1, array('id' => 'page')) !!}
					{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
					{!! Form::hidden('totPagar', 0.00, array('id' => 'totPagar')) !!}
					{!! Form::hidden('totPagado', 0.00, array('id' => 'totPagado')) !!}
					{!! Form::hidden('totDeuda', 0.00, array('id' => 'totDeuda')) !!}
					<div class="form-group">
						{!! Form::label('mercader_id', 'Mercader', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('mercader_id', $cboMercaderes, null, array('class' => 'form-control input-xs', 'id' => 'mercader_id', 'onchange' => 'cargarDetallesConceptosPagosDeMercader();', 'data-live-search' => 'true')) !!}
					</div>					
					<div class="form-group">
						{!! Form::label('conceptopago_id', 'Concepto de Pago', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('conceptopago_id', $cboConceptos, null, array('class' => 'form-control input-xs', 'id' => 'conceptopago_id', 'onchange' => 'buscar2()', 'data-live-search' => 'true')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('anno', 'Período', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::selectRange('anno', 2021, 2080, (int) date('Y'), array('class' => 'form-control input-xs', 'data-live-search' => 'true', 'id' => 'anno', 'onchange' => 'buscar2()')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('buscarfecha', 'Buscar Fecha', array('class'=>'input-xs')) !!}
						{!! Form::text('buscarfecha', '', array('class' => 'form-control input-xs text-center', 'id' => 'buscarfecha', 'onkeyup' => 'buscarFecha(this);', 'maxlength' => '10')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('buscarestado', 'Buscar Estado', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('buscarestado', array(''=>'-- Todos --', 'PENDIENTE'=>'PENDIENTE', 'INCOMPLETO'=>'INCOMPLETO', 'PAGADO'=>'PAGADO', 'OMITIDO'=>'OMITIDO'), null, array('class' => 'form-control input-xs text-center', 'id' => 'buscarestado', 'onchange' => 'buscarEstado(this);')) !!}
					</div>
					{!! Form::button('<i class="glyphicon glyphicon-search"></i> Buscar', array('class' => 'btn btn-primary waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnBuscar', 'onclick' => 'buscar2()')) !!}
					{!! Form::button('<i class="fa fa-download"></i> Excel', array('class' => 'btn btn-success waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnExcel', 'onclick' => 'exportar(\''.$entidad.'\', \'E\')')) !!}
					{!! Form::button('<i class="fa fa-download"></i> PDF', array('class' => 'btn btn-danger waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnPDF', 'onclick' => 'exportar(\''.$entidad.'\', \'P\')')) !!}
					{!! Form::close() !!}
				</div>
            </div>

			<div id="listado{{ $entidad }}"></div>
			
            <table id="datatable" class="table table-striped table-bordered">
            </table>
        </div>
    </div>
</div>

<script>
	$(document).ready(function () {		
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$('#mercader_id').selectpicker();
		$('#tipo').selectpicker();
		$('#conceptopago_id').selectpicker();
		$('#anno').selectpicker();
		$('#buscarestado').selectpicker();
		cargarDetallesConceptosPagosDeMercader();
	});

	function buscar2() {
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="buscarfecha"]').val('');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="buscarestado"]').val('');
		$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="buscarestado"]').val('').selectpicker('refresh');
		buscar('{{$entidad}}');
	}

	function buscarFecha(field) {
		var i = 0;
		$('.fechaTd').each( function(element, index) {
			if($(this).html().trim().includes($(field).val().trim().toUpperCase())) {
				$(this).parent().show();
				i++;
			} else {
				$(this).parent().hide();
			}
		});
		$('#noFilas').hide();
		if(i === 0) {
			$('#noFilas').show();
		}
	}

	function buscarEstado(field) {
		var i = 0;
		$('.estadoTd').each( function(element, index) {
			if($(this).html().trim().includes($(field).val().trim().toUpperCase())) {
				$(this).parent().show();
				i++;
			} else {
				$(this).parent().hide();
			}
		});
		$('#noFilas').hide();
		if(i === 0) {
			$('#noFilas').show();
		}
	}

	function cargarDetallesConceptosPagosDeMercader() {
		$.ajax({
			url: 'persona/cargarDetallesConceptosPagosDeMercader?id='+$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="mercader_id"]').val(),
			type: 'GET',
			dataType: 'JSON',
			success: function(e) {
				//if(e.estado === 'OK') {
					$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="conceptopago_id"]').html(e.opciones);
					$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="conceptopago_id"]').selectpicker('refresh');
				//}
				buscar2();
			},
			error: function() {
				$(IDFORMBUSQUEDA + '{{ $entidad }} :input[id="conceptopago_id"]').html('<option value="">--- Ocurrió un error ---</option>');
			}
		});
	}
</script>