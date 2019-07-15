        <div class="easyui-layout" fit="true">

            <div id="setting-buttons" data-options="region:'north'" style="height:90px;background: #eee;padding:10px;border-left:0;border-right: 0;text-align: center;">

                @can('view_users')
                    <a  class="easyui-linkbutton"
                        data-options="size:'large',width:'100px', iconCls:'icon-large-user', iconAlign:'top'"
                        onclick="javascript:$('#settings-center-panel').panel({href:'/cp/users'});">
                        Users
                    </a>
                @endcan

                @can('view_roles_and_permissions')
                    <a  class="easyui-linkbutton"
                        data-options="size:'large',width:'100px', iconCls:'icon-large-permission', iconAlign:'top'"
                        onclick="javascript:$('#settings-center-panel').panel({href:'/cp/roles'});">
                        Permissions
                    </a>
                @endcan

                @can('view_activities')
                    <a  class="easyui-linkbutton"
                        data-options="size:'large',width:'100px', iconCls:'icon-large-camera', iconAlign:'top'"
                        onclick="javascript:$('#settings-center-panel').panel({href:'/cp/activities'});">
                        Activities
                    </a>
                @endcan



            </div>

            <div data-options="region:'center',border:false" id="settings-center-panel">
                <div class="screen-centered-text">
                    <img src="/img/dock/settings.svg" style="width:30%;opacity: 0.05" alt="home">
                </div>
            </div>


        </div>

        <style media="screen">
          #setting-buttons .easyui-linkbutton{
              margin: 0  5  px;
          }
        </style>
