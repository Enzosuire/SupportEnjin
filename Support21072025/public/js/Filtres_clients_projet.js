
// filtre client en fonction des projets associés au client 

function updateProjectSelect(projects) {
    document.addEventListener('DOMContentLoaded', function () {
        const customerSelect = document.querySelector('select[name="id_customers"]');
        const projectSelect = document.querySelector('select[name="id_projet"]');

        function updateProjects(selectedCustomerId) {
            // Supprimez toutes les options actuelles du projet
            projectSelect.innerHTML = '<option value="" disabled selected>Sélectionner un projet</option>';

            // Ajoutez uniquement les projets liés au client sélectionné
            let firstProjectId = null;
            projects.forEach(project => {
                project.customers.forEach(customer => {
                    if (customer.id == selectedCustomerId) {
                        const option = new Option(project.nom, project.id);
                        option.setAttribute('data-customer-id', customer.id);
                        projectSelect.add(option);

                        // Stockez l'ID du premier projet pour la sélection par défaut
                        if (firstProjectId === null) {
                            firstProjectId = project.id;
                        }
                    }
                });
            });

            // Sélectionnez le premier projet par défaut
            if (firstProjectId !== null) {
                projectSelect.value = firstProjectId;
            }
        }

        // Appeler la fonction directement pour le chargement initial de la page
        updateProjects(customerSelect.value);

        // Attacher l'événement change au sélecteur des clients
        customerSelect.addEventListener('change', function () {
            updateProjects(this.value);
        });
    });
}




// filtre client en fonction des projets associés au client pour le formulaire de update facturations,interventions et projet 
function updateProjectSelect2faint(projects, selectedProjectId, selectedCustomerId) {
    document.addEventListener('DOMContentLoaded', function () {
        const customerSelect = document.querySelector('select[name="id_customers"]');
        const projectSelect = document.querySelector('select[name="id_projet"]');

        // Initialiser le sélecteur client et projet
        function initializeSelects() {
            // Mettre à jour le sélecteur de clients
            if (selectedCustomerId) {
                customerSelect.value = selectedCustomerId;
            }
            
        }

        // Mettre à jour les projets en fonction du client sélectionné
        function updateProjects(selectedCustomerId) {
            projectSelect.innerHTML = '<option value="" disabled selected>Sélectionner un projet</option>';

            projects.forEach(project => {
                if (project.customers.some(customer => customer.id == selectedCustomerId)) {
                    const option = new Option(project.nom, project.id);
                    projectSelect.add(option);
                }
            });

            // Sélectionner le projet pré-sélectionné s'il y en a un
            if (selectedProjectId) {
                projectSelect.value = selectedProjectId;
            }
        }

        // Initialiser les sélecteurs lors du chargement de la page
        initializeSelects();

        // Mettre à jour les projets lorsque le client change
        customerSelect.addEventListener('change', function () {
            updateProjects(this.value);
        });

        // Mettre à jour les projets à partir du client sélectionné initialement
        updateProjects(customerSelect.value);
    });
}



//formulaire d'update conversation assignée une conversation a un projet
function updateConversations() {
document.getElementById('projectSelector').addEventListener('change', function() {
    document.getElementById('projectForm').submit();
});

}

//Formulaire création  et update projet Sélécteur pour plusieurs clients
function initializeCustomerSelect() {
    const select = document.getElementById('customers');
    const selectedCustomersDiv = document.getElementById('selected-customers');
    const hiddenInputsContainer = document.getElementById('hidden-inputs-container');
    let selectedCustomers = new Set();

    // Fonction pour mettre à jour les badges et les champs cachés
    function updateSelectedCustomers() {
        selectedCustomersDiv.innerHTML = '';  // Vider les badges
        hiddenInputsContainer.innerHTML = ''; // Vider les champs cachés

        selectedCustomers.forEach(customerId => {
            const option = select.querySelector(`option[value="${customerId}"]`);
            if (option) {
                // Badge pour chaque client
                const badge = document.createElement('span');
                badge.classList.add('badge', 'bg-primary', 'me-1', 'mb-1');
                badge.textContent = option.textContent;
                badge.dataset.id = customerId;

                // Suppression du badge au clic
                badge.onclick = function() {
                    selectedCustomers.delete(customerId);
                    updateSelectedCustomers();
                };
                selectedCustomersDiv.appendChild(badge);

                // Champ caché pour chaque client sélectionné
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'selected_customers[]';
                hiddenInput.value = customerId;
                hiddenInputsContainer.appendChild(hiddenInput);
            }
        });
    }

    // Événement lors de la sélection
    select.addEventListener('change', function() {
        const customerId = this.value;
        if (customerId && !selectedCustomers.has(customerId)) {
            selectedCustomers.add(customerId);
            updateSelectedCustomers();
        }
        this.value = ""; // Réinitialiser la sélection
    });

    // Initialisation des clients sélectionnés
    const initialSelectedCustomers = Array.from(select.querySelectorAll('option[selected]')).map(option => option.value);
    initialSelectedCustomers.forEach(customerId => {
        if (customerId !== "") {
            selectedCustomers.add(customerId);
        }
    });

    updateSelectedCustomers();
}

// Lancer l'initialisation après le chargement du DOM
document.addEventListener('DOMContentLoaded', initializeCustomerSelect);




//filtre formulaire création d'un projet (entreprise/client)
function filterCustomerscompany() {
    var selectedCompany = document.getElementById('company').value;
    var customersSelect = document.getElementById('customers');
    var options = customersSelect.options;

    for (var i = 0; i < options.length; i++) {
        var option = options[i];
        // Affiche le client si l'entreprise est sélectionnée ou si aucun filtre n'est appliqué
        option.style.display = (selectedCompany === "" || option.text.includes(selectedCompany)) ? 'block' : 'none';
    }
}


// Fonction de filtrage des facturations en fonction du client, du pôle, de la date de facturation, et du projet
function filterFacturations() {
    document.addEventListener("DOMContentLoaded", function () {
        const selectClients = document.querySelector('[name="id_customers"]');
        const selectPole = document.querySelector('[name="pole"]');
        const selectDateDebut = document.querySelector('[name="date_debut"]');
        const selectDateFin = document.querySelector('[name="date_fin"]');
        const selectProjet = document.querySelector('[name="id_projet"]');
        const resetButton = document.getElementById("resetButton");

        // Mise à jour des projets selon le client sélectionné
        function updateProjects(selectedClientId) {
            const options = selectProjet.options;
            
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                const customerID = option.getAttribute('data-customer-id');
                
                if (option.value === '') continue; // Ignore l'option vide
                
                if (!selectedClientId || customerID === selectedClientId) {
                    option.hidden = false;
                } else {
                    option.hidden = true;
                    if (option.selected) {
                        selectProjet.value = ''; // Réinitialise la sélection si le projet n'est plus disponible
                    }
                }
            }
        }

        selectClients.addEventListener("change", function() {
            updateProjects(this.value);
            this.form.submit();
        });

        // Filtrage initial au chargement de la page
        updateProjects(selectClients.value);

        // Fonction de filtrage des facturations
        function filterFacturationsByCriteria() {
            const selectedClientId = selectClients.value;
            const selectedPole = selectPole.value;
            const selectedDateDebut = selectDateDebut.value;
            const selectedDateFin = selectDateFin.value;
            const selectedProjet = selectProjet.value;

            const facturations = document.querySelectorAll(".facturation");

            facturations.forEach(function(facturation) {
                const client = facturation.dataset.client;
                const pole = facturation.dataset.pole;
                const projet = facturation.dataset.projet;
                const dateFacturationText = facturation.querySelector("td:nth-child(3)").innerText;
                const dateFacturation = new Date(dateFacturationText).toISOString().split('T')[0];

                const isInClient = !selectedClientId || client === selectedClientId;
                const isInPole = !selectedPole || pole === selectedPole;
                const isInDateRange = (!selectedDateDebut || dateFacturation >= selectedDateDebut) &&
                                    (!selectedDateFin || dateFacturation <= selectedDateFin);
                const isInProjet = !selectedProjet || projet === selectedProjet;

                facturation.style.display = (isInClient && isInPole && isInDateRange && isInProjet) ? "table-row" : "none";
            });
        }

        // Gestion des autres filtres
        selectPole.addEventListener("change", filterFacturationsByCriteria);
        selectDateDebut.addEventListener("change", filterFacturationsByCriteria);
        selectDateFin.addEventListener("change", filterFacturationsByCriteria);
        selectProjet.addEventListener("change", filterFacturationsByCriteria);

        // Réinitialisation des filtres
        resetButton.addEventListener("click", function() {
            selectClients.value = "";
            selectPole.value = "";
            selectDateDebut.value = "";
            selectDateFin.value = "";
            selectProjet.value = "";

            const url = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, url);
            window.location.reload();
        });
    });
}



//Formulaire d'update conversation assignée une conversation a un projet
function urlcustomer() {
    document.getElementById('id_customers').addEventListener('change', function() {
         // Récupérer l'ID du client dans l'URL
         const urlParams = new URLSearchParams(window.location.search);
         const customerId = urlParams.get('id_customers');

         if (customerId) {
            // Si un client est passé dans l'URL, sélectionnez-le dans le sélecteur
            const selectCustomer = document.querySelector('#id_customers');
            selectCustomer.value = customerId; // Définir la valeur du sélecteur
            selectCustomer.form.submit(); // Soumettre le formulaire automatiquement
        }
        
    });
    
}



// Fonction JavaScript pour filtrer les Projets par client et Créasite (view projet)
function filterProjets() {
    const selectedCustomerId = document.getElementById('id_customer').value;
    const selectedCreasite = document.getElementById('creasite').value;
    const allProjets = document.querySelectorAll('.customer-projets');

    allProjets.forEach(function(projetContainer) {
        const customerId = projetContainer.getAttribute('data-customer-id');
        const projets = projetContainer.querySelectorAll('tbody tr');

        let hasVisibleProjet = false;

        projets.forEach(function(projetRow) {
            const creasiteValue = projetRow.querySelector('td:nth-child(7)').textContent.trim().toLowerCase(); // Récupère la valeur Créasite

            // Vérifie si le projet correspond aux filtres
            const matchesCustomer = !selectedCustomerId || customerId == selectedCustomerId;
            const matchesCreasite = !selectedCreasite || creasiteValue === selectedCreasite;

            if (matchesCustomer && matchesCreasite) {
                projetRow.style.display = '';  // Afficher la ligne du projet
                hasVisibleProjet = true;
            } else {
                projetRow.style.display = 'none'; // Masquer la ligne du projet
            }
        });

        // Masquer ou afficher le conteneur du client en fonction de ses projets visibles
        projetContainer.style.display = hasVisibleProjet ? 'block' : 'none';
    });
}



 // Fonction pour filtrer les clients sur la view de tout les clients Customerall
 function filterCustomers() {
    const selectedCustomerId = document.getElementById('id_customer').value;
    // Redirection avec le paramètre de filtrage
    window.location.href = `${window.location.pathname}?id_customers=${selectedCustomerId}`;
}


// Filtre Type de projet formulaire de création projet 
    function toggleFields() {
        const typeProjet = document.getElementById('type_projet').value;
        const webFields = document.querySelectorAll('.web-only');
        
        if (typeProjet === 'web') {
            // Afficher tous les champs web
            webFields.forEach(field => {
                field.classList.add('show');
            });
            
            // Rendre les champs requis pour le web
            document.querySelector('input[name="maintenance_preventive"][value="oui"]').setAttribute('required', '');
            document.querySelector('input[name="creasite"][value="oui"]').setAttribute('required', '');
            
        } else {
            // Cacher tous les champs web
            webFields.forEach(field => {
                field.classList.remove('show');
            });
            
            // Retirer l'attribut required et réinitialiser les valeurs
            const radioInputs = document.querySelectorAll('.web-only input[type="radio"]');
            radioInputs.forEach(input => {
                input.removeAttribute('required');
                input.checked = false;
            });
            
            // Vider les autres champs
            document.querySelector('input[name="date_sortie_site"]').value = '';
            document.querySelector('input[name="duree_garantie"]').value = '';
            document.querySelector('select[name="referent_web"]').value = '';
            document.querySelector('select[name="referent_seo"]').value = '';
            document.querySelector('select[name="referent_commercial"]').value = '';
        }
    }
    
    // Initialiser l'état au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });

