function formatAttachments(attachments, row) {
  if(!row.is_footer) {
    if(Array.isArray(attachments))
      if(attachments.length > 0)
        return attachments.map(function(attachment){return '<a href="' + attachment + '" target="_blank ">Attachment</a>'});

    return (attachments) ? attachments : '---';
  }
}

function isDatagridRowSelected(id, rowType) {
  var row = $('#' + id).datagrid('getSelected');
  if(row) {
    return row;
  } else {
    $.messager.show({ title: 'Error', msg: 'Please select a ' + rowType});
  }
}

function openDialogWithUrl(id, url, title) {
  $('#' + id).dialog('open');

  if(typeof title !== 'undefined')
    $('#' + id).dialog('setTitle', title);

  $('#' + id).dialog('refresh', url);
}

function onChangeDatagridFilterConrols(datagrid, filter, value, op) {
  if (value == ''){
      $('#' + datagrid).datagrid('removeFilterRule', filter);
  } else {
      $('#' + datagrid).datagrid('addFilterRule', {
          field: filter,
          value: value,
          op: (typeof op !== 'undefined') ? op : 'like',
      });
  }
  $('#' + datagrid).datagrid('doFilter');
}

function datagridFilterByDate(holder, datagrid, field) {

   var filter_from = $('#' + holder + ' #filter_from').datebox('getValue') || '01-01-2010';
   var filter_to = $('#' + holder + ' #filter_to').datebox('getValue') || '01-01-2100';

   $('#' + datagrid).datagrid('addFilterRule', {
     field: field,
     filter_from: filter_from,
     filter_to: filter_to
    });

    $('#' + datagrid).datagrid('doFilter');

 }

 function clearDatagridFilterByDate(holder, datagrid, field) {
   $('#' + holder + ' #filter_from').datebox('setValue', '');
   $('#' + holder + ' #filter_to').datebox('setValue', '');
   onChangeDatagridFilterConrols(datagrid, field, '');
 }

 function reloadBranGroupsAndColors(editor, brandEditor,groupEditor, colorEditor) {
    var value = editor.combobox('getValue');
    var brand = brandEditor.combobox('getValue');
    var group = groupEditor.combobox('getValue');
    var color = colorEditor.combobox('getValue');

    switch(editor) {

      case brandEditor:
        groupEditor.combobox('reload', '/items/list-item-groups?brand=' + brand);
        colorEditor.combobox('setValue', '');

      case groupEditor:
        colorEditor.combobox('reload', '/items/list-item-colors?brand=' + brand + '&group=' + group);
    }
  }

/**
 * style footer total in payments and sales
 * @param {*} value of cell
 * @param {*} row of the datagrid
 * @param {*} index index of the row
 */
function totalFooterCellFormatter(value, row, index) {
  if (row.is_footer) {
    return '<div style="width:100%;margin:0 -5px;background-color:#ffee00;font-size:35px;padding:10px;">' + value + '</div>';
  }
  return value;
}


$.extend($.fn.datagrid.defaults.filters, {
  dateRange: {
    init: function (container, options) {
      var input = $('<input>').appendTo(container);
      input.combobox({
        panelWidth: 220,
        panelHeight: 275,
        selectOnNavigation: false,
        onShowPanel: function () {
          // var dd = input.combobox('getText').split(',');
          // var d1 = $.fn.datebox.defaults.parser(dd[0]);
          // var d2 = $.fn.datebox.defaults.parser(dd[1]);
          // var p = input.combobox('panel');
          // p.find('.c1').datebox('setValue', d1);
          // p.find('.c2').datebox('setValue', d2);
          // p.find('.c1').datebox('setValue', '01-01-2019');
        }
      });
      var p = input.combobox('panel');
      p.css({padding: '0 10px'})

      $('<p><input class="c1" style="width:100%;"></p><p><input class="c2" style="width:100%;"></p>').appendTo(p);
      var c1 = p.find('.c1').datebox();
      var c2 = p.find('.c2').datebox();

      var footer = $('<div style="position:absolute;bottom:0;left:0px;width:100%;border: 1px solid #95B8E7;text-align:center;padding:0px;background:#eee;"></div>').appendTo(p);
      // var footer = $('<div></div>').appendTo(p);

      var yesterday = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Yesterday</a>').appendTo(footer);
      yesterday.linkbutton({});
      yesterday.bind('click', function () {
        var yesterday = moment().subtract(1, 'days').format("DD-MM-YYYY");
        c1.datebox('setValue', yesterday)
        c2.datebox('setValue', yesterday)
      })

      var today = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Today</a>').appendTo(footer);
      today.linkbutton({});
      today.bind('click', function () {
        var today = moment().format("DD-MM-YYYY");
        c1.datebox('setValue', today)
        c2.datebox('setValue', today)
      })

      var lastWeek = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Last week</a>').appendTo(footer);
      lastWeek.linkbutton({});
      lastWeek.bind('click', function () {
        var startOfWeek = moment().subtract(1, 'week').startOf('week').subtract(1, 'day').format("DD-MM-YYYY");
        var endOfWeek = moment().subtract(1, 'week').endOf('week').subtract(2, 'day').format("DD-MM-YYYY");
        c1.datebox('setValue', startOfWeek)
        c2.datebox('setValue', endOfWeek)
      })

      var thisWeek = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">This Week</a>').appendTo(footer);
      thisWeek.linkbutton({});
      thisWeek.bind('click', function () {
        var thisWeek = moment().startOf('week').subtract(1, 'day').format("DD-MM-YYYY");
        var today = moment().format("DD-MM-YYYY");
        c1.datebox('setValue', thisWeek)
        c2.datebox('setValue', today)
      })

      var lastMonth = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Last month</a>').appendTo(footer);
      lastMonth.linkbutton({});
      lastMonth.bind('click', function () {
        var startOfMonth = moment().subtract(1, 'month').startOf('month').format("DD-MM-YYYY");
        var endOfMonth = moment().subtract(1, 'month').endOf('month').format("DD-MM-YYYY");
        c1.datebox('setValue', startOfMonth)
        c2.datebox('setValue', endOfMonth)
      })

      var thisMonth = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">This Month</a>').appendTo(footer);
      thisMonth.linkbutton({});
      thisMonth.bind('click', function () {
        var thisMonth = moment().startOf('month').format("DD-MM-YYYY");
        var today = moment().format("DD-MM-YYYY");
        c1.datebox('setValue', thisMonth)
        c2.datebox('setValue', today)
      })

      var btn = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Done</a>').appendTo(footer);
      btn.linkbutton({
        iconCls: 'icon-ok'
      });
      btn.bind('click', function () {
        var v1 = c1.datebox('getValue')
        var v2 = c2.datebox('getValue')
        var v = v1 + ',' + v2;
        input.combobox('setValue', v).combobox('setText', v);
        input.combobox('hidePanel');
        // var dg = container.closest('div.datagrid-view:first').children('table');
        // dg.datagrid('doFilter');
      })

      var clear = $('<a href="javascript:void(0)" style="margin:5px;width:95px;">Clear</a>').appendTo(footer);
      clear.linkbutton({
        iconCls: 'icon-reset'
      });
      clear.bind('click', function () {
        c1.datebox('setValue', '')
        c2.datebox('setValue', '')

        input.combobox('setValue', '').combobox('setText', '');
        input.combobox('hidePanel');
        // var dg = container.closest('div.datagrid-view:first').children('table');
        // dg.datagrid('doFilter');
      })

      return input;
    },
    destroy: function (target) {
      $(target).combobox('destroy');
    },
    getValue: function (target) {
      var p = $(target).combobox('panel');
      var v1 = p.find('.c1').datebox('getValue')
      var v2 = p.find('.c2').datebox('getValue')
      // var v1 = $.fn.datebox.defaults.formatter(p.find('.c1').datebox('options').current);
      // var v2 = $.fn.datebox.defaults.formatter(p.find('.c2').datebox('options').current);
      return v1 + ',' + v2;
    },
    setValue: function (target, value) {
      var dd = value.split(',');
      var d1 = dd[0];
      var d2 = dd[1];
      var p = $(target).combobox('panel');
      p.find('.c1').datebox('setValue', d1);
      p.find('.c2').datebox('setValue', d2);
      $(target).combobox('setValue', value).combobox('setText', value);
    },
    resize: function (target, width) {
      $(target).combobox('resize', width);
    }
  }
});

$.extend($.fn.datagrid.defaults.operators, {
  between: {
    text: 'Between',
    isMatch: function (source, value) {
      var dd = value.split(',');
      var d1 = dd[0];
      var d2 = dd[1];
      var d = $.fn.datebox.defaults.parser(source);
      return d1 <= d2;
    }
  }
});


var ID = function () {
  // Math.random should be unique because of its seeding algorithm.
  // Convert it to base 36 (numbers + letters), and grab the first 9 characters
  // after the decimal.
  return '_' + Math.random().toString(36).substr(2, 9);
};

function print(url) {
  $("<iframe>").hide().attr("src", url).appendTo("body");
}

/**
 * Number.prototype.format(n, x)
 * 
 * @param integer n: length of decimal
 * @param integer x: length of sections
 */
Number.prototype.format = function (n) {
  return _.ceil(this, n);
};

// important! do not remove this piece
function BrandPiece(pieces) {
  this.pieces = pieces;
}


let FilterByDate = class {
  constructor(datagridId) {
    this.datagridId = datagridId;
    this.datagrid = $('#' + datagridId);
    this.form = $('#' + datagridId + 'DateFilterForm');
  }

  filter() {
    var isValid = this.form.form('validate');

    if (!isValid) return;

    var dateFrom = $('#from', this.form).datebox('getValue');
    var dateTo = $('#to', this.form).datebox('getValue');

    if(!(dateFrom) && !(dateTo)) return;
    
    if(!(dateFrom)) dateFrom = '1-1-2010';
    if(!(dateTo)) dateTo = moment().format('DD-MM-YY');

    this.datagrid.datagrid('addFilterRule', {
      field: 'date',
      op: 'between',
      value: dateFrom + ',' + dateTo,
    });

    this.datagrid.datagrid('doFilter');
  }

  reset() {
    this.form.form('clear');

    this.datagrid.datagrid('removeFilterRule', 'date');

    this.datagrid.datagrid('doFilter');
  }
};




