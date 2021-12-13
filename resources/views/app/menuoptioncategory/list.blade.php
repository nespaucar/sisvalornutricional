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
				<?php 
					$posicion = '';
					if ($value->position == 'V') {
						$posicion = 'Vertical';
					}elseif ($value->position == 'H') {
						$posicion = 'Horizontal';
					}
				?>
				<td>{{ $contador }}</td>				
				<td>{{ $value->name }}</td>
				<td class="text-primary"><i class="{{ $value->icon }}"></i></td>
				<td>{{ $value->order }}</td>
				<td>{{ ($value->Fathercategory !== NULL ? $value->Fathercategory->name : '-') }}</td>
				<td>{{ $posicion }}</td>
				<td class="text-center">{!! Form::button('<div class="glyphicon glyphicon-pencil"></div>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-xs btn-warning waves-effect waves-light')) !!}</td>
				<td class="text-center">{!! Form::button('<div class="glyphicon glyphicon-remove"></div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-xs btn-danger waves-effect waves-light')) !!}</td>
			</tr>
			<?php
			$contador = $contador + 1;
			?>
			@endforeach
		</tbody>
	</table>
</div>
	
@endif