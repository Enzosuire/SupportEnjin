// Filtre client, projet et types interventions (affichage admin)
function setupSelectFilters() {
    document.addEventListener("DOMContentLoaded", function () {
        const selectClient = document.querySelector('[name="id_customers"]'); // Sélecteur client
        const selectProjet = document.querySelector('[name="id_projet"]'); // Sélecteur projet
        const selectTypesIntervention = document.querySelector('[name="types_intervention"]'); // Sélecteur types d'intervention
        const resetButton = document.getElementById("resetButton"); // Bouton de réinitialisation

        // Initialiser les valeurs des sélecteurs à partir des paramètres d'URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('id_customers')) selectClient.value = urlParams.get('id_customers');
        if (urlParams.get('id_projet')) selectProjet.value = urlParams.get('id_projet');
        if (urlParams.get('types_intervention')) selectTypesIntervention.value = urlParams.get('types_intervention');

        // Ajouter les écouteurs d'événements sur les sélecteurs
        selectClient.addEventListener("change", function () {
            updateProjectOptions();
            selectProjet.value = ''; // Réinitialise uniquement la sélection du projet
            updateURLParams();
            filterInterventions();
        });

        selectProjet.addEventListener("change", function () {
            updateURLParams();
            filterInterventions();
        });

        selectTypesIntervention.addEventListener("change", function () {
            updateURLParams();
            filterInterventions();
        });

        resetButton.addEventListener("click", resetFilters);

        // Met à jour les options de projet en fonction du client sélectionné
        function updateProjectOptions() {
            Array.from(selectProjet.options).forEach(option => {
                if (option.value === '') {
                    option.style.display = 'block';
                    return;
                }

                const optionCustomerId = option.getAttribute('data-customer-id');

                if (selectClient.value === '') {
                    option.style.display = 'block';
                } else {
                    option.style.display = (optionCustomerId === selectClient.value) ? 'block' : 'none';
                }
            });
        }

        // Fonction de filtrage des interventions
        function filterInterventions() {
            const selectedClientId = selectClient.value; // ID du client sélectionné
            const selectedProjetId = selectProjet.value; // ID du projet sélectionné
            const selectedTypeId = selectTypesIntervention.value; // ID du type d'intervention sélectionné

            const interventions = document.querySelectorAll(".intervention"); // Toutes les interventions

            // Filtrage des interventions en fonction des sélections
            interventions.forEach(function (intervention) {
                const clientId = intervention.dataset.clientId; // ID du client dans les données de l'intervention
                const projetId = intervention.dataset.projetId; // ID du projet dans les données de l'intervention
                const typeId = intervention.dataset.typesinterventionId; // ID du type d'intervention dans les données

                const isClientSelected = !selectedClientId || clientId === selectedClientId;
                const isProjetSelected = !selectedProjetId || projetId === selectedProjetId;
                const isTypeSelected = !selectedTypeId || typeId === selectedTypeId;

                if (isProjetSelected && isTypeSelected && isClientSelected) {
                    intervention.style.display = "table-row"; // Afficher l'intervention
                } else {
                    intervention.style.display = "none"; // Cacher l'intervention
                }
            });

            updateProjectVisibility(selectedClientId, selectedProjetId);
        }

        // Met à jour les paramètres d'URL sans recharger la page
        function updateURLParams() {
            const newParams = new URLSearchParams();
            if (selectClient.value) newParams.set("id_customers", selectClient.value);
            if (selectProjet.value) newParams.set("id_projet", selectProjet.value);
            if (selectTypesIntervention.value) newParams.set("types_intervention", selectTypesIntervention.value);

            // Mise à jour de l'URL sans recharger la page
            history.replaceState(null, "", `${window.location.pathname}?${newParams.toString()}`);
        }

        // Fonction pour afficher ou masquer les projets et lignes associées
        function updateProjectVisibility(selectedClientId, selectedProjetId) {
            const projectTitles = document.querySelectorAll('[id^="projectTitle_"]');
            const containerTables = document.querySelectorAll('.container-table');
            const theads = document.querySelectorAll('[id^="thead_"]');
            const totalRows = document.querySelectorAll('[id^="totalRow_"]');
            const remainingTimeRows = document.querySelectorAll('[id^="tempsRestantRow_"]');
            const forfaitRows = document.querySelectorAll('[id^="forfaitRow_"]');

            // Afficher ou cacher les projets et les lignes en fonction des filtres
            projectTitles.forEach(title => {
                const associatedProjetId = title.id.replace('projectTitle_', '');
                title.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "block" : "none";
            });

            containerTables.forEach(container => {
                const associatedProjetId = container.id.replace('containerTable_', '');
                container.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "block" : "none";
            });

            theads.forEach(thead => {
                const associatedProjetId = thead.id.replace('thead_', '');
                thead.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "table-row" : "none";
            });

            totalRows.forEach(row => {
                const associatedProjetId = row.id.replace('totalRow_', '');
                row.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "table-row" : "none";
            });

            remainingTimeRows.forEach(row => {
                const associatedProjetId = row.id.replace('tempsRestantRow_', '');
                row.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "table-row" : "none";
            });

            forfaitRows.forEach(row => {
                const associatedProjetId = row.id.replace('forfaitRow_', '');
                row.style.display = shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) ? "table-row" : "none";
            });
        }

        function shouldDisplayProject(selectedClientId, associatedProjetId, selectedProjetId) {
            return (
                (!selectedClientId || Array.from(document.querySelectorAll(".intervention")).some(intervention =>
                    intervention.dataset.projetId === associatedProjetId && intervention.dataset.clientId === selectedClientId)) &&
                (!selectedProjetId || associatedProjetId === selectedProjetId)
            );
        }


        // Fonction de réinitialisation
        function resetFilters() {
            // Réinitialiser les paramètres d'URL sans aucune valeur
            history.replaceState(null, "", window.location.pathname);

            // Recharger la page
            location.reload();
        }

        // Filtrer au chargement initial
        filterInterventions();
        updateProjectOptions(); // S'assurer que les options de projet sont mises à jour initialement
        updateURLParams(); 
    });
}




//Filtre projet  (affichage customer)

function setupSelectFiltersProjet() {
    document.addEventListener("DOMContentLoaded", function () {
        const selectProjet = document.querySelector('[name="id_projet"]');
        const totalRow = document.getElementById("totalRow");
        const tempsRestantRow = document.getElementById("tempsRestantRow");

        // lignes pour définir les valeurs initiales
        const initialProjetValue = selectProjet.value;

        selectProjet.addEventListener("change", function () {
            if (selectProjet.value === "") {
                resetSelect();
            } else {
                filterInterventions();
            }
        });

        function filterInterventions() {
            const selectedProjetId = selectProjet.value;
            const interventions = document.querySelectorAll(".intervention");

            interventions.forEach(function (intervention) {
                const projetId = intervention.dataset.projetId;
                const isProjetSelected =
                    selectedProjetId === "" || projetId === selectedProjetId;

                intervention.style.display = isProjetSelected
                    ? "table-row"
                    : "none";
            });

            // Mettre à jour l'affichage des lignes Total et Temps restant
            updateTotalAndRemainingTimeRows(selectedProjetId);
        }

        function updateTotalAndRemainingTimeRows(selectedProjetId) {
            const totalRows = document.querySelectorAll('[id^="totalRow_"]');
            const remainingTimeRows = document.querySelectorAll(
                '[id^="tempsRestantRow_"]'
            );
            const projectTitles = document.querySelectorAll(
                '[id^="projectTitle_"]'
            );
            const thead = document.querySelectorAll('[id^="thead_"]');
            const interventions = document.querySelectorAll(".intervention");
            let anyVisibleIntervention = false;

            // Vérifier s'il y a au moins une intervention visible
            interventions.forEach(function (intervention) {
                if (
                    intervention.style.display !== "none" &&
                    intervention.getAttribute("data-projet-id") ===
                        selectedProjetId
                ) {
                    anyVisibleIntervention = true;
                }
            });

            // Afficher ou masquer les lignes en fonction du projet sélectionné et de la visibilité des interventions
            totalRows.forEach((row) => {
                row.style.display =
                    selectedProjetId !== "" &&
                    anyVisibleIntervention &&
                    row.id === "totalRow_" + selectedProjetId
                        ? "table-row"
                        : "none";
            });

            remainingTimeRows.forEach((row) => {
                row.style.display =
                    selectedProjetId !== "" &&
                    anyVisibleIntervention &&
                    row.id === "tempsRestantRow_" + selectedProjetId
                        ? "table-row"
                        : "none";
            });

            projectTitles.forEach((title) => {
                title.style.display =
                    selectedProjetId !== "" &&
                    title.id === "projectTitle_" + selectedProjetId
                        ? "block"
                        : "none";
            });

            thead.forEach((row) => {
                row.style.display =
                    selectedProjetId !== "" &&
                    anyVisibleIntervention &&
                    row.id === "thead_" + selectedProjetId
                        ? "table-row"
                        : "none";
            });
        }

        function resetSelect() {
            selectProjet.value = initialProjetValue;

            // Rafraîchir la page
            window.location.reload();
        }

        // Ajoutez cet événement pour réinitialiser les sélecteurs au clic sur le bouton
        document
            .getElementById("resetButton")
            .addEventListener("click", resetSelect);
    });
}


function updateInterventionSelect(interventions, selectedInterventionId, selectedProjectId, selectedCustomerId) {
    document.addEventListener('DOMContentLoaded', function () {
        const customerSelect = document.querySelector('select[name="id_customers"]');
        const projectSelect = document.querySelector('select[name="id_projet"]');
        const interventionSelect = document.querySelector('select[name="id_intervention"]');

        // Initialiser le sélecteur client
        function initializeSelects() {
            if (selectedCustomerId) {
                customerSelect.value = selectedCustomerId;
            }
            if (selectedProjectId) {
                projectSelect.value = selectedProjectId;
            }
        }

        // Mettre à jour les projets en fonction du client sélectionné
        function updateProjects(selectedCustomerId) {
            projectSelect.innerHTML = '<option value="" disabled selected>Sélectionner un projet</option>'; // Réinitialise le sélecteur des projets

            // Filtrer les projets associés au client sélectionné
            const filteredProjects = projects.filter(project => {
                return project.customers.some(customer => customer.id == selectedCustomerId);
            });

            // Ajouter les options de projet
            filteredProjects.forEach(project => {
                const option = new Option(project.nom, project.id);
                projectSelect.add(option);
            });

            // Sélectionner le projet pré-sélectionné s'il y en a un
            if (selectedProjectId) {
                projectSelect.value = selectedProjectId;
            }

            // Mettre à jour les interventions en fonction du projet et du client sélectionnés
            updateInterventions(selectedCustomerId, selectedProjectId);
        }

        // Mettre à jour les interventions en fonction du projet et du client
        function updateInterventions(selectedCustomerId, selectedProjectId) {
            interventionSelect.innerHTML = '<option value="" disabled selected>Sélectionner une intervention</option>'; // Réinitialise le sélecteur des interventions

            // Filtrer les interventions associées au client et au projet
            interventions.forEach(intervention => {
                if (
                    (!selectedCustomerId || intervention.customerId == selectedCustomerId) && // Vérifie si le client correspond
                    (!selectedProjectId || intervention.projectId == selectedProjectId) // Vérifie si le projet correspond
                ) {
                    const option = new Option(intervention.name, intervention.id);
                    interventionSelect.add(option);
                }
            });

            // Sélectionner l'intervention pré-sélectionnée s'il y en a une
            if (selectedInterventionId) {
                interventionSelect.value = selectedInterventionId;
            }
        }

        // Initialisation des sélecteurs lors du chargement de la page
        initializeSelects();

        // Mise à jour des projets lorsque le client change
        customerSelect.addEventListener('change', function () {
            updateProjects(this.value); // Mettre à jour les projets selon le client sélectionné
        });

        // Mise à jour des interventions lorsque le projet change
        projectSelect.addEventListener('change', function () {
            updateInterventions(customerSelect.value, this.value); // Mettre à jour les interventions selon le client et projet sélectionnés
        });

        // Initialisation des projets et interventions en fonction des sélections initiales
        updateProjects(selectedCustomerId);
    });
}


function setupSelectFiltersprojetclients() {
    const customerSelect = document.getElementById('id_customers');
    const projectSelect = document.getElementById('id_projet');

    customerSelect.addEventListener('change', function() {
        const selectedCustomerId = this.value;
        
        // Reset project selector
        projectSelect.value = '';
        
        // Hide all project options
        Array.from(projectSelect.options).forEach(option => {
            if (option.value === '') {
                option.style.display = 'block'; // Always show default option
                return;
            }
            
            // If no customer is selected, show all projects
            if (selectedCustomerId === '') {
                option.style.display = 'block';
            } else {
                // Show only projects for the selected customer
                const optionCustomerId = option.getAttribute('data-customer-id');
                option.style.display = (optionCustomerId === selectedCustomerId) ? 'block' : 'none';
            }
        });
    });
}