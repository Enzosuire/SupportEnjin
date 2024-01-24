@extends('layouts.app')

@section('title', __('System Status'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')

<div class="container">
    <h1 class="mt-4 mb-4 text-center">Création d'une Intervention</h1>

    <form class="form-horizontal mt-4" method="POST" action="{{ route('interventions.store')}}">
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
            <label for="types_interventions">Types d'interventions:</label>
            <select class="form-control" name="types_interventions" required>
                <option value="" disabled selected>Sélectionnez le type d'intervention</option>
                <option value="Développement">Développement</option>
                <option value="Maintenance">Maintenance</option>
                <option value="Correctif">Correctif</option>
            </select>
        </div>


        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="date_intervention">Date d'intervention:</label>
            <input class="form-control" type="datetime-local" name="date_intervention" required>
        </div>

        <div class="form-group">
            <label for="temps_alloue">Temps-allouée (min):</label>
            <input class="form-control" type="number" name="temps_alloue" required>
        </div>


        <div class="form-group">
            <label for="numero_ticket_jira">Numéro de ticket jira :</label>
            <input class="form-control" type="text" name="numero_ticket_jira" required>
        </div>

        <div class="form-group">
            <label for="id_users">Utilisateur :</label>
            <select class="form-control" name="id_users" required> 
                <option value="" disabled selected>Sélectionner un utilisateur (admin)</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
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


@section('javascript')
    @parent
    initSystemStatus();
@endsection

