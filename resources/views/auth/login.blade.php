<!DOCTYPE html>
    <html lang="en">
      <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>Login | SI Monitoring Sumber Dana</title>
        <!-- Vendors styles-->
        <link rel="stylesheet" href="{{ asset('coreui/vendor/simplebar.css') }}">
        <!-- Main styles for this application-->
        <link href="{{ asset('coreui/css/coreui.css') }}" rel="stylesheet">

        <link href="{{ asset('coreui/fontawesome/css/fontawesome.css') }}" rel="stylesheet">
        <link href="{{ asset('coreui/fontawesome/css/brands.css') }}" rel="stylesheet">
        <link href="{{ asset('coreui/fontawesome/css/solid.css') }}" rel="stylesheet">
      </head>
      <body>
        <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-8">
                <div class="card-group d-block d-md-flex row">
                  <div class="card col-md-7 p-4 mb-0">
                    <div class="card-body">
                      <h1>Login</h1>
                      <p class="text-body-secondary">Sign In to your account</p>
                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                          <span class="input-group-text">
                            <i class="fa-solid fa-user"></i> 
                          </span>
                          <input class="form-control" type="text" name="email" id="email" required placeholder="Username">
                        </div>
                        <div class="input-group mb-4">
                          <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                          </span>
                          <input class="form-control" type="password" name="password" id="password" required placeholder="Password">
                        </div>
                        <div class="row">
                          <div class="col-6">
                            <button class="btn btn-primary px-4" type="submit">Login</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="card col-md-5 text-white bg-primary py-5">
                    <div class="card-body text-center">
                      <div>
                        <h2>SI Monitoring Sumber Dana</h2>
                        <p>Monitoring Realisasi Belanja Perangkat Daerah yang bersumber pada APBD Kab. Bojonegoro</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- CoreUI and necessary plugins-->
        <script src="{{ asset('coreui/js/coreui.bundle.js') }}"></script>
        <script src="{{ asset('coreui/vendor/simplebar.min.js') }}"></script>
        <script>
          const header = document.querySelector('header.header');
    
          document.addEventListener('scroll', () => {
            if (header) {
              header.classList.toggle('shadow-sm', document.documentElement.scrollTop > 0);
            }
          });
        </script>
        <script>
        </script>
    
      </body>
    </html>