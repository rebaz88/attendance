<div class="easyui-layout" fit="true">

  <div data-options="region:'west', collapsible:true" style="width:400px;">
    <table id="RolesDatagrid"></table>

    <div id="RolesDatagridToolbar" style="padding:5px;text-align:center;">
      <a href="#" class="easyui-linkbutton" iconCls="icon-add"  onclick="javascript:$('#RolesDatagrid').edatagrid('addRow')">New</a>
      <a href="#" class="easyui-linkbutton" iconCls="icon-reload"  onclick="javascript:$('#RolesDatagrid').edatagrid('reload')">Reload</a>
    </div>
  </div>

  <div data-options="region:'center', title:'Permissions'" id="RolesPermissionPanel">

  </div>

</div>


<script type="text/javascript">

  $(function(){
    $('#RolesDatagrid').edatagrid({
      idField:'id',
      title: 'Roles',
      toolbar:'#RolesDatagridToolbar',
      fit:true,
      border:false,
      fitColumns:true,
      singleSelect:true,
      method:'get',
      rownumbers:true,
      url:'/cp/roles/list',
      saveUrl: '/cp/roles/insert',
      updateUrl: '/cp/roles/update',
      destroyUrl: '/cp/roles/destroy',

        columns: [[
          {field:'name',title:'Name',width:50,
            editor:{
              type:'validatebox',
              options:{
                required:true
              }
            }
          },

          {field:'action',title:'Action',width:100,align:'center',
              formatter:function(value,row,index){
                  if (row.editing){
                      var s = '<button onclick="saverow(\'RolesDatagrid\', ' + index +')">Save</button> ';
                      var c = '<button onclick="cancelrow(\'RolesDatagrid\', ' + index +')">Cancel</button>';
                      return s+c;
                  } else {
                      var e = '<button onclick="editrow(\'RolesDatagrid\', ' + index + ')">Edit</button> ';
                      var d = '<button onclick="deleterow(\'RolesDatagrid\', ' + index + ')">Delete</button> ';
                      var f = '<button onclick="loadPermissions(\'' + row.name + '\')">Permissions</button> ';
                      return e+d+f;
                  }
              }
          }

        ]],

        onBeforeEdit:function(index,row){
            row.editing = true;
            $(this).edatagrid('refreshRow', index);
        },
        onAfterEdit:function(index,row){
            row.editing = false;
            $(this).edatagrid('refreshRow', index);
        },
        onCancelEdit:function(index,row){
            row.editing = false;
            $(this).edatagrid('refreshRow', index);
        },

        onDestroy: function() {
          resetPermissionCheckboxes();
        }

    });
  });

  function loadPermissions(roleName) {

    $('#RolesPermissionPanel').panel({
      'href': 'permissions?role_name=' + roleName,
    });

  }

  function resetPermissionCheckboxes() {

    $('#RolesPermissionPanel').panel('clear');

  }


</script>
