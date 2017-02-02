var QUERIES = {};
var CURRENT_QUERY = null;
var FIELDSETS = {};
var CURRENT_FIELDSET = null;
var CURRENT_COLS = [];

var COLS = [];
var _COLS = {};
var LISTS = {};
var _LISTS = [];
var PAGE_NAME = null;
var API_DATA = [];
var ROWID_NAME = null;

find_API_DATA = function(rowid){
  rowid = parseInt(rowid);
  result = null;
  $.each(API_DATA, function(key, row){
    if (row[_ROW_ID] && row[_ROW_ID]==rowid){
      result = row;
      return false;
    }
  });
  return result;
}

// +++++++++++++ QUERIES +++++++++++++ \\

draw_query_options = function(){
  ul = $("#QUERY-DROPDOWN");

  if (CURRENT_QUERY && QUERIES[CURRENT_QUERY]){
    li = $("<li>").addClass("QUERY-SAVE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-floppy-o fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; &nbsp;&nbsp; SAVE");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("QUERY-NEW");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-plus fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp;&nbsp;&nbsp; SAVE AS..");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("QUERY-DELETE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-trash-o fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp;&nbsp;&nbsp; DELETE");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("QUERY-CLEAR");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-times fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp;&nbsp;&nbsp; CLEAR");
    $(li).append(a);
    $(ul).append(li);
  }else{
    li = $("<li>").addClass("QUERY-NEW");
    a = $("<a>").attr({ "href":"#", "id": "QUERY-SELECTED" })
    icon = $("<i>").addClass("fa fa-plus fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp;&nbsp;&nbsp; SAVE AS..");
    $(li).append(a);
    $(ul).append(li);
  }
}

draw_queries = function(){
  ul = $("#QUERY-DROPDOWN");
  $(ul).empty();

  divider = $("<li>").addClass("divider");

  if (CURRENT_QUERY && QUERIES[CURRENT_QUERY]){
    qname = QUERIES[CURRENT_QUERY]["QUERY_NAME"];
  }else{
    qname = "SAVED QUERIES";
  }
  header = $("<h6>").addClass("dropdown-header").append(qname);
  $(header).css("margin-bottom","0px");
  li = $("<li>").append(header);
  $(ul).append(li);

  $(ul).append($(divider).clone());

  draw_query_options();

  $(ul).append($(divider).clone());

  var tot = 0;
  $.each(QUERIES, function(key,query){
    tot += 1;
    qname = query["QUERY_NAME"];
    qid = query["QUERY_ID"]
    li = $("<li>");
    a = $("<a>").attr("href","#");
    $(a).attr("QUERY-ID",qid);
    $(a).addClass("QUERY-SELECT");
    $(a).text(qname);
    $(li).append(a);
    $(ul).append(li);
  });
  if (tot <= 0){
    footer = $("<h6>").addClass("dropdown-header").append("N/A");
    $(footer).css("margin-bottom","0px");
    li = $("<li>").append(footer);
    $(ul).append(li);
  }
}

clear_query = function(){
    CURRENT_QUERY = null;
    draw_queries();
    $("#PAGE-SEARCH").val("");
    load_table();
}

load_query_callback = function(data) {
  if (api_success(data)) {
    QUERIES = {};
    $.each(data.data, function(key, query){
      query_id = query["QUERY_ID"];
      QUERIES[query_id] = query;
    });
    draw_queries();
  }
}

load_queries = function() {
  api("QUERY/list", {
    "QUERY_CONTEXT": _API_CONTEXT,
    "QUERY_CONTEXT_ID": _API_CONTEXT_ID,
  }, load_query_callback);
}

select_query = function(){
  if (this) {
    qid = $(this).attr("QUERY-ID");
    qname = QUERIES[qid]["QUERY_NAME"];
    query = QUERIES[qid]["QUERY_QUERY"];
    CURRENT_QUERY = qid;
    $('#PAGE-SEARCH').val(query);
    draw_queries();
    $('#PAGE-SEARCH').change();
  }
}

save_query_callback = function(data){
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    load_queries();
  }
}

save_query = function(){
  var data = {
    "QUERY_QUERY": $("#PAGE-SEARCH").val(),
    "rowid": CURRENT_QUERY
  }
  api("QUERY/save", data, save_query_callback);
}

save_as_query_callback = function(data){
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    if (data.meta.rowid) {
      CURRENT_QUERY = data.meta.rowid;
    }
    load_queries();
  }
}

save_as_query = function(){
  haxGet("QUERY NAME", "NEW_QUERY", function(query_name) {
    if (query_name) {
      var data = {
        "QUERY_CONTEXT": _API_CONTEXT,
        "QUERY_CONTEXT_ID": _API_CONTEXT_ID,
        "QUERY_NAME": query_name,
        "QUERY_QUERY": $("#PAGE-SEARCH").val(),
      }
      api("QUERY/new", data, save_as_query_callback);
    }
  });
}

delete_query_callback = function(data){
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    CURRENT_QUERY = null;
    load_queries();
  }
}

delete_query = function(){
  qname = QUERIES[CURRENT_QUERY]["QUERY_NAME"]
  alertify.confirm("Are you sure you want to delete:<br/><strong>" + qname + "</strong>", function() {
    api("QUERY/delete", {
      "rowid": CURRENT_QUERY
    }, delete_query_callback);
  });
}

// ------------- QUERIES ------------- \\

// +++++++++++++ FIELDSETS +++++++++++++ \\

draw_fieldset_options = function(){
  ul = $("#FIELDSET-DROPDOWN");

  if (CURRENT_FIELDSET && FIELDSETS[CURRENT_FIELDSET]){
    fname = FIELDSETS[CURRENT_FIELDSET]["FIELDSET_NAME"]

    li = $("<li>").addClass("FIELDSET-SAVE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-floppy-o fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; SAVE");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-NEW");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-plus fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; SAVE AS..");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-DELETE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-trash-o fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; DELETE");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-CLEAR");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-times fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; CLEAR");
    $(li).append(a);
    $(ul).append(li);
  }else{
    li = $("<li>").addClass("FIELDSET-NEW");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-plus fa-fw");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; save as..");
    $(li).append(a);
    $(ul).append(li);
  }
}

draw_fieldsets = function(){
  ul = $("#FIELDSET-DROPDOWN");
  $(ul).empty();

  divider = $("<li>").addClass("divider");

  header = $("<h6>").addClass("dropdown-header").append("SAVED FIELDSETS");
  $(header).attr({ "id": "CURRENT-FIELDSET" });
  $(header).css("margin-bottom","0px");
  li = $("<li>").append(header);
  $(ul).append(li);

  $(ul).append($(divider).clone());

  draw_fieldset_options();

  $(ul).append($(divider).clone());

  var tot = 0;
  $.each(FIELDSETS, function(key,fieldset){
    tot += 1;
    fname = fieldset["FIELDSET_NAME"];
    fid = fieldset["FIELDSET_ID"];
    if (CURRENT_FIELDSET == fid){
      $("#CURRENT-FIELDSET").html(fname);
    }else{
      li = $("<li>");
      a = $("<a>").attr("href","#");
      $(a).attr("FIELDSET-ID",fid);
      $(a).addClass("FIELDSET-SELECT");
      $(a).text(fname);
      $(li).append(a);
      $(ul).append(li);
    }
  });
  if (tot <= 0){
    footer = $("<h6>").addClass("dropdown-header").append("N/A");
    $(footer).css("margin-bottom","0px");
    li = $("<li>").append(footer);
    $(ul).append(li);
  }
}

clear_fieldset = function(){
    CURRENT_FIELDSET = null;
    draw_fieldsets();
    CURRENT_COLS = [];
    draw_table();
}

load_fieldset_callback = function(data) {
  if (api_success(data)) {
    FIELDSETS = {};
    if (data.data) {
      $('#FIELDSET-DROPDOWN').empty();
      $.each(data.data, function(key, fieldset) {
        FIELDSETS[fieldset["FIELDSET_ID"]] = fieldset;
      });
    }
    draw_fieldsets();
  }
}

select_fieldset = function() {
  if (this) {
    fid = $(this).attr("FIELDSET-ID");
    fname = FIELDSETS[fid]["FIELDSET_NAME"];
    CURRENT_FIELDSET = fid;
    CURRENT_COLS = FIELDSETS[fid]["COLS"];
    $('#CURRENT_FIELDSET').text(fname);
    draw_table();
  }
}

save_fieldset_callback = function(data) {
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    load_fieldsets();
  }
}

save_fieldset = function() {
  var data = {
    "COLS": CURRENT_COLS,
    "rowid": CURRENT_FIELDSET
  }
  api("FIELDSET/save", data, save_fieldset_callback);
}

save_as_fieldset_callback = function(data) {
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    if (data.meta.rowid) {
      CURRENT_FIELDSET = data.meta.rowid;
    }
    load_fieldsets();
  }
}

save_as_fieldset = function() {
  haxGet("FIELDSET NAME", "NEW_FIELDSET", function(fieldset_name) {
    if (fieldset_name) {
      var data = {
        "FIELDSET_CONTEXT": _API_CONTEXT,
        "FIELDSET_CONTEXT_ID": _API_CONTEXT_ID,
        "FIELDSET_NAME": fieldset_name,
        "COLS": CURRENT_COLS,
      }
      api("FIELDSET/new", data, save_as_fieldset_callback);
    }
  });
}

delete_fieldset_callback = function(data) {
  if (api_success(data)) {
    if (data.message) {
      haxSay(data.message);
    }
    CURRENT_FIELDSET = null;
    load_fieldsets();
  }
}

delete_fieldset = function() {
  fname = FIELDSETS[CURRENT_FIELDSET]["FIELDSET_NAME"]
  alertify.confirm("Are you sure you want to delete:<br/><strong>" + fname + "</strong>", function() {
    api("FIELDSET/delete", {
      "rowid": CURRENT_FIELDSET
    }, delete_fieldset_callback);
  });
}

load_fieldsets = function() {
  api("FIELDSET/list", {
    "FIELDSET_CONTEXT": _API_CONTEXT,
    "FIELDSET_CONTEXT_ID": _API_CONTEXT_ID,
  }, load_fieldset_callback);
}

cols_edit_callback = function(data) {
  $('#haxdb-fieldset-modal .modal-title').html("COLS: " + _API);

  table = $("<table>").addClass("table table-striped table-bordered tablesorter tablesorter-default");
  tbody = $("<tbody>");
  $.each(COLS, function(key, col) {
    tr = $("<tr>");
    id = "COLS-EDIT-COL-" + col["NAME"];
    checkbox = $("<input>").attr("type", "checkbox").attr("id", id);
    $(checkbox).attr("colname", col["NAME"]);
    if (CURRENT_COLS.indexOf(col["NAME"]) >= 0) {
      $(checkbox).attr("checked", true);
    }
    $(checkbox).addClass("COLS-EDIT-CHECKBOX");
    $(checkbox).attr("COLS-COL", col);
    $("<td>").html(checkbox).appendTo(tr);
    $("<td>").html(col["HEADER"]).addClass("CHECKBOX-CLICK").attr("CHECKBOX-TARGET", id).appendTo(tr);
    tbody.append(tr);
  });

  table.append(tbody);
  $('#haxdb-fieldset-modal .modal-body').html(table);

  $('#haxdb-fieldset-modal').modal();
}

// ------------- FIELDSETS ------------- \\


draw_table = function() {
  $('#loader').hide();
  $('#LIST-TABLE thead').empty();
  $('#LIST-TABLE').trigger("destroy");

  if (!CURRENT_COLS || CURRENT_COLS.length <=0){
    $.each(COLS, function(key,col){
      if (col["DEFAULT"] && col["DEFAULT"] == 1){
        CURRENT_COLS.push(col["NAME"])
      }
    });
  }

  tr = $('<tr>');

  total = 0;
  $.each(CURRENT_COLS, function(key, col) {
    if (_COLS[col]) {
      total += 1;
      header = _COLS[col]["HEADER"];
      th = $('<th>').html(header).attr("title", col);
      if (total > 2) {
        $(th).addClass("hidden-xs hidden-sm");
      }
      tr.append(th);
    }
  });

  th = $('<th>').addClass("empty").css({ "width": "1%" }).css("text-align", "center");
  $(th).attr({ "colspan":2, "data-sorter": "false" });

  grp = $("<div>").addClass("btn-group").css("width", "90px");

  subgrp = $("<div>").addClass("btn-group");
  button = $("<button>").addClass("btn dropdown-toggle haxdb-header-button");
  $(button).attr({ "data-toggle": "dropdown", "aria-haspopup": "true", "aria-expanded": "false" })
  $(button).attr({ "id": "FIELDSET-EDIT" })
  icon = $("<span>").addClass("fa fa-list");
  $(button).append(icon)
  $(subgrp).append(button);
  $(grp).append(subgrp);

  subgrp = $("<div>").addClass("btn-group");
  button = $("<button>").addClass("btn dropdown-toggle haxdb-header-button");
  $(button).attr({ "data-toggle": "dropdown", "aria-haspopup": "true", "aria-expanded": "false" })
  icon = $("<span>").addClass("fa fa-angle-down");
  $(button).append(icon);
  ul = $("<ul>").addClass("dropdown-menu dropdown-menu-right").attr("id", "FIELDSET-DROPDOWN");
  $(subgrp).append(button);
  $(subgrp).append(ul);
  $(grp).append(subgrp);
  $(th).append(grp);
  $(tr).append(th);

  $('#LIST-TABLE thead').append(tr);
  draw_fieldsets();

  $('#LIST-TABLE tbody').empty();
  if (API_DATA) {
    $.each(API_DATA, function(rowid, row) {
      tr = $('<tr>');

      total = 0;
      $.each(CURRENT_COLS, function(key, col) {
        if (_COLS[col]) {
          total += 1;
          id = row[_ROW_ID];
          type = _COLS[col]["TYPE"];
          val = row[col];
          td = null;
          td = haxdb_table_cell(_COLS[col], _API, id, row);
          if (total > 2) {
            $(td).addClass("hidden-xs hidden-sm");
          }
          $(tr).append(td);
        }
      });

      td = $('<td>').addClass("BUTTON-TD").addClass("TD-LINK");
      if (_ROW_EDIT){
        href = _ROW_EDIT + "/" + row[_ROW_ID];
        $(td).attr("href", href);
      }else{
        $(td).addClass('disabled');
      }
      icon = $('<i/>').addClass("fa").addClass("fa-search");
      $(td).append(icon);
      $(tr).append(td);

      td = $('<td>').addClass("LIST-ROW-DELETE").addClass("BUTTON-TD");
      if (_ROW_INTERNAL && row[_ROW_INTERNAL] && row[_ROW_INTERNAL] == 1) {
        $(td).addClass("disabled");
      }
      delete_name = "";
      $(td).attr("DELETE-ROWID", row[_ROW_ID]);
      $(td).attr("DELETE-NAME", _ROW_NAME);
      icon = $('<i/>').addClass("fa").addClass("fa-trash");
      $(td).append(icon);
      $(tr).append(td);

      $('#LIST-TABLE tbody').append(tr);
    });
    $('#LIST-TABLE').tablesorter({
      textExtraction: tablesortExtraction
    });
  }
  $(document).trigger("haxdb-table-draw");
}

new_row_save_callback = function(data) {
  if (data && data.success && data.success == 1) {
    haxSay(data.message, "success");
    $("#haxdb-new-modal").modal("hide");
    load_table();
  } else {

    if (data && data.message) {
      $("#haxdb-new-modal .form-error").html(data.message);
    } else {
      $("#haxdb-new-modal .form-error").html("UNKOWN ERROR");
    }
    $("#haxdb-new-modal .form-error").show();
  }
}

new_row_save = function() {
  var url = _API + "/new";
  var data = _DATA_NEW;
  $("#haxdb-new-modal .modal-body .FORM-EDIT").each(function(key, input) {
    col = $(input).attr("haxdb-col");
    val = $(input).val();
    data[col] = val;
  });
  api(url, data, new_row_save_callback);
}

new_row = function(data) {
  $('#haxdb-new-modal .modal-title').html("NEW: " + _API);

  body = $('#haxdb-new-modal .modal-body');
  $(body).html("");
  $("#haxdb-new-modal .form-error").hide();

  form = $("<form/>").addClass("form-horizontal").attr("role", "form");

  $.each(COLS, function(key, col) {
    if (col.NEW && col.NEW == 1) {
      var row = {}
      row[col["NAME"]] = "";
      var newcol = $.extend({}, col);
      newcol["EDIT"] = 1;
      if (typeof col.DEFAULT_VALUE != undefined){
        row[col["NAME"]] = col.DEFAULT_VALUE;
      }
      element = haxdb_form_cell(newcol, _API, "NEW", row, false);
      $(form).append(element);
    }
  });
  $(body).append(form);

  $("#haxdb-new-modal").modal("show");
}

load_table_callback = function(data) {
  if (api_success(data)) {
    if (data.meta && data.meta.name){ $("#PAGE-NAME").html(data.meta.name); }

    API_DATA = data.data;
    COLS = data.meta.cols;
    LISTS = data.meta.lists;

    _LISTS = {};
    $.each(LISTS, function(key, list){
      _LISTS[list.name] = list.items;
    });

    _COLS = {};
    $.each(COLS, function(key, col) {
      _COLS[col["NAME"]] = col;
    });

    draw_table();
  }
}

load_table = function() {
  var query = $('#PAGE-SEARCH').val();
  var data = _DATA_LIST;
  data["query"] = query;
  $('#LIST-TABLE thead').empty();
  $('#LIST-TABLE tbody').empty();
  $('#loader').show();
  api(_API + "/list", data, load_table_callback);
}


$(document).on("hidden.bs.modal", '#haxdb-fieldset-modal', function() {
  CURRENT_COLS = []
  $.each($(".COLS-EDIT-CHECKBOX:checked"), function(key, checkbox) {
    colname = $(checkbox).attr("colname");
    CURRENT_COLS.push(colname);
  });
  draw_table();
});

$(document).on("click",".LIST-ROW-DELETE:not(.disabled)", function(){
  var tr = $(this).closest("tr");
  var rowid = $(this).attr("DELETE-ROWID");
  var data = find_API_DATA(rowid);
  var call = _API + "/delete/" + rowid;

  var deletenames = $(this).attr("DELETE-NAME").split(".");
  var rowname = "";
  $.each(deletenames, function(key, col){
    if (rowname.length > 0){ rowname += " "; }
    rowname += data[col];
  });
  alertify.confirm("Are you sure you want to delete:<br/>"+rowname, function(){
    api(call, {}, function(data){
      if (api_success(data)){
        $(tr).remove();
        haxSay("DELETED","error");
      }
    });
  });
});

$(function() {
  $(document).on("click","a.HAXDB-LIST-CSV", function(e){
    var call = _API + "/csv";
    var data = _DATA_LIST;
    data["query"] = $('#PAGE-SEARCH').val();
    apiDownload(call,data);
    e.preventDefault();
  });

  $('#PAGE-SEARCH').change(load_table);
  $('#LIST-TABLE').tablesorter({
    textExtraction: tablesortExtraction
  });
  $('#PAGE-NEW').click(new_row);
  $(document).on("click", '#FIELDSET-EDIT', cols_edit_callback);
  $(document).on("click", ".FIELDSET-SAVE", save_fieldset);
  $(document).on("click", ".FIELDSET-NEW", save_as_fieldset);
  $(document).on("click", ".FIELDSET-DELETE", delete_fieldset);
  $(document).on("click", ".FIELDSET-SELECT", select_fieldset);
  $(document).on("click", ".FIELDSET-CLEAR", clear_fieldset);
  $(document).on("click", ".QUERY-SAVE", save_query);
  $(document).on("click", ".QUERY-NEW", save_as_query);
  $(document).on("click", ".QUERY-DELETE", delete_query);
  $(document).on("click", ".QUERY-SELECT", select_query);
  $(document).on("click", ".QUERY-CLEAR", clear_query);
  $('#haxdb-new-modal-save').click(new_row_save);
  load_fieldsets();
  load_queries();
  load_table();
});
