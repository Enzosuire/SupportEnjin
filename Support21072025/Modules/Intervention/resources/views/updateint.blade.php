@extends('layouts.app')

@section('title', __('Modifications Intervention'))



@section('content')

    <div class="container-fluid">


        <form action="{{ route('intervention.update_interventions_traitement') }}" method="post"  class="form-creation">
            {{ csrf_field() }}

            <h1 class="mt-4 mb-4 update-h1">Modifier une Intervention</h1>
            <hr class="soustitres">

            <input type="hidden" name="id" value="{{ $uneIntervention->id }}">
            <input type="hidden" name="type" value="{{ $uneIntervention instanceof \App\Conversation ? 'conversation' : 'intervention' }}">



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
                @if($uneIntervention instanceof \App\Conversation)
                    <!-- Champ Objet de la conversation -->
                    <div class="form-group form-line-item champ-input-txt">
                        <label for="subject">Description:</label>
                        <input class="form-control" type="text" name="subject" value="{{ $uneIntervention->subject }}">
                    </div>
                @else
                    <!-- Champ Description -->
                    <div class="form-group form-line-item champ-input-txt">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description">{{ $uneIntervention->description }}</textarea>
                    </div>
                @endif
            </div>


            <div class="form-line-3">
                <div class="form-group form-line-item-1 champ-list">
                    <label for="types_interventions">Types d'interventions:</label>
                    <select class="form-control" name="types_interventions" >
                        <option value="" disabled selected>Sélectionnez le type d'intervention</option>
                        @foreach (['Développement', 'Maintenance', 'Correctif','Print'] as $types_interventions)
                            <option value="{{ $types_interventions }}"
                                {{ $uneIntervention->types_interventions == $types_interventions ? 'selected' : '' }}>
                                {{ $types_interventions }}
                            </option>
                        @endforeach
                    </select>
                </div>
    
    
    
                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="date_intervention">Date d'intervention:</label>
                    <input class="form-control" type="date" name="date_intervention"
                     value="{{ \Carbon\Carbon::parse($uneIntervention->date_intervention)->format('Y-m-d') }}" required>

                </div>
            </div>

            <div class="form-line-4">
                
                @if($uneIntervention instanceof \App\Conversation)
                    <div class="form-group form-line-item-2 champ-input-txt">
                        <label for="time_spent">Temps alloué (min):</label>
                        <input class="form-control" type="number" name="time_spent" 
                            value="{{ number_format($uneIntervention->timelogs->sum('time_spent') / 60 , 1) }}"> <!-- Conversion en minutes -->
                    </div>
                @else
                    <div class="form-group form-line-item-1 champ-input-txt">
                        <label for="temps_alloue">Temps-allouée (min):</label>
                        <input class="form-control" type="number" name="temps_alloue" 
                            value="{{ $uneIntervention->temps_alloue }}" >
                    </div>
                    
                @endif

                    

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
const projects = @json($projets); 
const selectedProjectId = {{ $uneIntervention->id_projet ?? '' }}; 
const selectedCustomerId = {{ $customerId ?? 'null' }}; // ID du client associé
updateProjectSelect2faint(projects, selectedProjectId, selectedCustomerId);
@endsection
