<div class="consumption-allocation-card">
    <div class="clearfix p-3"> 
        <div class="float-start">
            <div class="d-flex align-items-top">
                <div class="me-1">
                    <label class="form-label mb-0">State&nbsp;<span class="text-danger">*</span>:</label>
                    <select name="state" id="state" class="form-select form-select-sm w-150" aria-label="All States" data-live-search="true" onchange="stateGaReportFilter(this.value)">
                        <option value="">All States</option>
                        <?php
                        foreach($states as $key => $value) {
                            ?>
                            <option value="<? echo $value['id']; ?>"><? echo $value['name']; ?></option>
                            <?
                        }
                        ?>
                    </select>
                    <div id="state_alert"></div>
                </div>
                <div id="reports_ga_filter" class="me-1">
                    <? $this->load->view('gas_source/reports_ga_filter'); ?>
                </div>
                <div class="me-1">
                    <label class="form-label mb-0">Supplier&nbsp;<span class="text-danger">*</span>:</label>
                    <select name="supplier" id="supplier" class="form-select form-select-sm w-150" aria-label="All Suppliers" data-live-search="true">
                        <option value="">Suppliers</option>
                        <?php
                        if(isset($suppliers)){
                            foreach($suppliers as $key => $supplier) {
                                ?>
                                <option value="<? echo $supplier['id']; ?>"><? echo $supplier['name']; ?></option>
                                <?
                            }
                        }
                        ?>
                    </select>
                    <div id="supplier_alert"></div>
                </div>
                <div class="me-1">
                    <label class="form-label mb-0">From Date&nbsp;<span class="text-danger">*</span>:</label>
                    <div class="input-group input-group-sm w-150">
                        <input type="text" class="form-control form-control-sm" id="date1" name="date1" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="date1" aria-describedby="date1">
                        <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                    </div>
                    <div id="date1_alert"></div>
                </div>
                <div class="me-1">
                    <label class="form-label mb-0">To Date&nbsp;<span class="text-danger">*</span>:</label>
                    <div class="input-group input-group-sm w-150">
                        <input type="text" class="form-control form-control-sm" id="date2" name="date2" autocomplete="off" placeholder="DD-MM-YYYY" aria-label="date2" aria-describedby="date2">
                        <span class="input-group-text"><span class="mdi mdi-calendar-month-outline"></span></span>
                    </div>
                    <div id="date2_alert"></div>
                </div>
                <div class="me-1">
                    <label class="form-label mb-0">&nbsp;</label>
                    <div>
                        <button type="button" class="btn btn-sm btn-success" onclick="reportsBody()"><span class="mdi mdi-magnify"></span></button>                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="reports_body"></div>
<script type="text/javascript">
    $('#date1').datepicker({format: 'dd-mm-yyyy', autoHide: true});
    $('#date2').datepicker({format: 'dd-mm-yyyy', autoHide: true});

    //Geo Area Filter Using State Id
    function stateGaReportFilter(id)
    {
        preLoader();
        $.post(WEB_ROOT + "GasSource/stateGaReportFilter", {'id' : id}, function(data){
            $('#reports_ga_filter').html(data);
            closePreLoader();
        });
    }
    //Gas Source Reports Body function
    function reportsBody() {
        var state = $('#state').val();
        var ga = $('#ga').val();
        var supplier = $('#supplier').val();
        var date1 = $('#date1').val();
        var date2 = $('#date2').val();
        //
        if(state == ''){
            $('#state_alert').html("<span class='text-danger'>Please Select State.</span>");
            return false;
        }
        else {
            $('#state_alert').html('');
        }
        //
        if(ga == ''){
            $('#ga_alert').html("<span class='text-danger'>Please Select Geo Area.</span>");
            return false;
        }
        else {
            $('#ga_alert').html('');
        }
        //
        if(supplier == ''){
            $('#supplier_alert').html("<span class='text-danger'>Please Select Supplier.</span>");
            return false;
        }
        else {
            $('#supplier_alert').html('');
        }
        //
        if(date1 == ''){
            $('#date1_alert').html("<span class='text-danger'>Please Select From Date.</span>");
            return false;
        }
        else {
            $('#date1_alert').html('');
        }
        //
        if(date2 == ''){
            $('#date2_alert').html("<span class='text-danger'>Please Select To Date.</span>");
            return false;
        }
        else {
            $('#date2_alert').html('');
        }
        var params = {
            'state': state,
            'ga':ga,
            'supplier':supplier,
            'date1':date1,
            'date2':date2,
        };
        preLoader();
        $.post(WEB_ROOT+"GasSource/reportsBody",params,function(data){
            $('#reports_body').html(data);
            closePreLoader();
        });
    }
</script>