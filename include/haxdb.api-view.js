var LISTS = [];
var _LISTS = {};
var COLS = [];
var _COLS = {};
var API_DATA = {};

draw_name = function(){
    names = _ROW_NAME.split(".");
    $("#PAGE-NAME").html("");
    $.each(names, function(key, name){
      if (name in API_DATA){
        $("#PAGE-NAME").append(API_DATA[name] + " ");
      }
    });
}

draw_view = function(){
    $.each(COLS, function(key,col){
      grp = haxdb_form_cell( col, _API, rowid, API_DATA);
      $(grp).addClass("row");
      $("#PAGE-VIEW-FORM").append(grp);
    });
    draw_name();
    $(document).trigger("haxdb-view-draw");
}

load_view_callback = function(data){
  if (api_success(data)){
    LISTS = data.meta.lists;
    COLS = data.meta.cols;
    API_DATA=data.data;
    $.each(LISTS, function(key, list){
      _LISTS[list.name] = list.items;
    });
    $.each(COLS, function(key,col){
      _COLS[col["NAME"]] = col;
    });
    draw_view();
  }
}

load_view = function(){
  var data = { "rowid": rowid }
  api(_API + "/view", data, load_view_callback);
}

$(function(){
  load_view();
});
