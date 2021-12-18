<?php
	use App\Models\Detalleconceptopago;
	use App\Models\Detallepago;
	$meses = array('1' => 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO', '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
?>
@if($mercader === NULL)
	<h3>Debe seleccionar un mercader.</h3>
@else
	@if($detconceptopago === NULL)
		<h3>Debe seleccionar un concepto de pago.</h3>
	@else
		@if(!is_null($anno)&&$anno!=='')
			<?php
				//Comprobamos si son cobros diarios o mensuales
				$detalleconceptopago = Detalleconceptopago::where('id', '=', $detconceptopago->id)
						->where('mercader_id', '=', $mercader->id)
						->first();
			?>
			@if($detalleconceptopago === NULL)
				<h3>El concepto de Pago no le corresponde al mercader {{$mercader->persona->nombre}}.</h3>
			@else
				<table style="width: 100%;">
					@for($i = 0; $i < 10; $i++)
						<tr><th></th></tr>
					@endfor
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th colspan="2" style="font-weight: bold; border: 1px solid #000000;">CUADRO RESUMEN {{$anno}}</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th></th>
							<th></th>
							<th style="font-weight: bold; border: 1px solid #000000; color: #3F51B5;">TOTAL A PAGAR</th>
							<td style="font-weight: bold; border: 1px solid #000000; color: #3F51B5;">{{$totPagar}}</td>
						</tr>
						<tr>
							<th></th>
							<th></th>
							<th style="font-weight: bold;  border: 1px solid #000000; color: #66BB6A;">TOTAL PAGADO</th>
							<td style="font-weight: bold; border: 1px solid #000000; color: #66BB6A;">{{$totPagado}}</td>
						</tr>
						<tr>
							<th></th>
							<th></th>
							<th style="font-weight: bold; border: 1px solid #000000; color: #EE6E73;">TOTAL DEUDA</th>
							<td style="font-weight: bold; border: 1px solid #000000; color: #EE6E73;">{{$totDeuda}}</td>
						</tr>
					</tbody>
				</table>
				<table style="width: 100%;">
					<thead>
						<tr>
							@foreach($cabecera as $key => $value)
								<th style="font-weight: bold; border: 1px solid #000000;" @if($value['numero'] > 1) colspan="{{ $value['numero'] }}" @endif>{!! $value['valor'] !!}</th>
							@endforeach
						</tr>
					</thead>
					<tbody>
						<?php
							// Obtener el tipo de cobro
							$tipo = $detalleconceptopago->tipo;
							//Armamos las fechas
						?>
						@if($tipo === 'D')
							<?php
								$fechaInicio = strtotime($anno."-01-01");
								$fechaFin = strtotime($anno."-12-31");
								$num = 1;
							?>
							@for($i = $fechaInicio; $i <= $fechaFin; $i += 86400)
								<?php 
									//Obtenemos el detalle de pago general
									$detallepago = Detallepago::where('fecha', '=', date('Y-m-d', $i))
										->where('mercader_id', '=', $mercader->id)
										->where('detalleconceptopago_id', '=', $detalleconceptopago->id)
										->whereNull('detallepago_id')
										->where('state', '<>', 'C')
										->select('id', 'monto_pagado', 'monto_deuda', 'state', 'comentario')
										->first();
									$ff = date("d/m/Y", $i);
									$periodo = date("Y-m-d", $i);

								?>
								@if($detallepago!==NULL)
									<?php 
										$estado = 'PAGADO';
										$class = '#54B359';
										switch ($detallepago->state) {
											case 'A':
												$estado = 'PENDIENTE';
												$class = '#3F51B5';
												break;
											case 'O':
												$estado = 'OMITIDO';
												$class = '#ECB100';
												break;
											case 'I':
												$estado = 'INCOMPLETO';
												$class = '#11AEF5';
												break;
										}
									?>
									<tr>
										<td style="border: 1px solid #000000;">{{$num}}</td>
										<td style="border: 1px solid #000000;">#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
										<td style="border: 1px solid #000000;">DIARIO</td>
										<td style="border: 1px solid #000000;">{{number_format($detallepago->monto_pagado, 2)}}</td>
										<td style="border: 1px solid #000000;">{{number_format($detallepago->monto_deuda, 2)}}</td>
										<td style="border: 1px solid #000000;">{{$ff}}</td>
										<td style="border: 1px solid #000000; color: {{ $class }}; font-weight: bold;">{{$estado}}</td>
									</tr>
									<?php 

										// Obtenermos los detalles de pago para este periodo

										$cobros = Detallepago::where('detallepago_id', '=', $detallepago->id)
								            ->get();
									?>
									@if(count($cobros) > 0)
										<tr>
											<td></td>
											<td></td>
											<td style="font-weight: bold; border: 1px solid #000000; color: #9C6500; background-color: #FFEB9C;">DETALLES</td>
											<td style="font-weight: bold; border: 1px solid #000000;">N° RECIBO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">MONTO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">FECHA PAGO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">ESTADO</td>
										</tr>
										@foreach($cobros as $cob)
											<?php 
												$estado = 'PAGADO';
												$class = '#54B359';
												switch ($cob->state) {
													case 'A':
														$estado = 'PENDIENTE';
														$class = '#3F51B5';
														break;
													case 'O':
														$estado = 'OMITIDO';
														$class = '#ECB100';
														break;
													case 'I':
														$estado = 'INCOMPLETO';
														$class = '#11AEF5';
														break;
												}
											?>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td style="border: 1px solid #000000;">{{$cob->numero}}</td>
												<td style="border: 1px solid #000000;">{{number_format($cob->monto_pagado, 2)}}</td>
												<td style="border: 1px solid #000000;">{{date('d/m/Y', strtotime($cob->fecha))}}</td>
												<td style="border: 1px solid #000000; color: {{ $class }}; font-weight: bold;">{{$estado}}</td>
											</tr>
										@endforeach
									@endif
								@else
									<tr>
										<td style="border: 1px solid #000000;">{{$num}}</td>
										<td style="border: 1px solid #000000;">#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
										<td style="border: 1px solid #000000;">DIARIO</td>
										<td style="border: 1px solid #000000;">0.00</td>
										<td style="border: 1px solid #000000;">{{number_format($detalleconceptopago->monto, 2)}}</td>
										<td style="border: 1px solid #000000;">{{$ff}}</td>
										<td style="border: 1px solid #000000; color: #3F51B5; font-weight: bold;">PENDIENTE</td>
									</tr>
								@endif
								<?php $num++; ?>
							@endfor							
						@elseif($tipo === 'M')
							@for($i = 1; $i <= 12; $i++)
								<?php
									$periodo = strtotime($anno."-" . str_pad($i."", 2, "0", STR_PAD_LEFT) . "-01");
									//Obtenemos el detalle de pago general
									$detallepago = Detallepago::where('fecha', '=', date('Y-m-d', $periodo))
										->where('mercader_id', '=', $mercader->id)
										->where('detalleconceptopago_id', '=', $detalleconceptopago->id)
										->whereNull('detallepago_id')
										->where('state', '<>', 'C')
										->select('id', 'monto_pagado', 'monto_deuda', 'state')
										->first();
									$ff = $meses[$i] . ' ' . $anno;
									$periodo = date('Y-m-d', $periodo);
								?>
								@if($detallepago!==NULL)
									<?php 
										$estado = 'PAGADO';
										$class = '#54B359';
										switch ($detallepago->state) {
											case 'A':
												$estado = 'PENDIENTE';
												$class = '#3F51B5';
												break;
											case 'O':
												$estado = 'OMITIDO';
												$class = '#ECB100';
												break;
											case 'I':
												$estado = 'INCOMPLETO';
												$class = '#11AEF5';
												break;
										}
									?>
									<tr>
										<td style="border: 1px solid #000000;">{{$i}}</td>
										<td style="border: 1px solid #000000;">#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
										<td style="border: 1px solid #000000;">MENSUAL</td>
										<td style="border: 1px solid #000000;">{{number_format($detallepago->monto_pagado, 2)}}</td>
										<td style="border: 1px solid #000000;">{{number_format($detallepago->monto_deuda, 2)}}</td>
										<td style="border: 1px solid #000000;">{{$ff}}</td>
										<td style="border: 1px solid #000000; color: {{ $class }}; font-weight: bold;">{{$estado}}</td>
									</tr>
									<?php 
										// Obtenermos los detalles de pago para este periodo

										$cobros = Detallepago::where('detallepago_id', '=', $detallepago->id)
								            ->get();
									?>
									@if(count($cobros) > 0)
										<tr>
											<td></td>
											<td></td>
											<td style="font-weight: bold; border: 1px solid #000000; color: #9C6500; background-color: #FFEB9C;">DETALLES</td>
											<td style="font-weight: bold; border: 1px solid #000000;">N° RECIBO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">MONTO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">FECHA PAGO</td>
											<td style="font-weight: bold; border: 1px solid #000000;">ESTADO</td>
										</tr>
										@foreach($cobros as $cob)
											<?php 
												$estado = 'PAGADO';
												$class = '#54B359';
												switch ($cob->state) {
													case 'A':
														$estado = 'PENDIENTE';
														$class = '#3F51B5';
														break;
													case 'O':
														$estado = 'OMITIDO';
														$class = '#ECB100';
														break;
													case 'I':
														$estado = 'INCOMPLETO';
														$class = '#11AEF5';
														break;
												}
											?>
											<tr>
												<td></td>
												<td></td>
												<td></td>
												<td style="border: 1px solid #000000;">{{$cob->numero}}</td>
												<td style="border: 1px solid #000000;">{{number_format($cob->monto_pagado, 2)}}</td>
												<td style="border: 1px solid #000000;">{{date('d/m/Y', strtotime($cob->fecha))}}</td>
												<td style="border: 1px solid #000000; color: {{ $class }}; font-weight: bold;">{{$estado}}</td>
											</tr>
										@endforeach
									@endif
								@else
									<tr>
										<td style="border: 1px solid #000000;">{{$i}}</td>
										<td style="border: 1px solid #000000;">#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
										<td style="border: 1px solid #000000;">MENSUAL</td>
										<td style="border: 1px solid #000000;">0.00</td>
										<td style="border: 1px solid #000000;">{{number_format($detalleconceptopago->monto, 2)}}</td>
										<td style="border: 1px solid #000000;">{{$ff}}</td>
										<td style="border: 1px solid #000000; color: #3F51B5; font-weight: bold;">PENDIENTE</td>
									</tr>
								@endif
							@endfor
						@endif
					</tbody>
				</table>
			@endif
		@else
			<h3>Debe seleccionar un año.</h3>
		@endif
	@endif
@endif