var LISTS = {};
var _LISTS = [];
var COLS = [];
var VIEW_DATA = {};

draw_view = function(){
    $.each(COLS, function(key,col){
      label = col["HEADER"];
      name = col["NAME"];
      val = VIEW_DATA[name];
      if (context_name.indexOf(name) > -1){
        $("#CONTEXT-NAME").append(val + " ");
      }
      grp = haxdb_form_cell( col, context, rowid, val);
      $(grp).addClass("row");
      $("#CONTEXT-VIEW-FORM").append(grp);
    });
}

load_view_callback = function(data){
  if (api_success(data)){
    _LISTS = data.meta.lists;
    COLS = data.meta.cols;
    VIEW_DATA=data.data;
    $.each(_LISTS, function(key, list){
      LISTS[list["LISTS_ID"]] = list;
    });
    draw_view();
  }
}

load_view = function(){
  var data = { "rowid": rowid }
  api(context + "/view", data, load_view_callback);
}

$(function(){
  load_view();
});
