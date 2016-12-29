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
    <li class='active'><a href='#'>LINKS</a></li>
    <li class='disabled'><a href='#'>FILES</a></li>
    <li class='disabled'><a href='#'>IMAGES</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>

<table class='TABLE-FILTER'>
<tbody>
<tr>
<td width='100%'><input ID='ASSET_LINKS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="ASSET_LINKS-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='ASSET_LINKS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%' >ID</th>
    <th width='25%'>NAME</th>
    <th width='75%'>LINK</th>
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
    $('#ASSET_LINKS-TABLE tbody').empty();
    if (api_success(data)){
        $('.ASSETS_NAME').text(data.meta.assets_name);
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["ASSET_LINKS_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSET_LINKS-" + row["ASSET_LINKS_ID"] + "-ASSET_LINKS_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSET_LINKS_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSET_LINKS-" + row["ASSET_LINKS_ID"] + "-ASSET_LINKS_LINK";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSET_LINKS_LINK"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSET_LINKS-" + row["ASSET_LINKS_ID"] + "-ASSET_LINKS_ORDER";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'number'}).addClass("TABLE-EDIT").val(row["ASSET_LINKS_ORDER"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>');
				btnid = "DELETE-ASSET_LINKS-" + row["ASSET_LINKS_ID"];
                rowkey1 = "ASSET_LINKS-" + row["ASSET_LINKS_ID"] + "-ASSET_LINKS_NAME";
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#ASSET_LINKS-TABLE tbody').append(tr);
            });
        }
        $('#ASSET_LINKS-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("ASSET LINK CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "ASSET_LINKS/new";
    var data = { "assets_id": <?=$rowid?>, "name": name }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#ASSET_LINKS-SEARCH').val();
    var data = { "assets_id": <?=$rowid?>, "disabled": 1 };
    if (query){ data["query"] = query; }
    api("ASSET_LINKS/list", data, load_table_callback);
}

$(function(){
    $('#ASSET_LINKS-TABLE').tablesorter( {textExtraction: tablesortExtraction, sortList: [[4,0]] } );
    $('#ASSET_LINKS-NEW').click(function(){ haxGet("NEW LINK NAME?", "NEW LINK", new_row); });
    $('#ASSET_LINKS-SEARCH').change(load_table);
    load_table();
});

</script>
