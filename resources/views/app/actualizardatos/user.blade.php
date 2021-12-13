<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ $title }}</h4>
        </div>
    </div>
</div>
<?php
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
$user = Auth::user();
$avatar = $user->avatar;
?>
<style>
	.fc-day {
		cursor: pointer;
	}
	.fc-day:hover {
		background-color: #DAE3E2;
	}
	#imageProfile {
		position: absolute;
		width: 100%;
		height: 190px;
		top: 0px;
		left: 0px;
		right: 0px;
		bottom: 0px;
		opacity: 0;
	}
	.imageProfileSection {
		border: #3F51B5 2px solid;
	}
</style>
<!-- Main content -->
<div class="row">
    <div class="col-md-6 col-md-offset-3 boxfondo">
        <div class="card-box">
			<div id="divMensajeError{!! $entidad !!}"></div>
			{!! Form::model($persona, $formData) !!}	
			{!! Form::hidden('listar', $listar, array('id' => 'listar')) !!}
			<div class="form-group">
				{!! Form::label('nombres', 'Nombres', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
				<div class="col-lg-9 col-md-9 col-sm-9">
					{!! Form::text('nombres', null, array('disabled','class' => 'form-control input-xs', 'placeholder' => 'Ingrese nombre')) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('dni', 'DNI', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
				<div class="col-lg-4 col-md-4 col-sm-4">
					{!! Form::text('dni', null, array('class' => 'form-control input-xs input-number', 'id' => 'dni', 'placeholder' => 'Ingrese dni', 'maxlength' => '8', 'readonly')) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('direccion', 'Direccion', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
				<div class="col-lg-9 col-md-9 col-sm-9">
					{!! Form::text('direccion', null, array('class' => 'form-control input-xs', 'id' => 'direccion', 'placeholder' => 'Ingrese direccion')) !!}
				</div>
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label requerido')) !!}
				<div class="col-lg-9 col-md-9 col-sm-9">
					{!! Form::text('email', $user->email, array('class' => 'form-control input-xs', 'id' => 'email', 'placeholder' => 'email@ejemplo.com')) !!}
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('imageProfile', 'Imagen de perfil (JPG|PNG|JPEG)', array('class' => 'col-lg-3 col-md-3 col-sm-3 control-label')) !!}
				<div class="col-lg-9 col-md-9 col-sm-9">
					{!! Form::file('imageProfile', array('id' => 'imageProfile', 'style' => 'cursor: pointer;')) !!}
					{!! Form::hidden('imgChange', "0", array('id' => 'imgChange')) !!}
					<center>
						<div id="imageProfileSection">
							<img src="{{ asset('avatar/' . $avatar) }}?t={{time()}}" class="img-circle imageProfileSection" height="200" width="200" alt="">
						</div>								
						<br>
						<br>
						{!! Form::button('<i class="fa fa-undo fa-md"></i> Restaurar Imagen', array('class' => 'btn btn-warning waves-effect waves-light btn-xl', 'onclick' => 'resetearImage();')) !!}
					</center>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-12 col-md-12 col-sm-12 text-right">
					{!! Form::button('<i class="fa fa-check fa-lg"></i> Guardar Cambios', array('class' => 'btn waves-effect waves-light btn-success', 'id' => 'btnGuardar', 'onclick' => 'actualizardatos(\''.$entidad.'\', this)')) !!}
				</div>
			</div>
			{!! Form::close() !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
    	<div id="CalendarioWeb" style="display: none;"></div>
    </div>
    <div class="col-sm-2"></div>
</div>

<script>
	$(document).ready(function() {
		init(IDFORMMANTENIMIENTO+'{!! $entidad !!}', 'M', '{!! $entidad !!}');	
		/*$("#CalendarioWeb").fullCalendar({
			header: {
				left: 'title',
				right: 'year,month,timelineCustom,agendaYear,prev,today,next, listMonth',
			},
			customButtons: {
				MiBoton: {
					text: 'Mi Botón',
					click: function() {
						alert('Mi boton');
					}
				}
			},
			dayClick: function(date, jsEvent, view) {
				alert('sd');
			},
			eventSources: [{
				events: [
					{
						title: 'Evento de prueba 1',
						start: '2021-03-05',
						color: '#FF0F0',
						textColor: '#FFFFFF'
					},
					{
						title: 'Evento de prueba 2',
						start: '2021-03-05',
						end: '2021-03-10'
					},
					{
						title: 'Evento de prueba 3',
						start: '2021-03-05T12:30:00',
						allDay: false,
						color: '#FFF000',
						textColor: '#000000'
					}
				],
				color: 'black',
				textColor: 'yellow',

			}],
			eventClick: function(callEvent, jsEvent, view) {
				alert('');
			}				
		});*/
		$("#imageProfile").change(function() {
			validarImagen(this);
		});
	});
		
	function actualizardatos (entidad, idboton) {
		var idformulario = IDFORMMANTENIMIENTO + entidad;
		//FORM
		console.log("1");
		console.log(entidad);
		var form = $('#formMantenimientoPersona')[0];
		// Create an FormData object
		var formulario = new FormData(form);
		console.log("2");
		console.log(entidad);
		var data  = procesarAjax(formulario,entidad);
		//FIN FORM
		var respuesta    = '';
		var listar       = 'NO';
		if ($(idformulario + ' :input[id = "listar"]').length) {
			var listar = $(idformulario + ' :input[id = "listar"]').val()
		};
		var btn = $(idboton);
		btn.button('loading');
		data.done(function(msg) {
			respuesta = msg;
		}).fail(function(xhr, textStatus, errorThrown) {
			respuesta = 'ERROR';
		}).always(function() {
			btn.button('reset');
			var divError ='#divMensajeError' + entidad;
			var divMensaje = $(divError);
			if(respuesta === 'ERROR'){
				var cadenaError = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Fallo al actualizar sus datos!!</strong></div>';
				divMensaje.html(cadenaError);
				divMensaje.show('slow');
			}else{
				if (respuesta === 'OK') {
					var cadenaExito = '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Sus datos han sido actualizados correctamente!!</strong></div>';
					divMensaje.html(cadenaExito);
					divMensaje.show('slow');
					var grilla ="#";
					$(idformulario).find(':input').each(function() {
						var elemento         = this;
						var cadena           = idformulario + " :input[id='" + elemento.id + "']";
						var elementoValidado = $(cadena);
						elementoValidado.parent().removeClass('has-error');
					});
					$("#imageProfile").val('');
					//Actualizar imagen -- tengo error no convierte de Object a string
					
					var accion = 'actualizardatosavatar';
					$.ajax({
						url : accion,
						data: {
							'_token': '{{ csrf_token() }}',
						},
						type: 'GET',
						success: function (img) {
							console.log(img);
							var avatar1 = '<img src="avatar/'+ img +'?t={{time()}}" alt="user-img" class="img-circle" height="40px" width="40px" style="border-color: red; border: #3F51B5 2px solid;">';
							var avatar2 = '<img style="cursor:pointer" onclick="cargarRuta(\'actualizardatos\', \'container\');" src="avatar/'+ img +'?t={{time()}}" alt="user-img" class="img-circle" height="90px" width="90px" style="border-color: red; border: #3F51B5 2px solid;">';
							var divAvatar1 = $('#imgProfile1');
							var divAvatar2 = $('#imgProfile2');
							divAvatar1.html(avatar1);
							divAvatar2.html(avatar2);
							divAvatar1.show('slow');
							divAvatar2.show('slow');
							$("#imageProfile").val('');
						},
					});
				} else {
					mostrarErrores(respuesta, idformulario, entidad);
				}
			}
		});
	}

	function procesarAjax(DATA,entidad) {
		if(entidad === "Persona"){
			var url     = $('#formMantenimientoPersona').attr('action').toLowerCase();
		}
		var respuesta  = $.ajax({
			url: url,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
			type: 'POST',
			enctype: 'multipart/form-data',
			data: DATA,
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000
		});
		return respuesta;
	}

	$('.input-number').on('input', function () { 
    	this.value = this.value.replace(/[^0-9]/g,'');
	});

	function validarImagen(obj) {
		var ret = true;
	    var uploadFile = obj.files[0];

	    if (!window.FileReader) {
	        mostrarMensaje('Tu navegador no soporta Cambio de imagen', 'ERROR');
	        $("#imgChange").val("0");
	        resetearImage();
	    }

	    if (!(/\.(jpg|png|jpeg|JPG|PNG|JPEG)$/i).test(uploadFile.name)) {
	        mostrarMensaje('Formato de Archivo no permitido', 'ERROR');
	        $("#imgChange").val("0");
	        resetearImage();
	    } else {
	        var img = new Image();
	        img.onload = function () {
	            if (uploadFile.size > 500000) {
	                mostrarMensaje('El archivo no puede pesar más de 500KB', 'ERROR');
	                resetearImage();
	                $("#imgChange").val("0");
	            } else {
	            	filePreview(obj);
	            	$("#imgChange").val("1");
	            }
	        };
	        img.src = URL.createObjectURL(uploadFile);
	    }                 
	}

	function filePreview(input) {		
		if(input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {				
				$("#imageProfileSection").html('<img src="' + e.target.result + '" class="img-circle imageProfileSection" height="200" width="200" alt="">');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	function resetearImage() {
		var accion = 'actualizardatosavatar';
		$.ajax({
			url : accion,
			data: {
				'_token': '{{ csrf_token() }}',
			},
			type: 'GET',
			success: function (img) {
				$("#imageProfileSection").html('<img src="avatar/' + img + '?t={{time()}}" class="img-circle imageProfileSection" height="200" width="200" alt="">');
				$("#imgChange").val("0");
				$("#imageProfile").val('');
			},
		});		
	}
</script>