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
				<th colspan="10" class="text-center text-primary">
					<h3 class="text-primary">TOTAL INGRESOS: S/<b id="ingresoTotal">100</b></h3>
				</th>
			</tr>
			<tr>
				@foreach($cabecera as $key => $value)
					<th @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			<?php
			$contador = $inicio + 1;
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
				<td>{{ $contador }}</td>
				<td>{{ date('d/m/Y', strtotime($value->fecha)) }}</td>
				<td class="text-center">{{ $value->numero }}</td>
				<td>{{ number_format($value->monto_pagado, 2) }}</td>
				<td>#{{ $value->detallepago->detalleconceptopago->comentario }} {{ $value->detallepago->detalleconceptopago->conceptopago->nombre }}</td>
				<td class="text-center">{{ $value->detallepago->detalleconceptopago->tipo==='M'?'MENSUALES':'DIARIOS' }}</td>
				<td class="text-center">{{$ff}}</td>
				<?php 

				$estado = 'PAGADO';
				$class = 'text-success';
				switch ($value->state) {
					case 'C':
						$estado = 'ANULADO';
						$class = 'text-danger';
						break;
					case 'O':
						$estado = 'OMITIDO';
						$class = 'text-warning';
						break;
					case 'P':
						$ingresoTotal += $value->monto_pagado;
						break;
				}

				?>
				<td class="{{ $class }}"><strong>{{ $estado }}</strong></td>				
				<td>{{ '(' . $value->mercader->persona->dni . ') ' . $value->mercader->persona->nombres }}</td>
				<td>{{ '(' . $value->comisionista->persona->dni . ') ' . $value->comisionista->persona->nombres }}</td>
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
		$('#ingresoTotal').html('{{ number_format($ingresoTotal, 2) }}');
		$('#ingresosTotal').val('{{ number_format($ingresoTotal, 2) }}');
		$('#btnExcel').attr('disabled', false);
		$('#btnPDF').attr('disabled', false);
	});
</script>
	
@endif