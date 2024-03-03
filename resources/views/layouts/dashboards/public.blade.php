  <!doctype html>
  <html lang="en">
    @include('layouts.dashboards.public_head')
    <body>
      @include('layouts.dashboards.nav') 
      <div class="container-fluite">
        <div class="row">
          @include('layouts.public_welcome')
        </div>
      </div>
    </body>

    <!--  country codes scripts -->
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: 'af',
            placeholderNumberType: 'FIXED_LINE',
            separateDialCode: true,
        });
    </script>
    <!--  country codes scripts -->
    <script src="{{ asset('public_assets/jquery/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('public_assets/assets/js/jquery-ui-1.10.4.custom.min.js') }}"></script>
    <script src="{{ asset('public_assets/bootstrap3/js/bootstrap.js') }}"></script>
    <script src="{{ asset('public_assets/assets/js/gsdk-checkbox.js') }}"></script>
    <script src="{{ asset('public_assets/assets/js/gsdk-radio.js') }}"></script>
    <script src="{{ asset('public_assets/assets/js/gsdk-bootstrapswitch.js') }}"></script>
    <script src="{{ asset('public_assets/assets/js/get-shit-done.js') }}"></script>
  </html>