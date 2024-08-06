<?php
/**
 * Template view
 * Template view includes header, footer and navigation content
 * Application must call this template from controller directly
 * Ajax based requests doesn't need to call this template, because the template will be loaded already
 * 
 * This template works with Bootstrap5
 * 
 * @version 1.0.1
 * @copyright HighGo Info Solutions Private Limited
 * @author Highgo
 * @package Recruit Tracker
 * 
 * @example usage of Page variable
 * $data['page'] = array(
 *      'layout' => 0, // 1 or 0
 *      'js' => ['file1', 'file2'],
 *      'css' => ['file1', file2],
 *      'title' => 'Page Title',
 *      'parent' => ['module' => 'Name of module', 'link' => 'link'],
 *      'content' => $this->load->view('view/path', $data, true), // view return as data
 * );
 */

//-- Page title and content
$page_layout = (isset($page['layout'])) ? $page['layout'] : 0;
$page_title = (isset($page['title'])) ? $page['title'] : 'Untitled page';
$page_content = (isset($page['content'])) ? $page['content'] : 'Empty page';
$parent = (isset($page['parent'])) ? $page['parent'] : '';
$js_files = (isset($page['js'])) ? $page['js'] : '';
$css_files = (isset($page['css'])) ? $page['css'] : '';
?>
<!DOCTYPE html>
<html data-theme="light" data-layout-mode="fluid" data-menu-color="dark" data-topbar-color="light" data-layout-position="fixed" data-sidenav-size="condensed" class="menuitem-active sidebar-enable" lang="en">
    <head>
        <title><? echo APP_TITLE; ?> : <? echo $page_title;?></title>
        <meta charset="utf-8">
        <meta name="robots" content="index,follow"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <link rel="shortcut icon" href="<? echo WEB_ROOT;?>assets/images/favicon.png" type="image/x-icon">
        <!-- Base CSS packages -->
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/bootstrap5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/material-design/css/materialdesignicons.min.css"/>
        <!-- <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/date-picker/datepicker.min.css"> -->
        <!-- Template CSS -->
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/css/template.css" id="app-style">
        <!-- External css -->
        <!-- <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/css/animation/animate.css"> -->
        <!-- Custom dynamic CSS files -->
        <?
        if($css_files) {
            foreach($css_files as $css_file) {
                ?><link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/<? echo $css_file;?>.css"><?
            }
        }
        ?>
        <script type="text/javascript">var loader = "<div class='position-absolute loader-position'><div class='loader-block'><div class='loader'></div></div></div>"</script>
        <!-- Base JS packages -->
        <script type="text/javascript">var WEB_ROOT = "<? echo WEB_ROOT;?>";</script>
        <!-- <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/js/main.js"></script>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/date-picker/datepicker.min.js"></script> -->
        <!-- Custom dynamic JS files -->
        <?
        if($js_files) {
            foreach($js_files as $js_file) {
                ?><script type="text/javascript" src="<? echo WEB_ROOT;?>assets/<? echo $js_file;?>.js"></script><? 
            }
        }
        ?>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/js/hyper-config.js"></script>
    </head>
    <body class="show" style="">
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Topbar Start ========== -->
            <div class="navbar-custom">
                <div class="topbar container-fluid">
                    <div class="d-flex align-items-center gap-lg-2 gap-1">
                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu">
                            <i class="mdi mdi-menu"></i>
                        </button>
                        <span class="logo-lg">
                            <img src="/recruitTracker/assets/images/logo.png" alt="logo">
                        </span>
                        <!-- Horizontal Menu Toggle Button -->
                        <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </button>

                        <!-- Topbar Search Form -->
                        <div class="app-search dropdown d-none d-lg-block">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                                    <span class="mdi mdi-magnify search-icon"></span>
                                    <button class="input-group-text btn btn-primary" type="submit">Search</button>
                                </div>
                            </form>

                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                                <!-- item-->
                                <div class="dropdown-header noti-title">
                                    <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-outline me-1"></i>
                                    <span>Analytics Report</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-outline me-1"></i>
                                    <span>How can I help you?</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-outline me-1"></i>
                                    <span>User profile settings</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <ul class="topbar-menu d-flex align-items-center gap-3">
                        <li class="dropdown d-lg-none">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <i class="ri-search-line font-22"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                                <form class="p-3">
                                    <input type="search" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                </form>
                            </div>
                        </li>

                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="https://coderthemes.com/hyper/saas/assets/images/flags/us.jpg" alt="user-image" class="me-0 me-sm-1" height="12">
                                <span class="align-middle d-none d-lg-inline-block">English</span> <i class="mdi mdi-chevron-down d-none d-sm-inline-block align-middle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <img src="https://coderthemes.com/hyper/saas/assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <img src="https://coderthemes.com/hyper/saas/assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <img src="https://coderthemes.com/hyper/saas/assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <img src="https://coderthemes.com/hyper/saas/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
                                </a>

                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="https://coderthemes.com/hyper/saas/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle" width="32">
                                </span>
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0">Admin</h5>
                                    <h6 class="my-0 fw-normal">Welcome</h6>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-account-circle me-1"></i>
                                    <span>My Account</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Settings</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-lifebuoy me-1"></i>
                                    <span>Support</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-lock-outline me-1"></i>
                                    <span>Lock Screen</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">
                                    <i class="mdi mdi-logout me-1"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- ========== Topbar End ========== -->

            <!-- ========== Left Sidebar Start ========== -->
            <div class="leftside-menu menuitem-active">
                <!-- Sidebar -left -->
                <div class="h-100 show" id="leftside-menu-container" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                    <!-- Leftbar User -->
                    <div class="leftbar-user">
                        <a href="pages-profile.html">
                            <img src="https://coderthemes.com/hyper/saas/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle shadow-sm" height="42">
                            <span class="leftbar-user-name mt-2">Dominic Keller</span>
                        </a>
                    </div>

                    <!--- Sidemenu -->
                    <ul class="side-nav">
                        <li class="side-nav-item menuitem-active">
                            <a href="apps-calendar.html" class="side-nav-link">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-calendar.html" class="side-nav-link">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span>Candidates</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-calendar.html" class="side-nav-link">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span>Career Page</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="apps-calendar.html" class="side-nav-link">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span>Users & Roles</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link collapsed">
                                <i class="mdi mdi-view-dashboard-outline"></i>
                                <span> Settings </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarEcommerce" style="">
                                <ul class="side-nav-second-level">
                                    <li>
                                        <a href="apps-ecommerce-products.html">App Settings</a>
                                    </li>
                                    <li>
                                        <a href="apps-ecommerce-products-details.html">Job Settings</a>
                                    </li>
                                    <li>
                                        <a href="apps-ecommerce-orders.html">Integrations</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!--- End Sidemenu -->

                    <div class="clearfix"></div>
                </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1952px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 407px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
            </div>
            <!-- ========== Left Sidebar End ========== -->
            

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <h1>Dashboard</h1>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                         <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p> 
                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script>2023 © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->
        
        <!-- Boosttrap js -->
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/bootstrap5/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/bootstrap5/js/bootstrap.bundle.min.js"></script>
        <!-- Dashboard App js -->
        <script src="<? echo WEB_ROOT;?>assets/template/js/dashboard.js"></script>
        <!-- App js -->
        <script src="<? echo WEB_ROOT;?>assets/template/js/app.min.js"></script>
</body>
</html>