<!DOCTYPE html>

<html lang="en" class="dark-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../admin-theme/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{env('APP_NAME')}} | Iniciar sesion</title>

    <meta name="description" content="Gestion de activos" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../admin-theme/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../admin-theme/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../admin-theme/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="../admin-theme/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../admin-theme/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../admin-theme/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../admin-theme/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../admin-theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../admin-theme/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="../admin-theme/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../admin-theme/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../admin-theme/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../admin-theme/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../admin-theme/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../admin-theme/js/config.js"></script>
</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="index.html" class="app-brand-link gap-0">
                                <span class="app-brand-logo demo">
                                    <img src="{{asset('admin-theme/img/favicon/favicon.ico')}}" alt="" width="35" srcset="">
                                </span>
                                <span class="text-body fw-bold ms-0 fs-4">{{env('APP_NAME')}}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        {{-- <h4 class="mb-1 pt-2">Bienvenido a {{env('APP_NAME')}}! 👋</h4> --}}
                        <p class="mb-4">Por favor inicia sesi&oacute;n con tus credenciales</p>

                        <form id="formAuthentication" class="mb-3" action="{{route('authenticate')}}" method="POST">
                          @csrf
                          @method('post')
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Ingresa tu correo" autofocus />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Contrase&ntilde;a</label>
                                    <a href="auth-forgot-password-basic.html">
                                        <small>Olvidaste tu contrase&ntilde;a?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember-me" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Recu&eacute;rdame </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Iniciar
                                    sesi&oacute;n</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../admin-theme/vendor/libs/jquery/jquery.js"></script>
    <script src="../admin-theme/vendor/libs/popper/popper.js"></script>
    <script src="../admin-theme/vendor/js/bootstrap.js"></script>
    <script src="../admin-theme/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../admin-theme/vendor/libs/node-waves/node-waves.js"></script>

    <script src="../admin-theme/vendor/libs/hammer/hammer.js"></script>
    <script src="../admin-theme/vendor/libs/i18n/i18n.js"></script>
    <script src="../admin-theme/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../admin-theme/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../admin-theme/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../admin-theme/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../admin-theme/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="../admin-theme/js/main.js"></script>

    <!-- Page JS -->
    <script src="../admin-theme/js/pages-auth.js"></script>
</body>

</html>
