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
 * @package Gas Sourcing
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
<html data-theme="light" data-layout-mode="fluid" data-menu-color="dark" data-topbar-color="light" data-layout-position="fixed" data-sidenav-size="condensed" class="menuitem-active" lang="en">
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
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/date-picker/datepicker.min.css">
        <!-- Template CSS -->
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/css/template.css" id="app-style">
        <link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/template/css/style.css" id="app-style">
        <?
        if($css_files) {
            foreach($css_files as $css_file) {
                ?><link rel="stylesheet" type="text/css" href="<? echo WEB_ROOT;?>assets/<? echo $css_file;?>.css"><?
            }
        }
        ?>

        <!-- Base JS packages -->
        <script type="text/javascript">var WEB_ROOT = "<? echo WEB_ROOT;?>";</script>
        <!-- Boosttrap js -->
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/bootstrap5/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/bootstrap5/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/date-picker/datepicker.min.js"></script>
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/js/main.js"></script>
        <!-- Custom dynamic JS files -->
        <?
        if($js_files) {
            foreach($js_files as $js_file) {
                ?><script type="text/javascript" src="<? echo WEB_ROOT;?>assets/<? echo $js_file;?>.js"></script><? 
            }
        }
        ?>
    </head>
    <body class="show">
        <div class="wrapper position-relative">
            <?
            //-- Load template header
            $this->load->view('template/template_header');
            ?>
            <div class="content-page">
                <?
                // Page layout
                if($page_layout == 1) {
                    ?>
                    <div class="pb-3">
                        <?
                        // Page content
                        echo $page_content;
                        ?>
                    </div>
                    <?
                }
                else {
                    ?>
                    <div class="template-card">
                        <div class="template-card-header d-flex justify-content-between align-items-center mb-2">
                            <div class="template-title"><h1><? echo $page_title;?></h1></div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<? echo WEB_ROOT;?>">Home</a></li>
                                    <?
                                    if(!empty($parent)) {
                                        ?>
                                        <li class="breadcrumb-item">
                                            <a href="<? echo WEB_ROOT . $parent['link'];?>"><? echo $parent['module'];?></a>
                                        </li>
                                        <?
                                    }
                                    ?>
                                    <li class="breadcrumb-item active" aria-current="page"><? echo $page_title;?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="template-card-body card p-3">
                            <?
                            // Page content
                            echo $page_content;
                            ?>                
                        </div>
                    </div>
                    <?
                }
                ?>
                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                               <? echo VERSION;?> &nbsp;Template V 1.0
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-center">
                                &copy;<? echo date('Y');?>&nbsp;<? echo COPYRIGHT;?>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 text-end">
                               <p class="mb-0">Developed By&nbsp;<a href="https://www.highgoweb.com/" target="_blank">Highgo Info Solutions</a></p>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->
            </div>
        </div>
        <!-- Additional JS for header and leftmenu -->
        <script type="text/javascript" src="<? echo WEB_ROOT;?>assets/template/js/menu.js"></script><!-- Left menu js -->
    </body>
</html>