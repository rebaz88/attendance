
<table id="ActivitiesDatagrid"></table>

<script type="text/javascript">
	$(function(){
		$('#ActivitiesDatagrid').datagrid({
			idField:'id',
			title:'Ativities',
		    fit:true,
		    fitColumns:true,
		    singleSelect:true,
		    method:'get',
		    rownumbers:true,
		    url:'/cp/activities/list',
		    pagination:true,
		    remoteFilter:true,
      		filterMatchingType:'any',
			columns: [
				[{
						field: 'users.name',
						title: 'Username',
						width: 100,
					},
					{
						field: 'properties',
						title: 'Target',
						width: 100,
						formatter: formatModelActivityName,
					},
					{
						field: 'subject_id',
						title: 'Target ID',
						width: 100,
					},
					{
						field: 'description',
						title: 'Description',
						width: 100,
					},
					{
						field: 'created_at',
						title: 'Time',
						width: 100,
						align: 'center',
						as: 'activity_log.created_at'
					},
				]
			]
		});

		$('#ActivitiesDatagrid').datagrid('enableFilter', [
			{
				field:'created_at',
				type:'dateRange',
				op: 'between'				
			},
		]);
	});


	function formatModelActivityName(value, row) {
		if(row.properties)
			return row.properties.model_activity_name;
		return '---'
	}



</script>
