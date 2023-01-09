  @env('production')
  <!-- Cloudflare Web Analytics -->
  <script defer src='//static.cloudflareinsights.com/beacon.min.js'
          data-cf-beacon='{"token": "{{config('services.cloudflare.token')}}"}'></script>
  <!-- End Cloudflare Web Analytics -->

  <!-- Fathom - beautiful, simple website analytics  -->
  <script src="https://essential-jazzy.lidonation.com/script.js" data-site="{{config('services.fathom.site')}}" defer></script>

  <!-- / Fathom -->
      <!-- Global site tag (gtag.js) - Google Analytics -->
    {{--    <script async src="//www.googletagmanager.com/gtag/js?id=G-GT4QM779D7"></script>--}}
    {{--    <script>--}}
    {{--        window.dataLayer = window.dataLayer || [];--}}

    {{--        function gtag() {--}}
    {{--            dataLayer.push(arguments);--}}
    {{--        }--}}

    {{--        gtag('js', new Date());--}}

    {{--        gtag('config', "{{config('services.analytics.id')}}");--}}
    {{--    </script>--}}
@endenv
