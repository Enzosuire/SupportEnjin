@extends('layouts.app')

@section('title', __('Modifier un Projet'))

@section('sidebar')
    {{-- @include('partials/sidebar_menu_toggle') --}}
    {{-- @include('system/sidebar_menu') --}}
@endsection

@section('content')
    <div class="container-fluid">

    
        <form action="{{ route('projet.update_projet_traitement') }}" method="post"  class="form-creation">
            {{ csrf_field() }}

            <h1 class="mt-4 mb-4 update-h1">Modifier un Projet</h1>
            <hr class="soustitres">

            <input type="hidden" name="id" value="{{ $projet->id }}">

            <div class="form-line-1">
                {{-- sélecteur client --}}
                <div class="form-group form-line-item champ-list">
                    <label for="id_customers">Client :</label>
                    <select class="form-control" id="id_customers" name="id_customers" required>
                        <option value="" disabled selected>Sélectionner un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $projet->id_customers ? 'selected' : '' }}>
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-line-2">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="nom">Nom du Projet:</label>
                    <input type="text" name="nom" class="form-control" value="{{ $projet->nom }}" required>
                </div>
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_sortie_site">Date sortie site :</label>
                    <input type="date" name="date_sortie_site" class="form-control" value="{{ $projet->date_sortie_site }}"
                        required>
                </div>

            </div>

            <div class="form-line-3">
                    
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="maintenance_preventive">Maintenance Préventive:</label>
                    <input type="text" name="maintenance_preventive" class="form-control" value="{{ $projet->maintenance_preventive }}" required>
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="duree_garantie">Durée de Garantie (mois):</label>
                    <input type="number" name="duree_garantie" class="form-control" value="{{ $projet->duree_garantie }}" required>
                </div>
            </div>



            <div class="line-button">
                <button type="submit" class="btn btn-primary">Modifier un Projet</button>
            </div>
        </form>
    </div>
@endsection


@section('javascript')
@endsection
