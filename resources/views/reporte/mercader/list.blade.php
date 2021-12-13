@if(count($lista) == 0)
<h3 class="text-danger">No se encontraron resultados.</h3>
<script>
	$(document).ready(function() {
		$('#btnExcel').attr('disabled', true);
		$('#btnPDF').attr('disabled', true);
	});
</script>
@else
{!! $paginacion !!}
<div class="table-responsive">
	<table id="example1" class="table table-condensed table-hover">

		<thead>
			<tr>
				@foreach($cabecera as $key => $value)
					<th @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>
						{!! $value['valor'] !!}
					</th>
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
				<td>{{ $value->mercader->persona->dni . ' - ' . $value->mercader->persona->nombres }}</td>
				<td style="font-weight: bold;" class="{{ $value->mercader->state === 'A' ? 'text-success' : 'text-danger' }}">{{ $value->mercader->state === 'A' ? 'ACTIVO' : 'INACTIVO' }}</td>
				<td>{{ $value->mercader->persona->direccion === NULL ? '-' : $value->mercader->persona->direccion }}</td>
				<td>{{ $value->mercader->persona->telefono === NULL ? '-' : $value->mercader->persona->telefono }}</td>
				<td>#{{ $value->comentario . ' ' . $value->conceptopago->nombre }}</td>
				<td>{{ number_format($value->monto, 2) }}</td>
				<td>{{ $value->tipo === 'D' ? 'DIARIOS' : 'MENSUALES' }}</td>
				<td>{{ $value->tipo2 }}</td>
			</tr>
			<?php
			$contador = $contador + 1;
			?>
			@endforeach
		</tbody>
	</table>
</div>
<script>
	$(document).ready(function() {
		$('#btnExcel').attr('disabled', false);
		$('#btnPDF').attr('disabled', false);
	});
</script>
	
@endif