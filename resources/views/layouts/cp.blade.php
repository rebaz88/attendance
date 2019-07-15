<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/png" href="{{asset('icon.png')}}"/>


    <title>{{ config('app.name', 'ngo') }}</title>

    <!-- Scripts -->
    <script type="text/javascript" src="{{asset('jeasyui/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/jquery.edatagrid.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/datagrid-filter.customized.js')}}"></script>
    {{-- <script type="text/javascript" src="{{asset('jeasyui/jquery.portal.js')}}"></script> --}}
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/lodash.min.js')}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.2/dist/Chart.min.js"></script> --}}
    <script type="text/javascript" src="{{asset('jeasyui/jeasyui.customized.js')}}"></script>
    <script type="text/javascript" src="{{asset('jeasyui/edatagrid.customized.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/application.custom.js')}}"></script>


    <!-- Styles -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet"> --}}
    {{--  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">  --}}
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/default/easyui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/themes/color.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('jeasyui/demo/demo.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/dock.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/application.custom.css')}}">

</head>
<body>

    {{-- Dashboard Layout --}}
    <div class="easyui-layout" fit="true">

        {{-- North panel of dashboard --}}
        <div data-options="region:'north', height:'100px'" style="background:#b7d2ff;">
            <div class="easyui-layout" fit="true">
                @auth
                    <div data-options="region:'west', width:'30%', border:false" style="background:#b7d2ff;padding:30px;font-size:15px;">
                        <label>
                                <i class="fas fa-user"></i> {{ucfirst(Auth::user()->name)}}
                                <span style="margin-right:10px;"></span>
                                <i class="far fa-calendar-alt"></i> {!! date("d-m-Y") !!}
                                <span style="margin-right:10px;"></span>
                        </label>
                    </div>
                    <div data-options="region:'east', width:'30%', border:false" style="background:#b7d2ff;padding:25px;text-align:right;">

                            <a href="{{ route('cp_logout') }}"
                                class="easyui-linkbutton c6"
                                data-options="size:'large',width:'120px'">
                                Logout
                            </a>

                            <a  class="easyui-linkbutton c5"
                                onclick="switchMainPanelTab('Change password', '/cp/chgpwd')"
                                data-options="size:'large',width:'140px'">
                                Change password
                            </a>

                    </div>
                @endauth
                <div data-options="region:'center', border:false" style="overflow:hidden;background:#b7d2ff;">
                    <h1 style="font-size:30px;text-align: center;padding:10px;font-weight:bold;">{{ env('APP_TITLE', 'NGO')}}</h1>
                </div>
            </div>

        </div>

        @auth
            {{-- South panel of dashboard --}}
            <div data-options="region:'south', border:false, height:'57px'">

                {{-- Dock Panel --}}
                <div id="dock-container">
                    <div id="dock">
                        <ul style="padding:0 10px 0 5px;margin:3px">
                            <li><span>Home</span><a href="#" onclick="switchMainPanelTab('Home', '')"><img src="/img/dock/home.svg" alt="home" /></a></li>

                            @can('view_settings')
                            <li><span>Settings</span><a href="#" onclick="switchMainPanelTab('Settings', '/cp/settings')"><img src="/img/dock/settings.svg" alt="Settings" /></a></li>
                            @endcan


                        </ul>
                    </div>
                </div>
                {{-- /Dock Panel --}}

            </div>
            {{-- /South panel of dashboard --}}
        @endauth



        {{-- Center panel of dashboard --}}
        <div data-options="region:'center', border:false" style="border-left:0;border-right:0;border-top:0;">

            <div class="easyui-tabs" id="MainPanelTab" fit="true" showHeader="false"
                data-options="border:false,showHeader:false">

                @yield('content')


            </div>


        </div>
        {{-- /Center panel of dashboard --}}



    </div>
    {{-- /Dashboard Layout --}}




    <script>

        function switchMainPanelTab(title, url) {

            var tabExists = $('#MainPanelTab').tabs('exists', title);

            if(tabExists){

                $('#MainPanelTab').tabs('select', title);

            } else {

                // add a new tab panel
                $('#MainPanelTab').tabs('add',{
                    title: title,
                    href: url,
                });

            }

            return

        }

        // set header for ajax calls
        $(function(){

            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Accept' : 'application/json',
                },
            });

            window.CSRF_TOKEN = csrf_token

            $(document).ajaxError(function(event, xhr, settings) {

                var response = eval('(' + xhr.responseText + ')');

                switch (xhr.status) {

                    case 401:
                        $.messager.alert({
                            title: 'Warning',
                            msg: 'Session expired! please login again',
                            icon: 'warning',
                            fn: function() {
                                document.location.href = '/';
                            },
                        });
                    break;

                    case 422:
                        $.messager.alert('Error', response.msg, 'error');
                    break;

                    case 403:
                        $.messager.alert('Error', response.error, 'error')
                    break;
                }

                $.messager.progress('close');
            });

        });
        // set header for ajax calls
        {{-- $(function(){

            const csrf_token = $('meta[name="csrf-token"]').attr('content');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf_token
                }
            });

            window.CSRF_TOKEN = csrf_token

        }); --}}


    </script>

    <style>
        .tabs-header-noborder{
            padding:0;
        }
    </style>

</body>
</html>
