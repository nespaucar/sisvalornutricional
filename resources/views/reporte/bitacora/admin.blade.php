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
					{!! Form::open(['route' => $ruta["listarbitacorareporte"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'form-inline', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
					{!! Form::hidden('page', 1, array('id' => 'page')) !!}
					{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
					<div class="form-group">
						{!! Form::label('fecha', 'Fecha', array('class'=>'input-xs')) !!}
						{!! Form::date('fecha', '', array('class' => 'form-control input-xs', 'id' => 'fecha', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('name', 'Descripción', array('class'=>'input-xs')) !!}
						{!! Form::text('name', '', array('class' => 'form-control input-xs', 'id' => 'name', 'onkeyup' => 'buscar(\''.$entidad.'\')')) !!}
						{!! Form::label('usuario_id', 'Persona', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('usuario_id', $cboPersonas, null, array('class' => 'form-control input-xs', 'id' => 'usuario_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
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
		$('#usuario_id').selectpicker();
	});
</script>