@extends('layouts.app')

@section('title', __('Modifications Facturation'))

@section('sidebar')
    {{-- @include('partials/sidebar_menu_toggle') --}}
    {{-- @include('system/sidebar_menu') --}}
@endsection

@section('content')
    <div class="container-fluid">
        

        <form action="{{ route('facturations.update_facturations_traitement') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h1 class="mt-4 mb-4 update-h1">Modifier une Facturation</h1>
            <hr class="soustitres">

            <input type="hidden" name="id" value="{{ $facturation->id }}">

            <div class="form-line-1">
                {{-- Sélecteur client --}}
                {{-- <div class="form-group form-line-item-1 champ-list">
                    <label for="id_customers">Client :</label>
                    <select class="form-control" id="id_customers" name="id_customers" required>
                        <option value="" disabled selected>Sélectionner un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $customerId ? 'selected' : '' }}>
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- Sélecteur projet --}}
                <div class="form-group form-line-item-2 champ-list">
                    <label for="id_projet">Projet :</label>
                    <select class="form-control" name="id_projet" id="id_projet" required>
                        <option value="" disabled>Sélectionner un projet</option>
                        @foreach ($projets as $projet)
                            <option value="{{ $projet->id }}" {{ $facturation->id_projet == $projet->id ? 'selected' : '' }}>
                                {{ $projet->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-line-2">
                <div class="form-group form-line-item champ-input-txt">
                    <label for="Numero_facturation">Numéro de Facture :</label>
                    <input class="form-control" type="text" name="Numero_facturation" value="{{ $facturation->Numero_facturation }}" required>
                </div>
            </div>

            <div class="form-line-3">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="Forfait_heure">Forfait d'heure (min) :</label>
                    <input class="form-control" type="number" name="Forfait_heure" value="{{ $facturation->Forfait_heure }}" required>
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_facturation">Date de Facturation :</label>
                    <input class="form-control" type="date" name="date_facturation" value="{{ $facturation->date_facturation }}" required>
                </div>
            </div>

            <div class="form-line-4">
                <div class="form-group form-line-item-1 champ-list">
                    <label for="pole">Pôle :</label>
                    <select class="form-control" name="pole" required>
                        <option value="" disabled>Sélectionnez un pôle</option>
                        @foreach (["Web", "Seo/Sea", "Print"] as $pole)
                            <option value="{{ $pole }}" {{ $facturation->pole == $pole ? 'selected' : '' }}>
                                {{ $pole }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="montant">Montant :</label>
                    <input class="form-control" type="text" name="montant" value="{{ $facturation->montant }}" required>
                </div>
            </div>
            
           
            <div class="line-button">
                <button type="submit" class="btn btn-primary">Modifier la facturation</button>
            </div>


        </form>
    </div>
@endsection


@section('javascript')
    var projects = @json($projets);
    var selectedProjectId = {{ $facturation->id_projet ?? '' }};
    updateProjectSelect2faint(projects);
@endsection