<?php
/**
 * Profile view foro logged in user
 */

?>
<div class="user-profile mb-3">
    <div class="row align-items-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-5">
            <div class="d-flex border-right px-5 pr-xl-5 pl-xl-0 align-items-center user-header-media">
                <div class="me-4">
                    <div class="profile-img d-flex rounded-circle">
                        <img src="<?php print WEB_ROOT; ?>assets/template/images/profile/profile_img.png" class="img-fluid">
                    </div>
                </div>
                <div class="profile-admin">
                    <h2><?php print $user_details['fname']. ' ' . $user_details['lname'];?></h2>
                    <p><?php print $user_details['name']?></p>
                    <? if($user_details['status'] == '1'){ ?>
                        <div class="status status-success status-icon-check">Active</div><?
                    }
                    else {
                        ?><div class="status status-danger status-icon-close">Inactive</div><?
                    }
                    ?>
                </div>                    
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
            <div class="user-details px-5 px-sm-5 px-md-5 px-lg-0 px-xl-0 mt-5 mt-sm-5 mt-md-0 mt-lg-0 mt-xl-0">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                        <div class="border-right custom">
                            <div class="d-flex mb-4">
                                <div class="align-self-center me-3 profile-icon">
                                    <span class="mdi mdi-account-outline"></span>
                                </div> 
                                <div class="media-body">
                                    <p class="text-muted mb-0">UserName&nbsp;:</p> 
                                    <p class="mb-0"><?php print $user_details['username'];?></p>
                                </div>
                            </div> 
                            <div class="d-flex">
                                <div class="align-self-center me-3 profile-icon">
                                    <span class="mdi mdi-email-outline"></span>
                                </div> 
                                <div data-v-21bb1480="" class="media-body">
                                    <p class="text-muted mb-0">E-Mail Id&nbsp;:</p> 
                                    <p class="mb-0"><?php print $user_details['email']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                        <div class="custom">
                            <div class="d-flex mb-4">
                                <div class="align-self-center me-3 profile-icon">
                                    <span class="mdi mdi-phone-outline"></span>
                                </div> 
                                <div class="media-body">
                                    <p class="text-muted mb-0">Phone Number&nbsp;:</p> 
                                    <p class="mb-0"><?php print $user_details['mobile']?></p>
                                </div>
                            </div> 
                            <div class="d-flex">
                                <div class="align-self-center me-3 profile-icon">
                                    <span class="mdi mdi-calendar-month-outline"></span>
                                </div> 
                                <div data-v-21bb1480="" class="media-body">
                                    <p class="text-muted mb-0">Added Date&nbsp;:</p> 
                                    <p class="mb-0"><?php echo displayDate($user_details['added_at']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
