@extends('layouts.cp')
@section('content')

    <table style="margin:auto;padding:20px;">
        <tr>
            <td>
                <div class="easyui-panel" title="Login" style="width:350px;padding:10px;height:200px;">
                    <div class="easyui-layout" fit="true">
                        <form class="easyui-form" id="LoginForm" method="POST" novalidate style="padding:0;">
                            @csrf
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="fitem" style="margin:10px;">
                                <input type="text" name="email" id="email" class="easyui-textbox" label="Email:" required="true" validType="email" style="width:300px;">
                            </div>
                            <div class="fitem" style="margin:10px;">
                                <input type="password" name="password" id="password" class="easyui-passwordbox" label="Password:" required="true" style="width:300px;">
                            </div>
                            <div style="margin:20px 15px 20px 0;text-align:center;">
                                <a href="#" class="easyui-linkbutton c5"  onClick="login()" style="width:120px;">Login</a>
                            </div>

                        </form>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <script>
        $(function() {
            $('#LoginForm #email,#LoginForm #password').each(function() {

                $(this).textbox('textbox')
                    .bind('keydown', function(e) {
                        if(e.keyCode == 13) {
                            login();
                        }
                    });
            });

        });
        function login() {

            $('#LoginForm').form('submit', {
                url: '{{ route('cp_login') }}',
                onSubmit: function(){
                    return $(this).form('validate');
                },
                success:function(result){
                    try {
                        result = JSON.parse(result);
                        if(!result.isError) {
                            {{--  $.messager.show({title:'Info', msg:'Logged in successfully!'});  --}}
                            location.href = '/cp';
                        }
                    } catch (e) {
                        return false;
                    }
                }
            });
        }
    </script>

@endsection
