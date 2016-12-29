<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h5><nobr>
ASSETS  
</h5></nobr></td>
</tr>
<tr>
<td width='100%'><input ID='ASSETS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="ASSETS-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='ASSETS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th width='1%'>ID</th>
    <th>TYPE</th>
    <th>NAME</th>
    <th class='hidden-sm' width='1%'>QTY</th>
    <th class='hidden-sm'>LOCATION</th>
    <th colspan=2 class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>

<script>

load_table_callback = function(data){
    $('#ASSETS-TABLE tbody').empty();
    if (api_success(data)){
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');

				td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({"href": '/page/asset/' + row["ASSETS_ID"], "readonly": true});
                $(input).addClass("TABLE-EDIT").addClass("TABLE-LINK").val(row["ASSETS_ID"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSETS-" + row["ASSETS_ID"] + "-ASSETS_TYPE";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSETS_TYPE"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSETS-" + row["ASSETS_ID"] + "-ASSETS_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["ASSETS_NAME"]);
                $(td).append(input);
                $(tr).append(td);

				id = "ASSETS-" + row["ASSETS_ID"] + "-ASSETS_QUANTITY";
                td = $('<td>').addClass("TD-EDIT").addClass("hidden-sm");
                input = $('<input/>').attr({ id: id, type: 'number'}).addClass("TABLE-EDIT").val(row["ASSETS_QUANTITY"]);
                $(td).append(input);
                $(tr).append(td);

                id = "ASSETS-" + row["ASSETS_ID"] + "-ASSETS_LOCATION";
                td = $('<td>').addClass("TD-EDIT").addClass("hidden-sm");
                select = $('<select/>').attr("id",id).addClass("TABLE-EDIT");
                $("<option />").appendTo(select);
                $.each(data.meta.lists["ASSET LOCATIONS"],function(key, row){
                    $("<option />", {value: row["LIST_ITEMS_VALUE"], text: row["LIST_ITEMS_DESCRIPTION"]}).appendTo(select);
                });
                $(select).val(row["ASSETS_LOCATION"]);
                $(td).append(select);
				$(tr).append(td);

				td = $('<td>');
                button = $('<a/>').attr({ "href": '/page/asset/' + row["ASSETS_ID"] });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-info");
                icon = $('<i/>').addClass("fa").addClass("fa-edit");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

				td = $('<td>');
                rowkey1 = "ASSETS-" + row["ASSETS_ID"] + "-ASSETS_NAME";
                btnid = "DELETE-ASSETS-" + row["ASSETS_ID"];
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#ASSETS-TABLE tbody').append(tr);
            });
        }
        $('#ASSETS-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("LIST CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "ASSETS/new";
    var data = { "name": name };
    api(call, data, new_callback);
}

load_table = function(){
    var query = $('#ASSETS-SEARCH').val();
    var loc = $('#TABLE-FILTER-LOCATIONS').val()
    var data = { "lists": 1 };
    if (query){ data["query"] = query; }
    if (loc){ data["location"] = loc; }
    api("ASSETS/list", data, load_table_callback);
}

$(function(){
    $('#ASSETS-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#ASSETS-NEW').click(function(){ haxGet("New Asset Name?", "NEW ASSET", new_row); });
    $('#ASSETS-SEARCH').change(load_table);
    $('#TABLE-FILTER-LOCATIONS').change(load_table);
    load_table();
});

</script>
