@extends('layouts.app')

@section('content')
    <livewire:reservation-payments :reservation_id="$reservation_id" />
@endsection
