@extends('layouts.app')

@section('title', __('Clients'))

{{-- @section('sidebar')
    @include('partials/sidebar_menu_toggle')
    @include('system/sidebar_menu')
@endsection --}}

@section('content')
<div class="container-fluid mt-4 ">

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="entete">
        <h2 class="mb-4">Tous les clients </h2>
    </div>
    <div class="form-group text-right btn-creation">
        <a href="{{ route('customers.create') }}" class="btn btn-primary">Création d'un client +</a>
    </div>



    <div class="">
        <div class="row">
            <!-- Formulaire de filtrage par client -->
            <div class="col-md-6">
                <div class="form-group champ-list">
                    <label for="id_customer">Sélectionner un client :</label>
                    <select class="form-control" id="id_customer" onchange="filterCustomers()">
                        <option value="">Tous les clients</option>
                        @foreach ($allCustomers as $customer)
                        <option value="{{ $customer->id }}" {{ request('id_customers') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Barre de recherche -->
            <div class="col-md-6">
                <form method="GET" action="{{ route('customers.Customerall') }}" class="form-group  champ-list">
                    <div class="form-group champ-list">
                        <label>&nbsp;</label> <!-- Espacement pour aligner avec le label du select -->
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="search" class="form-control" placeholder="Rechercher un client..." value="{{ request('search') }}" style="flex: 1;">
                            <button type="submit" class="btn btn-primary" style="white-space: nowrap;">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <br>
    <div class="container-table">
        <div class="gradient-overlay"></div>
        <div class="content-table">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Entreprise</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th class="text-center">Interventions</th>
                        <th class="text-center">Projet</th>
                        <th class="text-center">Facture</th>
                        <th class="text-center">Conversations</th>
                        <th class="text-center">Modifier</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr class="customerRow" data-id="{{ $customer->id }}">
                        <td>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->company }}</td>
                        <td>{{ $customer->first_name }}</td>
                        <td>{{ $customer->last_name }}</td>


                        <td class="text-center">
                            @if($customer->projets->isNotEmpty())
                            <a href="{{ route('intervention.show', ['id_customers' => $customer->id]) }}" class="a-customers">
                                <ion-icon name="construct-outline" class="icon-table-clients md hydrated" role="img"></ion-icon>
                            </a>
                            @endif
                        </td>


                        <td class="text-center">
                            @if($customer->projets->isNotEmpty()) <!-- Vérifie s'il y a des projets -->
                            <a href="{{ route('projet.show', ['id' => $customer->id]) }}" class="a-customers">
                                <ion-icon name="folder-open-outline" class="icon-table-clients md hydrated" role="img"></ion-icon>
                            </a>
                            @endif
                        </td>


                        <td class="text-center">
                            @if($customer->projets->isNotEmpty())
                            <a href="{{ route('facturations.show', ['id_customers' => $customer->id]) }}">
                                <ion-icon name="wallet-outline" class="icon-table-clients md hydrated" role="img"></ion-icon>
                            </a>
                            @endif
                        </td>


                        <td class="text-center">
                            @if($customer->conversations->isNotEmpty()) <!-- Vérifie s'il y a des conversations -->
                            <a href="{{ route('customers.conversations', ['id' => $customer->id]) }}" class="a-customers">
                                <ion-icon name="chatbubble-ellipses-outline" class="icon-table-clients md hydrated" role="img"></ion-icon>
                            </a>
                            @endif
                        </td>


                        <td class="text-center"><a href="{{ route('customers.update', ['id' => $customer->id]) }}" class="a-customers">
                                <ion-icon name="person-add-outline" class="icon-table-clients md hydrated" role="img"></ion-icon></a>

                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $customers->appends(request()->query())->links() }}


    </div>


</div>
@endsection



@section('javascript')
urlcustomer()
@endsection