<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h4><nobr>LISTS</nobr></h4></td>
</tr>
<tr>
<td width='100%'><input ID='LISTS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="LISTS-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='LISTS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%'>ID</th>
    <th width='100%'>NAME</th>
    <th colspan=2 class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>

<script>

load_table_callback = function(data){
    $('#LISTS-TABLE tbody').empty();
    if (api_success(data)){
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["LISTS_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "LISTS-" + row["LISTS_ID"] + "-LISTS_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["LISTS_NAME"]);
                if (row["LISTS_INTERNAL"] == 1) input.attr("readonly", true);
                $(td).append(input);
                $(tr).append(td);

                td = $('<td>');
				btn_href = "/page/list-items/" + row["LISTS_ID"];
                button = $('<a/>').attr({"href": btn_href}).addClass("btn").addClass("btn-sm").addClass("btn-info");
                icon = $('<i/>').addClass("fa").addClass("fa-edit");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

				td = $('<td>');
                rowkey1 = "LISTS-" + row["LISTS_ID"] + "-LISTS_NAME";
                btnid = "DELETE-LISTS-" + row["LISTS_ID"];
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                if (row["LISTS_INTERNAL"] == 1) button.attr("disabled", true);
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#LISTS-TABLE tbody').append(tr);
            });
        }
        $('#LISTS-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("LIST CREATED","success");
        load_table(); 
    }
}

new_list = function(name){
    var call = "LISTS/new";
    var data = { "name": name };
    api(call, data, new_callback);
}

load_table = function(){
    var query = $('#LISTS-SEARCH').val();
    var data = {};
    if (query){ data["query"] = query; }
    api("LISTS/list", data, load_table_callback);
}

$(function(){
    $('#LISTS-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#LISTS-NEW').click(function(){ haxGet("New List Name?", "NEW LIST", new_list); });
    $('#LISTS-SEARCH').change(load_table);
    load_table();
});

</script>
