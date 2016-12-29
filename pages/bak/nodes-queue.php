<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h4><nobr>NODES</nobr></h4></td>
</tr>
</table>

<ul class = "nav nav-tabs">
    <li><a href='/page/nodes'>NODES</a></li>
    <li><a href='/page/nodes-temp'>SESSIONS</a></li>
    <li class='active'><a href='#'>QUEUED</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>

<table class='TABLE-FILTER'>
<tr>
<td width='100%'><input ID='NODES-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<!--<td><button id="NODES-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>-->
</tr>
</table>

<table id='NODES-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%'>ID</th>
    <th>NAME</th>
    <th>IP</th>
    <th colspan=2 width='1%'></th>
</thead>
<tbody>

</tbody>
</table>

</div>

<script>

var ASSETS = Array();

load_table_callback = function(data){
    $('#NODES-TABLE tbody').empty();
    if (api_success(data)){
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

                id = "NODES-" + row["NODES_ID"] + "-NODES_ID";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text', "disabled": true }).addClass("TABLE-EDIT").val(row["NODES_ID"]);
                $(td).append(input);
                $(tr).append(td);

				id = "NODES-" + row["NODES_ID"] + "-NODES_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text' }).addClass("TABLE-EDIT").val(row["NODES_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                id = "NODES-" + row["NODES_ID"] + "-NODES_IP";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'});
                $(input).addClass("TABLE-EDIT").val(row["NODES_IP"]);
                $(td).append(input);
                $(tr).append(td);

                td = $('<td>');
                btnid = "APPROVE-NODES-" + row["NODES_ID"];
                button = $('<button/>').attr({id: btnid, "type":"button" });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-success").addClass("APPROVE-NODE");
                icon = $('<i/>').addClass("fa").addClass("fa-thumbs-up");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

				td = $('<td>');
				rowkey1 = "NODES-" + row["NODES_ID"] + "-NODES_NAME";
				btnid = "DELETE-NODES-" + row["NODES_ID"];
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1  });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#NODES-TABLE tbody').append(tr);
            });
        }
        $('#NODES-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("NODE CREATED","success");
        load_table(); 
    }
}

new_api_key = function(listName){
    var call = "NODES/new";
    api(call,{},new_callback);
}

approve_node_callback = function(data){
    if (api_success(data)){
        load_table();
    }
}

approve_node = function (rowid){
    data = { "rowid": rowid, "col": "NODES_QUEUED", "val": 0 }
    api("NODES/save",data, approve_node_callback);
}

load_table = function(){
    var query = $('#NODES-SEARCH').val();
    var data = { "query": "" }
    if (query){ data["query"] += query; }
    data["query"] += " NODES_QUEUED=1";
    api("NODES/list", data, load_table_callback);
}

$(function(){
    $('#NODES-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#NODES-NEW').click(new_api_key);
    $('#NODES-SEARCH').change(load_table);
    $(document).on("click",'.APPROVE-NODE',function(){ 
        var tmp = $(this).attr("id").split("-");
        var rowid = tmp[2];
        console.log(rowid);
        approve_node(rowid);
    });
    load_table();
});

</script>
