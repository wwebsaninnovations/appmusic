@extends('admin.layouts.app')
@section('content')
 <!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> -->

          <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-4">Page 1</h4>
              <p>
                Sample page.<br />For more layout options use
                <a href="https://themeselection.com/tools/generator/sneat/html" target="_blank" class="fw-bold"
                  >HTML starter template generator</a
                >
                and refer
                <a
                  href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation//layouts.html"
                  target="_blank"
                  class="fw-bold"
                  >Layout docs</a
                >.
              </p>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <!-- <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , made with ❤️ by
                  <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                </div>
                <div>
                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >
                </div>
              </div>
            </footer> -->
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
        </div>
        <!-- / Layout page -->
      </div>
@endsection
