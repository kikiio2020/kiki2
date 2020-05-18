<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kikiio.com') }}</title>

	<link rel="shortcut icon" type="image/png" href="/images/favicon.png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    
    body a:hover {
        color: #999999;
    }
    
    .content {
        flex: 1 0 auto;
        background-image: linear-gradient(#0c00ff, #5d58cc);
        color: #fff;
    }
    
    .menu {
        background-color: #0900cc;
        color: #fff;
    }
    
    .menu a {
        color: #fff;
    }
    
    .body-content {
        min-height: 70%;  /* Fallback for browsers do NOT support vh unit */
        min-height: 70vh;
        width: 100%;
        width: 100vh;
        display: flex;
        align-items: center;
    }
    
    .footer {
        /*background-color: #9893ff;*/
        background-color: #5d58cc;
        font-size: small;
        color: #fff;
    }
    .footer a {
        color: #bbbbbb;
    }
    .footer a:hover {
        text-decoration: underline;
    }
    </style>
    
    @yield('pageHeadInclude')
    
</head>
<body>
    <div id="app" class="content" v-on:keyup.esc="menuOpened=false">

	<b-container fluid class="menu">
	<b-row>
		<b-col class="p-2 align-items-center d-none d-md-flex">
			<div>
			<router-link to="/"><b-img src="images/nameLogoOsaka.png"></b-img></router-link>
			<span class="ml-3 small font-italic align-bottom">technology with heart</span>
			</div>
		</b-col>
		<b-col class="text-center">

			<!-- Mobile view -->
			<div style="font-size: 1rem;" class="m-2 d-md-none">
				<a 
					href="#" 
					class="border border-primary rounded p-1"
					v-b-toggle.dropdownmenu
				>
					<b-icon-x v-if="menuOpened"></b-icon-x>
					<b-icon-list v-else></b-icon-list>
				</a>
			</div>
            <b-collapse id="dropdownmenu" v-model="menuOpened" class="mt-2">
                <b-card no-body>
                	<mobile-dropdown-menu :menu-items="menuItems" :external-menu-items="externalMenuItems"></mobile-dropdown-menu>
                </b-card>
          	</b-collapse>
			
			<!-- Desktop view -->
			<top-nav :menu-items="menuItems" :external-menu-items="externalMenuItems"></top-nav>
		</b-col>
	</b-row>
	</b-container>

	<div class="text-center m-1 p-1 w-auto">
		<router-link to="/"><b-img src="images/logoIcon.png"></b-img></router-link>
	</div>
	
    <main class="body-content text-center w-auto">
        @yield('content')
    </main>
    
    </div>
    
    <footer class="footer">
    	<div class="b-container mt-2 mb-2">
    		<div class="row">
        		<div class="col text-center">&#169; copyright <a href="https://www.kikiio.com">Kikiio.com</a> {{ now()->year }}</div>
    		</div>
    	</div>
    </footer>
</body>
</html>
