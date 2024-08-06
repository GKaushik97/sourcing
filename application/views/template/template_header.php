<?php
/**
 * Template header
 * This header holds the logo and employee profile and links to other main modules
 * @version 1.0.1
 */

//-- Employee details
$employee = $this->session->userdata('emp');
?>
<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">
            <!-- Sidebar Menu Toggle Button -->
            <button class="button-toggle-menu">
                <i class="mdi mdi-menu"></i>
            </button>
            <span style="width: 140px;">
                <a href="<? echo WEB_ROOT;?>" title="Home"><img src="<? echo WEB_ROOT;?>assets/images/logo.png" alt="logo" class="img-fluid"></a>
            </span>
            <!-- Horizontal Menu Toggle Button -->
            <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3">
            <!-- Topbar Search Form -->
            <li><div class="noti-title"><h6 class="text-overflow m-0">Welcome <? echo $this->session->userdata('user')['username'];?>&nbsp;!</h6></div></li>
            <li class="dropdown">
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="<? echo WEB_ROOT;?>assets/template/images/profile/profile_img.png" alt="profile-image" class="rounded-circle" width="32">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0"><? echo $this->session->userdata('user')['name'];?></h5>
                        <h6 class="my-0 fw-normal"><? echo $this->session->userdata('user')['username'];?></h6>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                    <a href="<? echo WEB_ROOT;?>user/profile" class="dropdown-item">
                        <i class="mdi mdi-account-circle-outline me-1"></i>
                        <span>My Account</span>
                    </a>
                    <a href="<? echo WEB_ROOT;?>user/changePassword" class="dropdown-item">
                        <i class="mdi mdi-security me-1"></i>
                        <span>Change Password</span>
                    </a>
                    <a href="<? echo WEB_ROOT;?>login/logout" class="dropdown-item">
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
            
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-item menuitem-active">
                <a href="<? echo WEB_ROOT;?>" class="side-nav-link">
                    <i class="mdi mdi-view-dashboard-outline"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#subMenu1" aria-expanded="false" aria-controls="subMenu1" class="side-nav-link collapsed">
                    <i class="mdi mdi-hydraulic-oil-level"></i>
                    <span>Gas Source</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="subMenu1" style="">
                    <ul class="side-nav-second-level">
                        <li><a href="<? echo WEB_ROOT;?>GasSource/add_nomination">Add Nomination</a></li>
                        <li><a href="<? echo WEB_ROOT;?>GasSource/addConsumption">Add Consumption</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a href="<? echo WEB_ROOT;?>contract" class="side-nav-link">
                    <i class="mdi mdi-archive-outline"></i>&nbsp;<span>Contracts</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<? echo WEB_ROOT;?>gasSource/reports" class="side-nav-link">
                    <i class="mdi mdi-file-document-multiple-outline"></i>&nbsp;<span>Report</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#subMenu1" aria-expanded="false" aria-controls="subMenu1" class="side-nav-link collapsed">
                    <i class="mdi mdi-database-outline"></i>
                    <span>Data Modules</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="subMenu1" style="">
                    <ul class="side-nav-second-level">
                        <li><a href="<? echo WEB_ROOT;?>states">States</a></li>
                        <li><a href="<? echo WEB_ROOT;?>states/geoAreas">Geo Areas</a></li>
                        <li><a href="<? echo WEB_ROOT;?>suppliers">Suppliers</a></li>
                        <li><a href="<? echo WEB_ROOT;?>contractTypes">Contract Types</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#subMenu2" aria-expanded="false" aria-controls="subMenu2" class="side-nav-link collapsed">
                    <i class="mdi mdi-account-multiple-outline"></i>
                    <span>User Administration</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="subMenu2" style="">
                    <ul class="side-nav-second-level">
                        <li><a href="<? echo WEB_ROOT;?>user">Users</a></li>
                        <li><a href="<? echo WEB_ROOT;?>roles">Roles</a></li>
                    </ul>
                </div>
            </li>
            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#subMenu3" aria-expanded="false" aria-controls="subMenu3" class="side-nav-link collapsed">
                    <i class="mdi mdi-cog-outline"></i>
                    <span>Settings</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="subMenu3" style="">
                    <ul class="side-nav-second-level">
                        <li><a href="<? echo WEB_ROOT;?>moduleActions">Module Actions</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 1952px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 407px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
</div>
<!-- ========== Left Sidebar End ========== -->