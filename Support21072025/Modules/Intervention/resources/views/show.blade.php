@extends('layouts.app')

@section('title', __('Intervention'))

@section('content')
    <div class="container-fluid mt-4">

        <div class="entete">
            <h2 class="mb-4">Toutes les Interventions Réalisées</h2>
            <div class="form-group text-right btn-creation">
                <a href="{{ route('intervention.create', ['id_customers' => request('id_customers')]) }}" class="btn btn-primary">
                    Création d'une intervention +
                </a>
            </div>

        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

            <div class="form-group">
                <form action="{{ route('intervention.show') }}" method="get">
                    {{-- Sélecteurs pour filtrer les clients, projets et types d'interventions --}}
                    <div class="form-line-1 form-show-interventions">
        
                        <div class="form-group form-line-item-1 champ-list">
                            <label for="id_customers">Client :</label>
                                <select class="form-control" id="id_customers" name="id_customers" >
                                    <option value="">Sélectionner un client</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $id_customers == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->company }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>


                        {{-- Sélecteur pour filtrer par projet --}}
                        <div class="form-group form-line-item-2 champ-list">
                            <label for="id_projet">Projet :</label>
                            <select class="form-control" name="id_projet" id="id_projet" onchange="this.form.submit()">
                                <option value="">Sélectionner un projet</option>
                                @foreach ($projets as $projet)
                                    <option value="{{ $projet->id }}" 
                                        {{ $id_projet == $projet->id ? 'selected' : '' }}
                                        data-customer-id="{{ $projet->customers->first()->id ?? '' }}">
                                        {{ $projet->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="form-line-2 form-show-interventions">

                    
                    {{-- Sélecteur de type d'intervention en dessous avec largeur réduite --}}
                    <div class="form-group form-line-item-3 champ-list half-width">
                        <label for="types_intervention">Types d'intervention :</label>
                        <select class="form-control" name="types_intervention" id="types_intervention">
                            <option value="">Sélectionner un type d'intervention</option>
                            @foreach ($typesinterventions as $typeIntervention)
                                <option value="{{ $typeIntervention }}">{{ $typeIntervention }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-secondary" type="button" id="resetButton">Réinitialiser</button>
                </div>
            </div>
            

        @if ($interventionsDuClient->isEmpty())
        <div class="alert alert-info" role="alert">
            Aucune intervention réalisée.
        </div>
        @else
        
      
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
                                                data-client-id="{{ $uneIntervention->projet->customers->first()->id ?? 'null' }}"
                                                data-projet-id="{{ optional($uneIntervention->projet)->id }}"
                                                data-typesintervention-id="{{ $uneIntervention->types_interventions }}">
                                                <td></td>
                                                <td>{{ \Carbon\Carbon::parse($uneIntervention->date_intervention)->format('d/m/Y') }}</td>
                                                <td>{{ $uneIntervention->description }}</td>
                                                <td>{{ $uneIntervention->temps_alloue }} min</td>
                                                <td>
                                                    @if ($uneIntervention->numero_ticket_jira)
                                                        <a href="https://enjinagency.atlassian.net/browse/{{ $uneIntervention->numero_ticket_jira }}"
                                                            target="_blank">
                                                            {{ $uneIntervention->numero_ticket_jira }}
                                                        </a>
                                                    @else
                                                        Aucun ticket Jira
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

                                                <td class="text-center btn-sm">
                                                    @php
                                                        $firstCustomer = $uneIntervention->projet->customers->first();
                                                    @endphp

                                                    @if ($firstCustomer)
                                                        <a href="{{ route('intervention.updateint', ['customerId' => $firstCustomer->id, 'type' => 'intervention', 'id' => $uneIntervention->id]) }}" 
                                                            class="btn-warning btn-sm">Modifier</a>
                                                       
                                                        <a href="{{ route('intervention.delete', ['customerId' => $firstCustomer->id, 'type' => 'intervention', 'id' => $uneIntervention->id]) }}"
                                                            class="btn-danger btn-sm"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')">Supprimer</a>
                                                    @else
                                                        <span>Aucun client associé</span>
                                                    @endif
                                                </td>

                                            </tr>
                                        @elseif ($uneIntervention instanceof \App\Conversation && $uneIntervention->user_id)
                                            <tr class="intervention"
                                                data-client-id="{{ $uneIntervention->projet->customers->first()->id ?? 'null' }}"
                                                data-projet-id="{{ optional($uneIntervention->projet)->id }}"
                                                data-typesintervention-id="{{ $uneIntervention->types_interventions }}">
                                                <td></td>
                                                <td>
                                                    @if ($uneIntervention->timelogs->last())
                                                        {{ $uneIntervention->timelogs->last()->updated_at }}
                                                    @endif
                                                </td>

                                                <td>{{ $uneIntervention->subject }}</td>
                                                <td>{{ number_format($uneIntervention->timelogs->sum('time_spent') / 60 ) }} min</td>
                                                <td>
                                                    @forelse ($uneIntervention->jira_keys as $jiraKey)
                                                        <a href="https://enjinagency.atlassian.net/browse/{{ $jiraKey }}"
                                                            target="_blank">{{ $jiraKey }}</a>
                                                    @empty
                                                        Aucun ticket Jira
                                                    @endforelse
                                                </td>
                                                <td>{{ optional($uneIntervention->user)->first_name ?? 'Utilisateur non disponible' }}</td>

                                                <td class="text-center btn-sm">
                                                    @php
                                                          $firstCustomer = $uneIntervention->projet->customers->first(); // Utilisation du customer associé à la conversation
                                                    @endphp

                                                    @if ($firstCustomer)
                                                        <!-- Si intervention d'un projet ou conversation avec client, on peut modifier ou supprimer -->
                                                        <a href="{{ route('intervention.updateint', ['customerId' => $firstCustomer->id, 'type' => 'conversation', 'id' => $uneIntervention->id]) }}" 
                                                        class="btn-warning btn-sm">Modifier</a>

                                                        <a href="{{ route('intervention.delete', ['customerId' => $firstCustomer->id, 'type' => 'conversation', 'id' => $uneIntervention->id]) }}" class="btn-danger btn-sm"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette intervention ?')">Supprimer</a>
                                                    @else
                                                        <span>Aucun client associé</span>
                                                    @endif
                                                </td>


                                            </tr>
                                            
                                        @endif
                                    @endforeach

                                    <tr id="totalRow_{{ $projetId }}" class="info info-intervention">
                                        <th colspan="2" class="text-center"><label>Total :</label>
                                            <span>
                                                @if (isset($tempsAlloueParProjet[$projetId]))
                                                    {{ intdiv($tempsAlloueParProjet[$projetId], 60) }}h {{ $tempsAlloueParProjet[$projetId] % 60 }} minutes 
                                                @else
                                                    Temps alloué total non disponible
                                                @endif
                                            </span>
                                        </th>
                                        <th colspan="2" class="text-center"><label>Forfait :</label>
                                            <span>
                                                @if (isset($forfaitHeureParProjet[$projetId]))
                                                    {{ intdiv($forfaitHeureParProjet[$projetId], 60) }}h {{ $forfaitHeureParProjet[$projetId] % 60 }} minutes
                                                @else
                                                    Forfait non disponible
                                                @endif
                                            </span>
                                        </th>

                                        <!-- <th colspan="2" class="text-center"><label>Temps restant contrat :</label>
                                            <span
                                                class="{{ $tempsRestantParProjet[$projetId] <= 0 || ($tempsRestantParProjet[$projetId] > 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : ($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60 ? 'text-warning' : '') }}">
                                                @if (isset($tempsRestantParProjet[$projetId]))
                                                    {{ $tempsRestantParProjet[$projetId] }} minutes restantes
                                                @else
                                                    Temps restant du contrat non disponible
                                                @endif
                                            </span>
                                        </th> -->
                                        <th colspan="3" class="text-center">
                                            <label>Temps restant contrat :</label>
                                            <span class="{{ $tempsRestantParProjet[$projetId] <= 0 || ($tempsRestantParProjet[$projetId] > 0 && $tempsRestantParProjet[$projetId] <= 30) ? 'text-danger' : ($tempsRestantParProjet[$projetId] > 30 && $tempsRestantParProjet[$projetId] <= 60 ? 'text-warning' : '') }}">
                                                @if (isset($tempsRestantParProjet[$projetId]))
                                                    {{ intdiv($tempsRestantParProjet[$projetId], 60) }}h {{ $tempsRestantParProjet[$projetId] % 60 }} minutes restantes
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


