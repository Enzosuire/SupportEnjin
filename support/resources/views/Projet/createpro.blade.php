@extends('layouts.app')

@section('title', __('System Status'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')

    <h1 class="mt-4 mb-4 text-center">Création Projet</h1>

    <form action="{{ route('projet.store') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="id_customers">Client :</label>
            <select class="form-control" name="id_customers" required>
                <option value="" disabled selected>Sélectionner un client</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->company }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="nom">Nom du Projet:</label>
            <input type="text" name="nom" class="form-control" required>
        </div>


        <div class="form-group">
            <label for="date_sortie_site">Date sortie site :</label>
            <input type="date" name="date_sortie_site" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="maintenance_preventive">Maintenance Préventive:</label>
            <input type="text" name="maintenance_preventive" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="duree_garantie">Durée de Garantie (mois):</label>
            <input type="number" name="duree_garantie" class="form-control" required>
        </div>



        <button type="submit" class="btn btn-primary">Créer Projet</button>
    </form>
@endsection

@section('javascript')
    @parent
    initSystemStatus();
@endsection
