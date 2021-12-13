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
					{!! Form::open(['route' => $ruta["listarmercaderreporte"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'form-inline', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
					{!! Form::hidden('page', 1, array('id' => 'page')) !!}
					{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
					<div class="form-group">
						{!! Form::label('mercader_id', 'Mercader', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('mercader_id', $cboMercaderes, null, array('class' => 'form-control input-xs', 'id' => 'mercader_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('tipo', 'Tipo', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('tipo', array('' => '-- Todos --', 'Mercado' => 'Mercado', 'Mercadillo' => 'Mercadillo', 'Ambulante' => 'Ambulante'), null, array('class' => 'form-control input-xs', 'id' => 'tipo', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('conceptopago_id', 'Concepto de Pago', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('conceptopago_id', $cboConceptos, null, array('class' => 'form-control input-xs', 'id' => 'conceptopago_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('cobro', 'Cobros', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('cobro', array('' => '-- Todos --', 'D' => 'DIARIOS', 'M' => 'MENSUALES'), null, array('class' => 'form-control input-xs', 'id' => 'cobro', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('filas', 'Filas a mostrar', array('class'=>'input-xs'))!!}
						{!! Form::selectRange('filas', 1, 30, 10, array('class' => 'form-control input-xs', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					{!! Form::button('<i class="glyphicon glyphicon-search"></i> Buscar', array('class' => 'btn btn-primary waves-effect waves-light m-l-10 btn-sm', 'id' => 'btnBuscar', 'onclick' => 'buscar(\''.$entidad.'\')')) !!}
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
		buscar('{{ $entidad }}');
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$('#mercader_id').selectpicker();
		$('#tipo').selectpicker();
		$('#cobro').selectpicker();
		$('#conceptopago_id').selectpicker();
	});
</script>