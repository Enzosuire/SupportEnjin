@extends('knowledgebase::layouts.portal')

@section('title', \Kb::getKbName($mailbox))

@section('content')

<div class="heading kb-front-heading">
	{{ \Kb::getKbName($mailbox) }}

	<!-- <div class="row">
			<form class="col-sm-6 col-sm-offset-3" action="{{ \Kb::route('knowledgebase.frontend.search', ['mailbox_id'=>\Kb::encodeMailboxId($mailbox->id)], $mailbox) }}">
				<div class="input-group input-group-lg margin-top">
					<input type="text" class="form-control" name="q">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
					</span>
				</div>
			</form>
		</div> -->
</div>

<!-- @if (count($categories))
		@include('knowledgebase::partials/frontend/category_panels', ['categories' => $categories])
	@elseif (count($articles))
		@include('knowledgebase::partials/frontend/articles', ['articles' => $articles])
	@else
		@include('partials/empty', ['icon' => 'book'])
	@endif
 -->




<div class="container">
	<h2 class="text-center">Enjin : Assistance et Connaissances </h2>
    <div class="text-center">
        <p>Voici une présentation de notre support pour une meilleure prise en main :  <strong><a href="https://www.loom.com/share/73085353be944e2883492fead47368d4?sid=1c15aefb-0ed1-456f-94c5-0c6d9d81ea92" target="_blank"> Vidéo de présentation de l'outil</a></strong></p>
    </div>
    <br>
		<div class="row">
			<div class="kb-category-panels">
				<a href="#" class="kb-category-panel" data-target="#questions-Site-Web">
					<div class="kb-category-panel-title">
						<p>Site Web</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-display"></i>
					</div>
				</a>
				<a href="#" class="kb-category-panel" data-target="#questions-Site-ecommerce">
					<div class="kb-category-panel-title">
						<p>Site e-commerce</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-cart"></i>
					</div>
				</a>
				<a href="#" class="kb-category-panel" data-target="#questions-Application">
					<div class="kb-category-panel-title">
						<p>Application</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-phone"></i>
					</div>
				</a>
				<a href="#" class="kb-category-panel" data-target="#questions-Mail">
					<div class="kb-category-panel-title">
						<p>Mail</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-envelope"></i>
					</div>
				</a>
				<a href="#" class="kb-category-panel" data-target="#questions-SEO">
					<div class="kb-category-panel-title">
						<p>SEO</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-bar-chart"></i>
					</div>
				</a>
				<a href="#" class="kb-category-panel" data-target="#questions-faq">
					<div class="kb-category-panel-title">
						<p>FAQ</p>
					</div>
					<div class="kb-category-panel-info">
						<i class="bi bi-question-square"></i>
					</div>
				</a>
			</div>

			<!-- Section de questions "Site Web" -->
			<div id="questions-Site-Web" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<br>
				<!-- Première question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#collapse1">
							<h4 class="panel-title">
								Mon site affiche d'anciennes versions des pages. Comment vider le cache ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse1" class="panel-collapse collapse">
						<div class="panel-body">
							Ce problème est souvent dû au cache. Voici comment le vider :
							<ul>
								<li><strong>Navigateur :</strong> Actualisez la page en utilisant <code>Ctrl + F5</code></li>
								<li><strong>Cache serveur :</strong> Via le panneau d'administration</li>
								<li><strong>Plugins :</strong> Utilisez les options de vidage du cache</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Deuxième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#collapse15">
							<h4 class="panel-title">
								Comment réparer une page qui ne s'affiche pas correctement ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse15" class="panel-collapse collapse">
						<div class="panel-body">
							Si votre page ne s'affiche pas correctement, voici quelques étapes à suivre :
							<ul>
								<li><strong>Vérifiez le code HTML/CSS :</strong> Assurez-vous que la structure de la page est correcte.</li>
								<li><strong>Testez la compatibilité :</strong> Utilisez des outils de test de compatibilité pour différents navigateurs.</li>
								<li><strong>Consultez les erreurs JavaScript :</strong> Vérifiez la console du navigateur pour tout message d'erreur.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>


			<!-- Section de questions "questions-Site-ecommerce" -->
			<div id="questions-Site-ecommerce" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<br>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#collapse2">
							<h4 class="panel-title">
								Mon site est lent ou ne charge pas. Que faire ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse2" class="panel-collapse collapse">
						<div class="panel-body">
							Plusieurs facteurs peuvent ralentir un site :
							<ul>
								<li>Vérifiez si votre connexion Internet fonctionne correctement.</li>
								<li>Essayez de désactiver temporairement les plugins récemment ajoutés.</li>
								<li>Nettoyez le cache comme décrit ci-dessus.</li>
								<li>Contactez-nous si le problème persiste, car cela pourrait être lié à une surcharge de trafic, une attaque DDoS, ou un problème d'hébergement.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>


			<!-- Questions Section pour la catégorie Application -->
			<div id="questions-Application" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<br>

				<!-- Première question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
							<h4 class="panel-title">
								Que faire si mon application ne répond pas ou se bloque fréquemment ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse3" class="panel-collapse collapse">
						<div class="panel-body">
							Si votre application ne répond pas ou se bloque, essayez ces solutions :
							<ul>
								<li><strong>Redémarrez votre appareil :</strong> Éteignez et rallumez votre appareil pour éliminer tout problème temporaire lié au système.</li>
								<li><strong>Effacez le cache et les données :</strong> Accédez aux paramètres de l'application sur votre appareil et videz le cache ou effacez les données pour réinitialiser l'application.</li>
								<li><strong>Met à jour l'application :</strong> Vérifiez si une mise à jour est disponible et installez-la pour bénéficier des dernières corrections de bugs.</li>
								<li><strong>Libérez de l'espace :</strong> Assurez-vous que votre appareil dispose d'un espace de stockage suffisant pour que l'application fonctionne correctement.</li>
								<li><strong>Réinstallez l'application :</strong> Désinstallez puis réinstallez l'application pour résoudre tout problème de corruption des fichiers.</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Deuxième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse34">
							<h4 class="panel-title">
								Pourquoi certaines fonctionnalités de l'application ne fonctionnent-elles pas correctement ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse34" class="panel-collapse collapse">
						<div class="panel-body">
							Si certaines fonctionnalités ne fonctionnent pas comme prévu, suivez ces étapes :
							<ul>
								<li><strong>Vérifiez les autorisations :</strong> Assurez-vous que l'application dispose des autorisations nécessaires (comme l'accès au GPS, au stockage, ou à la caméra).</li>
								<li><strong>Confirmez votre connexion internet :</strong> Certaines fonctionnalités nécessitent une connexion stable. Essayez de passer à un réseau plus fiable.</li>
								<li><strong>Redémarrez l'application :</strong> Fermez l'application complètement et relancez-la pour voir si le problème persiste.</li>
								<li><strong>Testez sur un autre appareil :</strong> Si possible, installez l'application sur un autre appareil pour déterminer si le problème est lié à votre matériel ou à l'application elle-même.</li>
								<li><strong>Contactez le support technique :</strong> Si le problème est spécifique à une fonctionnalité, contactez l'équipe de support avec des détails sur l'erreur rencontrée.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>


			<!-- Questions Section pour la question Mail -->
			<div id="questions-Mail" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<br>

				<!-- Première question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
							<h4 class="panel-title">
								Comment résoudre les problèmes d'envoi ou de réception de mes e-mails ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse4" class="panel-collapse collapse">
						<div class="panel-body">
							Si vous rencontrez des difficultés pour envoyer ou recevoir des e-mails, suivez ces étapes pour diagnostiquer et résoudre le problème :
							<ul>
								<li><strong>Vérifiez la connexion internet :</strong> Assurez-vous que votre connexion à Internet est stable pour que les e-mails puissent être transmis sans problème.</li>
								<li><strong>Vérifiez vos paramètres de messagerie :</strong> Assurez-vous que les paramètres SMTP et IMAP/POP3 sont correctement configurés selon les recommandations de votre fournisseur d'e-mail.</li>
								<li><strong>Consultez l'espace de stockage :</strong> Vérifiez si la boîte de réception ou la boîte d'envoi est pleine, ce qui peut empêcher l'envoi ou la réception de nouveaux messages.</li>
								<li><strong>Effacez le cache et les cookies :</strong> Parfois, des données obsolètes dans le cache du navigateur peuvent causer des problèmes d'accès à votre boîte mail. Videz le cache pour réinitialiser.</li>
								<li><strong>Essayez un autre client de messagerie :</strong> Si le problème persiste, testez l'envoi et la réception d'e-mails sur un autre client de messagerie pour identifier si le problème est lié à votre application actuelle.</li>
								<li><strong>Contactez le support technique :</strong> Si le problème persiste malgré ces étapes, contactez le support technique de votre fournisseur d'e-mail pour obtenir de l'aide.</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Deuxième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse45">
							<h4 class="panel-title">
								Que faire si mes e-mails sont marqués comme spam ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse45" class="panel-collapse collapse">
						<div class="panel-body">
							Si vos e-mails sont marqués comme spam, suivez ces conseils pour les éviter :
							<ul>
								<li><strong>Vérifiez la qualité de vos e-mails :</strong> Évitez les mots et les phrases typiques des spams dans vos messages.</li>
								<li><strong>Authentifiez vos e-mails :</strong> Mettez en place des enregistrements SPF, DKIM et DMARC pour garantir l'authenticité de vos e-mails.</li>
								<li><strong>Utilisez des services d'envoi fiables :</strong> Utilisez des services de messagerie réputés pour éviter les problèmes de réputation.</li>
								<li><strong>Demandez à vos utilisateurs de vous ajouter à leur liste blanche :</strong> Encouragez vos contacts à ajouter votre adresse e-mail à leurs contacts ou à la liste blanche de leur client de messagerie.</li>
								<li><strong>Consultez les filtres de spam de votre fournisseur :</strong> Assurez-vous que votre adresse e-mail n'est pas bloquée par les filtres de spam de votre fournisseur de messagerie.</li>
							</ul>
						</div>
					</div>
				</div>

				<!-- Troisième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse46">
							<h4 class="panel-title">
								Pourquoi mes e-mails prennent-ils trop de temps à arriver ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse46" class="panel-collapse collapse">
						<div class="panel-body">
							Si vos e-mails prennent trop de temps à arriver, voici des points à vérifier :
							<ul>
								<li><strong>Vérifiez les serveurs de votre fournisseur :</strong> Assurez-vous que les serveurs SMTP et IMAP/POP3 fonctionnent correctement et qu'il n'y a pas de panne.</li>
								<li><strong>Examinez la taille de vos e-mails :</strong> Les pièces jointes volumineuses peuvent ralentir le processus d'envoi et de réception.</li>
								<li><strong>Contrôlez la bande passante de votre connexion :</strong> Une connexion lente peut entraîner des retards dans l'envoi et la réception des messages.</li>
								<li><strong>Contactez votre fournisseur de messagerie :</strong> Si le problème persiste, il peut s'agir d'un problème sur le serveur de votre fournisseur de services de messagerie.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>




			<!-- Questions Section pour la catégorie SEO -->
			<div id="questions-SEO" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<br>

					<!-- Première question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
							<h4 class="panel-title">
								Quels sont les critères essentiels pris en compte par Google pour le référencement d’un site web ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse5" class="panel-collapse collapse">
						<div class="panel-body">
							Pour optimiser le référencement d'un site web, Google prend en compte les critères suivants :
							<ul>
								<li><strong>Un contenu de qualité :</strong> Le contenu doit être original, pertinent, structuré, avec des mots-clés SEO bien intégrés.</li>
								<li><strong>Une bonne expérience utilisateur (UX) :</strong> Le site doit être rapide, responsive, avec une navigation intuitive.</li>
								<li><strong>Une autorité forte :</strong> Des backlinks de qualité et une expertise reconnue aident à votre bon référencement.</li>
								<li><strong>Une technique irréprochable :</strong> Plusieurs critères sont à prendre en compte tels que l’HTTPS, les balises optimisées, les Core Web Vitals et une architecture claire.</li>
								<li><strong>Une intention de recherche cohérente :</strong> Apporter des réponses précises aux besoins des utilisateurs (information, achat, navigation).</li>
								<li><strong>L’engagement :</strong> Un taux de clic et des interactions élevés sont de bons indicateurs.</li>
								<li><strong>Le SEO local :</strong> L’optimisation des fiches Google My Business, avis positifs, localisation… est essentielle pour votre référencement local.</li>
								<li><strong>Des mises à jour régulières :</strong> Le contenu doit être fréquemment enrichi ou actualisé.</li>
								<li><strong>Des médias optimisés :</strong> Ne pas négliger l’optimisation des images et vidéos afin qu’elles soient légères, ainsi que les balises alt et les données structurées pour les extraits enrichis.</li>
							</ul>
							L’agence Enjin vous accompagne à chaque étape de cette optimisation, en proposant des solutions adaptées à vos besoins pour garantir un site bien conçu, techniquement performant et orienté utilisateur, favorisant ainsi un bon classement dans les moteurs de recherche.
						</div>
					</div>
				</div>

				<!-- Troisième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse58">
							<h4 class="panel-title">
								Combien de temps faut-il attendre pour constater une amélioration de la position d’un site sur les moteurs de recherche ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse58" class="panel-collapse collapse">
						<div class="panel-body">
							Le temps nécessaire pour observer une amélioration du positionnement d’un site sur les moteurs de recherche varie selon plusieurs facteurs. Les <strong>changements techniques</strong> peuvent montrer des effets en quelques semaines, tandis que le <strong>contenu de qualité</strong> prend souvent 4 à 8 semaines pour se classer. Les <strong>backlinks</strong>, essentiels au SEO, nécessitent généralement 2 à 6 mois pour produire des résultats. Dans des <strong>secteurs compétitifs</strong>, un délai de 6 à 12 mois est souvent requis pour des améliorations significatives. Globalement, une <strong>stratégie SEO bien menée</strong> peut offrir des résultats visibles en 3 à 6 mois, mais cela dépend fortement de la concurrence, des efforts déployés et des mises à jour des algorithmes.
						</div>
					</div>
				</div>


				<!-- Quatrième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse59">
							<h4 class="panel-title">
								Quel est le rôle du méta titre et de la méta description dans le SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse59" class="panel-collapse collapse">
						<div class="panel-body">
							Le <strong>méta titre</strong> et la <strong>méta description</strong> jouent un rôle clé en SEO. Le méta titre, qui doit inclure des <strong>mots-clés pertinents</strong>, est un <strong>facteur de classement direct</strong> et sert à indiquer le sujet de la page tout en attirant les clics. La méta description, bien que <strong>non prise en compte directement pour le classement</strong>, influence fortement le <strong>taux de clics (CTR)</strong> en résumant brièvement le contenu de la page et en incitant les utilisateurs à cliquer. Ensemble, ils améliorent la <strong>visibilité</strong> et l’<strong>attractivité</strong> d’une page dans les résultats de recherche, contribuant ainsi à un <strong>meilleur positionnement indirectement</strong>.
						</div>
					</div>
				</div>


				<!-- Cinquiéme question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse60">
							<h4 class="panel-title">
								Qu'est-ce qui constitue une bonne vitesse de défilement des pages pour un site web ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse60" class="panel-collapse collapse">
						<div class="panel-body">
							Une <strong>bonne vitesse de page (PageSpeed)</strong> correspond à un <strong>score élevé</strong> dans les outils d’analyse comme <strong>Google PageSpeed Insights</strong>. Idéalement, un site devrait atteindre un score de <strong>80+ sur 100</strong>, aussi bien pour les versions desktop que mobile. Cela implique un <strong>temps de chargement rapide</strong>, ainsi que des <strong>critères de Core Web Vitals faibles</strong>. Ces indicateurs garantissent une <strong>expérience utilisateur fluide</strong> et contribuent au <strong>bon référencement</strong> du site.
						</div>
					</div>
				</div>
				<!-- Sixieme question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse61">
							<h4 class="panel-title">
								Qu’est-ce que le netlinking et pourquoi est-il important pour le SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse61" class="panel-collapse collapse">
						<div class="panel-body">
							Le <strong>netlinking</strong> est une stratégie SEO consistant à obtenir des <strong>liens entrants (backlinks)</strong> depuis d’autres sites web, renforçant ainsi l’<strong>autorité</strong> et la <strong>crédibilité</strong> de votre site auprès des moteurs de recherche. Les <strong>backlinks de qualité</strong>, provenant de sites <strong>fiables</strong> et <strong>pertinents</strong>, améliorent le <strong>positionnement dans les SERP</strong> et peuvent générer du <strong>trafic direct</strong>. Ils jouent un rôle clé dans la <strong>cohérence thématique</strong> et sont l’un des principaux <strong>facteurs de classement</strong>. Cependant, la <strong>qualité des liens</strong> est essentielle, car des <strong>pratiques douteuses</strong> ou des <strong>sites peu fiables</strong> peuvent nuire au SEO. <strong>L’agence Enjin</strong> vous accompagne dans la gestion de votre stratégie de netlinking en mettant en place des <strong>campagnes d’acquisition de backlinks</strong> adaptées à vos objectifs, pour garantir des <strong>résultats optimaux</strong> et durables.
						</div>
					</div>
				</div>
				<!-- Sixième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse62">
							<h4 class="panel-title">
								Peut-on modifier les URLs d’un site sans impact négatif sur le référencement ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse62" class="panel-collapse collapse">
						<div class="panel-body">
							Il est possible de modifier les <strong>URLs</strong> d’un site sans impact négatif sur le <strong>référencement</strong> en appliquant des <strong>redirections 301</strong>, en mettant à jour les <strong>liens internes</strong>, le <strong>sitemap</strong> et les <strong>backlinks</strong>, et en surveillant les performances. Ces actions permettent de transférer l’<strong>autorité SEO</strong> et de minimiser les fluctuations, bien que des variations temporaires puissent survenir le temps que <strong>Google réindexe</strong> les nouvelles URLs. Généralement, nous recommandons d’éviter d’effectuer des modifications dans les URLs (ou slug). Si nécessaire, nous vous conseillons de faire appel au <strong>service SEO</strong> de notre agence.
						</div>
					</div>
				</div>

				<!-- Septième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse63">
							<h4 class="panel-title">
								Qui doit effectuer les modifications sur un site (changement d’image, ajout de page, mise en ligne de contenu) : le service SEO ou le service WEB ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse63" class="panel-collapse collapse">
						<div class="panel-body">
							Il est généralement préférable de contacter le <strong>service WEB</strong> pour toute <strong>modification technique</strong> (changement d’image, ajout de pages, intégration de contenu). Cependant, si les modifications concernent le <strong>référencement</strong> ou doivent être <strong>optimisées pour le SEO</strong>, il est recommandé d'impliquer également le <strong>service SEO</strong> pour garantir que les ajustements respectent les <strong>bonnes pratiques</strong>. Une <strong>coordination entre les deux services</strong> peut être nécessaire selon la nature des modifications.
						</div>
					</div>
				</div>
				<!-- Huitième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse64">
							<h4 class="panel-title">
								Lors d’une modification sur un site, dans quelles situations faut-il informer le service SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse64" class="panel-collapse collapse">
						<div class="panel-body">
							Dans le cadre d’un contrat SEO, le <strong>service SEO</strong> doit être informé dès qu'une modification peut impacter le <strong>référencement</strong> ou la <strong>visibilité</strong> du site. Par exemple, lorsqu'un <strong>changement d’URL</strong> est prévu, il est crucial de mettre en place des <strong>redirections</strong> pour éviter les <strong>erreurs 404</strong> et préserver l’<strong>autorité des pages</strong>. De même, toute <strong>modification de contenu</strong>, qu'il s'agisse de <strong>textes</strong>, d'<strong>images</strong> ou de <strong>balises</strong>, peut influencer le <strong>positionnement</strong> sur certains <strong>mots-clés</strong> et nécessite une attention particulière. Lors de l’<strong>ajout ou de la suppression de pages</strong>, le service SEO garantit que les nouvelles pages sont <strong>optimisées</strong> et que les anciennes sont correctement <strong>redirigées</strong>. Les <strong>ajustements techniques</strong>, comme des modifications du fichier <strong>robots.txt</strong>, du <strong>sitemap XML</strong>, ou encore des changements touchant à la <strong>vitesse</strong> ou à la <strong>structure</strong> du site, nécessitent également leur intervention. Enfin, dans le cas d'une <strong>refonte</strong> ou d'une <strong>migration</strong> du site, leur implication est essentielle pour limiter les <strong>pertes de trafic</strong> et assurer une bonne <strong>réindexation</strong> des pages dans les moteurs de recherche. Si vous n’avez pas de contrat SEO en cours avec l’agence, nous vous invitons à contacter notre <strong>service commercial</strong> pour plus de renseignements.
						</div>
					</div>
				</div>

				<!-- Neuvième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse65">
							<h4 class="panel-title">
								Comment rédiger un article optimisé pour le SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse65" class="panel-collapse collapse">
						<div class="panel-body">
							Pour rédiger un article optimisé SEO, il est important de choisir des <strong>mots-clés pertinents</strong> et de structurer le contenu avec des <strong>titres</strong> et <strong>sous-titres clairs</strong>. Un texte doit être <strong>original</strong>, <strong>utile</strong> et intégrer naturellement les mots-clés. L’optimisation des <strong>balises</strong> (titre SEO, méta description, balises ALT) est cruciale, tout comme l’ajout de <strong>liens internes</strong> et <strong>externes</strong> pour améliorer la navigation et la pertinence. Compresser les <strong>images</strong> permet de garantir une vitesse de chargement rapide. Enrichir l’article avec des <strong>visuels</strong> et conclure par un <strong>appel à l’action</strong> renforce son impact. Enfin, sur WordPress, des outils comme <strong>Yoast SEO</strong> peuvent être utilisés pour vérifier l’optimisation et fournir des conseils utiles en rédaction SEO.
						</div>
					</div>
				</div>

				<!-- Dixième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse66">
							<h4 class="panel-title">
								Comment vérifier si mon contenu est bien optimisé pour le référencement ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse66" class="panel-collapse collapse">
						<div class="panel-body">
							Pour vérifier si un contenu est bien optimisé pour le SEO, plusieurs éléments clés doivent être examinés. L’intégration des <strong>mots-clés</strong>, présents dans le contenu, les titres et les balises meta, est essentielle tout en restant naturelle. Les <strong>balises title</strong> et <strong>meta description</strong> doivent être uniques, bien rédigées et inciter aux clics. Le contenu doit être <strong>pertinent</strong>, <strong>original</strong> et structuré pour répondre aux intentions des utilisateurs. Les <strong>images</strong> doivent être optimisées pour un chargement rapide, avec des noms de fichier descriptifs et des balises ALT adaptées. Les <strong>liens internes</strong> doivent guider les visiteurs vers des pages pertinentes du site. Pour aller plus loin, des outils comme <strong>Google Search Console</strong> ou <strong>Semrush</strong> permettent de vérifier l’indexation et de détecter des erreurs techniques et sémantiques. Un site bien optimisé combine <strong>contenu de qualité</strong>, <strong>performance technique</strong> et <strong>expérience utilisateur optimale</strong>. Si des doutes persistent, nous vous invitons à contacter le <strong>service SEO de l’agence Enjin</strong> ou à vous renseigner sur un <strong>contrat SEO</strong> auprès de notre service commercial.
						</div>
					</div>
				</div>

				<!-- Onzième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse67">
							<h4 class="panel-title">
								Sur WordPress, doit-on prêter attention aux vignettes de couleur SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse67" class="panel-collapse collapse">
						<div class="panel-body">
							Les <strong>vignettes de couleur SEO</strong> sur WordPress, proposées par des plugins comme <strong>Yoast SEO</strong>, sont des indicateurs utiles pour évaluer rapidement le niveau d’optimisation d’une page ou d’un article. Elles aident à vérifier si les <strong>éléments essentiels</strong> (mots-clés, balises, lisibilité) sont bien pris en compte. Cependant, elles ne doivent pas être considérées comme une <strong>garantie de bon classement</strong>, car les algorithmes des moteurs de recherche sont bien plus complexes que les critères évalués par ces outils. Bien qu’elles soient pratiques pour identifier et corriger les bases du SEO, ces vignettes ne remplacent pas une <strong>analyse stratégique approfondie</strong> et une réflexion globale sur le référencement.
						</div>
					</div>
				</div>

				<!-- Douzième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse68">
							<h4 class="panel-title">
								Pourquoi Google n’affiche-t-il pas le contenu de la méta description que j’ai renseigné dans ma page ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse68" class="panel-collapse collapse">
						<div class="panel-body">
							Google peut décider de ne pas afficher la <strong>méta description</strong> renseignée si elle ne correspond pas précisément à l’<strong>intention de recherche</strong> de l’utilisateur. Si la méta description est jugée trop <strong>générique</strong>, non <strong>pertinente</strong>, ou si elle ne reflète pas correctement le <strong>contenu</strong> de la page, Google peut générer un extrait plus adapté directement depuis le texte. De même, en l'absence d’une description <strong>unique</strong>, ou si elle est trop longue ou trop courte, Google peut choisir de la remplacer. Cela s'explique par sa volonté d’offrir aux utilisateurs des <strong>résultats pertinents</strong> et utiles. Pour augmenter les chances que la <strong>méta description</strong> soit affichée, elle doit être <strong>claire</strong>, <strong>unique</strong> et alignée avec les <strong>mots-clés</strong> et les <strong>besoins de recherche</strong>.
						</div>
					</div>
				</div>

				<!-- Treizième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse69">
							<h4 class="panel-title">
								Après avoir modifié les balises title et meta description, combien de temps faut-il attendre avant que les changements soient visibles dans Google ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse69" class="panel-collapse collapse">
						<div class="panel-body">
							Le délai pour que les modifications des <strong>balises title</strong> et <strong>meta description</strong> soient visibles dans les résultats de recherche Google varie généralement de quelques jours à plusieurs semaines. Cela dépend de la <strong>fréquence de crawl</strong> de Google, qui est plus élevée pour les pages <strong>actives</strong> ou <strong>populaires</strong>. Il est possible d’accélérer le processus en demandant une <strong>nouvelle indexation</strong> via <strong>Google Search Console</strong>. En règle générale, les changements apparaissent sous <strong>4 à 14 jours</strong>, bien que cela puisse varier en fonction de l’<strong>activité</strong> et de la <strong>taille du site</strong>.
						</div>
					</div>
				</div>

				<!-- Quatorzième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse70">
							<h4 class="panel-title">
								À quoi sert le fichier robots.txt pour un site web ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse70" class="panel-collapse collapse">
						<div class="panel-body">
							Le fichier <strong>robots.txt</strong> sert à guider les <strong>moteurs de recherche</strong> sur les parties d’un site qu’ils sont autorisés ou non à explorer. Il permet de contrôler l’accès des <strong>crawlers</strong> en définissant des règles spécifiques, comme l’exclusion de certaines <strong>pages</strong>, <strong>répertoires</strong> ou <strong>fichiers</strong> pour éviter leur indexation. Cependant, il ne garantit pas une <strong>confidentialité totale</strong>, car certains moteurs de recherche peuvent ignorer ces directives.
						</div>
					</div>
				</div>

				<!-- Quinzième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse71">
							<h4 class="panel-title">
								Quel est le rôle du fichier sitemap.xml dans le SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse71" class="panel-collapse collapse">
						<div class="panel-body">
							Le fichier <strong>sitemap.xml</strong> joue un rôle clé en SEO en fournissant aux moteurs de recherche une feuille de route détaillée des pages importantes d’un site web. Il facilite leur exploration en indiquant quelles pages doivent être crawlées, leur <strong>fréquence de mise à jour</strong>, et leur <strong>priorité relative</strong>. Cela est particulièrement utile pour les sites volumineux, complexes ou contenant des pages difficiles à atteindre via la navigation standard. Bien que ce fichier n'améliore pas directement le classement, il contribue à une <strong>meilleure indexation</strong>, augmentant ainsi les chances que les pages soient prises en compte dans les résultats de recherche.
						</div>
					</div>
				</div>

				<!-- Seizième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse72">
							<h4 class="panel-title">
								Comment obtenir un accès complet aux outils Google tels que Google Analytics 4 (GA4) et Google Search Console ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse72" class="panel-collapse collapse">
						<div class="panel-body">
							Pour obtenir un accès complet à <strong>Google Analytics 4 (GA4)</strong> et <strong>Google Search Console</strong>, vous devez être ajouté comme utilisateur avec les <strong>autorisations appropriées</strong> par le propriétaire ou l’administrateur des propriétés correspondantes.
							<br><br>
							Chez <strong>Enjin</strong>, nous créons pour tous nos clients des <strong>accès administrateurs dédiés</strong>, leur permettant d'utiliser ces outils en toute autonomie. Si vous ne parvenez pas à obtenir ces accès, nous vous invitons à contacter le <strong>service WEB ou SEO</strong> de notre agence afin de vous aider à effectuer les démarches nécessaires.
						</div>
					</div>
				</div>

				<!-- Dix-septième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse73">
							<h4 class="panel-title">
								Quels sont les leviers d’acquisition complémentaires au SEO ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse73" class="panel-collapse collapse">
						<div class="panel-body">
							En complément du <strong>SEO</strong>, plusieurs leviers d’acquisition permettent de renforcer la <strong>visibilité</strong> et d’attirer du <strong>trafic</strong>. Le <strong>SEA</strong>, par exemple, avec des campagnes publicitaires comme <strong>Google Ads</strong>, offre un <strong>trafic immédiat</strong> et ciblé grâce à des annonces payantes. Les <strong>réseaux sociaux</strong>, qu’il s’agisse de communication organique ou de publicités sponsorisées, permettent d’<strong>engager les audiences</strong> et d’élargir la portée. Le <strong>content marketing</strong>, en produisant des articles de blog, vidéos ou livres blancs, contribue à générer du <strong>trafic qualifié</strong> tout en renforçant l’<strong>autorité</strong> de la marque. L’<strong>emailing</strong> reste également un outil puissant pour fidéliser les audiences et stimuler les conversions. Par ailleurs, des stratégies comme l’<strong>affiliation</strong> sont essentielles pour toucher de nouveaux publics. En combinant ces différents leviers, une stratégie digitale devient plus <strong>complète</strong> et permet de <strong>maximiser les résultats</strong> obtenus. <strong>L’agence Enjin</strong> peut vous accompagner dans la mise en place et l’<strong>optimisation</strong> de ces leviers pour créer une stratégie digitale complète, adaptée à vos objectifs, et maximiser vos résultats.
						</div>
					</div>
				</div>

				<!-- Dix-huitième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse74">
							<h4 class="panel-title">
								Quels sont les différents formats publicitaires proposés par Google Ads ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse74" class="panel-collapse collapse">
						<div class="panel-body">
							<strong>Google Ads</strong> propose une variété de <strong>formats publicitaires</strong> adaptés aux objectifs et aux audiences des annonceurs. Parmi eux, on trouve les <strong>annonces textuelles</strong>, utilisées principalement dans les campagnes sur le <strong>Réseau de Recherche</strong>, qui apparaissent en haut ou en bas des résultats de recherche Google. Les <strong>annonces display</strong>, quant à elles, incluent des <strong>images ou des animations</strong> et sont diffusées sur le réseau de sites partenaires de Google, couvrant des <strong>millions d’emplacements</strong>. Les <strong>annonces vidéo</strong>, souvent intégrées à <strong>YouTube</strong>, permettent de capter l'attention avec des contenus courts ou longs diffusés avant, pendant ou après d'autres vidéos.
							<br><br>
							Pour les <strong>e-commerçants</strong>, les <strong>annonces shopping</strong> mettent en avant des <strong>produits</strong> avec leur image, prix, et description directement dans les résultats de recherche. Les <strong>campagnes Performance Max</strong> combinent plusieurs formats (texte, vidéo, shopping, display) pour maximiser les conversions grâce à une stratégie <strong>automatisée</strong>. Enfin, les <strong>annonces locales</strong> et pour <strong>applications</strong> sont des formats spécifiques, respectivement optimisés pour attirer du <strong>trafic en magasin</strong> par exemple. Chaque format est conçu pour répondre à des <strong>objectifs précis</strong>, qu’il s’agisse de notoriété, de trafic ou de conversions.
						</div>
					</div>
				</div>

				<!-- Dix-neuvième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse75">
							<h4 class="panel-title">
								Comment fonctionne Google Ads, et quelles sont les étapes d’une prestation SEA ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse75" class="panel-collapse collapse">
						<div class="panel-body">
							<strong>Google Ads</strong> fonctionne sur un système d’<strong>enchères</strong> où les annonceurs définissent un budget et enchérissent sur des <strong>mots-clés pertinents</strong> pour diffuser leurs annonces. Ces enchères, combinées à un <strong>score de qualité</strong> (basé sur la pertinence de l’annonce, la qualité de la page de destination et le taux de clic attendu), déterminent le classement des annonces dans les résultats de recherche ou sur le réseau publicitaire. Le plus souvent, les annonceurs paient uniquement lorsqu’un utilisateur <strong>clique</strong> sur leur annonce, selon le modèle du <strong>coût par clic (CPC)</strong>.
							<br><br>
							Chez <strong>Enjin</strong>, chaque prestation <strong>SEA</strong> suit des étapes clés pour assurer le succès de vos campagnes. Nous commençons par définir avec vous des <strong>objectifs précis</strong>, qu’il s’agisse d’augmenter votre trafic, vos ventes ou votre notoriété. Ensuite, nos experts réalisent une <strong>recherche approfondie des mots-clés</strong> pour cibler les requêtes les plus pertinentes pour votre audience. Nous configurons ensuite vos campagnes dans <strong>Google Ads</strong>, en concevant des <strong>annonces optimisées</strong> et en segmentant finement vos audiences. Une fois vos campagnes en ligne, notre équipe assure un <strong>suivi rigoureux</strong> des performances pour analyser les résultats, ajuster les enchères et optimiser les annonces et mots-clés. Enfin, nous vous fournissons un <strong>reporting clair et régulier</strong>, afin de mesurer l’impact de nos actions et d’affiner la stratégie en fonction des données collectées, garantissant ainsi une <strong>amélioration continue</strong> de vos résultats.
						</div>
					</div>
				</div>

				<!-- Vingtième question -->
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse80">
							<h4 class="panel-title">
								Comment définir un budget pour une campagne Google Ads ?
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse80" class="panel-collapse collapse">
						<div class="panel-body">
							Définir un <strong>budget</strong> pour une campagne <strong>Google Ads</strong> passe par l’identification des <strong>objectifs</strong>, qu’il s’agisse d’augmenter le trafic, de générer des conversions ou d’améliorer la notoriété. Il est important d’évaluer le <strong>montant à investir par conversion</strong> et d’analyser le <strong>coût par clic (CPC)</strong> des mots-clés choisis, en tenant compte de leur niveau de compétitivité. Le budget doit ensuite être <strong>réparti</strong> sur la durée de la campagne, avec un montant initial permettant d’<strong>ajuster les dépenses</strong> en fonction des performances. L’<strong>équilibre</strong> entre les objectifs, les moyens disponibles et les <strong>coûts des mots-clés</strong> est essentiel pour maximiser l’efficacité de la campagne.
						</div>
					</div>
				</div>
			</div>




			<!-- Questions Section pour la question Faq -->

			<div id="questions-faq" class="panel-group" style="display: none;">
				<h1 id="category-name" class="category-name"></h1>
				<button class="backButton retour" style="display: none;">Retour aux catégories</button>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse7">
							<h4 class="panel-title">
								FAQ
								<i class="bi bi-caret-down float-end toggle-icon"></i>
							</h4>
						</a>
					</div>
					<div id="collapse7" class="panel-collapse collapse">
						<div class="panel-body">
							<h4>Comment Suivre Mon Ticket de Support ?</h4>
							<ul>
								<li>1. Vérifiez votre e-mail pour les mises à jour de votre ticket.</li>
								<li>2. Connectez-vous à votre compte sur notre site.</li>
								<li>3. Allez dans la section "Mes tickets" pour voir l'état.</li>
							</ul>
						</div>
						<div class="panel-body">
							<h4>Qu'est-ce qu'un Ticket du Support ?</h4>
							<ul>
								<li>1. Un ticket de support est une demande d'assistance pour un problème que vous rencontrez avec votre site.</li>
								<li>2. Pour créer un ticket, dirigez-vous vers la barre de navigation et cliquez sur Mes tickets.</li>
							</ul>
						</div>
						<div class="panel-body">
							<h4>Quels Sont les Délais de Réponse ?</h4>
							<ul>
								<li>1. Nous nous efforçons de répondre à tous les tickets dans un délai de 24 à 48 heures.</li>
								<li>2. Pour les problèmes urgents, n'hésitez pas à le mentionner dans votre ticket.</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

		</div>



</div>


@endsection



@section('javascript')
    @parent
@endsection




