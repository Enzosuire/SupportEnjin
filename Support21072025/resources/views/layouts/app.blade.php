<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if (Helper::isLocaleRtl()) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@if ($__env->yieldContent('title_full'))@yield('title_full') @elseif ($__env->yieldContent('title'))@yield('title') - {{ config('app.name', 'Support Enjin') }} @else{{ config('app.name', 'Support Enjin') }}@endif</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="@filter('layout.favicon', URL::asset('favicon.ico'))"> -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/cropped-favicon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" crossorigin="use-credentials">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <!-- <link rel="stylesheet" href="css/refonte.css">  -->
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="@filter('layout.theme_color', '#ffffff')">
    @action('layout.head')
    {{-- Styles --}}
    {{-- Conversation page must open immediately, so we are loading scripts present on conversation page --}}
    {{-- style.css must be the last to able to redefine styles --}}
    @php
        try {
            $styles= array('/css/fonts.css','/css/bootstrap.css', '/css/select2/select2.min.css', '/js/featherlight/featherlight.min.css', '/js/featherlight/featherlight.gallery.min.css', '/css/magic-check.css' , '/css/style.css', '/css/refonte.css'); 
            if (Helper::isLocaleRtl()) {
                $styles[] = '/css/bootstrap-rtl.css';
                $styles[] = '/css/style-rtl.css';
            }
    @endphp
    {!! Minify::stylesheet(\Eventy::filter('stylesheets', $styles)) !!}
    @php
        } catch (\Exception $e) {
            // Try...catch is needed to catch errors when activating a module and public symlink not created for module.
            \Helper::logException($e);
        }
    @endphp
 
    @yield('stylesheets')
    
</head>
<body class="locale-{{ app()->getLocale() }} @if (Helper::isLocaleRtl()) rtl @endif @if (!Auth::user()) user-is-guest @endif @if (Auth::user() && Auth::user()->isAdmin()) user-is-admin @endif @yield('body_class') @action('body.class')" @yield('body_attrs') @if (Auth::user()) data-auth_user_id="{{ Auth::user()->id }}" @endif>
<div id="app">

        @if (Auth::user() && empty(app('request')->x_embed) && empty($__env->yieldContent('guest_mode')))

            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                    
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @guest
                                &nbsp;
                            @else
                                <li class="dropdown web-notifications">
                                    @auth
                                        @php
                                            $web_notifications_info = Auth::user()->getWebsiteNotificationsInfo();
                                        @endphp
                                    @endauth


                                    {{------------------ NOTIFICATION -----------------------}}

                                </li>


                                <li class="dropdown text-center">

                                
                                    <a  href="{{ route('dashboard') }} ">
                                        <div class="profil-picture text-center">
                                            <span class="photo-sm">@include('partials/person_photo', ['person' => Auth::user()])</span>
                                            <span class="nom-utilisateur">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}@action('menu.user.name_append', Auth::user())</span>                      
                                            <hr class="hr-nav">
                                        </div>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('users.profile', ['id'=>Auth::user()->id]) }}">{{ __('Your Profile') }}</a></li>
                                        @action('menu_right.user.after_profile')
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                {{ __('Log Out') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                        <li class="divider hidden in-app-switcher"></li>
                                        <li>
                                            <a href="javascript:switchHelpdeskUrl();void(0);" class="hidden in-app-switcher">{{ __('Switch Helpdesk URL') }}</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown">


                                    {{--------------------- SEARCHBAR ----------------------------}}

                                </li>
                            @endguest
                        </ul>
                        

                        <form class="form-inline form-nav-search-mobile" role="form" action="{{ route('conversations.search') }}" target="_blank" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control searchbar" name="q" placeholder="Rechercher...">
                                {{-- <div class="input-group-append">
                                    <button class="btn btn-default" type="submit">{{ __('Search') }}</button>
                                </div> --}}
                            </div>
                        </form>
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            @php
                                $mailboxes = Auth::user()->mailboxesCanView(true);
                                $mailboxes = \Eventy::filter('menu.mailboxes', $mailboxes);
                            @endphp
                            
                            @if (Auth::user()->isAdmin()
                                || Auth::user()->hasPermission(App\User::PERM_EDIT_USERS)
                                || Auth::user()->can('viewMailboxMenu', Auth::user())
                                || Eventy::filter('menu.manage.can_view', false)
                                )
                                <ul>
                                    <li class="dropdown {{ \App\Misc\Helper::menuSelectedHtml('manage') }}"><ion-icon name="list-circle-outline" class="icon-nav"></ion-icon>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                            {{ __('Manage') }} <span class="caret"></span>
                                        </a> 

                                        <ul class="dropdown-menu">
                                            @if (Auth::user()->isAdmin())
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('settings') }}"><a href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
                                    
                                            @endif
                                            @if (Auth::user()->can('viewMailboxMenu', Auth::user()))
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('mailboxes') }}"><a href="{{ route('mailboxes') }}">{{ __('Mailboxes') }}</a></li>                                    
                                            @endif
                                        
                                            @action('menu.manage.after_mailboxes')
                                            @if (Auth::user()->isAdmin() || Auth::user()->hasPermission(App\User::PERM_EDIT_USERS))
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('users') }}"><a href="{{ route('users') }}">{{ __('Users') }}</a></li>
                                            @endif
                                            @if (Auth::user()->isAdmin())
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('modules') }}"><a href="{{ route('modules') }}">{{ __('Modules') }}</a></li>
                                                <li class=""><a href="{{ asset('translations') }}">{{ __('Translate') }}</a></li>
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('logs') }}"><a href="{{ route('logs') }}">{{ __('Logs') }}</a></li>
                                                <li class="{{ \App\Misc\Helper::menuSelectedHtml('system') }}"><a href="{{ route('system') }}">{{ __('System') }}</a></li>
                                            @endif
                                            @action('menu.manage.append')
                                        </ul>

                                    </li>
                                </ul>  

                                <!-- Menu Navigation -->
                                <ul>
                                       <!-- Tableau de bord -->
                                        <li class="{{ \App\Misc\Helper::menuSelectedHtml('dashboard') }}"><ion-icon name="clipboard-outline" class="icon-nav"></ion-icon><a href="{{ route('dashboard', ['id' => Auth::id()]) }}"> {{ __('Dashboard') }}</a></li> 
                                         <!-- Mailbox Section -->
                                        @if (count($mailboxes) == 1)
                                            <li class="{{ \App\Misc\Helper::menuSelectedHtml('mailbox') }}"><ion-icon name="mail-outline" class="icon-nav"></ion-icon><a href="{{ \Eventy::filter('mailbox.url', route('mailboxes.view', ['id'=>$mailboxes[0]->id]), $mailboxes[0]) }}">@action('menu.mailbox_single.before_name', $mailboxes[0]){{ __('Mailbox') }}@action('menu.mailbox_single.after_name', $mailboxes[0])</a></li>
                                        @elseif (count($mailboxes) > 1)
                                            <li class="dropdown {{ \App\Misc\Helper::menuSelectedHtml('mailbox') }}">
                                                <ion-icon name="mail-outline" class="icon-nav"></ion-icon>
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                                    {{ __('Mailbox') }} <span class="caret"></span>
                                                </a>
                                                <ul class="dropdown-menu dm-scrollable">
                                                    @foreach ($mailboxes as $mailbox_item)
                                                        <li @if ($mailbox_item->id == app('request')->id)class="active"@endif><a href="{{ \Eventy::filter('mailbox.url', route('mailboxes.view', ['id' => $mailbox_item->id]), $mailbox_item) }}">@action('menu.mailbox.before_name', $mailbox_item){{ $mailbox_item->name }}@action('menu.mailbox.after_name', $mailbox_item)</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endif
                                    <!-- Clients -->
                                    <li class="{{ \App\Misc\Helper::menuSelectedHtml('customer') }}"><ion-icon name="people-outline" class="icon-nav"></ion-icon><a href="{{ route('customers.Customerall') }}"> {{ __('Clients') }}</a></li>   

                                    <!-- Projet -->
                                    <li class="{{ \App\Misc\Helper::menuSelectedHtml('projet') }}"><ion-icon name="folder-open-outline" class="icon-nav"></ion-icon><a href="{{ route('projet.show')}}" class="a-link-menu"> {{ __('Projet') }}</a></li> 
                                    
                                    {{-- <li class="{{ \App\Misc\Helper::menuSelectedHtml('projet.createpro') }}"><a href="{{ route('projet.createpro') }}">{{ __('Création Projet') }}</a></li>  --}}

                                     <!-- Facturation -->
                                     <li class="{{ \App\Misc\Helper::menuSelectedHtml('facturations') }}"><ion-icon name="wallet-outline" class="icon-nav"></ion-icon><a href="{{ route('facturations.show') }}">{{ __('Facturation') }}</a></li>                               
                                    {{-- <li class="{{ \App\Misc\Helper::menuSelectedHtml('Facturations.createFa') }}"><a href="{{ route('Facturations.createFa') }}">{{ __('Création Facturation') }}</a></li>  --}}
                                   
                                    <!-- Intervention -->
                                    <li class="{{ \App\Misc\Helper::menuSelectedHtml('intervention') }}"><ion-icon name="construct-outline" class="icon-nav"></ion-icon><a href="{{ route('intervention.show') }}"> {{ __('Intervention') }}</a></li>                                     
                                    {{-- <li class="{{ \App\Misc\Helper::menuSelectedHtml('interventions.create') }}"><a href="{{ route('interventions.create') }}">{{ __('Création Intervention') }}</a></li>  --}}
                                   
                                     <!-- Utilisateurs -->
                                    <li class="{{ \App\Misc\Helper::menuSelectedHtml('users') }}"><ion-icon name="person-outline" class="icon-nav"></ion-icon><a href="{{ route('users') }}">{{ __('Users') }}</a></li>
                                    <!-- Paramètres -->
                                    <li class="{{ \App\Misc\Helper::menuSelectedHtml('settings') }}"><ion-icon name="settings-outline" class="icon-nav"></ion-icon><a href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
                                    
                                </ul>
                                <hr>
                            @endif
                            @action('menu.append')
                        </ul>
                    </div>
                </div>
            </nav>
        @endif

        @auth
            <div class="header">

                {{------------------------- PARTIE GAUCHE DU HEADER -------------------------}}
        
                <h1 class="heading">{{ App\Option::getCompanyName() }} {{ __('- ') }} @yield('title')</h1>

        
                {{------------------------- PARTIE DROITE DU HEADER -------------------------}}
                <div class="left-part-header">
                    <form class="form-inline form-nav-search" role="form" action="{{ route('conversations.search') }}" target="_blank" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control searchbar" name="q" placeholder="">
                            <div class="input-group-append">
                                <button class="btn btn-default" type="submit">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>

                    
                    <div class="burger-button" id="burgerButton">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </div>
                    
                    @php
                        $web_notifications_info = Auth::user()->getWebsiteNotificationsInfo();
                    @endphp

                    <div class="dropdown-notif">
                            <a href="#" class="dropdown-toggle dropdown-toggle-icon @if ($web_notifications_info['unread_count']) has-unread @endif icon-notifs" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre title="{{ __('Notifications') }}">
                                <ion-icon name="notifications-outline"></ion-icon>
                            </a>
                        

                        <ul class="dropdown-menu-notif">
                            <li>
                                <div class="web-notifications-header">
                                    <h1>
                                        {{ __('Notifications') }}
                                        <small class="web-notifications-count  @if (!(int)$web_notifications_info['unread_count']) hidden @endif" title="{{ __('Unread Notifications') }}" data-toggle="tooltip">@if ($web_notifications_info['unread_count']){{ $web_notifications_info['unread_count'] }}@endif</small>
                                    </h1>
                                    <a href="#" class="web-notifications-mark-read @if (!(int)$web_notifications_info['unread_count']) hidden @endif" data-loading-text="{{ __('Processing') }}…">
                                        {{ __('Mark all as read') }}
                                    </a>
                                </div>
                                <ul class="web-notifications-list">
                                    @if (count($web_notifications_info['data']))
                                        @if (!empty($web_notifications_info['html']))
                                            {!! $web_notifications_info['html'] !!}
                                        @else
                                            @include('users/partials/web_notifications', ['web_notifications_info_data' => $web_notifications_info['data']])
                                        @endif

                                        @if ($web_notifications_info['notifications']->hasMorePages())
                                            <li class="web-notification-more">
                                                <button class="btn btn-link btn-block link-dark" data-loading-text="{{ __('Loading') }}…">
                                                    {{ __('Load more') }}
                                                </button>
                                            </li>
                                        @endif
                                    @else
                                        <div class="text-center margin-top-40 margin-bottom-40">
                                            <i class="glyphicon glyphicon-bullhorn icon-large"></i>
                                            <p class="block-help text-large">
                                                {{ __('Notifications will start showing up here soon') }}
                                            </p>
                                            <a href="{{ route('users.notifications', ['id' => Auth::user()->id]) }}">{{ __('Update your notification settings') }}</a>
                                        </div>
                                    @endif
                                </ul>
                            </li>

                        </ul>
                    </div>
                
                   
                    <div class="dropdown dropdown-account">
                        <a href="#" class="dropdown-toggle  dropdown-toggle-account" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre title="{{ __('Account') }}" aria-label="{{ __('Account') }}">
                            <ion-icon name="person-circle-outline"></ion-icon>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{ route('users.profile', ['id'=>Auth::user()->id]) }}">{{ __('Your Profile') }}</a></li>
                            @action('menu_right.user.after_profile')
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Log Out') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                            <li class="divider hidden in-app-switcher"></li>
                            <li>
                                <a href="javascript:switchHelpdeskUrl();void(0);" class="hidden in-app-switcher">{{ __('Switch Helpdesk URL') }}</a>
                            </li>
                        </ul>
                    </div>
                
                </div>
            
            </div>
        @endauth

        {{-- @if ($__env->yieldContent('sidebar'))
            <div class="layout-2col">
                    <div class="sidebar-2col">
                        @yield('sidebar')
                    </div>
                    <div class="content-2col">
                        @yield('content')
                    </div>

            </div>
        @else
            <div class="content @yield('content_class')">
                @yield('content')
            </div>
        @endif --}}

                {{-- @if ($__env->yieldContent('sidebar'))
            <div class="layout-2col">
                <div class="sidebar-2col">
                    @yield('sidebar')
                </div>
                <div class="content-2col">
                    @yield('content')
                </div>
            </div>
        @else
            <div class="sidebar-top">
                @yield('sidebar')
            </div>
            <div class="content @yield('content_class')">
                @yield('content')
            </div>
        @endif --}}

        @if ($__env->yieldContent('sidebar'))
            @if($__env->yieldContent('use_flex_layout'))
                <div class="layout-2col flex-enabled">
            @else
                <div class="layout-2col flex-enabled">
            @endif
                <!-- <div class="sidebar-top"> -->
                <div class="sidebar-2col">
                    @yield('sidebar')
                </div>
                <div class="content-2col">
                    @yield('content')
                </div>
            </div>
        @else
            <div class="sidebar-top">
                @yield('sidebar')
            </div>
            <div class="content @yield('content_class')">
                @yield('content')
            </div>
        @endif

        @if (!in_array(Route::currentRouteName(), array('mailboxes.view'))
            && empty(app('request')->x_embed) && empty($__env->yieldContent('no_footer')))
            <div class="footer">
                @if (!\Eventy::filter('footer.text', ''))
                    &copy; 2018-{{ date('Y') }} <a href="{{ config('app.freescout_url') }}" target="blank">{{ \Config::get('app.name') }}</a> — {{ __('Free open source help desk & shared mailbox') }}
                @else
                    {!! \Eventy::filter('footer.text', '') !!}
                @endif
                @if (!Auth::user())
                    <a href="javascript:switchHelpdeskUrl();void(0);" class="hidden in-app-switcher"><br/>{{ __('Switch Helpdesk URL') }}</a>
                @endif
                {{-- Show version to admin only --}}
                @if (Auth::user() && Auth::user()->isAdmin())
                    <br/>
                    <a href="{{ route('system') }}">{{ config('app.version') }}</a>
                @endif
            </div>
        @endif
    </div>

    <div id="loader-main"></div>

    @include('partials/floating_flash_messages')

    @yield('body_bottom')
    @action('layout.body_bottom')

    {{-- Scripts --}}
    @php
        try {
    @endphp
    {!! Minify::javascript(\Eventy::filter('javascripts', array('/js/jquery.js', '/js/bootstrap.js', '/js/lang.js', '/storage/js/vars.js', '/js/laroute.js', '/js/parsley/parsley.min.js', '/js/parsley/i18n/'.strtolower(Config::get('app.locale')).'.js', '/js/select2/select2.full.min.js', '/js/polycast/polycast.js', '/js/push/push.min.js', '/js/featherlight/featherlight.min.js', '/js/featherlight/featherlight.gallery.min.js', '/js/taphold.js', '/js/jquery.titlealert.js', '/js/main.js','/js/Filtres_clients_projet.js','/js/Filtres_projet_typeinterventions.js'))) !!}
    @php
        } catch (\Exception $e) {
            // To prevent 500 errors on update.
            // Also catches errors when activating a module and public symlink not created for module.
            if (strstr($e->getMessage(), 'vars.js')) {
                \Artisan::call('freescout:generate-vars');
            }
            \Helper::logException($e);
        }
    @endphp
    @yield('javascripts')
    
    <script type="text/javascript">
        var fs_in_app_data = fs_in_app_data || {};
    
        @if (\Helper::isInApp())
            @if (Auth::check())
                fs_in_app_data['token'] = '{{ Auth::user()->getAuthToken() }}';
            @else
                fs_in_app_data['token'] = '';
            @endif
        @endif
    
        @yield('javascript')
        @action('javascript', $__env->yieldContent('javascripts'))
    
        document.addEventListener("DOMContentLoaded", function() {
            console.log("DOM fully loaded and parsed");
    
            const buttonBurger = document.querySelector(".burger-button");
            const navbar = document.querySelector(".navbar");
    
            if (buttonBurger && navbar) {
                console.log("Burger button and navbar found");
    
                buttonBurger.addEventListener("click", () => {
                    console.log("Burger button clicked");
                    buttonBurger.classList.toggle("active");
                    navbar.classList.toggle("active");
                    console.log("Classes toggled: ", buttonBurger.classList, navbar.classList);
                });
    
                document.querySelectorAll(".navbar .navbar-nav ul li").forEach(n => {
                    n.addEventListener("click", () => {
                        console.log("Navbar item clicked");
                        buttonBurger.classList.remove("active");
                        navbar.classList.remove("active");
                    });
                });
            } else {
                if (!buttonBurger) {
                    console.error("Burger button not found");
                }
                if (!navbar) {
                    console.error("Navbar not found");
                }
            }
        });
    </script>
    

</body>
</html>
