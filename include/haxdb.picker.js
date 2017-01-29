var _PICKER_API = "";
var _PICKER_TARGET = "";
var _PICKER_CACHE = {};

haxdb_picker = function(objid, col){
  _PICKER_API = col["ID_API"];
  _PICKER_TARGET = objid;

  $("#haxdb-id-picker-modal .modal-title").html("SELECTOR: " + _PICKER_API);

  $("#PICKER-SEARCH").val("");
  $("#PICKER-TABLE tbody").empty();
  $("#PICKER-RESULTS").html("SEARCH AND THEN SELECT");

  haxdb_picker_search();
  $("#haxdb-id-picker-modal").modal("show");
  $("#PICKER-SEARCH").focus();

}

haxdb_picker_select = function(){
  var value = $(this).attr("haxdb-picker-value");
  var name = $(this).attr("haxdb-picker-name");
  var obj = $(document.getElementById(_PICKER_TARGET));

  option = $("<option>").val(value).text(name);
  $(obj).empty().append(option);
  $(obj).change();
  $('#haxdb-id-picker-modal').modal("toggle");
}

haxdb_picker_clear = function(){
  var obj = $(document.getElementById(_PICKER_TARGET));
  option = $("<option>").val("").text("");
  $(obj).empty().append(option);
  $(obj).change();
  $('#haxdb-id-picker-modal').modal("toggle");
}

haxdb_picker_search_callback = function(data){
  if (api_success(data)){
    var total = 0;
    $.each(data.data, function(key, row){
      total += 1;
      tr = $("<tr>");

      td = $("<td>");
      input = $("<input>").attr("readonly",true);
      $(input).addClass("TABLE-EDIT");
      rowname = row["ROW_NAME"];
      $(input).val(rowname);
      $(td).append(input);
      $(tr).append(td);

      td = $("<td>").addClass("BUTTON-TD");
      $(td).addClass("haxdb-picker-selector");
      $(td).attr("haxdb-picker-value", row["ROW_ID"]);
      $(td).attr("haxdb-picker-name", rowname);
      icon = $("<i>").addClass("fa fa-check");
      $(td).append(icon);
      $(tr).append(td);

      $("#PICKER-TABLE tbody").append(tr);
    });
    $("#PICKER-RESULTS").html("FOUND: " + total);
  }
}

haxdb_picker_search = function(){
  var query = $("#PICKER-SEARCH").val();
  data = { "query": query }
  $("#PICKER-TABLE tbody").empty();
  $("#PICKER-RESULTS").html("SEARCHING...");
  api(_PICKER_API + "/list", data, haxdb_picker_search_callback);
}

haxdb_picker_load_api = function(data){
  if (api_success(data)){
    var api_name = data.meta["api"];
    $.each(data.data, function(key,row){
      var rowid = row["ROW_ID"]
      var rowname = row["ROW_NAME"]
      if (!_PICKER_CACHE[api_name]){ _PICKER_CACHE[api_name] = {}; }
      _PICKER_CACHE[rowid] = rowname;
      var selector = "select.haxdb-picker[haxdb-picker-api=" + api_name + "]";
      selector += " option[value=" + rowid + "]";
      $(selector).text(rowname);
    });
  }
}

haxdb_picker_update = function(){
  var _LOAD = {};
  $("select.haxdb-picker").each(function(){
    var api_id = $(this).val();
    if (api_id){
        var api_name = $(this).attr("haxdb-picker-api");
        if (_PICKER_CACHE[api_name] && _PICKER_CACHE[api_name][api_id]){
          $(this).text(_PICKER_CACHE[api_name][api_id]);
        }else{
          if (!_LOAD[api_name]){ _LOAD[api_name] = []; }
          if ($.inArray(api_id, _LOAD[api_name]) == -1){
            _LOAD[api_name].push(api_id);
          }
        }
    }
  });
  $.each(_LOAD, function(api_name, api_ids){
    api(api_name + "/list", { "rowid": api_ids }, haxdb_picker_load_api);
  });
}

$(function(){

  $(document).on("mousedown",".haxdb-picker", function(e){
    if (e.which == 1){
      e.preventDefault();
      if ( $(this).is("[readonly]")) return;
      var objid = $(this).attr("id");
      var colname = $(this).attr("haxdb-col");
      var col = _COLS[colname];
      haxdb_picker(objid, col);
    }
  });

  $(document).on("change", "#PICKER-SEARCH", haxdb_picker_search);
  $(document).on("click", ".haxdb-picker-selector", haxdb_picker_select);
  $(document).on("click", "#PICKER-CLEAR", haxdb_picker_clear);
  $(document).on("haxdb-table-draw haxdb-view-draw", haxdb_picker_update);
});
