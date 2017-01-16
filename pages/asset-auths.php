<?php
$rowid = intval($_GET["arg1"]);

$api_name = "ASSET_AUTHS";
$api_context = "ASSET_AUTHS";
$api_context_id = $rowid;
$udf_context = "ASSET_AUTHS";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "ASSET_AUTHS_ID";
$_SHOW_TITLE = False;
$_PAGE_NAME = "ASSETS_NAME";
$_ROW_NAME = "PEOPLE_NAME_FIRST.PEOPLE_NAME_LAST";

?>

<h5>
<a href='/page/assets'>ASSETS</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span id='PAGE-PARENT-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li><a href='/page/asset/<?= $rowid ?>'>ASSET</a></li>
    <li class='active'><a href='#'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <!--
        <li class='disabled'><a href='#'>FILES</a></li>
        <li class='disabled'><a href='#'>IMAGES</a></li>
    -->
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>

    <?php
        include("api-list.php");
    ?>

  </div>
</div>

<script>

AUTHED = {};
PAGE_DATA = [];

load_people_search_callback = function(data){
    if (api_success(data)){
      $('#ASSET_AUTHS-NEWPEOPLE tbody').empty();
      if (data.data){
        $.each(data.data, function(key,row){
          people_id = row["PEOPLE_ID"];
          if (!AUTHED[people_id]){
            var tr = $('<tr/>').attr("id","NEW_PEOPLE-"+people_id);

            td = $('<td>').addClass("TD-EDIT");
            name = row["PEOPLE_NAME_FIRST"];
            input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val(name);
            $(td).append(input);
            $(tr).append(td);

            td = $('<td>').addClass("TD-EDIT");
            name = row["PEOPLE_NAME_LAST"];
            input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val(name);
            $(td).append(input);
            $(tr).append(td);

            td = $('<td>').addClass("TD-EDIT").css("width","500px");
            input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val(row["PEOPLE_EMAIL"]);
            $(td).addClass("hidden-xs");
            $(td).append(input);
            $(tr).append(td);

            td = $('<td>').addClass("BUTTON-TD").css("width","1%");
            $(td).addClass("ADD-AUTH-BUTTON");
            $(td).attr({ "people_id": row["PEOPLE_ID"] });
            icon = $('<i/>').addClass("fa").addClass("fa-plus");
            $(td).append(icon);
            $(tr).append(td);

            $('#ASSET_AUTHS-NEWPEOPLE tbody').append(tr);

          }
        });
      }
    }
}

new_auth_callback = function(data){
    if (api_success(data)){
        haxSay("AUTH ADDED","success");
        $('#ASSET_AUTHS-SEARCH').val("");
        load_table();
    }
}

new_auth_row = function(people_id){
    var call = "ASSET_AUTHS/new";
    var data = { "ASSET_AUTHS_ASSETS_ID": <?=$rowid?>, "ASSET_AUTHS_PEOPLE_ID": people_id }
    api(call,data,new_auth_callback);
}

load_auth_search = function(){
    var query = $('#PAGE-SEARCH').val();
    console.log(query);
    if (query){
      var data = { "query": query }
      api("PEOPLE/list",data, load_people_search_callback);
    }else{
      $('#ASSET_AUTHS-NEWPEOPLE tbody').empty();
    }
}

$(function(){
    $('#PAGE-SEARCH').change(load_auth_search);
    $(document).on("click",'.ADD-AUTH-BUTTON',function(){ new_auth_row($(this).attr("people_id")); });
    $('#PAGE-WRAPPER').append("<table id='ASSET_AUTHS-NEWPEOPLE' class='table table-bordered table-striped'><tbody></tbody></table>");
});

</script>
