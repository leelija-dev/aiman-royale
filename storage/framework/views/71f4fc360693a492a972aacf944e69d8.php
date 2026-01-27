<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/logo/favicon.png" type="image/png">
    <title> Leelija - Sign In Page</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />


    <link href="<?php echo e(asset('Admin/css/soft-ui-dashboard.css')); ?>" rel="stylesheet">

    
    

    


    <style>
        .custm-confirm {
            color: #a6a6a6;
            transition: all 0.3s ease;
            margin: 0 !important;
            font-size: 16px !important;
            z-index: 99;
        }
    </style>
</head>

<body class="">
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container ">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain my-3 pb-3"
                                style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">
                                <div class="card-header pb-0 text-left bg-transparent ">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>

                                    <?php $__errorArgs = ['error'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger">
                                            <small><strong>Failed!</strong> <?php echo e($message); ?></small>
                                        </div>
                                    <?php else: ?>
                                        <p class="mb-0">Enter your email and password to sign in</p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                </div>
                                <div class=" ms-3 me-3">
                                    <form class="needs-validation" action="<?php echo e(route('Admin.login')); ?>" method="POST"
                                        novalidate>
                                        <?php echo csrf_field(); ?>

                                        <div class="mb-2">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="email" class="form-control" id="username"
                                                placeholder="Username" aria-label="Username"
                                                aria-describedby="username-addon" name="email" required>
                                            <div class="invalid-feedback">
                                                Enter valid email
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div>
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <?php echo e($message); ?>

                                                </span>
                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                        <div class="form-group mb-2">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" placeholder="Password"
                                                    aria-label="Password" id="cpass"
                                                    aria-describedby="password-addon" name="password" required>

                                                <button class="btn custom-toggle-icon" type="button" id="toggler"> <i
                                                        class="fa-solid fa-eye-slash custm-confirm "
                                                        id="toggler"></i></button>
                                                <div class="invalid-feedback">
                                                    Please enter your Password!
                                                </div>
                                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>



                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" value="1" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <div class="text-center py-1">
                                            <button type="submit"
                                                class="btn bg-gradient-secondary w-100 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>
                                
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script>
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
    <!-- ---------------------------------------------- -->
    <!-- for current password view icon hideshow -->
    <!-- ------------------------------------------- -->
    <script>
        var password = document.getElementById('cpass');
        var toggler = document.getElementById('toggler');
        showHidePassword = () => {
            if (password.type == 'password') {
                toggler.classList.replace("fa-eye-slash", "fa-eye");
                password.setAttribute('type', 'text');
            } else {
                password.setAttribute('type', 'password');
                toggler.classList.replace("fa-eye", "fa-eye-slash");
            }
        };
        toggler.addEventListener('click', showHidePassword);
    </script>
    <!-- ---------------------------------------------- -->
    <!-- for current password view icon hideshow end -->
    <!-- ------------------------------------------- -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="assets/js/soft-ui-dashboard.min.js"></script>
</body>

</html>







<?php /**PATH C:\project\aiman-royale\resources\views/Admin/login.blade.php ENDPATH**/ ?>