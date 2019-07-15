<div class="easyui-layout" fit="true">

  <div id="displayRoleBar" data-options="region:'north',border:false" style="height:50px;text-align:center;padding:10px;font-size:20px;background:#eee;">
      @if(!empty($role))
        {!! $role->name !!}
      @else
        ---
      @endif
  </div>

  <div data-options="region:'south',border:false" style="height:50px;border-top:1px solid #95B8E7;text-align:center;padding:10px;">

    <a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-save" onclick="savePermissions()" style="width:100px;">Save</a>

  </div>

  <div id="PermissionsPage" data-options="region:'center',border:false">


    <form method="post" style="width:100%;height:100%" id="PermissionsForm">


      <table PermissionTable id="PermissionsDatagrid">

          <thead>
            <tr>
              <th  style="padding:10px 20px;background:#E0ECFF;  ">Section</th>
              <th colspan="6" style="padding:10px 20px;background:#E0ECFF;  ">Operation</th>
            </tr>
          </thead>

          <tbody>
              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_dashboard">Student Dashboard</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_student_dashboard">View</td>
              </tr>
              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_quota_dashboard">Quota Dashboard</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_quota_dashboard">View</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_telefon">Telefon</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_telefon">View</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_telefon">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_telefon">Edit</td>
                  <td colspan="3"><input type="checkbox" class="permission-checkbox" name="remove_telefon">Remove</td>
              </tr>

               <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_quota">Quota</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_quota">View</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_money_transfer">Money Transfer</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_money_transfer">View</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_money_transfer">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_money_transfer">Edit</td>
                  <td colspan="3"><input type="checkbox" class="permission-checkbox" name="remove_money_transfer">Remove</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_office">Office</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_office">View</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_expenses">Expenses</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_expenses">View</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_expenses">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_expenses">Edit</td>
                  <td colspan="3"><input type="checkbox" class="permission-checkbox" name="remove_expenses">Remove</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_promotions">Promotion</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_promotions">View</td>
              </tr>



              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_website">Website</td>
                  <td colspan="6"><input type="checkbox" view class="permission-checkbox" name="view_website">View</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_hisabat">Hisabat</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_hisabat">View</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="see_other_branches_hisabat">View other branches</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_hisabat">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_hisabat">Edit</td>
                  <td colspan="3"><input type="checkbox" class="permission-checkbox" name="remove_hisabat">Remove</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_users">Users</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_users">View</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_user">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_user">Edit</td>
                  <td colspan="3"><input type="checkbox" class="permission-checkbox" name="remove_user">Remove</td>
              </tr>

              <tr>
                <td colspan="7" style="text-align:center;padding:10px;">Student information</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_students">Students</td>
                  <td><input type="checkbox" view class="permission-checkbox" name="view_students">View</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_student">Edit</td>
                  <td><input type="checkbox" class="permission-checkbox" name="remove_student">Remove</td>
                  <td><input type="checkbox" class="permission-checkbox" name="archive_student">Archive</td>
                  <td><input type="checkbox" class="permission-checkbox" name="set_student_priority">Set Priority</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_application">Student Application</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student_application">New Application</td>
                  <td><input type="checkbox" class="permission-checkbox" name="remove_student_application">Remove Application</td>
                  <td><input type="checkbox" class="permission-checkbox" name="transfer_application">Transfer Application</td>
                  <td><input type="checkbox" class="permission-checkbox" name="reset_password">Reset Password</td>
                  <td colspan="2"><input type="checkbox" class="permission-checkbox" name="download_student_data">Download Student Data</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_documents">Student Documents</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student_document">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="remove_student_document">Remove</td>
                  <td colspan="4"><input type="checkbox" class="permission-checkbox" name="download_student_documents">Donwload Documents</td>
              </tr>

              {{-- <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_missing_documents">Student Missing Documents</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student_missing_document">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="save_student_missing_document">Save</td>
                  <td colspan="4"><input type="checkbox" class="permission-checkbox" name="remove_student_missing_document">Remove</td>
              </tr> --}}

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_payments">Student Payments</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student_payment">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_student_payment">Edit</td>
                  <td colspan="4"><input type="checkbox" class="permission-checkbox" name="remove_student_payment">Remove</td>
              </tr>

              <tr>
                  <td><input type="checkbox" main class="permission-checkbox" name="view_student_refunds">Student Refunds</td>
                  <td><input type="checkbox" class="permission-checkbox" name="add_student_refund">Add</td>
                  <td><input type="checkbox" class="permission-checkbox" name="edit_student_refund">Edit</td>
                  <td colspan="4"><input type="checkbox" class="permission-checkbox" name="remove_student_refund">Remove</td>
              </tr>




          </tbody>
      </table>


    </form>


  </div>

</div>


<script type="text/javascript">

  var oldPermissions = {!! $permissions !!};
  var role_id;

  $(function() {

    $('#PermissionsPage :input[type="checkbox"]').change(function(){
        handlePermissionCheck();
      });

      $('form#PermissionsForm :input[type="checkbox"]').each(function(){

        if(oldPermissions.indexOf($(this).prop('name')) >= 0)
          $(this).prop('checked', true);

      });

  });



  function handlePermissionCheck() {
    var $el = $(event.target);
    var isMain = $el.is("[main]");
    var isView = $el.is("[view]");
    var checkboxState = $el.prop('checked');
    // console.log($el.prop('checked'));

    var parentRow = $el.closest('tr')

    var inputs = [];

    parentRow.find("td input:checkbox").each(function(index) {

        inputs.push($(this));

    });

    if(isMain){
      changeAllBoxes(inputs, checkboxState);
    }
    else if (isView) {
      if (checkboxState == false) {
        changeAllBoxes(inputs, checkboxState);
      } else {
        inputs[0].prop('checked', checkboxState);
      }
    } else if (checkboxState == true){ // all other controls
      inputs[0].prop('checked', true);
      inputs[1].prop('checked', true);
    }

  }

  function changeAllBoxes(inputs, checkboxState) {
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].prop('checked', checkboxState);
    }
  }


  function savePermissions(){

    $('#PermissionsForm').form('submit',{
      url: 'cp/permissions/{!! $role->id !!}/save',
      onSubmit: function(param){
        param._token = window.Rony.csrfToken;
      },
      success: function(result){
        var result = eval('('+result+')');
        if (result.msg){
          showMessageDialog('Error', result.msg)
        } else {
          showMessageDialog('Success', 'Operation performed successfully!')
        }
      }
    });
  }

</script>

<style media="screen">

  #PermissionsDatagrid{
    width: 100%;
  }

  .permission-checkbox {
    margin: 10px 10px 10px 20px !important;
  }

  #PermissionsPage td{
    border-bottom: 1px solid #ddd;
  }

  #PermissionsPage td:nth-child(1) {
    background:#b76e6e;
    color:white;
    border-bottom: 1px solid #ddd;
  }

  #PermissionsPage td[field="title"]{
    background: red;
    color: white;
  }
</style>
