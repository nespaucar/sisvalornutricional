@if(count($lista) == 0)
<h3>No se encontraron resultados.</h3>
@else
<table style="width: 100%;">
	<thead>
		@for($i = 0; $i < 8; $i++)
			<tr><th></th></tr>
		@endfor
		<tr>
			@foreach($cabecera as $key => $value)
				<th style="font-weight: bold; border: 1px solid #000000;" @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		<?php
		$contador = 1;
		?>
		@foreach ($lista as $key => $value)
		<tr>
			<td style="border: 1px solid #000000;">{{ $contador }}</td>
			<td style="border: 1px solid #000000;">{{ date('d/m/Y H:i A', strtotime($value->created_at)) }}</td>
			<td style="border: 1px solid #000000;">{{ $value->descripcion }}</td>
			<td style="border: 1px solid #000000;">{{ $value->tabla }}</td>
			<td style="border: 1px solid #000000;">{{ $value->tabla_id }}</td>
			<td style="border: 1px solid #000000;">{{ $value->usuario->persona->nombre }}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
	
@endif