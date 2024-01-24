@extends('layouts.app')

@section('title', __('Intervention Details'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')
<div class="container-fluid mt-4"> 
    <h2 class="mb-4">Facturations Réalisée pour {{ $facturations->customer->company }}</h2>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Numéro de Facturation </th>
                <th>Date de Facturation</th>
                <th>Forfait d'heure</th>
                <th>Pôle </th>
                <th>Client </th>
                <th>Projet </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                <td>{{ $facturations->Numero_facturation }}</td>
                <td>{{ $facturations->date_facturation }}</td>
                <td>{{ $facturations->Forfait_heure}}</td>
                <td>{{ $facturations->pole }}</td>
                <td>{{ $facturations->customer->company }}</td>
                <td>{{ $facturations->projet->nom }}</td>
            </tr>

        </tbody>
    </table>
    
</div>
@endsection



    

@section('javascript')
    @parent
    initSystemStatus();
@endsection


{{-- <table class="table tablecustom">
        <tbody>
            <tr>
                <th>Numéro de Facturation</th>
                <td>{{ $facturations->Numero_facturation }}</td>
            </tr>
            <tr>
                <th>Date de Facturation</th>
                <td>{{ $facturations->date_facturation }}</td>
            </tr>
            <tr>
                <th>Forfait d'heure</th>
                <td>{{ $facturations->Forfait_heure}}</td>
            </tr>
            <tr>
                <th>Pôle</th>
                <td>{{ $facturations->pole }}</td>
            </tr>
            <tr>
                <th>Client</th>
                <td>{{ $facturations->customer->company }}</td>
            </tr>
            <tr>
                <th>Projet</th>
                <td>{{ $facturations->projet->nom }}</td>
            </tr>
            <tr>

        </tbody>
    </table> --}}