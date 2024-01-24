
@extends('layouts.app')

@section('title', __('Intervention Details'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')
<div class="container-fluid mt-4"> 
    <h2 class=" mb-4 ">Projet Réalisée pour {{ $projet->customer->company }}</h2>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nom Projet </th>
                <th>Date sortie site </th>
                <th>Maintenance Préventive</th>
                <th>Durée de Garantie</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                <td>{{ $projet->nom }}</td>
                <td>{{ $projet->date_sortie_site}}</td>
                <td>{{ $projet->maintenance_preventive }}</td>
                <td>{{ $projet->duree_garantie }} mois</td>
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
            <th>Nom Projet</th>
            <td>{{ $projet->nom }}</td>
        </tr>
        <tr>
            <th>Date sortie site </th>
            <td>{{ $projet->date_sortie_site}}</td>
        </tr>
        <tr>
        <th>Maintenance Préventive</th>
            <td>{{ $projet->maintenance_preventive }}</td>
        </tr>
        <tr>
            <th>Durée de Garantie</th>
            <td>{{ $projet->duree_garantie }} mois</td>
        </tr>


        
    </tbody>
</table> --}}