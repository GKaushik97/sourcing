<div id="consumption_body">
    <? $this->load->view('gas_source/consumption_body.php'); ?>
</div>

<script type="text/javascript">
    //Geo Area Filter Using State Id
    function stateGaFilter(id)
    {
        preLoader();
        $.post(WEB_ROOT + "GasSource/stateGaFilter", {'id' : id}, function(data){
            $('#ga_consumption_filter').html(data);
            closePreLoader();
        });
    }

    //Gas Source Consumption Body function
    function consumptionBody() {
        var state = $('#state').val();
        var ga = $('#ga').val();
        var supplier = $('#supplier').val();
        var selected_date = $('#selected_date').val();
        //
        if(state == ''){
            $('#state_alert').html("<span class='text-danger'>Please Select State.</span>");
            $('#consumption_allocation_details').html('');
            return false;
        }
        else {
            $('#state_alert').html('');
        }
        //
        if(ga == ''){
            $('#ga_alert').html("<span class='text-danger'>Please Select Geo Area.</span>");
            $('#consumption_allocation_details').html('');
            return false;
        }
        else {
            $('#ga_alert').html('');
        }
        //
        if(supplier == ''){
            $('#supplier_alert').html("<span class='text-danger'>Please Select Supplier.</span>");
            $('#consumption_allocation_details').html('');
            return false;
        }
        else {
            $('#supplier_alert').html('');
        }
        //
        if(selected_date == ''){
            $('#consumption_allocation_details').html('');
            $('#date_alert').html("<span class='text-danger'>Please Select Date.</span>");
            return false;
        }
        else {
            $('#date_alert').html('');
        }
        var params = {
            'state': state,
            'ga':ga,
            'supplier':supplier,
            'selected_date':selected_date,
        };
        preLoader();
        $.post(WEB_ROOT+"GasSource/consumptionBody",params,function(data){
            $('#consumption_allocation_details').html(data);
            closePreLoader();
        });
    }

    function consumptionBodyExt()
    {
        var consumption = $('#consumption').val();
        var gcv = $('#gcv').val();
        if(consumption == ''){
            $('#consumption_alert').html("<span class='text-danger'>Please Enter Consumption.</span>");
            return false;
        }
        else {
            $('#consumption_alert').html('');
        }
        if(gcv == '' || gcv == 0){
            $('#gcv_alert').html("<span class='text-danger'>Please Enter Gcv.</span>");
            return false;
        }
        else {
            $('#gcv_alert').html('');
        }
        var params = $("#allocation_details_form").serializeArray();
        preLoader();
        $.post(WEB_ROOT + "GasSource/consumptionBodyExt", params, function(data){
            $('#consumption_allocation_form').removeClass('d-none');
            $('#consumption_allocation_form').addClass('show');
            $('#consumption_allocation_form').html(data);
            closePreLoader();
        });
    }
    function allocateConsumptionExt()
    {  
        var params = $("#allocation_form").serializeArray();
        preLoader();
        $.post(WEB_ROOT + "GasSource/allocateConsumptionExt", params, function(data){
            $('#consumption_allocation_details').html(data);
            $('#consumption_allocation_form').removeClass('d-none');
            $('#consumption_allocation_form').addClass('show');
            closePreLoader();
        });
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 45 || charCode > 57))
        return false;
        return true;
    }
</script>