
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




// filtre client en fonction des projets associés au client uniquement pour la formulaire de update facturations et interventions

function updateProjectSelect2faint(projects, selectedProjectId) {
    document.addEventListener('DOMContentLoaded', function () {
        const customerSelect = document.querySelector('select[name="id_customers"]');
        const projectSelect = document.querySelector('select[name="id_projet"]');

        function updateProjects(selectedCustomerId) {
            // Supprimez toutes les options actuelles du projet
            projectSelect.innerHTML = '<option value="" disabled selected>Sélectionner un projet</option>';

            // Ajoutez uniquement les options qui correspondent au client sélectionné
            projects.forEach(project => {
                // Assurez-vous que `project.customers` est un tableau d'objets `Customer` et vérifiez si le client est associé
                if (project.customers.some(customer => customer.id == selectedCustomerId)) {
                    const option = new Option(project.nom, project.id);
                    projectSelect.add(option);
                }
            });

            // Sélectionnez le projet pré-sélectionné s'il y en a un
            if (selectedProjectId) {
                projectSelect.value = selectedProjectId;
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

