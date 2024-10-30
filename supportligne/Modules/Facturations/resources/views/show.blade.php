@extends('layouts.app')

@section('title', __('Facturations'))


{{-- @section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection --}}

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


        <div class="form-group form-line-item-2 champ-list">
            <label for="id_projet">Projet :</label>
            <select class="form-control" name="id_projet" id="id_projet" required onchange="location = this.value;">
                <option value="{{ route('facturations.show') }}" {{ is_null($id_projet) ? 'selected' : '' }}>Tous les
                    projets</option>
                @foreach ($projets as $projet)
                    <option value="{{ route('facturations.show', ['id_projet' => $projet->id]) }}"
                        {{ $id_projet == $projet->id ? 'selected' : '' }}>
                        {{ $projet->nom }}
                    </option>
                @endforeach
            </select>
        </div>


        @if ($id_projet && $facturations->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucune Facturation réalisée pour ce projet.
            </div>
        @elseif ($id_projet)
            <br>
            <h2>Facturations pour le Projet : {{ $facturations->first()->projet->nom }}</h2>
        @else
            <h2>Toutes les Facturations</h2>
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
                                <tr>
                                    <td></td>
                                    <td>{{ $facturation->Numero_facturation }}</td>
                                    <td>{{ $facturation->date_facturation }}</td>
                                    <td>{{ $facturation->Forfait_heure }}</td>
                                    <td>{{ $facturation->pole }}</td>
                                    <td>{{ $facturation->projet->nom }}</td>
                                    <td>{{ $facturation->montant }} €</td>

                                    <td class="text-center">
                                        <a
                                            href="{{ route('facturations.updatefa', ['id_projet' => $facturation->projet->id, 'id' => $facturation->id]) }} "class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="{{ route('facturations.delete', ['id_projet' => $facturation->projet->id, 'id' => $facturation->id]) }}"class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette facturation ?')">Supprimer</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- @else
            <div class="alert alert-info" role="alert">
                Aucune facturation trouvée.
            </div> --}}
        @endif

    </div>
@endsection



@section('javascript')
@endsection
