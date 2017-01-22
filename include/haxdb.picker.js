var _PICKER_API = "";
var _PICKER_ID = "";
var _PICKER_VIEW = {};
var _PICKER_TARGET = "";

haxdb_picker = function(objid, col){
  _PICKER_API = col["ID_API"];
  _PICKER_ID = col["ID_ID"];
  _PICKER_VIEW = col["ID_VIEW"];
  _PICKER_TARGET = objid;

  $("#haxdb-id-picker-modal .modal-title").html("SELECTOR: " + _PICKER_API);

  $("#PICKER-SEARCH").val("");
  $("#PICKER-TABLE tbody").empty();
  $("#PICKER-RESULTS").html("SEARCH AND THEN SELECT");

  $("#haxdb-id-picker-modal").modal("show");
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

haxdb_picker_search_callback = function(data){
  if (api_success(data)){
    var total = 0;
    $.each(data.data, function(key, row){
      total += 1;
      console.log(row);
      tr = $("<tr>");

      td = $("<td>");
      input = $("<input>").attr("readonly",true);
      $(input).addClass("TABLE-EDIT");
      rowname = "";
      $.each(_PICKER_VIEW, function(key, colname){
        rowname += " ";
        rowname += row[colname];
      });
      $(input).val(rowname);
      $(td).append(input);
      $(tr).append(td);

      td = $("<td>").addClass("BUTTON-TD");
      $(td).addClass("haxdb-picker-selector");
      $(td).attr("haxdb-picker-value", row[_PICKER_ID]);
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
  var query = $(this).val();
  data = { "query": query }
  $("#PICKER-TABLE tbody").empty();
  $("#PICKER-RESULTS").html("SEARCHING...");
  api(_PICKER_API + "/list", data, haxdb_picker_search_callback);
}

$(function(){

  $(document).on("mousedown",".haxdb-picker", function(e){
    e.preventDefault();
    var objid = $(this).attr("id");
    var colname = $(this).attr("haxdb-col");
    var col = _COLS[colname];
    haxdb_picker(objid, col);
  });

  $(document).on("change", "#PICKER-SEARCH", haxdb_picker_search);
  $(document).on("click", ".haxdb-picker-selector", haxdb_picker_select);
});
