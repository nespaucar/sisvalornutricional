<?php 

$nombrepersona = '';
$persona_id = '';
$telefono = '';
$email = '';
$direccion = '';

if($usuario !== NULL) {
	$nombrepersona = $usuario->persona->nombre;
	$persona_id = $usuario->persona_id;
	$telefono = $usuario->persona->telefono;
	$email = $usuario->persona->email;
	$direccion = $usuario->persona->direccion;
}

?>
<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($usuario, $formData) !!}
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
	{!! Form::label('usertype_id', 'Tipo de usuario', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-8 col-md-8 col-sm-8">
		@if($usuario == null)	
			{!! Form::select('usertype_id', $cboUsertype, null, array('class' => 'form-control input-xs', 'id' => 'usertype_id')) !!}
		@else
			{!! Form::select('usertype_id', $cboUsertype, null, array('disabled','class' => 'form-control input-xs')) !!}
		@endif
	</div>
</div>
<div class="form-group">
	{!! Form::label('nombre', 'Nombre', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-8 col-md-8 col-sm-8">
		{!! Form::text('nombre', $nombrepersona, array('class' => 'form-control input-xs', 'id' => 'nombre', 'placeholder' => 'Escribe Nombre de Persona', 'maxlength' => '100')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('direccion', 'Dirección', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label')) !!}
	<div class="col-lg-8 col-md-8 col-sm-8">
		{!! Form::text('direccion', $direccion, array('class' => 'form-control input-xs', 'id' => 'direccion', 'placeholder' => 'Escribe Nombre de Persona', 'maxlength' => '100')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('telefono', 'Teléfono', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-6 col-md-6 col-sm-6">
		{!! Form::text('telefono', $telefono, array('class' => 'form-control input-xs', 'id' => 'telefono', 'placeholder' => 'Seleccione Nombre de Persona', 'maxlength' => '9')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('email', 'Email', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-8 col-md-8 col-sm-8">
		{!! Form::text('email', $email, array('class' => 'form-control input-xs', 'id' => 'email', 'placeholder' => 'Seleccione Nombre de Persona')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('login', 'Usuario', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-5 col-md-5 col-sm-5">
		{!! Form::text('login', null, array('class' => 'form-control input-xs', 'id' => 'login', 'placeholder' => 'Ingrese Usuario', 'maxlength' => '8')) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('password', 'Password', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
	<div class="col-lg-5 col-md-5 col-sm-5">
		{!! Form::password('password', array('class' => 'form-control input-xs', 'id' => 'password', 'placeholder' => 'Ingrese Password')) !!}
	</div>
</div>
<div class="form-group">
	<div class="col-lg-12 col-md-12 col-sm-12 text-right">
		{!! Form::button('<i class="fa fa-check fa-lg"></i> '.$boton, array('class' => 'btn btn-success btn-sm waves-effect waves-light', 'id' => 'btnGuardar', 'onclick' => 'guardar(\''.$entidad.'\', this)')) !!}
		&nbsp;
		{!! Form::button('<i class="fa fa-exclamation fa-lg"></i> Cancelar', array('class' => 'btn btn-warning btn-sm waves-effect waves-light', 'id' => 'btnCancelar'.$entidad, 'onclick' => 'cerrarModal();')) !!}
	</div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		$(IDFORMMANTENIMIENTO + '{!! $entidad !!} :input[id="usertype_id"]').focus();
		configurarAnchoModal('550');
	}); 
</script>