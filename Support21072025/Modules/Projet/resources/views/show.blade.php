@extends('layouts.app')

@section('title', __('Projet'))

@section('content')

<div class="container-fluid mt-4">

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Bouton de création de projet -->
    <div class="form-group text-right btn-creation mb-4">
        <a href="{{ route('projet.createpro') }}" class="btn btn-primary">
            Création d'un projet +
        </a>
    </div>

    <!-- Vérification si des projets existent -->
    @if (empty($groupedProjets))
        <div class="alert alert-info" role="alert">
            Aucun projet réalisé.
        </div>
    @else

        
        
        <div class="form-line-1">

            <!-- Formulaire de filtrage par client -->
            <div class="form-group form-line-item-1 champ-list  half-width">
                <label for="id_customer">Sélectionner un client :</label>
                <select class="form-control" id="id_customer" onchange="filterProjets()">
                    <option value="">Sélectionner un client</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ request('id_customer') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtre Créasite -->
            <div class="form-group form-line-item-1 champ-list  half-width">
                <label for="creasite">Créasite :</label>
                <select class="form-control" id="creasite" onchange="filterProjets()">
                    <option value="">Tous</option>
                    <option value="oui" {{ request('creasite') == 'oui' ? 'selected' : '' }}>Oui</option>
                    <option value="non" {{ request('creasite') == 'non' ? 'selected' : '' }}>Non</option>
                </select>
            </div>

         
        </div>

       
        <div class="form-line-2">
             <!-- Barre de recherche -->
            <div class="form-group form-line-item-3 champ-list half-width">
                <form method="GET" action="{{ route('projet.show') }}" class="form-group champ-list">
                    <div class="form-group champ-list">
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher un client..." value="{{ request('search') }}" >
                            <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Affichage des projets pour chaque client -->
        <div id="projets-container">
            @foreach ($groupedProjets as $customerId => $group)
                <div class="customer-projets" data-customer-id="{{ $customerId }}">
                    <div class="entete">
                        <h2 class="mb-4">
                            Projet pour {{ $group['customer']->company }}
                        </h2>
                    </div>

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
                                        <th>Créasite</th> 
                                        <th class="text-center">Référent</th>
                                        <th>Liste des Interventions</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($group['projets'] as $projet)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $projet->nom }}</td>
                                            <td>{{ $projet->date_sortie_site ? \Carbon\Carbon::parse($projet->date_sortie_site)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $projet->maintenance_preventive }}</td>
                                            <td>{{ $projet->duree_garantie ? $projet->duree_garantie . ' mois' : 'Sans durée' }}</td>
                                            <td>{{ $projet->date_fin_garantie ? \Carbon\Carbon::parse($projet->date_fin_garantie)->format('d/m/Y') : '' }}</td>
                                            <td>{{ $projet->creasite ?: 'non' }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $projet->referent_web_name ? 'b-web' : '' }}">
                                                    WEB: {{ $projet->referent_web_name ?? 'Non attribué' }}
                                                </span>
                                                <span class="badge {{ $projet->referent_seo_name ? 'b-seo' : '' }}">
                                                    SEO: {{ $projet->referent_seo_name ?? 'Non attribué' }}
                                                </span>
                                                <span class="badge {{ $projet->referent_commercial_name ? 'b-commercial' : '' }}">
                                                    Commercial: {{ $projet->referent_commercial_name ?? 'Non attribué' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('intervention.show', ['id_customers' => $customerId]) }}?id_projet={{ $projet->id }}" class="a-customers">
                                                    <ion-icon name="hammer-outline" class="icon-table-clients md hydrated" role="img"></ion-icon>
                                                </a>
                                            </td>

                                            <td class="text-center btn-sm">
                                                <a href="{{ route('projet.updatepro', ['customerId' => $customerId, 'id' => $projet->id]) }}" class="btn-warning btn-sm">Modifier</a>
                                                <a href="{{ route('projet.delete', ['customerId' => $customerId, 'id' => $projet->id]) }}" class="btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer le projet ?')">Supprimer</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>

@endsection

@section('javascript')
@endsection
