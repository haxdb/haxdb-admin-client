<?php
$rowid = intval($_GET["arg1"]);
?>

<h5>
<a href='/page/assets'>ASSETS</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span class='ASSETS_NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li><a href='/page/asset/<?= $rowid ?>'>ASSET</a></li>
    <li><a href='/page/asset-rfid/<?= $rowid ?>'>RFID</a></li>
    <li class='active'><a href='#'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <li class='disabled'><a href='#'>FILES</a></li>
    <li class='disabled'><a href='#'>IMAGES</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>

<table class='TABLE-FILTER'>
<tbody>
<tr>
<td width='100%'><input ID='ASSET_AUTHS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
</tr>
</table>

<div class='scrollx'>
<table id='ASSET_AUTHS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%' >ID</th>
    <th>NAME</th>
    <th class='hidden-xs' width='500'>EMAIL</th>
    <th class='empty'></th>
</thead>
<tbody></tbody>
</table>
<table id='ASSET_AUTHS-NEWPEOPLE' class='table table-bordered table-striped'><tbody></tbody></table>
</div>

</div></div>

<script>

AUTHED = {}; 

load_table_callback = function(data){
    $('#ASSET_AUTHS-TABLE tbody').empty();
    if (api_success(data)){
        $('.ASSETS_NAME').text(data.meta.assets_name);
        if (data.data){
            AUTHED = {};
            $.each(data.data, function(rowid,row){
                people_id = row["ASSET_AUTHS_PEOPLE_ID"];
                AUTHED[people_id] = 1;
                $('#NEW_AUTHS-' + people_id).hide();

                tr = $('<tr>');

                td = $('<td>').addClass("TD-EDIT");
				id = "ASSET_AUTHS-" + row["ASSET_AUTHS_ID"] + "-ASSET_AUTHS_ID";
                input = $('<input/>').attr({ type: 'text', 'id': id, 'disabled': true}).addClass("TABLE-EDIT").val(row["ASSET_AUTHS_ID"]);
                $(td).append(input);                
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
                id = "ASSET_AUTHS-" + row["ASSET_AUTHS_ID"] + "-PEOPLE_NAME";
                name = row["PEOPLE_NAME_FIRST"] + " " + row["PEOPLE_NAME_LAST"];
                input = $('<input/>').attr({ type: 'text', 'id': id, 'disabled': true}).addClass("TABLE-EDIT").val(name);
                $(td).append(input);                
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
				id = "ASSET_AUTHS-" + row["ASSET_AUTHS_ID"] + "-PEOPLE_EMAIL";
                input = $('<input/>').attr({ type: 'text', 'id': id, 'disabled': true}).addClass("TABLE-EDIT").val(row["PEOPLE_EMAIL"]);
                $(td).addClass("hidden-xs");
                $(td).append(input);                
                $(tr).append(td);

				td = $('<td>').css("width","55px");
				btnid = "DELETE-ASSET_AUTHS-" + row["ASSET_AUTHS_ID"];
                rowkey1 = "ASSET_AUTHS-" + row["ASSET_AUTHS_ID"] + "-PEOPLE_NAME_FIRST";
				rowkey2 = "ASSET_AUTHS-" + row["ASSET_AUTHS_ID"] + "-PEOPLE_NAME_LAST";
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1, "rowkey2": rowkey2 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#ASSET_AUTHS-TABLE tbody').append(tr);
            });
        }
        $('#ASSET_AUTHS-TABLE').trigger("update");
    }
}

load_people_search_callback = function(data){
    if (api_success(data)){
		$('#ASSET_AUTHS-NEWPEOPLE tbody').empty();
        if (data.data){
            $.each(data.data, function(key,row){
                people_id = row["PEOPLE_ID"];
                if (!AUTHED[people_id]){

                var tr = $('<tr/>').attr("id","NEW_PEOPLE-"+people_id);
				
                td = $('<td>').addClass("TD-EDIT").css("width","100px");
                input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val("NEW");
                $(td).append(input);                
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
                name = row["PEOPLE_NAME_FIRST"] + " " + row["PEOPLE_NAME_LAST"];
                input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val(name);
                $(td).append(input);                
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT").css("width","500px");
                input = $('<input/>').attr({ type: 'text', 'disabled': true}).addClass("TABLE-EDIT").val(row["PEOPLE_EMAIL"]);
                $(td).addClass("hidden-xs");
                $(td).append(input);                
                $(tr).append(td);

                td = $('<td>').css("width","1%");
                btnid = "NEW-ASSET_AUTHS-" + row["PEOPLE_ID"];
                button = $('<button/>').attr({id: btnid, "type":"button", "people_id": row["PEOPLE_ID"] });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-primary").addClass("TABLE-NEW");
                icon = $('<i/>').addClass("fa").addClass("fa-plus");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#ASSET_AUTHS-NEWPEOPLE tbody').append(tr);

                }    
            });
        }
    }
}


new_callback = function(data){
    if (api_success(data)){
        haxSay("AUTH ADDED","success");
		$('#ASSET_AUTHS-SEARCH').val("");
        load_search(); 
    }
}

new_row = function(people_id){
    var call = "ASSET_AUTHS/new";
    var data = { "assets_id": <?=$rowid?>, "people_id": people_id }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#ASSET_AUTHS-SEARCH').val();
    var data = { "assets_id": <?= $rowid ?> };
    if (query){ data["query"] = query; }
    api("ASSET_AUTHS/list", data, load_table_callback);
}

load_search = function(){
    var query = $('#ASSET_AUTHS-SEARCH').val();
    if (query){
        var data = { "query": query, "category": "PRIMARY" }
        api("PEOPLE/list",data, load_people_search_callback);
    }else{
		$('#ASSET_AUTHS-NEWPEOPLE tbody').empty();
	}
	load_table();
}

$(function(){
    $('#ASSET_AUTHS-TABLE').tablesorter( {textExtraction: tablesortExtraction, sortList: [[4,0]] } );
    $('#ASSET_AUTHS-SEARCH').change(load_search);
	$(document).on("click",'.TABLE-NEW',function(){ new_row($(this).attr("people_id")); });
    load_table();
});

</script>
