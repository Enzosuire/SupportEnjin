@extends('layouts.app')

@section('title', __('Modifications Intervention'))

@section('sidebar')
    {{-- @include('partials/sidebar_menu_toggle') --}}
    {{-- @include('system/sidebar_menu') --}}
@endsection


@section('content')

    <div class="container-fluid">


        <form action="{{ route('intervention.update_interventions_traitement') }}" method="post"  class="form-creation">
            {{ csrf_field() }}

            <h1 class="mt-4 mb-4 update-h1">Modifier une Intervention</h1>
            <hr class="soustitres">

            <input type="hidden" name="id" value="{{ $uneIntervention->id }}">


            <div class="form-line-1">

                {{-- Sélecteur client --}}
                <div class="form-group form-line-item-1 champ-list">
                    <label for="id_customers">Client :</label>
                    <select class="form-control" id="id_customers" name="id_customers" required>
                        <option value="" disabled selected>Sélectionner un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $customerId ? 'selected' : '' }}>
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Sélecteur projet --}}
                <div class="form-group form-line-item-2 champ-list">
                    <label for="id_projet">Projet :</label>
                    <select class="form-control" name="id_projet" id="id_projet" required>
                        <option value="" disabled>Sélectionner un projet</option>
                        @foreach ($projets as $projet)
                            <option value="{{ $projet->id }}"
                                {{ $uneIntervention->id_projet == $projet->id ? 'selected' : '' }}>
                                {{ $projet->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-line-2">
                <div class="form-group form-line-item champ-input-txt">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description">{{ $uneIntervention->description }}</textarea>
                </div>
            </div>

            <div class="form-line-3">
                <div class="form-group form-line-item-1 champ-list">
                    <label for="types_interventions">Types d'interventions:</label>
                    <select class="form-control" name="types_interventions" required>
                        <option value="" disabled selected>Sélectionnez le type d'intervention</option>
                        @foreach (['Développement', 'Maintenance', 'Correctif'] as $types_interventions)
                            <option value="{{ $types_interventions }}"
                                {{ $uneIntervention->types_interventions == $types_interventions ? 'selected' : '' }}>
                                {{ $types_interventions }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
    
    
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_intervention">Date d'intervention:</label>
                    <input class="form-control" type="datetime-local" name="date_intervention"
                        value="{{ $uneIntervention->date_intervention }}" required>
                </div>
            </div>

            <div class="form-line-4">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="temps_alloue">Temps-allouée (min):</label>
                    <input class="form-control" type="number" name="temps_alloue" value="{{ $uneIntervention->temps_alloue }}"
                        required>
                </div>
    
    
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="numero_ticket_jira">Numéro de ticket jira :</label>
                    <input class="form-control" type="text" name="numero_ticket_jira"
                        value="{{ $uneIntervention->numero_ticket_jira }}">
                </div>
            </div>

            <div class="form-line-5">
                <div class="form-group form-line-item champ-list">
                    <label for="id_users">Utilisateur :</label>
                    <select class="form-control" name="id_users" required>
                        <option value="" disabled>Sélectionner un utilisateur (admin)</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ $user->id === $uneIntervention->id_users ? 'selected' : '' }}>
                                {{ $user->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-group line-button">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>

@endsection



@section('javascript')
    var projects = @json($projets);
    var selectedProjectId = {{ $uneIntervention->id_projet ?? '' }};
    updateProjectSelect2faint(projects);
@endsection
