@extends('layouts.app')

@section('title', __('Facturations'))


@section('content')
<div class="container-fluid mt-4 ">

    @if (session('info'))
    <div class="alert alert-info" role="alert">
        {{ session('info') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="form-group text-right btn-creation mb-4">
        <a href="{{ route('facturations.createFa') }}" class="btn btn-primary">
            Création d'une Facturation +
        </a>
    </div>


    <form action="{{ route('facturations.show') }}" method="get" id="filterForm">


        {{-- Sélecteurs pour filtrer les clients, projets et types d'interventions --}}
        <div class="form-line-1 ">
           
            {{-- Sélecteur pour filtrer par client --}}
             
            <div class="form-group form-line-item-1 champ-list">
                <label for="id_customers">Client :</label>
                    <select class="form-control" id="id_customers" name="id_customers" onchange="this.form.submit()">
                        <option value="">Sélectionner un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $id_customers == $customer->id ? 'selected' : '' }}>
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                
            </div>

            {{-- Sélecteur pour filtrer par projet --}}
            <div class="form-group form-line-item-1 champ-list">
                <label for="id_projet">Projet :</label>
                    <select class="form-control" name="id_projet" id="id_projet" onchange="this.form.submit()">
                        <option value="">Sélectionner un projet</option>
                        @foreach ($projets as $projet)
                            <option value="{{ $projet->id }}" 
                                    {{ $id_projet == $projet->id ? 'selected' : '' }}
                                    data-customer-id="{{ $projet->customers->first()->id ?? '' }}">
                                {{ $projet->nom }}
                            </option>
                        @endforeach
                    </select>
            </div>


            {{-- Sélecteur de pôle --}}
            <div class="form-group form-line-item-1 champ-list">
                <label for="pole">Pôles :</label>
                <select class="form-control" name="pole" id="pole" onchange="this.form.submit()">
                    <option value="">Sélectionner un pôle</option>
                    @foreach ($poles as $p)
                    <option value="{{ $p }}" {{ $pole == $p ? 'selected' : '' }}>
                        {{ $p }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="form-line-2">

            {{-- Sélecteur de date de début --}}
            <div class="form-group form-line-item-3 champ-list half-width">
                <label for="date_debut">Date de Début :</label>
                <input type="date" class="form-control" name="date_debut" id="date_debut"  onchange="this.form.submit()" value="{{ $dateDebut ?? '' }}">
            </div>

            {{-- Sélecteur de date de fin --}}
            <div class="form-group form-line-item-3 champ-list half-width">
                <label for="date_fin">Date de Fin :</label>
                <input type="date" class="form-control" name="date_fin" id="date_fin" onchange="this.form.submit()" value="{{ $dateFin ?? '' }}">
            </div>

         
        </div>
        <div class="form-group">
            <button class="btn btn-secondary" type="button" id="resetButton">Réinitialiser</button>
        </div>

    </form>


    @if ($facturations->isEmpty())
    <div class="alert alert-info" role="alert">
        Aucune Facturation réalisée.
    </div>
    @else


        @if ($id_customers)
        <h2>Facturations pour le Client : {{ $customers->firstWhere('id', $id_customers)->company ?? 'Client inconnu' }}</h2>
        @endif

        @if ($facturations->isNotEmpty())
            <div class="container-table">
                <div class="gradient-overlay"></div>
                <div class="content-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Numéro de Facture</th>
                                <th>Date de Facturation</th>
                                <th>Forfait d'heure</th>
                                <th>Pôle</th>
                                <th>Projet</th>
                                <th>Montant</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturations as $facturation)
                            <tr class="facturation" data-client="{{ $facturation->projet->customers->first()->id ?? '' }}" data-pole="{{ $facturation->pole }}" data-projet="{{ $facturation->id_projet }}">
                                <td></td>
                                <td>{{ $facturation->Numero_facturation }}</td>
                                <td>{{ \Carbon\Carbon::parse($facturation->date_facturation)->format('d/m/Y') }}</td>
                                <td>{{ $facturation->Forfait_heure }}</td>
                                <td>{{ $facturation->pole }}</td>
                                <td>{{ $facturation->projet->nom }}</td>
                                <td>{{ $facturation->montant }} €</td>
                                <td class="text-center btn-sm">
                                    <a href="{{ route('facturations.updatefa', ['id_projet' => $facturation->projet->id, 'id' => $facturation->id]) }}" class="btn-warning btn-sm">Modifier</a>
                                    <a href="{{ route('facturations.delete', ['id_projet' => $facturation->projet->id, 'id' => $facturation->id]) }}" class="btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facturation ?')">Supprimer</a>
                                </td>
                            </tr>
                            @endforeach

                            <tr class="info info-intervention">
                                <th colspan="3" class="text-center"><label>Total de facturation  :</label>
                                    <span>
                                    {{ $totalFacturations }}
                                    </span>
                                    
                                </th>
                                <th colspan="3" class="text-center"><label></label></th>

                                <th colspan="3" class="text-center">
                                    <label>Coût facturation : </label>
                                    <span >
                                    {{ number_format($totalMontant, 2) }} €
                                    </span>
                                </th>

                            </tr>
                            

                        </tbody>

                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="pagination-container">
                {{ $facturations->appends([
                    'id_customers' => $id_customers,
                    'id_projet' => $id_projet,
                    'pole' => $pole,
                    'date_debut' => $dateDebut,
                    'date_fin' => $dateFin
                ])->links() }}
            </div>

                {{-- @else
                <div class="alert alert-info" role="alert">
                    Aucune facturation trouvée.
                </div> --}}
        @endif
    @endif

</div>
@endsection



@section('javascript')
filterFacturations();
@endsection

