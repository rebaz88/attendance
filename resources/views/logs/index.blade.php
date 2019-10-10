
<table id="LogsDatagrid"></table>

<div id="LogsDatagridToolbar" style="padding:5px;text-align:center;">

    <a href="#" class="easyui-linkbutton c5"  onclick="importLogs()">Import</a>

</div>

<script>


  $(function(){

    $('#LogsDatagrid').datagrid({
      title:'Logs',
      toolbar: '#LogsDatagridToolbar',
      fit:true,
      nowrap:false,
      fitColumns:true,
      singleSelect:true,
      method:'get',
      rownumbers:true,
      pagination:true,
      url:'/cp/logs/list',
      remoteFilter:true,
      filterMatchingType:'any',
      columns: [
				[
          {
						field: 'PIN',
						title: 'Pin',
						width: 120,
					},
          {
						field: 'DateTime',
						title: 'Time',
						width: 120,
					},
					{
						field: 'Status',
						title: 'Status',
						width: 120,
					},
				]
			]

    })

    $('#LogsDatagrid').datagrid('enableFilter');

  })

  function importLogs() {
    
    $.messager.progress({
        title:'Please waiting',
        msg:'Importing data...'
    });

    $.get( "cp/logs/import", function( data ) {
      $.messager.progress('close');
    }, "json" );
  }



 

</script>
