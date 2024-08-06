/* Events*/
function moduleActionsBody(rows, pageno, sortby, sort_order) 
{
    var qStr = {
        "rows" : rows,
        "pageno" : pageno,
        "sortby" : sortby,
        "sort_order" : sort_order,
        "keywords" : $("#keywords").val(),
    };
    $.post(WEB_ROOT+"moduleActions/moduleActionsBody", qStr, function (data) {
        $("#module_actions_body").html(data);
    });
}
function resetModuleActionsBody() 
{
    $("#keywords").val("");
    moduleActionsBody(20, 1, 'name', 'desc');
}
function addModuleAction()
{
    preLoader();
    $.post(WEB_ROOT+"moduleActions/addModuleAction",function (data) {
        loadModal(data);
        closePreLoader();
    });
}
function insertModuleAction(e)
{
    e.preventDefault();
    var module_id = $("#module_id").val();
    var action_name = $("#action_name").val();
    var action_code = $("#action_code").val();
    if(module_id == ""){
        $('#module_alert').html("<span class='text-danger'>Plaese Select Module.</span>");
        return false;
    }
    if(action_name == ""){
        $('#name_alert').html("<span class='text-danger'>Plaese Enter Action Name.</span>");
        return false;
    }
    if(action_code == ""){
        $('#code_alert').html("<span class='text-danger'>Plaese Enter Action Code.</span>");
        return false;
    }
    $('button[type = "submit"]').prop('disabled', true);
    $('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var params = $("#module_action_add_form").serializeArray();
    $.post(WEB_ROOT + "moduleActions/insertModuleAction", params, function(data){
        $(".modal-dialog").parent().html(data);
        $('button[type = "submit"]').prop('disabled',false);
        $('button[type = "submit"]').html('<i class="fa fa-plus">&nbsp;</i>Add');
        resetModuleActionsBody();
    });
}
function editModuleAction(id)
{
    preLoader();
    $.post(WEB_ROOT+"moduleActions/editModuleAction",{"id":id},function (data) {
        loadModal(data);
        closePreLoader();
    });
}
function updateModuleAction(e)
{
    e.preventDefault();
    var module_id = $("#module_id").val();
    var action_name = $("#action_name").val();
    var action_code = $("#action_code").val();
    if(module_id == ""){
        $('#module_alert').html("<span class='text-danger'>Plaese Select Module.</span>");
        return false;
    }
    if(action_name == ""){
        $('#name_alert').html("<span class='text-danger'>Plaese Enter Action Name.</span>");
        return false;
    }
    if(action_code == ""){
        $('#code_alert').html("<span class='text-danger'>Plaese Enter Action Code.</span>");
        return false;
    }
    $('button[type = "submit"]').prop('disabled', true);
    $('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var params = $("#module_action_edit_form").serializeArray();
    $.post(WEB_ROOT + "moduleActions/updateModuleAction", params, function(data){
        $(".modal-dialog").parent().html(data);
        $('button[type = "submit"]').prop('disabled',false);
        $('button[type = "submit"]').html('<i class="fa fa-pencil-square-o">&nbsp;</i>Update');
        resetModuleActionsBody();
    });
}
