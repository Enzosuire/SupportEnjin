@extends('layouts.app')

@section('title', __('Tous les Projets'))

@section('content')

    <div class="container-fluid mt-4">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($groupedProjets->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucun Projet réalisé.
            </div>
        @else
            <div class="form-group text-right btn-creation mb-4">
                <a href="{{ route('projet.createpro') }}" class="btn btn-primary">
                    Création d'un projet +
                </a>
            </div>

            @foreach ($groupedProjets as $customerId => $projetsGroup)
                <div class="entete">
                    <h2 class="mb-4">
                        @if ($customerId == 'sans_client')
                            Projets sans client
                        @else
                            @php
                                // Trouver un projet pour obtenir les clients
                                $projet = $projetsGroup->first();
                                $customers = $projet->customers;
                            @endphp
                            Projets pour {{ $customers->pluck('company')->implode(', ') }}
                        @endif
                    </h2>
                </div>

                <br>
                <div class="container-table">
                    <div class="gradient-overlay"></div>
                    <div class="content-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom Projet</th>
                                    <th>Date sortie site</th>
                                    <th>Maintenance Préventive</th>
                                    <th>Durée de Garantie</th>
                                    <th>Date fin de Garantie</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projetsGroup as $projet)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $projet->nom }}</td>
                                        <td>{{ $projet->date_sortie_site }}</td>
                                        <td>{{ $projet->maintenance_preventive }}</td>
                                        <td>{{ $projet->duree_garantie }} mois</td>
                                        <td>{{ $projet->date_fin_garantie }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('projet.updatepro', ['customerId' => $customerId, 'id' => $projet->id]) }}"
                                                class="btn btn-warning btn-sm">Modifier</a>
                                            <a href="{{ route('projet.delete', ['customerId' => $customerId, 'id' => $projet->id]) }}"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer le projet ?')">Supprimer</a>
                                        </td>
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
