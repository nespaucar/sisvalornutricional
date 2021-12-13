<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>

<?php 

	$meses = array('1' => 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO', '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');

?>

<!-- Main content -->
<div class="row boxfondo">
    <div class="col-sm-12">
        <div class="card-box">

            <div class="row m-b-30">
                <div class="col-sm-12">
					{!! Form::open(['route' => $ruta["listaringresoreporte"], 'method' => 'POST' ,'onsubmit' => 'return false;', 'class' => 'form-inline', 'role' => 'form', 'autocomplete' => 'off', 'id' => 'formBusqueda'.$entidad]) !!}
					{!! Form::hidden('page', 1, array('id' => 'page')) !!}
					{!! Form::hidden('accion', 'listar', array('id' => 'accion')) !!}
					{!! Form::hidden('ingresosTotal', 0, array('id' => 'ingresosTotal')) !!}					
					<div class="form-group">
						{!! Form::label('mercader_id', 'Mercader', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('mercader_id', $cboMercaderes, null, array('class' => 'form-control input-xs', 'id' => 'mercader_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('comisionista_id', 'Comisionista', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('comisionista_id', $cboComisionistas, null, array('class' => 'form-control input-xs', 'id' => 'comisionista_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
					</div>
					<div class="form-group">
						{!! Form::label('conceptopago_id', 'Concepto de Pago', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('conceptopago_id', $cboConceptos, null, array('class' => 'form-control input-xs', 'id' => 'conceptopago_id', 'onchange' => 'buscar(\''.$entidad.'\')', 'data-live-search' => 'true')) !!}
					</div>										
					<div class="form-group">
						{!! Form::label('tipo', 'Tipo de Reporte', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group">
						{!! Form::select('tipo', array('D' => 'Diario', 'M' => 'Mensual', 'R' => 'Rango de Fechas'), null, array('class' => 'form-control input-xs', 'id' => 'tipo', 'onchange' => 'changeDateType(this.value)')) !!}
					</div>
					<div class="form-group diario rango">
						{!! Form::label('fechai', 'Fecha Inicial', array('class'=>'input-xs labeldiario')) !!}
						{!! Form::date('fechai', date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fechai', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group rango">
						{!! Form::label('fechaf', 'Fecha Final', array('class'=>'input-xs')) !!}
						{!! Form::date('fechaf', date('Y-m-d'), array('class' => 'form-control input-xs', 'id' => 'fechaf', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group mensual">
						{!! Form::label('mes', 'Fecha', array('class'=>'input-xs')) !!}
					</div>
					<div class="form-group mensual">
						{!! Form::select('mes', $meses, (int) date('m'), array('class' => 'form-control input-xs', 'id' => 'mes', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
					</div>
					<div class="form-group mensual">
						{!! Form::selectRange('anno', 2021, 2080, (int) date('Y'), array('class' => 'form-control input-xs', 'data-live-search' => 'true', 'id' => 'anno', 'onchange' => 'buscar(\''.$entidad.'\')')) !!}
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
		init(IDFORMBUSQUEDA+'{{ $entidad }}', 'B', '{{ $entidad }}');
		$('#mercader_id').selectpicker();
		$('#tipo').selectpicker();
		$('#cobro').selectpicker();
		$('#conceptopago_id').selectpicker();
		$('#comisionista_id').selectpicker();
		$('#mes').selectpicker();
		$('#anno').selectpicker();
		changeDateType($('#tipo').val());
	});
	function changeDateType(tipo) {
		$('.rango').removeAttr('style').attr('style', 'display:none;');
		$('.diario').removeAttr('style').attr('style', 'display:none;');
		$('.mensual').removeAttr('style').attr('style', 'display:none;');
		$('.labeldiario').html('Fecha Inicial');
		switch (tipo) {
			case 'R':
				$('.rango').removeAttr('style');
				break;
			case 'D':
				$('.diario').removeAttr('style');
				$('.labeldiario').html('Fecha');
				break;
			case 'M':
				$('.mensual').removeAttr('style');
				break;
		}
		buscar('{{ $entidad }}');
	}
</script>