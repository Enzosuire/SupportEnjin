$(document).ready(function(){
	$('#kb-customer-logout-link').click(function(e) {
		$('#customer-logout-form').submit();
		e.preventDefault();
	});
	$('#kb-logout-link').click(function(e) {
		$('#logout-form').submit();
		e.preventDefault();
	});
	$('#kb-category-nav-toggle').click(function(e) {
		$('#kb-category-nav').toggleClass('hidden-xs')
		e.preventDefault();
	});
});


// Script JavaScript pour gérer les flèches

    // Fonction pour gérer le changement d'icône dans le collapse de la base de connaissances
	document.addEventListener('DOMContentLoaded', function () {
		const categoryPanels = document.querySelectorAll('.kb-category-panel');
		const questionSections = document.querySelectorAll('.panel-group');
		const backButtons = document.querySelectorAll('.backButton');
		const categoryNameElement = document.getElementById('category-name');
	
		// Gérer les clics sur les catégories
		categoryPanels.forEach(panel => {
			panel.addEventListener('click', function (e) {
				e.preventDefault();
				
				const targetId = this.getAttribute('data-target');
				const categoryName = this.querySelector('.kb-category-panel-title p').textContent;
	
				// Afficher le nom de la catégorie dans la vue détaillée
				const targetSection = document.querySelector(targetId);
				targetSection.querySelector('#category-name').textContent = `Catégorie : ${categoryName}`;

				// Cacher la section des catégories
				document.querySelector('.kb-category-panels').style.display = 'none';
	
				// Masquer toutes les sections de questions et afficher la section sélectionnée
				questionSections.forEach(section => {
					section.style.display = 'none';
				});
				targetSection.style.display = 'block';
	
				// Afficher le bouton de retour dans la section choisie
				targetSection.querySelector('.backButton').style.display = 'inline-block';
			});
		});
	
		// Gérer les clics sur le bouton de retour
		backButtons.forEach(button => {
			button.addEventListener('click', function () {
				// Masquer la section de questions en cours
				this.closest('.panel-group').style.display = 'none';
	
				// Afficher la section des catégories
				document.querySelector('.kb-category-panels').style.display = 'grid';
	
				// Masquer le bouton de retour
				this.style.display = 'none';
	
				// Effacer le nom de la catégorie lorsqu'on revient aux catégories
				this.closest('.panel-group').querySelector('#category-name').textContent = '';
			});
		});
	
		// Gérer les clics sur les questions pour basculer l'affichage des réponses
		document.querySelectorAll('.panel-heading a').forEach(question => {
			question.addEventListener('click', function (e) {
				e.preventDefault();
				const collapseId = this.getAttribute('href');
				const collapseElement = document.querySelector(collapseId);
				
				// Toggle la classe collapse
				collapseElement.classList.toggle('collapse');
				
				// Toggle l'icône
				const icon = this.querySelector('.toggle-icon');
				icon.classList.toggle('bi-caret-up');
				icon.classList.toggle('bi-caret-down');
			});
		});
	});
	
	