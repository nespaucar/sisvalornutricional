@if(count($lista) == 0)
<h3>No se encontraron resultados.</h3>
@else
<table style="width: 100%;">
	<thead>
		@for($i = 0; $i < 8; $i++)
			<tr><th></th></tr>
		@endfor
		<tr>
			<th colspan="10" style="color: #3F51B5; font-size: 15px; font-weight: bold;">
				TOTAL INGRESOS: S/{{ $ingresosTotal }}
			</th>
		</tr>
		<tr><th></th></tr>
		<tr>
			@foreach($cabecera as $key => $value)
				<th style="font-weight: bold; border: 1px solid #000000;" @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		<?php
		$contador = 1;
		$ingresoTotal = 0;
		$meses = array('1' => 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO', '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
		?>
		@foreach ($lista as $key => $value)
		<?php 

			//Armar la fecha con formato
			$ff = '';
			$fechag = date('Y-m-d', strtotime($value->detallepago->fecha));
			if($value->detallepago->detalleconceptopago->tipo==='M') {
				$ff = $meses[(int)date('m', strtotime($value->detallepago->fecha))] . ' ' . date('Y', strtotime($value->detallepago->fecha));
			} else {
				$ff = date('d/m/Y', strtotime($value->detallepago->fecha));
			}
		?>
		<tr>
			<td style="border: 1px solid #000000;">{{ $contador }}</td>
			<td style="border: 1px solid #000000;">{{ date('d/m/Y', strtotime($value->fecha)) }}</td>
			<td style="border: 1px solid #000000;">{{ $value->numero }}</td>
			<td style="border: 1px solid #000000;">{{ number_format($value->monto_pagado, 2) }}</td>
			<td style="border: 1px solid #000000;">#{{ $value->detallepago->detalleconceptopago->comentario }} {{ $value->detallepago->detalleconceptopago->conceptopago->nombre }}</td>
			<td style="border: 1px solid #000000;">{{ $value->detallepago->detalleconceptopago->tipo==='M'?'MENSUALES':'DIARIOS' }}</td>
			<td style="border: 1px solid #000000;">{{$ff}}</td>
			<?php 

			$estado = 'PAGADO';
			$class = '#54B359';
			switch ($value->state) {
				case 'C':
					$estado = 'ANULADO';
					$class = '#EB575D';
					break;
				case 'O':
					$estado = 'OMITIDO';
					$class = '#ECB100';
					break;
				case 'P':
					$ingresoTotal += $value->monto_pagado;
					break;
			}

			?>
			<td style="border: 1px solid #000000; color: {{ $class }};"><strong>{{ $estado }}</strong></td>
			<td style="border: 1px solid #000000;">{{ '(' . $value->mercader->persona->dni . ') ' . $value->mercader->persona->nombres }}</td>
			<td style="border: 1px solid #000000;">{{ '(' . $value->comisionista->persona->dni . ') ' . $value->comisionista->persona->nombres }}</td>
		</tr>
		<?php
		$contador = $contador + 1;
		?>
		@endforeach
	</tbody>
</table>
	
@endif