@if(count($lista) == 0)
<h3 class="text-danger">No se encontraron resultados.</h3>
@else
{!! $paginacion !!}
<div class="table-responsive">
	<table id="example1" class="table table-condensed table-hover">

		<thead>
			<tr>
				@foreach($cabecera as $key => $value)
					<th @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			<?php
			$contador = $inicio + 1;
			?>
			@foreach ($lista as $key => $value)
			<tr>
				<td>{{ $contador }}</td>
				<td>{{ $value->descripcion }}</td>
				<td>{{ $value->estado=="A"?"HABILITADO":"DESHABILITADO" }}</td>
				@if($value->estado=="A")
					<td class="text-center">{!! Form::button('<div class="glyphicon glyphicon-pencil"></div>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-xs btn-warning waves-effect waves-light')) !!}</td>
					<td class="text-center">{!! Form::button('<div class="glyphicon glyphicon-remove"></div> Deshabilitar', array('onclick' => 'modal (\''.URL::route($ruta["alterarestado"], array($value->id, 'SI', 'I')).'\', \'Dehabilitar Local\', this);', 'class' => 'btn btn-xs btn-danger waves-effect waves-light')) !!}</td>
				@else
					<td class="text-center">-</td>
					<td class="text-center">{!! Form::button('<div class="glyphicon glyphicon-check"></div> Habilitar', array('onclick' => 'modal (\''.URL::route($ruta["alterarestado"], array($value->id, 'SI', 'A')).'\', \'Habilitar Local\', this);', 'class' => 'btn btn-xs btn-success waves-effect waves-light')) !!}</td>
				@endif
			</tr>
			<?php
			$contador = $contador + 1;
			?>
			@endforeach
		</tbody>
	</table>
</div>
	
@endif