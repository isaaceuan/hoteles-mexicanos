@extends('basico.base')
@section('content')
    <div class="container contentDetalleHabitacionTarifa rounded-0 border-0 card shadow">
                <section class="text-center mt-3">
            <h4><i class="fa fa-bed color-acento mr-2"></i>Habitación</h4>
            <hr class="bg-acento">
            @include('basico.disponibilidad.detalle.habitacion')
        </section>
        <section class="text-center mt-3">
            <h4><i class="fa fa-tag color-acento"></i> Tarifas</h4>
            <hr class="bg-acento">
            @include('basico.disponibilidad.detalle.tarifa')
        </section>
        <section class="text-center mt-3">
            <h4><i class="fa fa-dollar-sign color-acento"></i> Desglose</h4>
            <hr class="bg-acento">
            @include('basico.disponibilidad.detalle.desglose')
        </section>
    </div>
@endsection
@section('sidebar')
    @include('basico.componentes.calendar')
@endsection
