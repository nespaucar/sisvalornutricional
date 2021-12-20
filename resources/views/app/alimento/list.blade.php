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
				<td>{{ $value->descr===NULL||$value->descr==""?"-":$value->descr }}</td>
				<td>{{ $value->energia_kcal===NULL||$value->energia_kcal==""?"-":$value->energia_kcal }}</td>
				<td>{{ $value->energia_kJ===NULL||$value->energia_kJ==""?"-":$value->energia_kJ }}</td>
				<td>{{ $value->agua===NULL||$value->agua==""?"-":$value->agua }}</td>
				<td>{{ $value->proteina===NULL||$value->proteina==""?"-":$value->proteina }}</td>
				<td>{{ $value->grasa===NULL||$value->grasa==""?"-":$value->grasa }}</td>
				<td>{{ $value->carbohidrato_total===NULL||$value->carbohidrato_total==""?"-":$value->carbohidrato_total }}</td>
				<td>{{ $value->carbohidrato_disponible===NULL||$value->carbohidrato_disponible==""?"-":$value->carbohidrato_disponible }}</td>
				<td>{{ $value->fibra_dietaria===NULL||$value->fibra_dietaria==""?"-":$value->fibra_dietaria }}</td>
				<td>{{ $value->ceniza===NULL||$value->ceniza==""?"-":$value->ceniza }}</td>
				<td>{{ $value->calcio===NULL||$value->calcio==""?"-":$value->calcio }}</td>
				<td>{{ $value->fosforo===NULL||$value->fosforo==""?"-":$value->fosforo }}</td>
				<td>{{ $value->zinc===NULL||$value->zinc==""?"-":$value->zinc }}</td>
				<td>{{ $value->hierro===NULL||$value->hierro==""?"-":$value->hierro }}</td>
				<td>{{ $value->bcaroteno===NULL||$value->bcaroteno==""?"-":$value->bcaroteno }}</td>
				<td>{{ $value->vitaminaA===NULL||$value->vitaminaA==""?"-":$value->vitaminaA }}</td>
				<td>{{ $value->tiamina===NULL||$value->tiamina==""?"-":$value->tiamina }}</td>
				<td>{{ $value->riboflavina===NULL||$value->riboflavina==""?"-":$value->riboflavina }}</td>
				<td>{{ $value->niacina===NULL||$value->niacina==""?"-":$value->niacina }}</td>
				<td>{{ $value->vitaminaC===NULL||$value->vitaminaC==""?"-":$value->vitaminaC }}</td>
				<td>{{ $value->acido_folico===NULL||$value->acido_folico==""?"-":$value->acido_folico }}</td>
				<td>{{ $value->sodio===NULL||$value->sodio==""?"-":$value->sodio }}</td>
				<td>{{ $value->potasio===NULL||$value->potasio==""?"-":$value->potasio }}</td>
				<td class="text-center">
					{!! Form::button('<div class="glyphicon glyphicon-pencil"></div>', array('onclick' => 'modal (\''.URL::route($ruta["edit"], array($value->id, 'listar'=>'SI')).'\', \''.$titulo_modificar.'\', this);', 'class' => 'btn btn-xs btn-warning waves-effect waves-light')) !!}
				</td>
				<td class="text-center">
					{!! Form::button('<div class="glyphicon glyphicon-remove"></div>', array('onclick' => 'modal (\''.URL::route($ruta["delete"], array($value->id, 'SI')).'\', \''.$titulo_eliminar.'\', this);', 'class' => 'btn btn-xs btn-danger')) !!}
				</td>
			</tr>
			<?php
			$contador = $contador + 1;
			?>
			@endforeach
		</tbody>
	</table>
</div>
	
@endif