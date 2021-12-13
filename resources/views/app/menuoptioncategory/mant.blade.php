<?php 
$icono = 'fa fa-bank';
if ($menuoptioncategory !== NULL) {
	$icono = $menuoptioncategory->icon;
}
?>

<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($menuoptioncategory, $formData) !!}	
	{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
	<div class="form-group">
		{!! Form::label('menuoptioncategory_id', 'Categoría', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
		<div class="col-lg-9 col-md-9 col-sm-9">
			{!! Form::select('menuoptioncategory_id', $cboCategoria, null, array('class' => 'form-control input-xs', 'id' => 'menuoptioncategory_id', 'data-live-search' => 'true')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('name', 'Nombre', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
		<div class="col-lg-9 col-md-9 col-sm-9">
			{!! Form::text('name', null, array('class' => 'form-control input-xs', 'id' => 'name', 'placeholder' => 'Ingrese nombre')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('order', 'Orden', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
		<div class="col-lg-9 col-md-9 col-sm-9">
			{!! Form::text('order', null, array('class' => 'form-control input-xs', 'id' => 'order', 'placeholder' => 'Ingrese orden')) !!}
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('icon', 'Icono', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
		<div class="col-lg-9 col-md-9 col-sm-9">
			{!! Form::select('icon', $cboIconos, null, array('class' => 'form-control input-xs', 'id' => 'icon', 'onchange' => 'changeIcon(this.value);', 'data-live-search' => 'true')) !!}
			<br>
			<br>
			<center>
				<i style="font-size: 50px; color: blue;" id="imgIcon"></i>
			</center>
		</div>
	</div>
	<div class="form-group">
		{!! Form::label('position', 'Posicion', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
		<div class="col-lg-9 col-md-9 col-sm-9">
			{!! Form::select('position', array('V' => 'Vertical'), null, array('class' => 'form-control input-xs', 'id' => 'position')) !!}
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
		configurarAnchoModal('500');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		$(IDFORMMANTENIMIENTO + '{{ $entidad }} :input[id="icon"]').selectpicker();
		$(IDFORMMANTENIMIENTO + '{{ $entidad }} :input[id="menuoptioncategory_id"]').selectpicker();
		changeIcon($(IDFORMMANTENIMIENTO + '{{ $entidad }} :input[id="icon"]').val());
		
	});
	function changeIcon(val) {
		$("#imgIcon").removeAttr('class').addClass(val);
	}	
</script>