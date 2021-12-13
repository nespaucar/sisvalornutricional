@if(count($lista) == 0)
<h3 class="text-warning">No se encontraron resultados.</h3>
@else
{!! $paginacion or '' !!}
<table id="example1" class="table table-bordered table-striped table-condensed table-hover">

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
			<td class="center-block">
				<img height='50px' width='50px' class='img img-responsive center-block' src='{{ asset("logos/" . $value->logo)."?t=".time() }}' />
			</td>
			<td>{{ $value->estado=="A"?"HABILITADO":"DESHABILITADO" }}</td>
			@if($value->estado=="A")
				<td>{!! Form::button('<div class="glyphicon glyphicon-pencil"></div> Editar', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-xs btn-warning')) !!}</td>
				<td>{!! Form::button('<div class="glyphicon glyphicon-remove"></div> Deshabilitar', array('onclick' => 'modal (\''.URL::route($ruta["alterarestado"], array($value->id, 'SI', 'I')).'\', \'Dehabilitar Local\', this);', 'class' => 'btn btn-xs btn-danger')) !!}</td>
			@else
				<td class="text-center">-</td>
				<td>{!! Form::button('<div class="glyphicon glyphicon-check"></div> Habilitar', array('onclick' => 'modal (\''.URL::route($ruta["alterarestado"], array($value->id, 'SI', 'A')).'\', \'Habilitar Local\', this);', 'class' => 'btn btn-xs btn-success')) !!}</td>
			@endif
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
@endif