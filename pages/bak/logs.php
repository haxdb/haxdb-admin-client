<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h5><nobr>
LOGS  
</h5></nobr></td>
</tr>
<tr>
<td width='100%'><input ID='LOGS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
</tr>
</table>

<div class='scrollx'>
<table id='LOGS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%'>ID</th>
    <th>WHO</th>
    <th>ACTION</th>
    <th>ASSET</th>
    <th>NODE</th>
    <th>DESCRIPTION</th>
    <th>TIMESTAMP</th>
</thead>
<tbody>

</tbody>
</table>
</div>

<script>

load_table_callback = function(data){
    $('#LOGS-TABLE tbody').empty();
    if (api_success(data)){
        if (data.rows){
            $.each(data.rows, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LOGS_ID"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["ACTION_FIRST_NAME"] + " " + row["ACTION_LAST_NAME"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["ACTION_VALUE"]);
                $(td).append(input);
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["ASSETS_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LOGS_NODE_NAME"]);
                $(td).append(input);
                $(tr).append(td);

                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LOGS_DESCRIPTION"])
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LOGS_UPDATED"])
                $(td).append(input);
                $(tr).append(td);

                $('#LOGS-TABLE tbody').append(tr);
            });
        }
        $('#LOGS-TABLE').trigger("update");
    }
}

load_table = function(){
    var query = $('#LOGS-SEARCH').val();
    var data = {};
    if (query){ data["query"] = query; }
    api("LOGS/list", data, load_table_callback);
}

load_lists_callback = function(data){

}

load_lists = function(){
    var data = { "name": ["LOG ACTIONS","LOG NODES"] }
    api("LIST_ITEMS/list", data, load_lists_callback);
}

$(function(){
    $('#LOGS-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#LOGS-SEARCH').change(load_table);
    load_table();
});

</script>
