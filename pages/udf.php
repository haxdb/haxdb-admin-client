<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h4><nobr>UDF: <span id='UDF_CONTEXT'><?= $_GET["arg1"] ?><?= (!empty($_GET["arg3"]))?": ".$_GET["arg3"]:""; ?></span></nobr></h4></td>
</tr>
<tr>
<td width='100%'><input ID='UDF-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="UDF-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='UDF-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th>NAME</th>
    <th>TYPE</th>
    <th>LIST</th>
    <th>ENABLED</th>
	<th>ORDER</th>
    <th class='empty'></th>
</thead>
<tbody>

</tbody>
</table>
</div>
<script>

var HAXDB_LISTS = [];
load_lists_callback = function(data){
    if (api_success(data)){
        $.each(data.data, function(key,list){ HAXDB_LISTS.push(list); });
        load_table();
    }
}

load_table_callback = function(data){
    $('#UDF-TABLE tbody').empty();
    if (api_success(data)){
        if (data.data){
            $.each(data.data, function(rowid,row){
                tr = $('<tr>');
                rowid = row["UDF_ID"]

                id = "UDF-" + rowid + "-UDF_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["UDF_NAME"]);
                $(td).append(input);
                $(tr).append(td);


                id = "UDF-" + rowid + "-UDF_TYPE";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "TEXT", text: "TEXT"}).appendTo(select);
                $("<option />", {value: "INT", text: "INTEGER"}).appendTo(select);
                $("<option />", {value: "FLOAT", text: "FLOAT"}).appendTo(select);
                $("<option />", {value: "DATE", text: "DATE"}).appendTo(select);
                $("<option />", {value: "BOOL", text: "BOOL"}).appendTo(select);
                $("<option />", {value: "LIST", text: "LIST"}).appendTo(select);
                $("<option />", {value: "FILE", text: "FILE"}).appendTo(select);
                $(select).val(row["UDF_TYPE"]);
                $(td).append(select);
                $(tr).append(td);

                id = "UDF-" + rowid + "-UDF_LISTS_ID";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
				$("<option />").appendTo(select);
				$.each(HAXDB_LISTS, function(key, list){
					$("<option />", { value: list.LISTS_ID, text: list.LISTS_NAME }).appendTo(select);
				});
				$(select).val(row["UDF_LISTS_ID"]);
                $(td).append(select);
                $(tr).append(td);

                id = "UDF-" + rowid + "-UDF_ENABLED";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "1", text: "Y"}).appendTo(select);
                $("<option />", {value: "0", text: "N"}).appendTo(select);
                $(select).val(row["UDF_ENABLED"]);
                $(td).append(select);
                $(tr).append(td);

				id = "UDF-" + rowid + "-UDF_ORDER";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["UDF_ORDER"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>');
                rowkey1 = "UDF-" + rowid + "-UDF_NAME";
                btnid = "DELETE-UDF-" + rowid;
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#UDF-TABLE tbody').append(tr);
            });
        }
        $('#UDF-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay(data.message,"success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "UDF/new"
    var data = { "name": name, "context": "<?=$_GET["arg1"]?>" }
    <?php if (!empty($_GET["arg2"])) echo 'data["context_id"] = "' . $_GET["arg2"] . '";'; ?>
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#UDF-SEARCH').val();
    var data = { "context": "<?=$_GET["arg1"]?>", "disabled": 1 };
    <?php if (!empty($_GET["arg2"])) echo 'data["context_id"] = "' . $_GET["arg2"] . '";'; ?>
    if (query){ data["query"] = query; }
    api("UDF/list", data, load_table_callback);
}

load_lists = function(){
    api("LISTS/list", { }, load_lists_callback);
}

$(function(){
    $('#UDF-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#UDF-NEW').click(function(){ haxGet("New Column?", "NEW_COLUMN", new_row); });
    $('#UDF-SEARCH').change(load_table);
    load_lists();
});

</script>
