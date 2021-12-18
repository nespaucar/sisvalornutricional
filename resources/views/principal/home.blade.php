@include('principal.header_start')

{!! Html::style('plugins/jquery-circliful/css/jquery.circliful.css') !!}

@include('principal.header_end')

{{-- aquí va el contenido --}}

@include('principal.footer_start')

@include('principal.footer_end')

<a class='flotante'>
    <img style="filter: drop-shadow(0 2px 3px rgba(0, 0, 0, 0.2));" class="img img-responsive" src="{{ asset('assets/images/logo.png') }}" alt="">
</a>