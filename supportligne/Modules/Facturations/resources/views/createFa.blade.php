@extends('layouts.app')

@section('title', __('Créer une facturation'))

{{-- @section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection --}}

@section('content')
    <div class="container-fluid">


        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('facturations.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h2>Détail de la facturation</h2>
            <hr class="soustitres">

            <div class="form-line-1">
                {{-- Sélecteur projet --}}
                <div class="form-group form-line-item-2 champ-list">
                    <label for="id_projet">Projet :</label>
                    <select class="form-control" name="id_projet" id="id_projet" required>
                        <option value="" disabled selected>Sélectionner un projet</option>
                        @foreach ($projets as $projet)
                            <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-line-2">
                <div class="form-group form-line-item champ-input-txt">
                    <label for="Numero_facturation">Numéro de Facture :</label>
                    <input class="form-control" type="text" name="Numero_facturation" required>
                </div>
            </div>

            <div class="form-line-3">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="Forfait_heure">Forfait d'heure (min) :</label>
                    <input class="form-control" type="number" name="Forfait_heure" required>
                </div>
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_facturation">Date de Facturation :</label>
                    <input class="form-control" type="date" name="date_facturation" required>
                </div>
            </div>

            <div class="form-line-4">
                <div class="form-group form-line-item-1 champ-list">
                    <label for="pole">Pôle :</label>
                    <select class="form-control" name="pole" required>
                        <option value="" disabled selected>Sélectionnez un pôle</option>
                        <option value="Web">Web</option>
                        <option value="Seo/Sea">Seo/Sea</option>
                        <option value="Print">Print</option>
                    </select>
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="montant">Montant :</label>
                    <input class="form-control" type="text" name="montant" required>
                </div>
            </div>


            <div class="line-button">
                <button type="submit" class="btn btn-primary">Créer la facturation</button>
            </div>


        </form>
    </div>
@endsection


@section('javascript')
    var projects = @json($projets);
    updateProjectSelect(projects);
@endsection
