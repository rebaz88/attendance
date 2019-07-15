@extends('layouts.cp')
@section('content')
    <div title="Home" style="text-align:center;">


      <div class="easyui-layout" fit="true">


        <div data-options="region:'center'" id="homeholder">

          <h1 class="not-agent-title">
            {{ env('APP_TITLE', 'NGO') }}
          </h1>

        </div>

      </div>


    </div>

    <style media="screen">

      #homeholder{
          border: 0;
          overflow: hidden;
          /* background: url('/img/datagrids/home.png') no-repeat center; */
      }


      .agent-title, .not-agent-title {
        font-size:50px;
         color:green;
         font-weight: bolder;
         height:80%;
         display: flex;
         justify-content: center;
         flex-direction: column;
         text-align: center;
      }
      .not-agent-title {
        color:red;
      }

    </style>

@endsection
