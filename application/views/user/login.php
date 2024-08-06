<?php
/**
 * Login view
 * Individual page
 */
?>
<!DOCTYPE html>
<html data-theme="light" data-layout-mode="fluid" data-menu-color="dark" data-topbar-color="light" data-layout-position="fixed" data-sidenav-size="condensed" class="menuitem-active" lang="en">
    <head>
        <title><? echo APP_TITLE; ?> : Login</title>
        <meta charset="utf-8">
        <meta name="robots" content="noindex,nofollow"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <link rel="shortcut icon" href="<? echo WEB_ROOT;?>assets/images/favicon.png" type="image/x-icon">
        <!-- Base CSS packages -->
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/bootstrap5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/material-design/css/materialdesignicons.min.css"/>        
    </head>
    <body class="show">
    	<div class="container">
            <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div style="width: 450px;">
                    <div class="login-wrap p-4 p-md-5">
                        <div class="text-center mb-3">
                            <img src="<? echo WEB_ROOT;?>assets/images/logo.png" alt="Banner" class="img-fluid" width="135">
                        </div>
                        <!-- <div class="icon d-flex align-items-center justify-content-center">
                            <span class="mdi mdi-account-outline"></span>
                        </div> -->
                        <h3 class="text-center mb-4">Sign In</h3>
                        <form action="<? echo WEB_ROOT;?>login/loginSubmit" method="post" class="sign-in-sign-up-form w-100">
                            <!-- <div class="mb-3">
                                <label class="form-label mb-0"><span class="mdi mdi-account"></span>&nbsp;Username</label>
                                <input type="text" name="username" class="form-control text-mute" placeholder="Enter username">
                                <small class="text-danger"><? echo form_error('username');?></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label mb-0"><span class="mdi mdi-key"></span>&nbsp;Password</label>
                                <input type="password" name="password" class="form-control text-mute" placeholder="Enter password">
                                <small class="text-danger"><? echo form_error('password');?></small>
                            </div> -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Enter User Name">
                                    <label for="floatingInput"><span class="mdi mdi-account"></span>&nbsp;&nbsp;User Name</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Enter Password">
                                    <label for="floatingPassword"><span class="mdi mdi-key"></span>&nbsp;&nbsp;password</label>
                                </div>                                
                                <small class="text-danger"><? echo form_error('password');?></small>                                
                            </div>
                            <small class="text-danger"><? echo isset($message) ? $message : '';?></small>
                            <div class="mb-3">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        <span class="mdi mdi-login-variant"></span>&nbsp;Login
                                    </button>
                                </div>
                            </div>
                            <div class="login-copy-right"><p class="text-center mt-5 mb-0">&copy; <?php echo date('Y');?>&nbsp;<?php echo COPYRIGHT;?></p></div>
                        </form>                    
                    </div>
                </div>                
            </div>
            <!-- <div class="login-block d-flex align-items-center">
                <div class="login-form login-block-pad">
                    <div class="row d-flex align-items-center">            
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="d-flex align-items-center login-form-height">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="position-relative">
                                <div class="login-form-height logo-bg">
                                    <img src="<? echo WEB_ROOT;?>assets/template/images/login-bg.png" class="img-fluid w-100">
                                </div>
                                <div class="position-absolute" style="top: 0;bottom: 0;left: 0;right: 0;opacity: 0.75;background-image: radial-gradient( circle 975px at 2.6% 48.3%,  rgba(0,8,120,1) 0%, rgba(95,184,224,1) 99.7% );border-top-right-radius: 1rem;border-bottom-right-radius: 1rem;">
                                    <div class="" style="color: #ffffff;padding: 3rem; display: flex; justify-content: center; align-items: center;height: 100%;text-align: center;">
                                        <div>
                                            <h3>Login</h3>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div> -->
        </div>
        <style type="text/css">
            @font-face {
                font-family: 'Poppins';
                src: url('<? echo WEB_ROOT;?>assets/template/fonts/Poppins/Poppins-Regular.woff');
            }
            body {
                font-family: 'Poppins';
                font-size: 14px;
                color: #262626;
                line-height: 24px;
                background-color: #f8f9fd;
            }
            @media (min-width: 768px) {
                .p-md-5 {
                  padding: 3rem !important;
                }
            }
            /*.form-control.text-mute::placeholder {
                color: #bdbdbd;
            }*/
            /*.login-wrap .icon {
                width: 80px;
                height: 80px;
                background: #1089ff;
                border-radius: 50%;
                font-size: 40px;
                margin: 0 auto;
                margin-bottom: 0px;
                margin-bottom: 10px;
            }
            .login-wrap .icon span {
                color: #fff;
            }*/
            .login-wrap h3 {
                font-weight: 300 !important;
                font-size: 1.25rem;
            }
            /*.back-image {
                background-repeat: no-repeat;
                background-size: cover
                bottom: 0;
                left: 0;
                position: absolute;
                right: 0;
                top: 0;
            }
            .login-form {
                background-color: #ffffff;
                box-shadow: 0px 0px 15px rgba(0,0,0,0.05);
                border-top-left-radius: 1rem;
                border-bottom-left-radius: 1rem;
            }
            .logo-bg {
                background-color: #ffffff;
                box-shadow: 0px 0px 15px rgba(0,0,0,0.05);
                border-top-right-radius: 1rem;
                border-bottom-right-radius: 1rem;
            }
            .login-form .sign-in-sign-up-form {
                padding: 6.5rem;
            }
            .login-block {
                min-height: 100vh;
                overflow-y: auto;
            }
            .login-block-pad .row {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .login-block-pad [class*= "col-"] {
                padding: 0px;
            }
            .login-form-height {
                height: 495px;
                overflow: hidden;
            }
            .logo-bg img {
                height: 495px;
            }
            .login-copy-right {
                color: #757575;
                font-size: 0.75rem;
            }
            @media (max-width: 1366px) {
                /*.login-block-pad {
                    padding-left: 0rem;
                    padding-right: 0rem;
                }*/
                /*.login-form .sign-in-sign-up-form {
                    padding: 2rem;
                }
            }
            @media (min-width: 1367px) and (max-width: 1980px) {
                .login-block-pad {
                    padding-left: 10rem;
                    padding-right: 10rem;
                }*/
            }*/
        </style>
        <style type="text/css">
            .login-wrap {
                position: relative;
                background: #fff;
                border-radius: 10px;
                -webkit-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
                -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
                box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            }
        </style>
    </body>
</html>