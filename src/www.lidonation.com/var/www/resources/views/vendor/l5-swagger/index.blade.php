<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.documentations.'.$documentation.'.api.title')}}</title>

    @include('includes.site-icons')

    <link rel="manifest" href="/site.webmanifest">

    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
    @livewireStyles
    @bukStyles(true)

    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>

    <!-- Cloudflare Web Analytics -->
    <script defer src='//static.cloudflareinsights.com/beacon.min.js'
            data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>
    <!-- End Cloudflare Web Analytics -->

    <!-- Fathom - beautiful, simple website analytics  -->
    <script src="https://essential-jazzy.lidonation.com/script.js" data-site="{{config('services.fathom.site')}}" defer></script>
    <!-- / Fathom -->
</head>

<body class="catalyst-api-spec">
    @include('includes.global-search-handler')

    @include('includes.header')

    @livewire('catalyst.catalyst-sub-menu-component')

    <main>
        <section class="container my-16">
            <div class="bg-white shadow-sm pb-8 pt-4" id="swagger-ui"></div>
        </section>
    </main>

    @include('includes.footer')

    <x-lido-menu />

    <script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
    <script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
    <script>
        window.onload = function () {
            // Build a system
            const ui = SwaggerUIBundle({
                dom_id: '#swagger-ui',
                url: "{!! $urlToDocs !!}",
                operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
                configUrl: {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
                validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
                oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",

                requestInterceptor: function (request) {
                    request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                    return request;
                },

                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],

                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],

                layout: "StandaloneLayout",
                docExpansion: "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
                deepLinking: true,
                filter: {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
                persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",

            })

            window.ui = ui

            @if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type')))
            ui.initOAuth({
                usePkceWithAuthorizationCodeGrant: "{!! (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant') !!}"
            })
            @endif
        }
    </script>

</body>
</html>
