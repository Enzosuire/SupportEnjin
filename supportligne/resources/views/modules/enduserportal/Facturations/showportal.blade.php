@extends('enduserportal::layouts.portal')

@section('title', __('Facturations'))


@section('content')

        <div class="container-fluid mt-4"> 
            @if ($groupedFacturations->isEmpty())
                <div class="alert alert-info " role="alert">
                    Aucune Facturation réalisée.
                </div>
            @else
                @foreach($groupedFacturations as $customerId => $facturationsGroup)
                    {{-- <h2 class="mb-4">Facturations Réalisée pour {{ $facturationsGroup->first()->customer->company }}</h2> --}}
                    <h2 class="mb-4">Facturations Réalisée </h2>
            
                    
                    
                    <table class="table">
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
                                <tr>
                                    <td>
                                    <td>{{ $facturation->Numero_facturation }}</td>
                                    <td>{{ $facturation->date_facturation }}</td>
                                    <td>{{ $facturation->Forfait_heure}}</td>
                                    <td>{{ $facturation->projet->nom }}</td>
                                    <td>{{ $facturation->pole }}</td>
                                    <td>{{ $facturation->montant }} €</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
   
@endsection



    
@section('javascript')
@endsection


