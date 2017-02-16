tablesortExtraction = function(node){ return $(node.childNodes[0]).val(); }

haxdb_input = function ( id, row, col, options, input_classes="", input_attrs={} ){
  var val = row[col["NAME"]];
  var input = null;
  var type = col["TYPE"]

  if (type == "TIMESTAMP"){
    timestamp = null;
    if (val){
      var t = new Date(val * 1000);
      timestamp = t.getFullYear() + '-' +  t.getMonth() + '-' + t.getDate() + ' ' + t.getHours() + ':' + t.getMinutes() + ':' + t.getSeconds();
    }
    input = $("<input/>").attr({ id: id, type: "text" });
    $(input).attr("timestamp-value", val);
    $(input).addClass("TIMESTAMP");
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "DATE"){
    input = $('<input/>').attr({ id: id, type: 'text'}).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "INT"){
    input = $('<input/>').attr({ id: id, type: 'number', step: "1"}).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "FLOAT"){
    input = $('<input/>').attr({ id: id, type: 'number', step: "0.001"}).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "BOOL"){
    input = $('<select/>').attr("id",id);
    $("<option />", {value: 0, text: "NO"}).appendTo(input);
    $("<option />", {value: 1, text: "YES"}).appendTo(input);
    $(input).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "LIST"){
    input = $('<select/>').attr("id",id);
    $("<option />", {value: "", text: ""}).appendTo(input);
    var valid_value = false;
    $.each(options, function(key,item){
      $("<option />", {value: item["VALUE"], text: item["DESCRIPTION"]}).appendTo(input);
      if (item["VALUE"] == val) valid_value = true;
    });
    if (!valid_value){
      $("<option />", {value: val, text: val }).addClass("invalid").appendTo(input);
    }
    $(input).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "SELECT"){
    input = $('<select/>').attr("id",id);
    $("<option />", {value: "", text: ""}).appendTo(input);
    $.each(col["OPTIONS"], function(key,item){
      $("<option />", {value: item, text: item}).appendTo(input);
    });
    $(input).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (type == "FILE"){
    input = $("<div>").addClass("haxdb-file-buttons");

    if (val){
      button = $("<a>").attr("id",id).attr("file-action","clear");
      $(button).addClass("haxdb-file-button");
      icon = $("<i>").addClass("fa fa-ban fa-border");
      $(button).append(icon);
      $(input).append(button);

      button = $("<a>").attr("id",id).attr("file-action","download");
      $(button).addClass("haxdb-file-button");
      if (!val){ $(button).addClass("disabled"); }
      icon = $("<i>").addClass("fa fa-download fa-border");
      $(button).append(icon);
      $(input).append(button);
    }else{
      button = $("<a>").attr("id",id).attr("file-action","upload");
      $(button).addClass("haxdb-file-button");
      icon = $("<i>").addClass("fa fa-upload fa-border");
      $(button).append(icon);
      $(input).append(button);
    }
  }

  if (type == "ID"){
    idname = col["ID_API"] + " ID: " + val;
    input = $('<select/>').attr({ "id": id });
    $("<option />", {value: val, text: idname}).appendTo(input);
    $(input).addClass("haxdb-picker");
    $(input).attr("haxdb-picker-api", col["ID_API"]);
    $(input).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }

  if (input == null){
    input = $('<input/>').attr({ id: id, type: 'text'}).val(val);
    $(input).addClass(input_classes);
    $(input).attr(input_attrs);
  }
  return input;
}

haxdb_form_cell = function ( col, api_name, rowid, row, quick_edit = true ) {
  var id = api_name + "-" + rowid + "-" + col["NAME"];
  var input_classes = "form-control FORM-EDIT";
  var input_attrs = {}
  var list = [];
  if (col["LIST"]){ list = LISTS[col["LIST"]]["items"]; }
  if (col["LIST_NAME"]){ list = _LISTS[col["LIST_NAME"]]; }

  frmgroup = $("<div/>").addClass("form-group");
  label = $("<label/>").attr("for",id).addClass("col-xs-12 col-sm-12 col-md-3 col-lg-3 control-label").text(col["HEADER"]);
  div = $("<div/>").addClass("col-xs-12 col-sm-12 col-md-9 col-lg-9");
  if (quick_edit){ input_classes += " QUICK-EDIT"; }
  input_attrs["placeholder"] = col["HEADER"];
  input_attrs["haxdb-col"] = col["NAME"];
  input_attrs["haxdb-rowid"] = rowid;
  if ((typeof col["EDIT"] != undefined) && (col["EDIT"] != 1)){
    input_attrs["readonly"] = true;
    input_attrs["copy-message"] = col["HEADER"] + ' COPIED';
    input_classes += " CLICK-COPY";
  }
  input = haxdb_input( id, row, col, list, input_classes, input_attrs);
  $(div).append(input);
  $(frmgroup).append(label);
  $(frmgroup).append(div);
  return frmgroup;
}

haxdb_table_cell = function ( col, api_name, rowid, row, quick_edit = true ){
  var id = api_name + "-" + rowid + "-" + col["NAME"];
  var input_classes = "TABLE-EDIT";
  var input_attrs = {}
  var list = [];
  if (col["LIST"]){ list = LISTS[col["LIST"]]["items"]; }
  if (col["LIST_NAME"]){ list = _LISTS[col["LIST_NAME"]]; }

  td = $('<td>').addClass("TD-EDIT");

  if (quick_edit){ input_classes += " QUICK-EDIT"; }
  input_attrs["placeholder"] = col["HEADER"];
  input_attrs["haxdb-col"] = col["NAME"];
  input_attrs["haxdb-rowid"] = rowid;
  if ((typeof col["EDIT"] != undefined) && (col["EDIT"] != 1)){
    input_attrs["readonly"] = true;
    input_attrs["copy-message"] = col["HEADER"] + ' COPIED';
    input_classes += " CLICK-COPY";
  }

  input = haxdb_input( id, row, col, list, input_classes, input_attrs );
  $(td).append(input);
  return td;
}

save_callback = function(data){
  if (api_success(data)){
    haxSay(data.message,"success");
    if (data.meta && data.meta.api){
      base = data.meta.api + "-" + data.meta.rowid + "-";
      $.each(data.meta.updated, function(key,col){
      obj = document.getElementById(base + col);
      $(obj).removeClass("saving");
    });
    }
  }else{
    if (data.meta){
      base = data.meta.api + "-" + data.meta.rowid + "-";
      $.each(data.meta.updated, function(key,col){
        obj = document.getElementById(base + col);
        $(obj).removeClass("saving").addClass("error");
      });
    }
  }
  $('table').trigger("update");
}

$(document).on("click",".CLICK-COPY",function(){
  val = $(this).val();
  message = $(this).attr("copy-message");
  $('#haxdb-copy-input').val(val).css("display","block");
  $("#haxdb-copy-input").select();
  if (document.execCommand("copy")){
    haxSay(message,"success");
  }else{
    haxSay("COPY FAILED","error");
  }
  $('#haxdb-copy-input').val("").css("display","none");
});

$(document).on("click",".BUTTON-COPY",function(){
  val = $(this).attr("copy");
  message = $(this).attr("copy-message");
  $('#haxdb-copy-input').val(val).css("display","block");
  $("#haxdb-copy-input").select();
  if (document.execCommand("copy")){
    haxSay(message,"success");
  }else{
    haxSay("COPY FAILED","error");
  }
  $('#haxdb-copy-input').val("").css("display","none");
});

$(document).on("change",'.QUICK-EDIT',function(){
  var tab = $(this).closest("table");
  var id = $(this).attr("id");
  if (!id) return
  id = id.split("-");
  var table = id[0];
  var rowid = id[1];
  var column = id[2];
  var call = table + "/save";
  var data = { "rowid": rowid };
  var val = $(this).val();
  if (!val){ val = ""; }
  data[column] = val;
  $(this).addClass("saving").removeClass("error");
  $('table').trigger("update");
  api(call,data,save_callback);
});

$(document).on("keydown", '.TABLE-EDIT', function(e){
  if (e.which == 38){
    // UP
    var cellIndex = $(this).closest("td").index();
    $(this).closest('tr').prev().children().eq(cellIndex).find(".TABLE-EDIT").focus();
  }
  if (e.which == 40){
    // DOWN
    var cellIndex = $(this).closest("td").index();
    $(this).closest('tr').next().children().eq(cellIndex).find(".TABLE-EDIT").focus();
  }

});

// FILE

$(document).on("click", ".haxdb-file-button", function(){
  var action = $(this).attr("file-action");
  var id = $(this).attr("id").split("-");
  var api_name = id[0];
  var rowid = id[1];
  var field_name = id[2];
  if (action == "upload"){
    $('#haxdb-file-upload-file').remove();
    $('#haxdb-file-upload-api_name').val(api_name);
    $('#haxdb-file-upload-rowid').val(rowid);
    $('#haxdb-file-upload-field_name').val(field_name);
    f = $("<input>").attr({ "id": "haxdb-file-upload-file", "type": "file" });
    $(f).addClass("hidden");
    $("#haxdb-file-upload-form").append(f);
    $('#haxdb-file-upload-file').click();
  } else if (action == "download"){
    var call = api_name + "/download";
    var data = { "rowid": rowid, "field_name": field_name }
    apiDownload(call, data);
  } else if (action == "clear"){
    var call = api_name + "/save";
    var data = { "rowid": rowid }
    data[field_name] = "";
    alertify.confirm("Are you sure you want to clear this file?", function(){
      api(call, data, function(data){
      save_callback(data);
      if (typeof load_table !== "undefined"){
        load_table();
      }else{
        load_view();
      }
    });
    });
  }
});

$(document).on("change","#haxdb-file-upload-file", function(){
  apiUpload(function(data){
    if (typeof load_table !== "undefined"){
      load_table();
    }else{
      load_view();
    }
    save_callback(data);
  });
});

// FILE

$(document).on("click",".TABLE-LINK", function(){
  var url = $(this).attr("href");
  document.location=url;
});

$(document).on("click",".CHECKBOX-CLICK", function(){
  target = $(this).attr("CHECKBOX-TARGET");
  $("[id='"+target+"']").trigger("click");
});

$(document).on("click", ".TD-LINK:not(.disabled)", function(){
  href = $(this).attr("href");
  document.location = href;
});

$(document).on("haxdb-table-draw haxdb-view-draw", function(){
  $(".TIMESTAMP").each(function(){
    var id = $(this).attr("id");
    var timestamp = parseInt($(this).attr("timestamp-value"));
    var this_date = null;
    if (timestamp){
      this_date = new Date(timestamp*1000);
    }
    var obj = document.getElementById(id);
    obj.flatpickr({
      enableTime: true,
      altInput: true,
      altFormat: "Y-m-d H:i:S",
      dateFormat: "U",
      allowInput: true,
      defaultDate: this_date,
    });
  });

  $("select[readonly] option:not(:selected)").remove(); //attr("disabled", true);
});
