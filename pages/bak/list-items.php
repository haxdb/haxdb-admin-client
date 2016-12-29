<?php $rowid = $_GET["arg1"]; ?>
<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2>
<h4><nobr><a href='/page/lists'>LISTS</a> &nbsp;&gt;&nbsp; <span id='LIST_ITEMS-NAME'></span></nobr></h4>
</td>
</tr>
<tr>
<td width='100%'><input ID='LIST_ITEMS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="LIST_ITEMS-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='LIST_ITEMS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%' >ID</th>
    <th width='25%'>VALUE</th>
    <th width='75%'>DESCRIPTION</th>
    <th>ENABLED</th>
    <th>ORDER</th>
    <th class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>

<script>

load_table_callback = function(data){
    $('#LIST_ITEMS-TABLE tbody').empty();
    if (api_success(data)){
        $('#LIST_ITEMS-NAME').text(data.meta.lists_name);
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LIST_ITEMS_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "LIST_ITEMS-" + row["LIST_ITEMS_ID"] + "-LIST_ITEMS_VALUE";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text', readonly: true}).addClass("TABLE-EDIT").val(row["LIST_ITEMS_VALUE"]);
                $(td).append(input);
                $(tr).append(td);

                id = "LIST_ITEMS-" + row["LIST_ITEMS_ID"] + "-LIST_ITEMS_DESCRIPTION";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["LIST_ITEMS_DESCRIPTION"]);
                $(td).append(input);
                $(tr).append(td);

                id = "LIST_ITEMS-" + row["LIST_ITEMS_ID"] + "-LIST_ITEMS_ENABLED";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr("id",id).addClass("TABLE-EDIT");
                $("<option />", {value: "1", text: "Y"}).appendTo(select);
                $("<option />", {value: "0", text: "N"}).appendTo(select);
                //input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["LIST_ITEMS_ENABLED"]);
                $(select).val(row["LIST_ITEMS_ENABLED"]);
                $(td).append(select);
                $(tr).append(td);

                id = "LIST_ITEMS-" + row["LIST_ITEMS_ID"] + "-LIST_ITEMS_ORDER";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'number'}).addClass("TABLE-EDIT").val(row["LIST_ITEMS_ORDER"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>');
				btnid = "DELETE-LIST_ITEMS-" + row["LIST_ITEMS_ID"]; 
                rowkey1 = "LIST_ITEMS-" + row["LIST_ITEMS_ID"] + "-LIST_ITEMS_VALUE";
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#LIST_ITEMS-TABLE tbody').append(tr);
            });
        }
        $('#LIST_ITEMS-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("LIST ITEM CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "LIST_ITEMS/new";
    var data = { "lists_id": <?=$rowid?>, "name": name }
    api(call,data,new_callback);
}

load_table = function(){
    var rowid = <?=$rowid?>;
    var query = $('#LIST_ITEMS-SEARCH').val();
    var data = { "lists_id": rowid, "include_disabled": 1 };
    if (query){ data["query"] = query; }
    api("LIST_ITEMS/list", data, load_table_callback);
}

$(function(){
    $('#LIST_ITEMS-TABLE').tablesorter( {textExtraction: tablesortExtraction, sortList: [[4,0]] } );
    $('#LIST_ITEMS-NEW').click(function(){ haxGet("NEW LIST ITEM:", "NEW ITEM", new_row); });
    $('#LIST_ITEMS-SEARCH').change(load_table);
    load_table();
});

</script>
