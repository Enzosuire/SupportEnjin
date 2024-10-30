@extends('layouts.app')

@section('title', __('Intervention'))

@section('content')
    <div class="container-fluid mt-4">

        <div class="entete">
            <h2 class="mb-4">Toutes les Interventions Réalisées</h2>
            <div class="form-group text-right btn-creation">
                <a href="{{ route('intervention.create') }}" class="btn btn-primary">
                    Création d'une intervention +
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($interventionsDuClient->isEmpty())
            <div class="alert alert-info" role="alert">
                Aucune intervention réalisée.
            </div>
        @else
            {{-- Sélecteurs pour filtrer les projets et les types d'interventions --}}
            <div class="form-line-1 form-show-interventions">
                <div class="left-part-line-1">
                    <div class="form-group form-line-item-1 champ-list">
                        <label for="id_projet">Projet :</label>
                        <select class="form-control" name="id_projet" id="id_projet">
                            <option value="">Sélectionner un projet</option>
                            @foreach ($projets as $projet)
                                <option value="{{ $projet->id }}">{{ $projet->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group form-line-item-2 champ-list">
                        <label for="types_intervention">Types d'intervention :</label>
                        <select class="form-control" name="types_intervention" id="types_intervention">
                            <option value="">Sélectionner un type d'intervention</option>
                            @foreach ($typesinterventions as $typeIntervention)
                                <option value="{{ $typeIntervention }}">{{ $typeIntervention }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button class="btn btn-secondary" type="button" id="resetButton">Réinitialiser</button>
            </div>

            @foreach ($interventionsDuClient->groupBy('id_projet') as $projetId => $interventionsProjet)
                <h3 id="projectTitle_{{ $projetId }}" class="h3-interventions">
                    Nom du Projet :
                    {{ optional($interventionsProjet->first()->projet)->nom }}
                </h3>

                @if (!isset($containerTableCreated[$projetId]))
                    <div class="container-table" id="containerTable_{{ $projetId }}">
                        <div class="gradient-overlay"></div>
                        <div class="content-table">
                            <table class="table table-intervention">
                                <thead>
                                    <tr id="thead_{{ $projetId }}">
                                        <th>#</th>
                                        <th>Date d'intervention</th>
                                        <th>Description</th>
                                        <th>Temps alloué (en min)</th>
                                        <th>Numéro de ticket Jira</th>
                                        <th>Utilisateur</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($interventionsProjet as $uneIntervention)
                                        @if ($uneIntervention instanceof \Modules\Intervention\Models\Intervention)
                                            <tr class="intervention"
                                                data-projet-id="{{ optional($uneIntervention->projet)->id }}"
                                                data-typesintervention-id="{{ $uneIntervention->types_interventions }}">
                                                <td></td>
                                                <td>{{ $uneIntervention->date_intervention }}</td>
                                                <td>{{ $uneIntervention->description }}</td>
                                                <td>{{ $uneIntervention->temps_alloue }} min</td>
                                                <td>
                                                    @if ($uneIntervention->numero_ticket_jira)
                                                        <a href="https://enjinagency.atlassian.net/browse/{{ $uneIntervention->numero_ticket_jira }}"
                                                            target="_blank">
                                                            {{ $uneIntervention->numero_ticket_jira }}
                                                        </a>
                                                    @else
                                                        Pas de ticket Jira
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ optional($uneIntervention->user)->first_name ?? 'Utilisateur non disponible' }}
                                                </td>
                                                {{-- <td class="text-center">
                                                    <a
                                                        href="{{ route('intervention.updateint', ['customerId' => $uneIntervention->projet->customers->first()->id, 'id' => $uneIntervention->id]) }}"
                                                        class="btn btn-warning btn-sm">Modifier</a>
                                                    <a href="{{ route('intervention.delete', ['customerId' => $uneIntervention->projet->customers->first()->id, 'id' => $uneIntervention->id]) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')">Supprimer</a>
                                                </td> --}}

                                                <td class="text-center">
                                                    @php
                                                        $firstCustomer = $uneIntervention->projet->customers->first();
                                                    @endphp

                                                    @if ($firstCustomer)
                                                        <a href="{{ route('intervention.updateint', ['customerId' => $firstCustomer->id, 'id' => $uneIntervention->id]) }}"
                                                            class="btn btn-warning btn-sm">Modifier</a>

                                                        <a href="{{ route('intervention.delete', ['customerId' => $firstCustomer->id, 'id' => $uneIntervention->id]) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')">Supprimer</a>
                                                    @else
                                                        <span>Aucun client associé</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @elseif ($uneIntervention instanceof \App\Conversation && $uneIntervention->user_id)
                                            <tr class="intervention">
                                                <td></td>
                                                <td>
                                                    @if ($uneIntervention->timelogs->last())
                                                        {{ $uneIntervention->timelogs->last()->updated_at }}
                                                    @endif
                                                </td>

                                                <td>{{ $uneIntervention->subject }}</td>
                                                <td>{{ $uneIntervention->timelogs->sum('time_spent') }} min</td>
                                                <td>
                                                    @forelse ($uneIntervention->jira_keys as $jiraKey)
                                                        <a href="https://enjinagency.atlassian.net/browse/{{ $jiraKey }}"
                                                            target="_blank">{{ $jiraKey }}</a>
                                                    @empty
                                                        Aucun ticket Jira
                                                    @endforelse
                                                </td>
                                                <td>{{ optional($uneIntervention->user)->first_name ?? 'Utilisateur non disponible' }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr id="totalRow_{{ $projetId }}" class="info info-intervention">
                                        <th colspan="3" class="text-center"><label>Total :</label>
                                            <span>
                                                @if (isset($tempsAlloueParProjet[$projetId]))
                                                    {{ $tempsAlloueParProjet[$projetId] }} min
                                                @else
                                                    Temps alloué total non disponible
                                                @endif
                                            </span>
                                        </th>
                                        <th colspan="3" class="text-center"><label>Forfait heure :</label>
                                            <span>
                                                @if (isset($forfaitHeureParProjet[$projetId]))
                                                    {{ number_format($forfaitHeureParProjet[$projetId] / 60, 1) }} heures
                                                @else
                                                    Forfait heure non disponible
                                                @endif

                                            </span>
                                        </th>
                                        <th colspan="3" class="text-center"><label>Temps restant contrat :</label>
                                            <span
                                                class="{{ $tempsRestantParProjet[$projetId] <= 0 || ($tempsRestantParProjet[$projetId] > 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : ($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60 ? 'text-warning' : '') }}">
                                                @if (isset($tempsRestantParProjet[$projetId]))
                                                    {{ $tempsRestantParProjet[$projetId] }} minutes restantes
                                                @else
                                                    Temps restant du contrat non disponible
                                                @endif
                                            </span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach


        @endif

    </div>
@endsection

@section('javascript')

    setupSelectFilters();

@endsection


