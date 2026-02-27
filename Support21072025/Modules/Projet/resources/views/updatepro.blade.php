@extends('layouts.app')

@section('title', __('Modifier un Projet'))


@section('content')
    <div class="container-fluid">

    
        <form action="{{ route('projet.update_projet_traitement') }}" method="post"  class="form-creation">
            {{ csrf_field() }}

            <h1 class="mt-4 mb-4 update-h1">Modifier un Projet</h1>
            <hr class="soustitres">

            <input type="hidden" name="id" value="{{ $projet->id }}">

             {{-- Sélecteur Type de projet en premier --}}
            <div class="form-line-1">
                <div class="form-group form-line-item champ-list">
                    <label for="type_projet">Type de projet :</label>
                    <select name="type_projet" id="type_projet" class="form-control" required onchange="toggleFields()">
                        <option value="">Choisir le type de projet</option>
                        <option value="web" {{ $projet->type_projet === 'web' ? 'selected' : '' }}>Web</option>
                        <option value="print" {{ $projet->type_projet === 'print' ? 'selected' : '' }}>Print</option>
                    </select>

                </div>
            </div>


            <div class="form-line-1">
                {{-- Sélecteur entreprise --}}
                <div class="form-group form-line-item champ-list">
                    <label for="id_customers">Entreprise :</label>
                    <select class="form-control" id="id_customers" name="id_customers" required>
                        <option value="" disabled selected>Sélectionner une entreprise</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $customer->id == $projet->customers->first()->id ? 'selected' : '' }}>
                                {{ $customer->company }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="form-line-1">
                {{-- Sélecteur client --}}
                <div class="form-group form-line-item champ-list">
                    <label for="customers">Clients :</label>
                    <select class="form-control select-multiple" id="customers" >
                        <option value="">Sélectionnez un client</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                @if($projet && $projet->customers->contains($customer->id)) selected @endif>
                                {{ $customer->company }} ({{ $customer->first_name }} {{ $customer->last_name }})
                            </option>
                        @endforeach
                    </select>

                    <div id="selected-customers" class="mt-2"></div>
                    <div id="hidden-inputs-container"></div>
                </div>
            </div>



            <div class="form-line-2">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="nom">Nom du Projet:</label>
                    <input type="text" name="nom" class="form-control" value="{{ $projet->nom }}" required>
                </div>
                <div class="form-group form-line-item-2 champ-input-txt web-only">
                    <label for="date_sortie_site">Date sortie site :</label>
                    <input type="date" name="date_sortie_site" class="form-control" value="{{ $projet->date_sortie_site }}"
                       >
                </div>

            </div>

            <div class="form-line-3 web-only">
                    
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="maintenance_preventive">Maintenance Préventive:</label><br>

                    <div class="radio-center">
                        <input type="radio" id="oui" name="maintenance_preventive" value="oui" {{ $projet->maintenance_preventive == 'oui' ? 'checked' : '' }} required>
                        <label for="oui">Oui</label>
                        
                        <input type="radio" id="non" name="maintenance_preventive" value="non" {{ $projet->maintenance_preventive == 'non' ? 'checked' : '' }}>
                        <label for="non">Non</label>
                    </div>
                </div>

                <div class="form-group form-line-item-2 champ-input-txt">
                    <label for="duree_garantie">Durée de Garantie (mois):</label>
                    <input type="number" name="duree_garantie" class="form-control" value="{{ $projet->duree_garantie }}" >
                </div>
            </div>
            <!-- Champ Créasite -->
            <div class="form-line-4 web-only ">
                <div class="form-group form-line-item-1 champ-input-txt">
                    <label for="creasite">Créasite:</label><br>

                    <div class="radio-center">
                        <input type="radio" id="oui" name="creasite" value="oui" {{ $projet->creasite == 'oui' ? 'checked' : '' }} required>
                        <label for="oui">Oui</label>
                        
                        <input type="radio" id="non" name="creasite" value="non" {{ $projet->creasite == 'non' ? 'checked' : '' }}>
                        <label for="non">Non</label>
                    </div>
                </div>
            </div>
        
            {{-- Sélecteurs de référents --}}
            <div class="form-line-4 web-only">
                <div class="form-group form-line-item champ-list">
                    <label for="referent_web">Référent Web :</label>
                    <select name="referent_web" id="referent_web" class="form-control">
                        <option value="">Choisir un référent pour le pôle Web</option>
                        @foreach ($users as $user)
                            <!-- Comparer avec le nom complet stocké dans referent_web_name -->
                            <option value="{{ $user->id }}" 
                                    {{ $user->first_name . ' ' . $user->last_name == $projet->referent_web_name ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-line-item champ-list">
                    <label for="referent_seo">Référent SEO :</label>
                    <select name="referent_seo" id="referent_seo" class="form-control">
                        <option value="">Choisir un référent pour le pôle SEO</option>
                        @foreach ($users as $user)
                            <!-- Comparer avec le nom complet stocké dans referent_seo_name -->
                            <option value="{{ $user->id }}" 
                                    {{ $user->first_name . ' ' . $user->last_name == $projet->referent_seo_name ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group form-line-item champ-list">
                    <label for="referent_commercial">Référent Commercial :</label>
                    <select name="referent_commercial" id="referent_commercial" class="form-control">
                        <option value="">Choisir un référent pour le pôle Commercial</option>
                        @foreach ($users as $user)
                            <!-- Comparer avec le nom complet stocké dans referent_commercial_name -->
                            <option value="{{ $user->id }}" 
                                    {{ $user->first_name . ' ' . $user->last_name == $projet->referent_commercial_name ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="line-button">
                <button type="submit" class="btn btn-primary">Modifier le Projet</button>
            </div>
        </form>
    </div>

 
@endsection


@section('javascript')
initializeCustomerSelect();
<!-- const projects = @json($projet); 
const selectedProjectId = {{ $projet->id }}; 
const selectedCustomerId = {{ $projet->customers->first()->id ?? 'null' }}; // ID du client associé
updateProjectSelect2faint(projects, selectedProjectId, selectedCustomerId); -->
toggleFields();
@endsection
