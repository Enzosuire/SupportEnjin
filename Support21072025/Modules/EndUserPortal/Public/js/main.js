/**
 * Module's JavaScript.
 */

$(document).ready(function(){
	// Floating alerts
	//fsFloatingAlertsInit();
	$('#eup-logout-link').click(function(e) {
		$('#eup-logout-form').submit();
		e.preventDefault();
	});
});

function eupInitSubmit()
{
	$(document).ready(function(){
		eupLoadTicketForm();

		$('.eup-remember').on('blur', function() {
			eupRememberTicketForm();
		});

		$('.eup-btn-ticket-submit').click(function() {
			localStorageRemove('eup_ticket_form');
		});

		// Attachments
		$('.eup-att-dropzone').click(function() {
			var element = document.createElement('div');
			element.innerHTML = '<input type="file" multiple>';
			var fileInput = element.firstChild;

			fileInput.addEventListener('change', function() {
				if (fileInput.files) {
					for (var i = 0; i < fileInput.files.length; i++) {
						eupAddAttachment(fileInput.files[i]);
		            }
			    }
			});

			fileInput.click();
		});

		$('.eup-att-dropzone').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
			e.preventDefault();
			e.stopPropagation();
		})
		.on('dragover dragenter', function() {
			$(this).addClass('eup-dragover');
		})
		.on('dragleave dragend drop', function() {
			$(this).removeClass('eup-dragover');
		})
		.on('drop', function(e) {
			eupAddAttachment(e.originalEvent.dataTransfer.files[0]);
		});

		$('#eup-ticket-form').on('submit', function(e) {
			$(this).children().find('.eup-btn-ticket-submit:first').button('loading');
		});

		if (typeof($.fn.flatpickr) != "undefined") {
			$('.eup-type-date').flatpickr({allowInput: true});
		}
	});
}

function eupRememberTicketForm()
{
	var data = {};

	$('.eup-remember').each(function(i, el) {
		var input = $(el);
		data[input.attr('name')] = input.val();
	});

	localStorageSetObject('eup_ticket_form', data);
}

// Load field values from storage.
function eupLoadTicketForm()
{
	var data = localStorageGetObject('eup_ticket_form');

	for (var field in data) {
		input = $('#eup-ticket-form *[name="'+field+'"]');
		if (!input.val() || !input.attr('data-prefilled')) {
			input.val(data[field]);
		}
	}
}

function eupAddAttachment(file)
{
	if (!file || typeof(file.type) == "undefined") {
		return false;
	}

	var attachments_container = $(".attachments-upload:first");
	var attachment_dummy_id = generateDummyId();
	var route = '';

	// CSRF token
	ajaxSetup();

	// Show loader
	var attachment_html = '<li class="atachment-upload-'+attachment_dummy_id+'"><img src="'+Vars.public_url+'/img/loader-tiny.gif" width="16" height="16"/> <a href="#" class="break-words disabled" target="_blank">'+file.name+'<span class="ellipsis">…</span> </a> <span class="text-help">('+formatBytes(file.size)+')</span> <i class="glyphicon glyphicon-remove" data-eup-att-id="'+attachment_dummy_id+'"></i></li>';
	$('.attachments-upload:first ul:first').append(attachment_html);

	$('li.atachment-upload-'+attachment_dummy_id+' .glyphicon-remove:first').click(function(e) {
		removeAttachment($(this).attr('data-eup-att-id'));
	});

	attachments_container.show();

	data = new FormData();
	data.append("file", file);
	data.append("mailbox_id", getGlobalAttr('mailbox_id_encoded'));
	if (getGlobalAttr('is_widget')) {
		data.append("is_widget", getGlobalAttr('is_widget'));
	}
	
	$.ajax({
		url: laroute.route('enduserportal.upload', {mailbox_id: getGlobalAttr('mailbox_id_encoded')}),
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		type: 'POST',
		success: function(response){
			if (typeof(response.url) == "undefined" || !response.url) {
				showFloatingAlert('error', Lang.get("messages.error_occured"));
				loaderHide();
				removeAttachment(attachment_dummy_id);
				return;
			}
			// Finish loading
			$('li.atachment-upload-'+attachment_dummy_id+':first').addClass('attachment-loaded');
			$('li.atachment-upload-'+attachment_dummy_id+':first a').removeClass('disabled').attr('href', response.url);

			if (typeof(response.status) == "undefined" || response.status != "success") {
				showAjaxError(response);
				removeAttachment(attachment_dummy_id);
				return;
			}
			
			if (typeof(response.attachment_id) != "undefined" || response.attachment_id) {
				var input_html = '<input type="hidden" name="attachments_all[]" value="'+response.attachment_id+'" />';
				input_html += '<input type="hidden" name="attachments[]" value="'+response.attachment_id+'" class="atachment-upload-'+attachment_dummy_id+'" />';
				attachments_container.prepend(input_html);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			removeAttachment(attachment_dummy_id);
			console.log(textStatus+": "+errorThrown);
			showFloatingAlert('error', Lang.get("messages.error_occured"));
		}
	});
}

//Fucntion sousmission du sélécteur statut

function submitFilterOnStatusChange() {
    const statusSelect = document.getElementById('status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    }
}

// Attacher l'événement après le chargement du DOM
document.addEventListener('DOMContentLoaded', submitFilterOnStatusChange);



//filtre cote portail utilisateurs view projet sélécteur projet 
function setupSelectsProjet() {
    document.getElementById('id_projet').addEventListener('change', function() {
        var selectedProjectId = this.value;
        var rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(function(row) {
            var projectId = row.getAttribute('data-id'); // Utilisez data-id pour la comparaison

            if (selectedProjectId === "" || selectedProjectId == projectId) {
                row.style.display = ''; // Affiche la ligne
            } else {
                row.style.display = 'none'; // Masque la ligne
            }
        });
    });
}

// Filtre projet côté portail utilisateurs vue projet et vue facturation
function setupSelectsProjet() {
    document.getElementById('id_projet').addEventListener('change', function() {
        var selectedProjectId = this.value;

        // Cibler la table des projets
        var projectRows = document.querySelectorAll('.projects-table tbody tr');

        projectRows.forEach(function(row) {
            var projectId = row.getAttribute('data-id'); // Utilisez data-id pour la comparaison

            if (selectedProjectId === "" || selectedProjectId == projectId) {
                row.style.display = ''; // Affiche la ligne
            } else {
                row.style.display = 'none'; // Masque la ligne
            }
        });

        // Cibler la table des facturations
        var facturationSections = document.querySelectorAll('.facturation-section');

        facturationSections.forEach(function(section) {
            var sectionProjectId = section.getAttribute('data-id');
            
            if (selectedProjectId === "" || selectedProjectId == sectionProjectId) {
                section.style.display = ''; // Affiche la section si le projet est sélectionné ou si aucune sélection n'est faite
            } else {
                section.style.display = 'none'; // Masque la section si le projet ne correspond pas
            }
        });
    });
}
