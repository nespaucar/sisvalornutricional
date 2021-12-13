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
				<th style="font-weight: bold; border: 1px solid #000000;" @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>
					{!! $value['valor'] !!}
				</th>
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
			<td style="border: 1px solid #000000;">{{ $value->mercader->persona->dni . ' - ' . $value->mercader->persona->nombres }}</td>
			<td style="border: 1px solid #000000; font-weight: bold; color: {{ $value->mercader->state === 'A' ? '#54B359' : '#EB575D' }}">{{ $value->mercader->state === 'A' ? 'ACTIVO' : 'INACTIVO' }}</td>
			<td style="border: 1px solid #000000;">{{ $value->mercader->persona->direccion === NULL ? '-' : $value->mercader->persona->direccion }}</td>
			<td style="border: 1px solid #000000;">{{ $value->mercader->persona->telefono === NULL ? '-' : $value->mercader->persona->telefono }}</td>
			<td style="border: 1px solid #000000;">#{{ $value->comentario . ' ' . $value->conceptopago->nombre }}</td>
			<td style="border: 1px solid #000000;">{{ number_format($value->monto, 2) }}</td>
			<td style="border: 1px solid #000000;">{{ $value->tipo === 'D' ? 'DIARIOS' : 'MENSUALES' }}</td>
			<td style="border: 1px solid #000000;">{{ $value->tipo2 }}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
	
@endif