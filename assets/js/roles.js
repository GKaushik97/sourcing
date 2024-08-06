/* Roles*/
function rolesBody(rows, pageno, sortby, sort_order) 
{
    var qStr = {
        "rows" : rows,
        "pageno" : pageno,
        "sortby" : sortby,
        "sort_order" : sort_order,
        "keywords" : $("#keywords").val(),
    };
    $.post(WEB_ROOT+"roles/rolesBody", qStr, function (data) {
        $("#roles_body").html(data);
    });
}
function resetRolesBody() 
{
    $("#keywords").val("");
    rolesBody(20, 1, 'id', 'asc');
}
function addRole()
{
    preLoader();
    $.post(WEB_ROOT+"roles/addRole",function (data) {
        loadModal(data);
        closePreLoader();
    });
}
function insertRole(e)
{
    e.preventDefault();
    var name = $("#name").val();
    if(name == ""){
        $('#add_name_alert').html("<span class='text-danger'>Plaese Enter Role Name.</span>");
        return false;
    }
    $('button[type = "submit"]').prop('disabled', true);
    $('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var params = $("#role_add_form").serializeArray();
    $.post(WEB_ROOT + "roles/insertRole", params, function(data){
        $(".modal-dialog").parent().html(data);
        $('button[type = "submit"]').prop('disabled',false);
        $('button[type = "submit"]').html('<i class="fa fa-plus">&nbsp;</i>Add');
        resetRolesBody();
    });
}
function editRole(id)
{
    preLoader();
    $.post(WEB_ROOT+"roles/editRole",{"id":id},function (data) {
        loadModal(data);
        closePreLoader();
    });
}
function updateRole(e)
{
    e.preventDefault();
    var name = $("#name").val();
    if(name == ""){
        $('#edit_name_alert').html("<span class='text-danger'>Plaese Enter Department Name.</span>");
        return false;
    }
    $('button[type = "submit"]').prop('disabled', true);
    $('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var params = $("#role_edit_form").serializeArray();
    $.post(WEB_ROOT + "roles/updateRole", params, function(data){
        $(".modal-dialog").parent().html(data);
        $('button[type = "submit"]').prop('disabled',false);
        $('button[type = "submit"]').html('<i class="fa fa-pencil-square-o">&nbsp;</i>Update');
        resetRolesBody();
    });
}
function manageRights(id)
{
    preLoader();
    $.post(WEB_ROOT+"roles/manageRights", {'id':id},function (data) {
        loadModal(data);
        closePreLoader();
    });
}
function manageRightsExt(e)
{
    e.preventDefault();
    $('button[type = "submit"]').prop('disabled', true);
    $('button[type = "submit"]').html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var params = $("#manage_rights_form").serializeArray();
    $.post(WEB_ROOT + "roles/manageRightsExt", params, function(data){
        $(".modal-dialog").parent().html(data);
        $('button[type = "submit"]').prop('disabled',false);
        $('button[type = "submit"]').html('<i class="fa fa-plus">&nbsp;</i>Add');
        resetRolesBody();
    });
}
function updateRoleStatus(id,status){
    $('#status_btn'+id).prop('disabled', true);
    $('#status_btn'+id).html('<i class="fa fa-spinner fa-spin"></i>&nbsp;<strong>processing...</strong>');
    var qStr = {
        "id" : id,
        "status" : status,
    };
    $.post(WEB_ROOT+"roles/updateRoleStatus",qStr,function (data) {
        $('#status_btn'+id).prop('disabled',false);
        $('#status_btn'+id).html('<i class="fa fa-remove">&nbsp;</i>Status');
        resetRolesBody();
    });
}