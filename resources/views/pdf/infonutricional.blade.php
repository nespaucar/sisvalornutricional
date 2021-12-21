<br>
<h3 align="center">INFORMACIÓN NUTRICIONAL</h3>
<br>
<div align="center"><img src="{{ asset('assets/images/nutricionista.png') }}" alt="" height="300"></div>
<br>
<div>
	<table width="100%" style="font-size: 12px; margin: 0px !important;" border="0" cellspacing="15">
		<?php $num = 0; ?>
		<?php $i = 0; ?>
		@foreach($cards as $card)		
			@if($num === 0) <tr> @endif
				<td align="center" style="background-color:{{ $card['color'] }}; color: white; width: 16.6%;">
					<br>
					<br>
				  	<b>{{ $card['name'] }}</b>
				  	<br>
				  	<br>
				  	<b>{{ $card['id'] }}</b>
				  	<br>
				  	<br>
				  	<b>{{ $sumas[$i] }}{{ $card['unity'] }}</b>
				  	<br>
				</td>
			@if($num === 5) </tr> <?php $num = -1; ?> @endif		
			<?php $num++; ?>
			<?php $i++; ?>
		@endforeach
		</tr>
	</table>
</div>