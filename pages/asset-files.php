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
    <li><a href='/page/asset-auths/<?= $rowid ?>'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <li class='active'><a href='#'>FILES</a></li>
    <li><a href='/page/asset-images/<?= $rowid ?>'>IMAGES</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>

<table class='TABLE-FILTER'>
<tbody>
<tr>
<td width='100%'><input ID='ASSET_FILES-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="ASSET_FILES-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='ASSET_FILES-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%' >ID</th>
    <th width='25%'>NAME</th>
    <th width='75%'>FILE</th>
    <th>ORDER</th>
    <th class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>

</div></div>

<script>

load_table_callback = function(data){
    $('#ASSET_FILES-TABLE tbody').empty();
    if (api_success(data)){
        $('.ASSETS_NAME').text(data.name);
        if (data.rows){
            $.each(data.rows, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["ASSET_FILES_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSET_FILES-" + row["ASSET_FILES_ID"] + "-ASSET_FILES_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSET_FILES_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSET_FILES-" + row["ASSET_FILES_ID"] + "-ASSET_FILES_FILE";
                td = $('<td>').addClass("TD-EDIT");
                //input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSET_FILES_LINK"]);
                //$(td).append(input);
                $(tr).append(td);

                id = "ASSET_FILES-" + row["ASSET_FILES_ID"] + "-ASSET_FILES_ORDER";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'number'}).addClass("TABLE-EDIT").val(row["ASSET_FILES_ORDER"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>');
				btnid = "DELETE-ASSET_FILES-" + rowid;
                rowkey1 = "ASSET_FILES-" + row["ASSET_FILES_ID"] + "-ASSET_FILES_NAME";
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#ASSET_FILES-TABLE tbody').append(tr);
            });
        }
        $('#ASSET_FILES-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("ASSET FILE CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "ASSET_FILES/new";
    var data = { "assets_id": <?=$rowid?>, "name": name }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#ASSET_FILES-SEARCH').val();
    var data = { "assets_id": <?=$rowid?>, "disabled": 1 };
    if (query){ data["query"] = query; }
    api("ASSET_FILES/list", data, load_table_callback);
}

$(function(){
    $('#ASSET_FILES-TABLE').tablesorter( {textExtraction: tablesortExtraction, sortList: [[4,0]] } );
    $('#ASSET_FILES-NEW').click(function(){ haxGet("NEW FILE NAME?", "NEW FILE", new_row); });
    $('#ASSET_FILES-SEARCH').change(load_table);
    load_table();
});

</script>
