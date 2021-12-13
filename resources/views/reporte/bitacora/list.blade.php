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
				<td>{{ date('d/m/Y H:i A', strtotime($value->created_at)) }}</td>
				<td style="height: auto;">{{ $value->descripcion }}</td>
				@if($user->usertype_id === 1)
					<td>{{ $value->tabla }}</td>
					<td>{{ $value->tabla_id }}</td>
				@endif
				<td>{{ $value->usuario->persona->nombres }}</td>
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