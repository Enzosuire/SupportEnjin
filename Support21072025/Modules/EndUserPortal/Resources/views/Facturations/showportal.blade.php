@extends('enduserportal::layouts.portal')

@section('title', __('Facturations'))


@section('content')

        <div class="container-fluid mt-4"> 
            @if ($groupedFacturations->isEmpty())
                <div class="alert alert-info " role="alert">
                    Aucune Facturation réalisée.
                </div>
            @else

             {{-- Sélecteur pour filtrer les facturations par projet --}}
                <div class="form-group form-line-item-1 champ-list">
                    <h3><label for="id_projet">Projet :</label></h3>
                    <div class="row">
                        <div class="col-md-4"> 
                            <select class="form-control" name="id_projet" id="id_projet" required>
                                <option value="">Sélectionner un projet</option>
                                @foreach ($groupedFacturations as $projetId => $facturationsGroup)
                                    <option value="{{ $projetId }}">{{ $facturationsGroup->first()->projet->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                @foreach($groupedFacturations as $projetId => $facturationsGroup)
                    <div class="facturation-section" data-id="{{ $projetId }}">
                        <h2 class="mb-4">Facturations Réalisées pour le Projet : {{ $facturationsGroup->first()->projet->nom }}</h2>

                        <table class="table container-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Numéro de Facture </th>
                                    <th>Date de Facturation</th>
                                    <th>Forfait d'heure</th>
                                    <th>Projet</th>
                                    <th>Pôle </th>
                                    <th>Montant</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facturationsGroup as $facturation)
                                    <tr data-id="{{ $projetId }}">
                                        <td></td>
                                        <td>{{ $facturation->Numero_facturation }}</td>
                                        <td>{{ \Carbon\Carbon::parse($facturation->date_facturation)->format('d/m/Y') }}</td>
                                        <td>{{ $facturation->Forfait_heure }}</td>
                                        <td>{{ $facturation->projet->nom }}</td>
                                        <td>{{ $facturation->pole }}</td>
                                        <td>{{ $facturation->montant }} €</td>
                                    </tr>
                                @endforeach
                                <tr class="info info-intervention">
                                    <th colspan="3" class="text-center"><label>Total de facturation  :</label>
                                        <span>
                                        {{ $totauxParProjet[$projetId]['totalFacturations'] }}
                                        </span>
                                    </th>
                                    <th colspan="3" class="text-center"><label></label></th>
                                    <th colspan="3" class="text-center">
                                        <label>Coût facturation : </label>
                                        <span>
                                        {{ number_format($totauxParProjet[$projetId]['totalMontant'], 2) }} €
                                        </span>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
   
@endsection



@section('eup_javascript')
setupSelectsProjet();
@endsection



