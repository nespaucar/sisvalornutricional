<div id="divMensajeError{!! $entidad !!}"></div>
{!! Form::model($alimento, $formData) !!}	
{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
<div class="form-group">
	<div class="col-lg-4 col-md-4 col-sm-4">
		<div class="form-group">
			{!! Form::label('grupo_id', 'Grupo', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
			<div class="col-lg-8 col-md-8 col-sm-8">
				{!! Form::select('grupo_id', $cboGrupo, null, array('class' => 'form-control input-xs', 'id' => 'grupo_id', 'data-live-search' => 'true')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('estrato', 'Estrato', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('estrato', null, array('class' => 'form-control input-xs text-right', 'id' => 'estrato', 'placeholder' => 'Ingrese estrato', 'maxlength' => '1')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('numero', 'Numero', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('numero', null, array('class' => 'form-control input-xs text-right', 'id' => 'numero', 'placeholder' => 'Ingrese numero', 'maxlength' => '5')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('descripcion', 'Descripcion', array('class' => 'col-lg-4 col-md-4 col-sm-4 control-label requerido')) !!}
			<div class="col-lg-8 col-md-8 col-sm-8">
				{!! Form::textarea('descripcion', null, array('class' => 'form-control input-xs', 'id' => 'descripcion', 'placeholder' => 'Ingrese descripcion', 'maxlength' => '120', 'rows' => 4)) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('energia_kcal', 'Energía Kcal', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('energia_kcal', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'energia_kcal', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('energia_kJ', 'Energía kJ', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('energia_kJ', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'energia_kJ', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('agua', 'Agua', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('agua', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'agua', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('proteina', 'Proteína', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('proteina', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'proteina', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4">
		<div class="form-group">
			{!! Form::label('grasa', 'Grasa', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('grasa', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'grasa', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('carbohidrato_total', 'Carbohidrato Total', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('carbohidrato_total', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'carbohidrato_total', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('carbohidrato_disponible', 'Carbohidrato Disponible', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('carbohidrato_disponible', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'carbohidrato_disponible', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('fibra_dietaria', 'Fibra Dietaria', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('fibra_dietaria', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'fibra_dietaria', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('ceniza', 'Ceniza', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('ceniza', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'ceniza', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('calcio', 'Calcio', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('calcio', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'calcio', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('fosforo', 'Fósforo', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('fosforo', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'fosforo', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('zinc', 'Zinc', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('zinc', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'zinc', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('hierro', 'Hierro', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('hierro', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'hierro', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
	</div>
	<div class="col-lg-4 col-md-4 col-sm-4">
		<div class="form-group">
			{!! Form::label('bcaroteno', 'B Caroteno', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('bcaroteno', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'bcaroteno', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('vitaminaA', 'Vitamina A', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('vitaminaA', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'vitaminaA', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('tiamina', 'Tiamina', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('tiamina', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'tiamina', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('riboflavina', 'Riboflavina', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('riboflavina', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'riboflavina', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('niacina', 'Niacina', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('niacina', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'niacina', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('vitaminaC', 'Vitamina C', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('vitaminaC', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'vitaminaC', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('acido_folico', 'Ácido Fólico', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('acido_folico', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'acido_folico', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('sodio', 'Sodio', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('sodio', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'sodio', 'placeholder' => '-', 'maxlength' => '8')) !!}
			</div>
		</div>
		<div class="form-group">
			{!! Form::label('potasio', 'Potasio', array('class' => 'col-lg-8 col-md-8 col-sm-8 control-label requerido')) !!}
			<div class="col-lg-4 col-md-4 col-sm-4">
				{!! Form::text('potasio', null, array('class' => 'form-control input-xs text-right numba', 'id' => 'potasio', 'placeholder' => '-', 'maxlength' => '8')) !!}
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
		configurarAnchoModal('1200');
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');
		$(IDFORMMANTENIMIENTO + '{{ $entidad }} :input[id="grupo_id"]').selectpicker();
		$('.numba').inputmask('decimal', { radixPoint: ".", autoGroup: true, groupSeparator: "", groupSize: 3, digits: 2 });
	});
</script>