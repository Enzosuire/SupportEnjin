//Filtre projet et types interventions (affichage admin)

function setupSelectFilters() {
    document.addEventListener("DOMContentLoaded", function () {
        const selectProjet = document.querySelector('[name="id_projet"]');
        const selectTypesIntervention = document.querySelector('[name="types_intervention"]');
        const resetButton = document.getElementById("resetButton");

        const initialProjetValue = selectProjet.value;
        const initialTypesInterventionValue = selectTypesIntervention.value;

        selectProjet.addEventListener("change", filterInterventions);
        selectTypesIntervention.addEventListener("change", filterInterventions);
        resetButton.addEventListener("click", resetSelect);

        function filterInterventions() {
            const selectedProjetId = selectProjet.value;
            const selectedTypeId = selectTypesIntervention.value;

            const interventions = document.querySelectorAll(".intervention");
            const projectTitles = document.querySelectorAll('[id^="projectTitle_"]');
            const containerTables = document.querySelectorAll('.container-table');
            const theads = document.querySelectorAll('[id^="thead_"]');
            const totalRows = document.querySelectorAll('[id^="totalRow_"]');
            const remainingTimeRows = document.querySelectorAll('[id^="tempsRestantRow_"]');
            const forfaitRows = document.querySelectorAll('[id^="forfaitRow_"]');

            let anyVisibleIntervention = false;

            interventions.forEach(function (intervention) {
                const projetId = intervention.dataset.projetId;
                const typeId = intervention.dataset.typesinterventionId;
                const isProjetSelected = selectedProjetId === "" || projetId === selectedProjetId;
                const isTypeSelected = selectedTypeId === "" || typeId === selectedTypeId;

                if (isProjetSelected && isTypeSelected) {
                    intervention.style.display = "table-row";
                    anyVisibleIntervention = true;
                } else {
                    intervention.style.display = "none";
                }
            });

            // Mise à jour de l'affichage des lignes de projet
            projectTitles.forEach(title => {
                title.style.display = title.id === `projectTitle_${selectedProjetId}` || selectedProjetId === "" ? "block" : "none";
            });

            // Mise à jour de l'affichage des conteneurs de tables
            containerTables.forEach(container => {
                container.style.display  = container.id === `containerTable_${selectedProjetId}` || selectedProjetId === "" ? "block" : "none";
            });

            // Mise à jour de l'affichage des lignes du tableau
            theads.forEach(thead => {
                thead.style.display = thead.id === `thead_${selectedProjetId}` || selectedProjetId === "" ? "table-row" : "none";
            });

            totalRows.forEach(row => {
                row.style.display = row.id === `totalRow_${selectedProjetId}` || selectedProjetId === "" ? "table-row" : "none";
            });

            remainingTimeRows.forEach(row => {
                row.style.display = row.id === `tempsRestantRow_${selectedProjetId}` || selectedProjetId === "" ? "table-row" : "none";
            });

            forfaitRows.forEach(row => {
                row.style.display = row.id === `forfaitRow_${selectedProjetId}` || selectedProjetId === "" ? "table-row" : "none";
            });
        }

        function resetSelect() {
            selectProjet.value = "";
            selectTypesIntervention.value = initialTypesInterventionValue;

            // Rafraîchir la page
            window.location.reload();
        }
    });
}


 

// divcontainer.forEach(div => {
//     div.style.display = div.class === `divcontainer${selectedProjetId}` || selectedProjetId === "" ? "table-row" : "none";
// });

// const divcontainer= document.querySelectorAll('[".container-table"]');

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
