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
            <div class="form-group form-line-item-2 champ-list">
                <h3><label for="id_projet">Projet :</label></h3>
                <div class="row">
                    <div class="col-md-4"> 
                        <select class="form-control" name="id_projet" id="id_projet" required>
                            <option value="" >Sélectionner un projet</option>
                            @foreach ($projets as $projet)
                                <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <button class="btn btn-secondary" type="button" id="resetButton">Réinitialiser</button>

            @foreach($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet)
                <h3 id="projectTitle_{{ $projetId }}">
                     @if ($interventionsProjet->first() && $interventionsProjet->first()->projet)
                        Nom du Projet : {{ $interventionsProjet->first()->projet->nom }}
                    @else
                        Nom du Projet non disponible
                    @endif
                </h3>

                <table class="table table-intervention container-table">
                    <thead>
                        <tr id="thead_{{ $projetId }}">
                            <th>#</th>
                            <th>Date d'intervention</th>
                            <th>Description</th>
                            <th>Temps alloué (en min)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($interventionsDuClient->where('id_projet', $projetId) as $uneIntervention)
                            <tr class="intervention"
                                data-projet-id="{{ $uneIntervention->projet ? $uneIntervention->projet->id : '' }}"
                                data-typesintervention-id="{{ $uneIntervention->types_interventions }}">
                                <th scope="row"></th>
                                @if($uneIntervention instanceof Modules\Intervention\Models\Intervention)
                                    <td>{{ \Carbon\Carbon::parse($uneIntervention->date_intervention)->format('d/m/Y') }}</td>   
                                    <td>{{ $uneIntervention->description }}</td>
                                    <td>{{ $uneIntervention->temps_alloue }} min</td>
                                @elseif($uneIntervention instanceof \App\Conversation)
                                    <td>
                                        @if ($uneIntervention->timelogs->last())
                                            {{ $uneIntervention->timelogs->last()->updated_at }}
                                        @endif
                                    </td>
                                    <td>{{ $uneIntervention->subject }}</td>
                                    <td>{{ round($uneIntervention->timelogs->sum('time_spent') / 60)  }} min</td>
                                @endif
                            </tr>
                        @endforeach
                        <tr id="totalRow_{{ $projetId }}" class="info info-intervention">
                            <th colspan="2" class="text-center"><label>Total :</label>
                                <span>
                                    @if (isset($tempsAlloueParProjet[$projetId]))
                                    {{ intdiv(round($tempsAlloueParProjet[$projetId]), 60) }}h {{ round($tempsAlloueParProjet[$projetId]) % 60 }} minutes

                                    @else
                                        Temps alloué total non disponible
                                    @endif
                                </span>
                            </th>
                            <th  class="text-center"><label>Forfait heure :</label>
                                <span>
                                    @if (isset($forfaitHeureParProjet[$projetId]))
                                        {{ intdiv($forfaitHeureParProjet[$projetId], 60) }}h {{ $forfaitHeureParProjet[$projetId] % 60 }} minutes
                                    @else
                                        Forfait non disponible
                                    @endif
                                </span>
                            </th>
                            <th  class="text-center"><label>Temps restant contrat :</label>
                                <span
                                    class="{{ $tempsRestantParProjet[$projetId] <= 0 || ($tempsRestantParProjet[$projetId] > 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : ($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60 ? 'text-warning' : '') }}">
                                    @if (isset($tempsRestantParProjet[$projetId]))
                                        {{ intdiv(round($tempsRestantParProjet[$projetId]), 60) }}h {{ round($tempsRestantParProjet[$projetId]) % 60 }} minutes restantes
                                    @else
                                        Temps restant du contrat non disponible
                                    @endif
                                </span>
                            </th>
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


 


