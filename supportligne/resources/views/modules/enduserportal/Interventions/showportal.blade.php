@extends('enduserportal::layouts.portal')

@section('title', __('Interventions'))


@section('content')
    <div class="container-fluid mt-4"> 

        {{-- <h2 class="mb-4">Toutes les Interventions Réalisées pour {{ $interventionsDuClient->first()->customer->company }}</h2> --}}
        <h2 class="mb-4">Toutes les Interventions Réalisées  </h2>

        @if ($interventionsDuClient->isEmpty())
        <div class="alert alert-info" role="alert">
            Aucune intervention réalisée.
        </div>
        @else


            {{-- Selecteur pour filtrer les projets--}}
            <div class="form-group">
                <label for="id_projet">Projet :</label>
                <select class="form-control" name="id_projet" id="id_projet" required>
                    <option value="" >Sélectionner un projet</option>
                    @foreach ($projetsDuClient as $projet)
                        <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                    @endforeach
                </select>
            </div>



            <button class="Réinitialiser" type="button" id="resetButton">Réinitialiser</button>

            @foreach($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet)
                <h3 id="projectTitle_{{ $projetId }}">
                     @if ($interventionsProjet->first() && $interventionsProjet->first()->projet)
                        Nom du Projet : {{ $interventionsProjet->first()->projet->nom }}
                    @else
                        Nom du Projet non disponible
                    @endif
                </h3>

                <table class="table">
                    <thead>
                        <tr id="thead_{{ $projetId }}">
                            <th> #</th>
                            <th>Date d'intervention </th>
                            <th>Description</th>
                            <th>Temps alloué (en min) </th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interventionsDuClient->where('id_projet', $projetId) as $uneIntervention)
                        <tr class="intervention"
                        data-projet-id="{{ $uneIntervention->projet ? $uneIntervention->projet->id : '' }}"
                        data-typesintervention-id="{{ $uneIntervention->types_interventions }}">                                
                                <th scope="row"></th>
                                @if($uneIntervention instanceof \App\Intervention)
                                    <td>{{ $uneIntervention->date_intervention }}</td>
                                    <td>{{ $uneIntervention->description }}</td>
                                    <td>{{ $uneIntervention->temps_alloue }} min</td>

                                @elseif($uneIntervention instanceof \App\Conversation)
                                    <td>
                                        @if ($uneIntervention->timelogs->last())
                                            {{ $uneIntervention->timelogs->last()->updated_at }}
                                        @endif
                                    </td>
                                    <td>{{ $uneIntervention->subject }}</td>
                                    <td>{{ $uneIntervention->timelogs->sum('time_spent') }} min</td>
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
                        <tr id="totalRow_{{ $projetId }}" class="info">
                            <th colspan="3" class="text-center">Forfait heure </th>
                            <td>
                                @if(isset($forfaitHeureParProjet[$projetId]))
                                    {{ number_format($forfaitHeureParProjet[$projetId] / 60, 1) }} heures
                                @else
                                    Forfait heure non disponible
                                @endif
                            </td>
                        </tr>
                        <tr id="tempsRestantRow_{{ $projetId }}" class="info">
                            <th colspan="3" class="text-center">Temps restant contrat</th>
                            {{-- condition ? valeur_si_vraie : valeur_si_fausse --}}
                            <td class="{{ $tempsRestantParProjet[$projetId] <= 0 || ($tempsRestantParProjet[$projetId] > 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : (($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60) ? 'text-warning' : '') }}">
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
        @endif

    
    </div>
@endsection 



@section('eup_javascript')
setupSelectFiltersProjet();
@endsection


 


