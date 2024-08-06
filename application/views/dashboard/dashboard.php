<?php
/**
 * Dashboard
 */
/*$start_date = date('01-m-Y');
$middle_date = date('d-m-Y', strtotime($start_date."+14days"));
echo $middle_date;
$today_date = date('d-m-Y');
if($middle_date > $today_date) {
    $from_date_val = date('01-m-Y');
    $to_date_val = date('d-m-Y');
}else {
    $from_date_val = date('16-m-Y');
    $to_date_val = date('d-m-Y');
}*/
$from_date_val = isset($params['date1']) ? $params['date1'] : '';
$to_date_val = isset($params['date2']) ? $params['date2'] : '';
?>
<div class="s-db-col">
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-0">
            <a href="<? echo WEB_ROOT; ?>contract">
                <div class="sourcing-card bg1">
                    <div class="statistic-block">
                        <div class="sourcing-card-body">
                            <div class="statistic-count"><? echo $contracts; ?></div>
                            <div class="divider"></div>
                            <div class="statistic-name">Contracts</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-0">
            <div class="sourcing-card bg5">
                <div class="statistic-block">
                    <div class="sourcing-card-body">
                        <?
                            $scm = convertToScm($dcq,9294.11);
                        ?>
                        <div class="statistic-count"><? echo displayNumber($dcq,2); ?><span>MMBtu</span>&nbsp;&nbsp;<div class="vr"></div>&nbsp;&nbsp;<? echo displayNumber($scm,2); ?><span>SCM</span></div>
                        <div class="divider"></div>
                        <div class="statistic-name">Total DCQ</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 pt-0">
            <a href="<? echo WEB_ROOT; ?>states/geoAreas">
                <div class="sourcing-card bg4">
                    <div class="statistic-block">
                        <div class="sourcing-card-body">
                            <div class="statistic-count"><? echo $total_ga; ?></div>
                            <div class="divider"></div>
                            <div class="statistic-name">GA</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="card s-card">
    <div class="card-header">Gas Source</div>
    <div class="card-body">
        <div class="p-3">
            <div class="d-flex align-items-top justify-content-center">
                <div class="d-flex align-items-center me-2">
                    <label class="form-label mb-0">From Date&nbsp;<span class="text-danger">*</span>:&nbsp;&nbsp;</label>
                    <div class="input-group w-180">
                        <input type="text" class="form-control" id="date1" name="date1" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="date1" aria-describedby="date1" value="<? echo $from_date_val; ?>">
                        <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                    </div>
                    <div id="date1_alert"></div>
                </div>
                <div class="d-flex align-items-center me-2">
                    <label class="form-label mb-0">To Date&nbsp;<span class="text-danger">*</span>:&nbsp;&nbsp;</label>
                    <div class="input-group w-180">
                        <input type="text" class="form-control" id="date2" name="date2" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="date2" aria-describedby="date2" value="<? echo $to_date_val; ?>">
                        <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                    </div>
                    <div id="date2_alert"></div>
                </div>
                <div class="d-flex align-items-center">
                    <button type="button" class="btn btn-success" onclick="dashboardCounts()"><span class="mdi mdi-magnify"></span></button>
                </div>
            </div>
        </div>
        <div id="dashboard_body">
            <? $this->load->view('dashboard/dashboard_ext'); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#date1').datepicker({format: 'dd-mm-yyyy', autoHide: true});
    $('#date2').datepicker({format: 'dd-mm-yyyy', autoHide: true});
    //Gas Source Reports Body function
    function dashboardCounts() {
        var date1 = $('#date1').val();
        var date2 = $('#date2').val();
        $('#date1_alert').html('');
        $('#date2_alert').html('');
        if(date1 == '') {
            $('#date1_alert').html("<span class='text-danger'>Please Select From Date.</span>");
            return false;
        }
        if(date2 == '') {
            $('#date2_alert').html("<span class='text-danger'>Please Select To Date.</span>");
            return false;
        }
        var from = date1.split("-").reverse().join("-");
        var to = date2.split("-").reverse().join("-");
        var d1 = new Date(from);
        var d2 = new Date(to);
        var days = Math.round((d2 - d1) / (1000 * 60 * 60 * 24));
        var params = {
            'date1':date1,
            'date2':date2,
            'days':days,
        };
        preLoader();
        $.post(WEB_ROOT + 'index/dashboardExt', params, function(data){
            $('#dashboard_body').html(data);
            closePreLoader();
        });
    }
</script>