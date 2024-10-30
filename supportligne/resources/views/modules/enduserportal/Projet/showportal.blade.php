@extends('enduserportal::layouts.portal')

@section('title', __('Projet'))


@section('content')
        
    <div class="container-fluid mt-4">

        @if ($groupedProjets->isEmpty())
                <div class="alert alert-info " role="alert">
                    Aucun Projet réalisée.
                </div>
        @else

            @foreach($groupedProjets as $customerId => $projetsGroup)
                {{-- <h2 class="mb-4">Projet Réalisée pour {{ $projetsGroup->first()->customer->company }}</h2> --}}
                <h2 class="mb-4">Projet Réalisée </h2>
        
                <br>
                <div class="container-table">
                    <div class="gradient-overlay"></div> 
                    <div class="content-table">
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom Projet </th>
                                    <th>Date sortie site </th>
                                    <th>Maintenance Préventive</th>
                                    <th>Durée de Garantie</th>
                                    <th>Date fin de Garantie</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projetsGroup  as $projet)
                                    <tr>
                                        <td>
                                        <td>{{ $projet->nom }}</td>
                                        <td>{{ $projet->date_sortie_site}}</td>
                                        <td>{{ $projet->maintenance_preventive }}</td>
                                        <td>{{ $projet->duree_garantie }} mois</td>
                                        <td>{{ $projet->date_fin_garantie }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @endif

        
    </div>
@endsection


@section('javascript') 
@endsection


