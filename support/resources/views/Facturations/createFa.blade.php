@extends('layouts.app')

@section('title', __('System Status'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')
    <div class="container">
        <h1 class="mt-4 mb-4 text-center">Création Facturation</h1>

        <form class="form-horizontal mt-4" method="POST" action="{{ route('Facturations.store') }}">
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
            <label for="id_projet">Projet :</label>
            <select class="form-control" name="id_projet" id="id_projet" required>
                <option value="" disabled selected>Sélectionner un projet </option>
                @foreach ($projets as $projet)
                    <option value="{{ $projet->id }}" data-customer-id="{{ $projet->customer_id }}">{{ $projet->nom }}</option>
                @endforeach
            </select>
        </div>

            <div class="form-group">
                <label for="Numero_facturation">Numéro de Facturation :</label>
                <input class="form-control"  type="text" name="Numero_facturation" required>
            </div>

            <div class="form-group">
                <label for="Forfait_heure">Forfait d'heure :</label>
                <input class="form-control"  type="number" name="Forfait_heure" required>
            </div>
            <div class="form-group">
                <label for="date_facturation">Date de Facturation :</label>
                <input class="form-control" type="date" name="date_facturation" required>
            </div>

         <div class="form-group">
                <label for="pole">Types d'interventions:</label>
                <select class="form-control" name="pole" required>
                    <option value="" disabled selected>Sélectionnez un pole</option>
                    <option value="Web">Web</option>
                    <option value="Seo/Sea">Seo/Sea</option>
                    <option value="Réseau sociaux">Réseau sociaux</option>
                </select>
            </div>

            <div class="form-group">
                <label for="montant">Montant :</label>
                <input class="form-control"  type="text" name="montant" required>
            </div>


            {{-- <div class="form-group">
                <label for="id_customers">Client :</label>
                <select class="form-control" name="id_customers" required>
                    <option value="" disabled selected>Sélectionner un client</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->company }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_projet">Projet :</label>
                <select class="form-control" name="id_projet" required>
                    <option value="" disabled selected>Sélectionnez un projet</option>
                    @foreach($projets as $projet)
                        <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                    @endforeach
                </select>
            </div> --}}

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
@endsection




    <script>
        var projects = @json($projets);
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const customerSelect = document.querySelector('select[name="id_customers"]');
            const projectSelect = document.querySelector('select[name="id_projet"]');
            
            customerSelect.addEventListener('change', function () {
                const selectedCustomerId = this.value;
    
                // Supprimez toutes les options sauf la première
                while (projectSelect.options.length > 1) {
                    projectSelect.remove(1);
                }
    
                // Ajoutez uniquement les options qui correspondent au client sélectionné
                projects.forEach(project => {
                if (project.customer.id == selectedCustomerId) {
                    const option = new Option(project.nom, project.id);
                    option.setAttribute('data-customer-id', project.customer.id);
                    projectSelect.add(option);
                }
            });
    
                // Réinitialisez la sélection du projet
                projectSelect.value = "";
            });
        });
    </script>

