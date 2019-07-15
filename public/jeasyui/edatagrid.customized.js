// function getRowIndex(target){
//     var tr = $(target).closest('tr.datagrid-row');
//     return parseInt(tr.attr('datagrid-row-index'));
// }
function editrow(datagridId, index){
    $('#' + datagridId).edatagrid('beginEdit', index);
}
function deleterow(datagridId, index){
    $('#' + datagridId).edatagrid('destroyRow', index);
}
function saverow(datagridId, index){
    $('#' + datagridId).edatagrid('endEdit', index);
}
function cancelrow(datagridId, index){
    $('#' + datagridId).edatagrid('cancelEdit', index);
}
