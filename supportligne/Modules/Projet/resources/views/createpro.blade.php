@extends('layouts.app')

@section('title', __('Créer un projet'))

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


        <form action="{{ route('projet.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}

            <h2>Création du projet</h2>
            <hr class="soustitres">

            <div class="form-line-1">
                
                {{-- sélecteur client --}}
                <div class="form-group form-line-item champ-list">
                    <label for="customers">Clients :</label>
                    <select class="form-control" id="customers" name="customers[]" multiple required>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $customerId ? 'selected' : '' }} class="option-value">
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>

                
            <div class="form-line-2">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="nom">Nom du Projet:</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_sortie_site">Date sortie site :</label>
                    <input type="date" name="date_sortie_site" class="form-control">
                </div>
            </div>

            <div class="form-line-3">
            
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="maintenance_preventive">Maintenance Préventive:</label>
                    <input type="text" name="maintenance_preventive" class="form-control">
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="duree_garantie">Durée de Garantie (mois):</label>
                    <input type="number" name="duree_garantie" class="form-control">
                </div>
            </div>





            <div class="line-button">
                <button type="submit" class="btn btn-primary">Créer le projet</button>
            </div>

        </form>
    </div>
@endsection


@section('javascript')
@endsection
