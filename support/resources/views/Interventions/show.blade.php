@extends('layouts.app')

@section('title', __('Intervention Details'))

@section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection

@section('content')
<div class="container-fluid mt-4"> 

    <h2 class="mb-4">Toutes les Interventions Réalisées pour {{ $interventionsDuClient->first()->customer->company }}</h2>


    {{-- Selecteur pour filtrer les projets--}}
    <div class="form-group">
        <label for="id_projet">Projet :</label>
        <select class="form-control" name="id_projet" id="id_projet" required>
            <option value="" disabled selected>Sélectionner un projet</option>
            @foreach ($projetsDuClient as $projet)
                <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
            @endforeach
        </select>
    </div>

    {{-- Selecteur pour filtrer les types d'interventions --}}
    <div class="form-group">
        <label for="types_intervention">Types intervention :</label>
        <select class="form-control" name="types_intervention" id="types_intervention" required>
            <option value="" disabled selected>Sélectionner un type d'intervention</option>
            @foreach ($typesinterventions as $typeIntervention)
                <option value="{{ $typeIntervention }}">{{ $typeIntervention }}</option>
            @endforeach
        </select>
    </div>

    <button type="button" id="resetButton">Réinitialiser</button>

    @foreach($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet)
        <h3>Nom du Projet : {{ $interventionsProjet->first()->projet->nom }}</h3>

        <table class="table">
            <thead>
                <tr>
                    <th> #</th>
                    <th>Date d'intervention </th>
                    <th>Description</th>
                    <th>Temps alloué (en min) </th>
                    <th>Numéro de ticket Jira </th>
                    <th>Utilisateur </th>
                </tr>
            </thead>
            <tbody>
                @foreach($interventionsDuClient->where('id_projet', $projetId) as $uneIntervention)
                    <tr class="intervention" data-projet-id="{{ $uneIntervention->projet->id }}" data-typesintervention-id="{{ $uneIntervention->types_interventions }}">
                        <th scope="row"></th>
                        @if($uneIntervention instanceof \App\Intervention)
                            <td>{{ $uneIntervention->date_intervention }}</td>
                            <td>{{ $uneIntervention->description }}</td>
                            <td>{{ $uneIntervention->temps_alloue }} min</td>
                            @if (Auth::user()->isAdmin())
                                <td><a href="https://enjinagency.atlassian.net/browse/TEAMWEB-151/{{ $uneIntervention->numero_ticket_jira }}">{{ $uneIntervention->numero_ticket_jira }}</a></td>
                                <td>{{ $uneIntervention->user->first_name }}</td>
                            @endif
                        @elseif($uneIntervention instanceof \App\Conversation)
                            <td>{{ $uneIntervention->timelogs->last()->updated_at }}</td>
                            <td>{{ $uneIntervention->subject }}</td>
                            <td>{{ $uneIntervention->timelogs->sum('time_spent') }} min</td>
                            {{-- <td>{{ $uneIntervention->numero_ticket_jira }}</td> --}}
                            <td>
                                @foreach($uneIntervention->jira_keys as $jiraKey)
                                    <a href="https://enjinagency.atlassian.net/browse/TEAMWEB-151/{{ $jiraKey }}">{{ $jiraKey }}</a>
                                @endforeach
                            </td>
                            <td>{{ $uneIntervention->user->first_name }}</td>
                        @endif
                    </tr>
                @endforeach
                    <tr id="totalRow_{{ $projetId }}" class="info" >
                        <th colspan="3" class="text-center">Total</th>
                        <td>
                            @if(isset($tempsAlloueParProjet[$projetId]))
                                {{ $tempsAlloueParProjet[$projetId] }} min
                            @else
                                Temps alloué total non disponible
                            @endif
                        </td>
                    </tr>
                    <tr id="tempsRestantRow_{{ $projetId }}" class="info">
                        <th colspan="3" class="text-center">Temps restant contrat</th>
                        {{-- condition ? valeur_si_vraie : valeur_si_fausse --}}
                        <td class="{{ ($tempsRestantParProjet[$projetId] >= 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : (($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60) ? 'text-warning' : '') }}">
                            @if(isset($tempsRestantParProjet[$projetId]))
                                {{ $tempsRestantParProjet[$projetId] }} minutes restantes
                            @else
                                Temps restant du contrat non disponible
                            @endif
                        </td>
                    </tr>
            </tbody>
        </table>
    @endforeach

   
</div>
@endsection 



<script>

document.addEventListener('DOMContentLoaded', function() {
    const selectProjet = document.querySelector('[name="id_projet"]');
    const selectTypesIntervention = document.querySelector('[name="types_intervention"]');
    const totalRow = document.getElementById('totalRow');
    const tempsRestantRow = document.getElementById('tempsRestantRow');

    // lignes pour définir les valeurs initiales
    const initialProjetValue = selectProjet.value;
    const initialTypesInterventionValue = selectTypesIntervention.value;

    selectProjet.addEventListener('change', filterInterventions);
    selectTypesIntervention.addEventListener('change', filterInterventions);

        function filterInterventions() {
        const selectedProjetId = selectProjet.value;
        const selectedTypeId = selectTypesIntervention.value;
        const interventions = document.querySelectorAll('.intervention');

        interventions.forEach(function(intervention) {
            const projetId = intervention.dataset.projetId;
            const typeId = intervention.dataset.typesinterventionId;
            const isProjetSelected = selectedProjetId === '' || projetId === selectedProjetId;
            const isTypeSelected = selectedTypeId === '' || typeId === selectedTypeId;

            if (isProjetSelected && isTypeSelected) {
                intervention.style.display = 'table-row';
            } else {
                intervention.style.display = 'none';
            }
        });

    
    }

    function updateTotalAndRemainingTimeRows(selectedProjetId) {
    // Sélectionner toutes les lignes Total et Temps restant
    // cible tous les éléments dont l'attribut id commence par la chaîne de caractères "totalRow_".
    const totalRows = document.querySelectorAll('[id^="totalRow_"]');
    const remainingTimeRows = document.querySelectorAll('[id^="tempsRestantRow_"]');

    // Afficher ou masquer les lignes en fonction du projet sélectionné
    totalRows.forEach(row => {
        // L'identifiant de la ligne est construit comme "totalRow_" suivi de l'ID du projet
        // Nous vérifions si cet identifiant correspond à celui du projet sélectionné
        row.style.display = (selectedProjetId === '' || row.id === 'totalRow_' + selectedProjetId) ? 'table-row' : 'none';
    });

    remainingTimeRows.forEach(row => {
        // De même pour les lignes de temps restant
        row.style.display = (selectedProjetId === '' || row.id === 'tempsRestantRow_' + selectedProjetId) ? 'table-row' : 'none';
    });
    }
    

    function resetSelect() {
        selectTypesIntervention.value = initialTypesInterventionValue;

        // Rafraîchir la page
        window.location.reload();
    }

    // Ajoutez cet événement pour réinitialiser les sélecteurs au clic sur le bouton
    document.getElementById('resetButton').addEventListener('click', resetSelect);
});


</script>



    
@section('javascript')
    @parent
    initSystemStatus();
@endsection

{{-- document.addEventListener('DOMContentLoaded', function() {
    const selectProjet = document.querySelector('select[name="id_projet"]');
    selectProjet.addEventListener('change', function() {
        const selectedProjetId = this.value;
        const interventions = document.querySelectorAll('.intervention');
        interventions.forEach(function(intervention) {
            // Affiche l'intervention seulement si un projet est sélectionné et qu'il correspond à l'intervention
            if (selectedProjetId && intervention.dataset.projetId === selectedProjetId) {
                intervention.style.display = 'block';
            } else {
                intervention.style.display = 'none';
            }
        });
        console.log(selectedProjetId);
    });
}); --}}

{{-- <h2 class="mb-4">Interventions créées à partir des Conversations</h2>

        <table class="table">
            <thead>
                <tr>
                    <th> #</th>
                    <th>Date d'intervention</th>
                    <th>Description</th>
                    <th>Temps alloué (en min)</th>
                    <th>Numéro de ticket Jira</th>
                    <th>Utilisateur</th>
                    <th>Projet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conversations as $conversation)
                {{-- Vérifier si l'intervention est présente --}
                        <tr>
                            <td>{{ $conversation->intervention->date_intervention }}</td>
                            <td>{{ $conversation->intervention->description }}</td>
                            <td>{{ $conversation->intervention->temps_alloue }}</td>
                            <td>
                                <a href="https://enjinagency.atlassian.net/browse/TEAMWEB-151/{{ $conversation->intervention->numero_ticket_jira }}">
                                    {{ $conversation->intervention->numero_ticket_jira }}
                                </a>
                            </td>
                            <td>{{ $conversation->intervention->user->first_name }}</td>
                            {{-- Utilisez la relation 'projet' directement--}}
                            {{-- <td>{{ $conversation->projet->nom }}</td> --
                        </tr>
                    @endif
                @endforeach
            

            </tbody>
        </table> --}}

         {{-- Partie pour afficher les conversations --}}
    {{-- <h2 class="mb-4">Conversations</h2>

        <table class="table">
            <thead>
                <tr>
                    <th> #</th>
                    <th>Date d'intervention</th>
                    <th>Description</th>
                    <th>Temps alloué (en min)</th>
                    <th>Numéro de ticket Jira</th>
                    <th>Utilisateur</th>
                    <th>Projet</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conversations as $conversation)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $conversation->timelogs->last()->updated_at }}</td>
                        <td>{{ $conversation->subject }}</td>
                        <td>{{ $conversation->timelogs->sum('time_spent') }}</td>
                        {{-- <td>{{ $conversation->intervention->numero_ticket_jira }}</td> --}}
                        {{-- <td>{{ $conversation->intervention->user->first_name }}</td> --
                    </tr>
                @endforeach
            </tbody>
        </table> --}}