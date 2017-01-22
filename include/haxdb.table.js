tablesortExtraction = function(node){ return $(node.childNodes[0]).val(); }

haxdb_input = function ( id, row, col, options, input_classes="", input_attrs={} ){
  var val = row[col["NAME"]];
  var input = null;
  var type = col["TYPE"]

  if (type == "TIMESTAMP"){
    timestamp = null;
    if (val){
      var t = new Date(val * 1000);
      timestamp = t.toLocaleString();
    }
    //t.getFullYear() + '-' + t.getDate() + '-' + t.getMonth() + ' ' + t.getHours() + ':' + t.getMinutes() + ':' + t.getSeconds();
    input = $("<input/>").attr({ id: id, type: "text", "disabled": true}).val(timestamp);
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
    $.each(options, function(key,item){
      $("<option />", {value: item["VALUE"], text: item["DESCRIPTION"]}).appendTo(input);
    });
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
    input = $("<div>").addClass("btn-group").attr("role","group").attr("aria-label","FILE");

    button = $("<button>").addClass("btn").attr("id",id).attr("file-action","download");
    if (!val){ $(button).addClass("disabled"); }
    icon = $("<i>").addClass("fa fa-cloud-download");
    $(button).append(icon);
    $(input).append(button);

    button = $("<button>").addClass("btn").attr("id",id).attr("file-action","clear");
    if (!val){ $(button).addClass("disabled"); }
    icon = $("<i>").addClass("fa fa-trash-o");
    $(button).append(icon);
    $(input).append(button);

    button = $("<button>").addClass("btn").attr("id",id).attr("file-action","upload");
    icon = $("<i>").addClass("fa fa-cloud-upload");
    $(button).append(icon);
    $(input).append(button);
  }

  if (type == "ID"){
    idname = "";
    $.each(col["ID_VIEW"], function(key, v){
      idname += " ";
      idname += row[v];
    });
    input = $('<select/>').attr({ "id": id, "readonly": true });
    $("<option />", {value: val, text: idname}).appendTo(input);
    $(input).addClass("haxdb-picker");
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
    base = data.meta.api + "-" + data.meta.rowid + "-";
    $.each(data.meta.updated, function(key,col){
      obj = document.getElementById(base + col);
      $(obj).removeClass("saving");
    });
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
  var id = $(this).attr("id").split("-");
  var table = id[0];
  var rowid = id[1];
  var column = id[2];
  var val = $(this).val();
  var call = table + "/save";
  var data = { "rowid": rowid };
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

$(document).on("click",".TABLE-FILE-UPLOAD", function(){
  var tmp = $(this).attr("id").split("-");
  var table = tmp[0];
  var rowid = tmp[1];
  var column = tmp[2];
  var call = table + "/save/" + rowid + "/" + column;
  $('#haxdb-file-upload-call').val(call);
  $('#haxdb-file-upload').click();
  $('#haxdb-file-upload-cell-id').val($(this).closest("td").attr("id"));
});

$(document).on("change","#haxdb-file-upload", function(){
  var cellid = $('#haxdb-file-upload-cell-id').val();
  $("#" + cellid + " .TABLE-FILE-BUTTON-SPAN").hide();
  $("#" + cellid + " .TABLE-FILE-PROGRESS-SPAN").show();
  apiUpload(load_table);
});

$(document).on("click",".TABLE-FILE-DOWNLOAD", function(){
  var tmp = $(this).attr("id").split("-");
  var table = tmp[0];
  var rowid = tmp[1];
  var column = tmp[2];
  var call = API_URL + table + "/download";
  $('#haxdb-file-download-form').attr("action",call);
  $('#haxdb-file-download-rowid').val(rowid);
  $('#haxdb-file-download-col').val(column);
  $('#haxdb-file-download-api_key').val(localStorage["api_key"]);
  $('#haxdb-file-download-form').submit();
});

// FILE
//
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
