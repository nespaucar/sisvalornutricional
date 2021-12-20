<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($grupo, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="form-group">
			{!! Form::label('codigo', 'Código', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('codigo', null, array('class' => 'form-control input-xs text-right', 'id' => 'codigo', 'placeholder' => 'Ingrese codigo', 'maxlength' => '2')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
			<div class="col-lg-8 col-md-8 col-sm-8">
				{!! Form::textarea('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion', 'placeholder' => 'Ingrese razon social', 'maxlength' => '120', 'rows' => 4)) !!}
			</div>
		</div>
	</div>
</div>
		
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm waves-effect waves-light', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm waves-effect waves-light', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		configurarAnchoModal('600');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
	});
</script>