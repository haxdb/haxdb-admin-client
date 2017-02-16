var QUERIES = {};
var CURRENT_QUERY = null;
var FIELDSETS = {};
var CURRENT_FIELDSET = null;
var CURRENT_COLS = [];

var COLS = [];
var _COLS = {};
var LISTS = [];
var _LISTS = {};
var PAGE_NAME = null;
var PAGE_DATA = [];
var ROWID_NAME = null;

find_PAGE_DATA = function(rowid){
  rowid = parseInt(rowid);
  result = null;
  $.each(PAGE_DATA, function(key, row){
    if (row[ROWID_NAME] && row[ROWID_NAME]==rowid){
      result = row;
      return false;
    }
  });
  return result;
}

load_query_callback = function(data) {
    if (api_success(data)) {
      QUERIES = {};
      $.each(data.data, function(key, query){
        query_id = query["QUERY_ID"];
        QUERIES[query_id] = query;
      });
      draw_queries();
      draw_query_options();
    }
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
    draw_fieldset_options();
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

select_query = function(){
  if (this) {
    qid = $(this).attr("QUERY-ID");
    qname = QUERIES[qid]["QUERY_NAME"];
    query = QUERIES[qid]["QUERY_QUERY"];
    CURRENT_QUERY = qid;
    $('#PAGE-SEARCH').val(query);
    draw_query_options();
    $('#PAGE-SEARCH').change();
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
        "context": context,
        "context_id": context_id,
        "rowid": CURRENT_FIELDSET
    }
    api("FIELDSET/save", data, save_fieldset_callback);
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
    "context": context,
    "context_id": context_id,
    "rowid": CURRENT_QUERY
  }
  api("QUERY/save", data, save_query_callback);
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
                "context": context,
                "context_id": context_id,
                "FIELDSET_NAME": fieldset_name,
                "COLS": CURRENT_COLS,
            }
            api("FIELDSET/new", data, save_as_fieldset_callback);
        }
    });
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
        "context": context,
        "context_id": context_id,
        "QUERY_NAME": query_name,
        "QUERY_QUERY": $("#PAGE-SEARCH").val(),
      }
      api("QUERY/new", data, save_as_query_callback);
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

load_table_callback = function(data) {
    if (api_success(data)) {
        if (data.meta && data.meta.PAGE_NAME){
          $("#PAGE-NAME").html(data.meta.PAGE_NAME);
        }
        ROWID_NAME = data.meta.rowid_name
        PAGE_DATA = [];
        PAGE_DATA = data.data;
        COLS = data.meta.cols;
        _LISTS = data.meta.lists;

        LISTS = [];
        $.each(_LISTS, function(key, list) {
            LISTS[list["LISTS_ID"]] = list;
        });

        _COLS = {};
        $.each(COLS, function(key, col) {
            _COLS[col["NAME"]] = col;
        });

        if (data.meta && data.meta.PAGE_NAME) {
            PAGE_NAME = data.meta.PAGE_NAME;
            $('#PAGE-NAME').text(": " +data.meta.PAGE_NAME);
            $('#PAGE-PARENT-NAME').text(data.meta.PAGE_NAME);
        }
        draw_table();
    }
}

draw_fieldset_options = function(){
  ul = $("#FIELDSET-OPTIONS");
  $(ul).empty();

  if (CURRENT_FIELDSET && FIELDSETS[CURRENT_FIELDSET]){
    fname = FIELDSETS[CURRENT_FIELDSET]["FIELDSET_NAME"]

    li = $("<li>").addClass("FIELDSET-EDIT");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-pencil-square-o");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; " + fname);
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("divider");
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-SAVE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-floppy-o");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; save");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-NEW");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-plus");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; save as..");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("divider");
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-DELETE");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-trash-o");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; delete");
    $(li).append(a);
    $(ul).append(li);
  }else{
    li = $("<li>").addClass("FIELDSET-EDIT");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-pencil-square-o");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; [NEW FIELDSET]");
    $(li).append(a);
    $(ul).append(li);

    li = $("<li>").addClass("divider");
    $(ul).append(li);

    li = $("<li>").addClass("FIELDSET-NEW");
    a = $("<a>").attr("href","#")
    icon = $("<i>").addClass("fa fa-plus");
    $(a).append(icon);
    $(a).append("&nbsp;&nbsp; save as..");
    $(li).append(a);
    $(ul).append(li);
  }
}

draw_fieldsets = function(){
	ul = $("#FIELDSET-DROPDOWN");
	var tot = 0;
	$.each(FIELDSETS, function(key,fieldset){
		tot += 1;
		fname = fieldset["FIELDSET_NAME"];
		fid = fieldset["FIELDSET_ID"]
		li = $("<li>");
		a = $("<a>").attr("href","#");
		$(a).attr("FIELDSET-ID",fid);
		$(a).addClass("FIELDSET-SELECT");
		$(a).text(fname);
		$(li).append(a);
		$(ul).append(li);
	});
	if (tot <= 0){
		li = $("<li>");
		a = $("<a>").attr("href","#");
		$(a).text("no saved fieldsets");
		$(li).append(a);
		$(ul).append(li);
	}
}

draw_query_options = function(){
	ul = $("#QUERY-OPTIONS");
  $(ul).empty();

	if (CURRENT_QUERY && QUERIES[CURRENT_QUERY]){
		qname = QUERIES[CURRENT_QUERY]["QUERY_NAME"]

		li = $("<li>").addClass("QUERY-EDIT");
		a = $("<a>").attr({ "href":"#", "id": "QUERY-SELECTED" });
		icon = $("<i>").addClass("fa fa-chevron-left");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; " + qname);
		$(li).append(a);
		$(ul).append(li);

		li = $("<li>").addClass("divider");
		$(ul).append(li);

		li = $("<li>").addClass("QUERY-SAVE");
		a = $("<a>").attr("href","#")
		icon = $("<i>").addClass("fa fa-floppy-o");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; save");
		$(li).append(a);
		$(ul).append(li);

		li = $("<li>").addClass("QUERY-NEW");
		a = $("<a>").attr("href","#")
		icon = $("<i>").addClass("fa fa-plus");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; save as..");
		$(li).append(a);
		$(ul).append(li);

		li = $("<li>").addClass("divider");
		$(ul).append(li);

		li = $("<li>").addClass("QUERY-DELETE");
		a = $("<a>").attr("href","#")
		icon = $("<i>").addClass("fa fa-trash-o");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; delete");
		$(li).append(a);
		$(ul).append(li);
	}else{
		li = $("<li>").addClass("QUERY-EDIT");
		a = $("<a>").attr("href","#")
		icon = $("<i>").addClass("fa fa-chevron-left");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; [NEW QUERY]");
		$(li).append(a);
		$(ul).append(li);

		li = $("<li>").addClass("divider");
		$(ul).append(li);

		li = $("<li>").addClass("QUERY-NEW");
		a = $("<a>").attr({ "href":"#", "id": "QUERY-SELECTED" })
		icon = $("<i>").addClass("fa fa-plus");
		$(a).append(icon);
		$(a).append("&nbsp;&nbsp; save as..");
		$(li).append(a);
		$(ul).append(li);
	}
}

draw_queries = function(){
	ul = $("#QUERY-DROPDOWN");
	$(ul).empty();

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
		li = $("<li>");
		a = $("<a>").attr("href","#");
		$(a).text("no saved queries");
		$(li).append(a);
		$(ul).append(li);
	}
}

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
            if (total > 3) {
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
    icon = $("<span>").addClass("fa fa-gear");
    $(button).append(icon)
    ul = $("<ul>").addClass("dropdown-menu dropdown-menu-right").attr("id", "FIELDSET-OPTIONS");
		$(subgrp).append(button);
		$(subgrp).append(ul);
    $(grp).append(subgrp);
    //$(tr).append(th);

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
		draw_fieldset_options();

    $('#LIST-TABLE tbody').empty();
    if (PAGE_DATA) {
        $.each(PAGE_DATA, function(rowid, row) {
            tr = $('<tr>');

            total = 0;
            $.each(CURRENT_COLS, function(key, col) {
                if (_COLS[col]) {
                    total += 1;
                    id = row[col_rowid];
                    type = _COLS[col]["TYPE"];
                    val = row[col];
                    td = null;
                    td = haxdb_table_cell(_COLS[col], api_name, id, val);
                    if (total > 3) {
                        $(td).addClass("hidden-xs hidden-sm");
                    }
                    $(tr).append(td);
                }
            });

						td = $('<td>').addClass("BUTTON-TD").addClass("TD-LINK");
            if (_EDIT_PAGE){
              href = "/page/" + _EDIT_PAGE + "/" + row[col_rowid];
              $(td).attr("href", href);
            }else{
              $(td).addClass('disabled');
            }
            icon = $('<i/>').addClass("fa").addClass("fa-search");
            $(td).append(icon);
            $(tr).append(td);

            td = $('<td>').addClass("LIST-ROW-DELETE").addClass("BUTTON-TD");
            if (row[col_internal] && row[col_internal] == 1) {
                $(td).addClass("disabled");
            }
            delete_name = "";
            $(td).attr("DELETE-ROWID", row[col_rowid]);
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
}

cols_edit_callback = function(data) {
    $('#haxdb-fieldset-modal .modal-title').html("COLS: " + api_name);

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
    var url = api_name + "/new";
    var data = { "context": context, "context_id": context_id }
    $("#haxdb-new-modal .modal-body .FORM-EDIT").each(function(key, input) {
        col = $(input).attr("haxdb-col");
        val = $(input).val();
        data[col] = val;
    });
    api(url, data, new_row_save_callback);
}

new_row = function(data) {
    $('#haxdb-new-modal .modal-title').html("NEW: " + api_name);

    body = $('#haxdb-new-modal .modal-body');
    $(body).html("");
    $("#haxdb-new-modal .form-error").hide();

    form = $("<form/>").addClass("form-horizontal").attr("role", "form");

    $.each(COLS, function(key, col) {
        if (col.NEW && col.NEW == 1) {
            val = "";
            if (typeof col.DEFAULT_VALUE != undefined) val = col.DEFAULT_VALUE;
            element = haxdb_form_cell(col, api_name, "NEW", val, false);
            $(form).append(element);
        }
    });
    $(body).append(form);

    $("#haxdb-new-modal").modal("show");
}

load_table = function() {
    var query = $('#PAGE-SEARCH').val();
    var data = {
        context: context,
        context_id: context_id
    };
    if (query) {
        data["query"] = query;
    }
    $('#LIST-TABLE thead').empty();
    $('#LIST-TABLE tbody').empty();
    $('#loader').show();
    api(api_name + "/list", data, load_table_callback);
}

load_fieldsets = function() {
    api("FIELDSET/list", {
        "context": context,
        "context_id": context_id
    }, load_fieldset_callback);
}

load_queries = function() {
    api("QUERY/list", {
        "context": context,
        "context_id": context_id
    }, load_query_callback);
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
  var data = find_PAGE_DATA(rowid);
	var call = api_name + "/delete/" + rowid;

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
    $('#PAGE-SEARCH').change(load_table);
    $('#LIST-TABLE').tablesorter({
        textExtraction: tablesortExtraction
    });
    $('#PAGE-NEW').click(new_row);
    $(document).on("click", '.FIELDSET-EDIT', cols_edit_callback);
	$(document).on("click", ".FIELDSET-SAVE", save_fieldset);
    $(document).on("click", ".FIELDSET-NEW", save_as_fieldset);
    $(document).on("click", ".FIELDSET-DELETE", delete_fieldset);
	$(document).on("click", ".FIELDSET-SELECT", select_fieldset);
	$(document).on("click", ".QUERY-SAVE", save_query);
    $(document).on("click", ".QUERY-NEW", save_as_query);
    $(document).on("click", ".QUERY-DELETE", delete_query);
	$(document).on("click", ".QUERY-SELECT", select_query);
    $('#haxdb-new-modal-save').click(new_row_save);
    load_fieldsets();
    load_queries();
		load_table();
});
