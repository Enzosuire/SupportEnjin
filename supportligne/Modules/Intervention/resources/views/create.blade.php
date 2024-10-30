@extends('layouts.app')

@section('title', __('Créer une intervention'))

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

        <form action="{{ route('intervention.store') }}" method="post" class="form-creation">
            {{ csrf_field() }}
            <h2>Détail de l'intervention</h2>
            <hr class="soustitres">
            <div class="form-line-1">
                {{-- sélecteur client --}}
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

                {{-- sélecteur Projet --}}
                <div class="form-group form-line-item-2 champ-list">
                    <label for="id_projet">Projet :</label>
                    <select class="form-control" name="id_projet" id="id_projet" required>
                        <option value="" disabled selected>Sélectionner un projet</option>
                        @foreach ($projets as $projet)
                            <option value="{{ $projet->id }}" data-customer-id="{{ $projet->customer_id }}">
                                {{ $projet->nom }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="form-line-2 ">
                <div class="form-group form-line-item champ-input-txt">
                    <label for="description">Description:</label>
                    <textarea class="form-control" name="description"></textarea>
                </div>
            </div>


            <div class="form-line-3">

                <div class="form-group form-line-item-1 champ-list">
                    <label for="types_interventions">Types d'interventions:</label>
                    <select class="form-control" name="types_interventions" required>
                        <option value="" disabled selected>Sélectionnez le type d'intervention</option>
                        <option value="Développement">Développement</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Correctif">Correctif</option>
                    </select>
                </div>


                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_intervention">Date d'intervention:</label>
                    <input class="form-control" type="datetime-local" name="date_intervention" required>
                </div>
            </div>

            <div class="form-line-4">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="temps_alloue">Temps-allouée (min):</label>
                    <input class="form-control" type="number" name="temps_alloue" required>
                </div>


                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="numero_ticket_jira">Numéro de ticket jira :</label>
                    <input class="form-control" type="text" name="numero_ticket_jira">
                </div>
            </div>


            <div class="form-line-5">
                <div class="form-line-item">
                    <div class="form-group champ-list">
                        <label for="id_users">Utilisateur :</label>
                        <select class="form-control" name="id_users" required>
                            <option value="" disabled>Sélectionner un utilisateur (admin)</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ $user->id === $loggedInUser->id ? 'selected' : '' }}>
                                    {{ $user->first_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>



            <div class="form-group line-button">
                <button type="submit" class="btn btn-primary">Créer l'intervention</button>
            </div>
        </form>
    </div>

@endsection



@section('javascript')
    var projects = @json($projets);
    updateProjectSelect(projects);
@endsection
