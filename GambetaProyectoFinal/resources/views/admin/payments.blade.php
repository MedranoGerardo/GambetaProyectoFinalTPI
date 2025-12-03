@extends('layouts.admin')

@section('content')
    <livewire:reservation-payments :reservation_id="$reservation_id" />
@endsection