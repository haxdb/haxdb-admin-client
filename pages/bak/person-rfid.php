<?php
$rowid = intval($_GET["arg1"]);
?>

<h5>
<a href='/page/people'>PEOPLE</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span class='PEOPLE_NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li><a href='/page/person/<?=$rowid?>'>PERSON</a></li>
    <li class="active"><a href='#'>RFID</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>

<table class='TABLE-FILTER'>
<tbody>
<tr>
<td width='100%'><input ID='PEOPLE_RFID-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="PEOPLE_RFID-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='PEOPLE_RFID-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%' >ID</th>
    <th>NAME</th>
    <th>RFID</th>
    <th width='1%'>ENABLED</th>
    <th class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>

</div></div>
<script>

load_table_callback = function(data){
    $('#PEOPLE_RFID-TABLE tbody').empty();
    if (api_success(data)){
        $('.PEOPLE_NAME').text(data.meta["people_name"]);
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["PEOPLE_RFID_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "PEOPLE_RFID-" + row["PEOPLE_RFID_ID"] + "-PEOPLE_RFID_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["PEOPLE_RFID_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                id = "PEOPLE_RFID-" + row["PEOPLE_RFID_ID"] + "-PEOPLE_RFID_RFID";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'password'}).addClass("TABLE-EDIT").val(row["PEOPLE_RFID_RFID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "PEOPLE_RFID-" + row["PEOPLE_RFID_ID"] + "-PEOPLE_RFID_ENABLED";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr({ id: id }).addClass("TABLE-EDIT");
                $("<option />", {value: "0", text: "NO"}).appendTo(select);
                $("<option />", {value: "1", text: "YES"}).appendTo(select);
                $(select).val(row["PEOPLE_RFID_ENABLED"]);
                $(td).append(select);
                $(tr).append(td);

				td = $('<td>');
				btnid = "DELETE-PEOPLE_RFID-" + row["PEOPLE_RFID_ID"];
                rowkey1 = "PEOPLE_RFID-" + row["PEOPLE_RFID_ID"] + "-PEOPLE_RFID_NAME";
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#PEOPLE_RFID-TABLE tbody').append(tr);
            });
        }
        $('#PEOPLE_RFID-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "PEOPLE_RFID/new";
    var data = { "people_id": <?=$rowid?>, "name": name }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#PEOPLE_RFID-SEARCH').val();
    var data = { "people_id": <?=$rowid?> };
    if (query){ data["query"] = query; }
    api("PEOPLE_RFID/list", data, load_table_callback);
}

$(function(){
    $('#PEOPLE_RFID-TABLE').tablesorter( {textExtraction: tablesortExtraction, sortList: [[4,0]] } );
    $('#PEOPLE_RFID-NEW').click(function(){ haxGet("NEW RFID NAME?", "NEW RFID", new_row); });
    $('#PEOPLE_RFID-SEARCH').change(load_table);
    load_table();
});

</script>
