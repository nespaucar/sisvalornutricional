<?php
	use App\Models\Detalleconceptopago;
	use App\Models\Detallepago;
	$meses = array('1' => 'ENERO', '2' => 'FEBRERO', '3' => 'MARZO', '4' => 'ABRIL', '5' => 'MAYO', '6' => 'JUNIO', '7' => 'JULIO', '8' => 'AGOSTO', '9' => 'SETIEMBRE', '10' => 'OCTUBRE', '11' => 'NOVIEMBRE', '12' => 'DICIEMBRE');
	$totPagar = 0.00;
	$totPagado = 0.00;
	$totDeuda = 0.00;
?>
@if($mercader === NULL)
	<h3 class="text-danger">Debe seleccionar un mercader.</h3>
	<script>
		$(document).ready(function() {
			$('#btnExcel').attr('disabled', true);
			$('#btnPDF').attr('disabled', true);
		});
	</script>
@else
	@if($detconceptopago === NULL)
		<h3 class="text-danger">Debe seleccionar un concepto de pago.</h3>
		<script>
			$(document).ready(function() {
				$('#btnExcel').attr('disabled', true);
				$('#btnPDF').attr('disabled', true);
			});
		</script>
	@else
		@if(!is_null($anno)&&$anno!=='')
			<?php
				//Comprobamos si son cobros diarios o mensuales
				$detalleconceptopago = Detalleconceptopago::where('id', '=', $detconceptopago->id)
						->where('mercader_id', '=', $mercader->id)
						->first();
			?>
			@if($detalleconceptopago === NULL)
				<h3 class="text-danger">El concepto de Pago no le corresponde al mercader {{$mercader->persona->nombre}}.</h3>
				<script>
					$(document).ready(function() {
						$('#btnExcel').attr('disabled', true);
						$('#btnPDF').attr('disabled', true);
					});
				</script>
			@else
				<div class="col-md-4 col-md-offset-4">
					<div class="table-responsive">
						<table id="resumenTable" class="table table-condensed table-hover table-bordered">
							<thead>
								<tr>
									<th colspan="2" class="text-center">CUADRO RESUMEN {{$anno}}</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th class="text-center text-primary">TOTAL A PAGAR</th>
									<td class="text-right text-primary" id="totPagar2"></td>
								</tr>
								<tr>
									<th class="text-center text-success">TOTAL PAGADO</th>
									<td class="text-right text-success" id="totPagado2"></td>
								</tr>
								<tr>
									<th class="text-center text-danger">TOTAL DEUDA</th>
									<td class="text-right text-danger" id="totDeuda2"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<br>
				<br>
				<div class="col-md-12">
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
								<tr id="noFilas">
									<td colspan="10" class="text-center text-danger">No hubieron coincidencias.</td>
								</tr>
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
												$class = 'text-success';
												switch ($detallepago->state) {
													case 'A':
														$estado = 'PENDIENTE';
														$class = 'text-primary';
														break;
													case 'O':
														$estado = 'OMITIDO';
														$class = 'text-warning';
														break;
													case 'I':
														$estado = 'INCOMPLETO';
														$class = 'text-info';
														break;
												}
											?>
											<tr>
												<td>{{$num}}</td>
												<td>#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
												<td class="text-center">DIARIO</td>
												<td>{{number_format($detallepago->monto_pagado, 2)}}</td>
												<td>{{number_format($detallepago->monto_deuda, 2)}}</td>
												<td class="text-center fechaTd">{{$ff}}</td>
												<td class="{{$class}} estadoTd"><strong>{{$estado}}</strong></td>
												<td>
													{!! Form::button('<div class="fa fa-eye"></div> Ver Detalles', array('class' => 'btn btn-xs btn-primary waves-effect waves-light', 'onclick' => 'modal(\'cobro/verDetalles?detalleconceptopago_id=' . $detalleconceptopago->id . '&pagogeneral_id=' . $detallepago->id . '&cuota_id=0&ff='.$ff.'\', \'Detalles - '.$ff.'\', this)')) !!}
												</td>
											</tr>
											<?php 
												$totPagado += $detallepago->monto_pagado;
												$totDeuda += $detallepago->monto_deuda;
											?>
										@else
											<tr>
												<td>{{$num}}</td>
												<td>#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
												<td class="text-center">DIARIO</td>
												<td>0.00</td>
												<td>{{number_format($detalleconceptopago->monto, 2)}}</td>
												<td class="text-center fechaTd">{{$ff}}</td>
												<td class="text-primary estadoTd"><strong>PENDIENTE</strong></td>
												<td>
													{!! Form::button('<div class="fa fa-eye"></div> Ver Detalles', array('class' => 'btn btn-xs btn-primary waves-effect waves-light', 'onclick' => 'modal(\'cobro/verDetalles?detalleconceptopago_id=' . $detalleconceptopago->id . '&pagogeneral_id=0&cuota_id=0&ff='.$ff.'&fecha='.$periodo.'\', \'Detalles - '.$ff.'\', this)')) !!}
												</td>
											</tr>
											<?php 
												$totDeuda += $detalleconceptopago->monto;
											?>
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
												$class = 'text-success';
												switch ($detallepago->state) {
													case 'A':
														$estado = 'PENDIENTE';
														$class = 'text-primary';
														break;
													case 'O':
														$estado = 'OMITIDO';
														$class = 'text-warning';
														break;
													case 'I':
														$estado = 'INCOMPLETO';
														$class = 'text-info';
														break;
												}
											?>
											<tr>
												<td>{{$i}}</td>
												<td>#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
												<td class="text-center">MENSUAL</td>
												<td>{{number_format($detallepago->monto_pagado, 2)}}</td>
												<td>{{number_format($detallepago->monto_deuda, 2)}}</td>
												<td class="text-center fechaTd">{{$ff}}</td>
												<td class="{{$class}} estadoTd"><strong>{{$estado}}</strong></td>
												<td>
													{!! Form::button('<div class="fa fa-eye"></div> Ver Detalles', array('class' => 'btn btn-xs btn-primary waves-effect waves-light', 'onclick' => 'modal(\'cobro/verDetalles?detalleconceptopago_id=' . $detalleconceptopago->id . '&pagogeneral_id=' .  $detallepago->id . '&cuota_id=0&ff='.$ff.'&fecha='.$periodo.'\', \'Detalles - '.$ff.'\', this)')) !!}
												</td>
											</tr>
											<?php 
												$totPagado += $detallepago->monto_pagado;
												$totDeuda += $detallepago->monto_deuda;
											?>
										@else
											<tr>
												<td>{{$i}}</td>
												<td>#{{$detconceptopago->comentario}} {{$detconceptopago->conceptopago->nombre}}</td>
												<td class="text-center">MENSUAL</td>
												<td>0.00</td>
												<td>{{number_format($detalleconceptopago->monto, 2)}}</td>
												<td class="text-center fechaTd">{{$ff}}</td>
												<td class="text-primary estadoTd"><strong>PENDIENTE</strong></td>
												<td>
													{!! Form::button('<div class="fa fa-eye"></div> Ver Detalles', array('class' => 'btn btn-xs btn-primary waves-effect waves-light', 'onclick' => 'modal(\'cobro/verDetalles?detalleconceptopago_id=' . $detalleconceptopago->id . '&pagogeneral_id=0&cuota_id=0&ff='.$ff.'&fecha='.$periodo.'\', \'Detalles - '.$ff.'\', this)')) !!}
												</td>
											</tr>
											<?php 
												$totDeuda += $detalleconceptopago->monto;
											?>									
										@endif
									@endfor
								@endif						
							</tbody>
						</table>
					</div>
				</div>
					
				<script>
					$('#noFilas').hide();
					$(document).ready(function() {
						$('#totPagar2').html('<strong>S/{{ number_format($totPagado+$totDeuda, 2) }}</strong>');
						$('#totPagado2').html('<strong>S/{{ number_format($totPagado, 2) }}</strong>');
						$('#totDeuda2').html('<strong>S/{{ number_format(($totDeuda), 2) }}</strong>');
						$('#totPagar').val('{{ ($totPagado + $totDeuda) }}');
						$('#totPagado').val('{{ $totPagado }}');
						$('#totDeuda').val('{{ $totDeuda }}');
						$('#btnExcel').attr('disabled', false);
						$('#btnPDF').attr('disabled', false);
					});
				</script>
			@endif				
		@else
			<h3 class="text-danger">Debe seleccionar un año.</h3>
			<script>
				$(document).ready(function() {
					$('#btnExcel').attr('disabled', true);
					$('#btnPDF').attr('disabled', true);
				});
			</script>
		@endif
	@endif
@endif