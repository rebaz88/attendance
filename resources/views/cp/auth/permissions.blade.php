<div class="easyui-layout" fit="true">

    <div id="displayRoleBar" data-options="region:'north',border:false" style="height:50px;text-align:center;padding:10px;font-size:20px;background:darkseagreen;">
        @if($role)
        {!! $role->name !!} Permissions
        @else
        ---
        @endif
    </div>

    <div data-options="region:'south',border:false" style="height:50px;border-top:1px solid #95B8E7;text-align:center;padding:10px;">

        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="checkAllPermissions()">Check all</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="unCheckAllPermissions()">Uncheck all</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="savePermissions()" style="width:100px;">Save</a>

    </div>

    <div id="PermissionsPage" data-options="region:'center',border:false">


        <form method="post" style="width:100%;height:100%" id="PermissionsForm">


            <table PermissionTable id="PermissionsDatagrid">

                <tbody>

                    <tr>
                        <td>
                            <div><input type="checkbox" main class="permission-checkbox" name="view_settings">Settings</div>
                            <p><input type="checkbox" class="permission-checkbox" name="view_users">Users</p>
                            <p><input type="checkbox" class="permission-checkbox" name="view_roles_and_permissions">Roles & Permissions</p>
                            <p><input type="checkbox" class="permission-checkbox" name="view_activities">Activities</p>
                        </td>
                    </tr>


                </tbody>
            </table>


        </form>


    </div>

</div>


<script type="text/javascript">
    var oldPermissions = {!!$permissions!!};

    $(function () {

        $('#PermissionsPage :input[type="checkbox"]').change(function () {
            handlePermissionCheck($(this));
        });

        $('form#PermissionsForm :input[type="checkbox"]').each(function () {

            if (oldPermissions.indexOf($(this).prop('name')) >= 0)
                $(this).prop('checked', true);

        });

    });

    function handlePermissionCheck($el) {

        var isMain = $el.is("[main]");
        var isView = $el.is("[view]");
        var checkboxState = $el.prop('checked');

        var parentRow = $el.closest('tr')

        var inputs = [];

        parentRow.find("td input:checkbox").each(function (index) {

            inputs.push($(this));

        });

        if (isMain) {
            changeAllBoxes(inputs, checkboxState);
        } else if (isView) {
            if (checkboxState == false) {
                changeAllBoxes(inputs, checkboxState);
            } else {
                inputs[0].prop('checked', checkboxState);
            }
        } else if (checkboxState == true) { // all other controls
            inputs[0].prop('checked', true);
            inputs[1].prop('checked', true);
        }

    }

    function changeAllBoxes(inputs, checkboxState) {
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].prop('checked', checkboxState);
        }
    }

    function checkAllPermissions() {
        $('#PermissionsForm input:checkbox').prop('checked', true);
    }

    function unCheckAllPermissions() {
        $('#PermissionsForm input:checkbox').prop('checked', false);
    }

    function savePermissions() {

        $('#PermissionsForm').form('submit', {
            url: '/cp/permissions/{!! $role->id !!}/save',
            onSubmit: function (param) {
                param._token = window.CSRF_TOKEN;
            },
            success: function (result) {
                var result = eval('(' + result + ')');
                if (result.msg) {
                    $.messager.show({
                        title: 'Error',
                        msg: result.msg
                    });
                } else {
                    $.messager.show({
                        title: 'Sucess',
                        msg: 'Operation performed successfully!'
                    })
                }
            }
        });
    }
</script>

<style media="screen">
    #PermissionsDatagrid {
        width: 100%;
    }

    .permission-checkbox {
        margin: 10px 10px 10px 20px !important;
    }

    #PermissionsPage td {
        border-bottom: 1px solid #ddd;
    }

    #PermissionsPage td div {
        background: #b76e6e;
        color: white;
        border-bottom: 1px solid #ddd;
    }

    #PermissionsPage td p {
        padding-left: 15px;
    }

    #PermissionsPage td[field="title"] {
        background: red;
        color: white;
    }
</style>