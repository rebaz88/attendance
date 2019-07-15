<table style="margin:auto;padding:20px;">
    <tr>
        <td>
            <div class="easyui-panel" title="Change Password" style="width:390px;height:200px;">
                <div class="easyui-layout" fit="true">
                    <div data-options="region:'center', border:false">
                        <form id="change-password-form" method="POST" novalidate action="{{ route('cp_chgpwd') }}" style="padding:0;">
                            @csrf

                            <div class="fitem" style="margin:10px;">
                                <input name="current-password" class="easyui-passwordbox" label="Current password:" labelWidth="160px" required="true" style="width:350px;">
                            </div>
                            <div class="fitem" style="margin:10px;">
                                <input name="new-password" id="new-password" class="easyui-passwordbox" label="New password:" labelWidth="160px" required="true" style="width:350px;">
                            </div>
                            <div class="fitem" style="margin:10px;">
                                <input name="new-password_confirmation" class="easyui-passwordbox" label="Confirm new password:"  labelWidth="160px" required="true" validType="equals['#new-password']" style="width:350px;">
                            </div>
                        </form>
                    </div>
                    <div data-options="region:'south', border:false" style="padding-left:95px;height:35px;margin-left:75px;">
                        <a href="#" class="easyui-linkbutton c5"  onClick="changePwd()" style="width:140px;">Change password</a>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>

<script>
    function changePwd() {

        $('#change-password-form').form('submit', {
            onSubmit: function(){
                return $('#change-password-form').form('validate');
            },
            success:function(result){
                try {
                    result = JSON.parse(result);
                    if(!result.isError) {
                        $.messager.alert({
                            title: 'Info',
                            msg: 'Password changed successfully!',
                            fn: function(){
                                location.reload();
                            }
                        });
                    }
                } catch (e) {
                    return false;
                }
            }
        });
    }
</script>

