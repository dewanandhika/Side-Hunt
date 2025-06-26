@extends('Dewa.Base.Basic-page')

@section('css')
<style>
</style>
@endsection

@section('content')
<div class="container w-100 h-auto gap-5 d-flex my-5 flex-column justify-content-center align-items-center">
    

</div>
@endsection

@section('script')
<script>

</script>
@endsection

@php
function hitungJarak($lon1, $lat1, $lon2, $lat2)
{
    $earthRadius = 6371; // kilometer

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
    cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
    sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $earthRadius * $c;

    return number_format($distance, 2) . ' km';
}


@endphp