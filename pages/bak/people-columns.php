<table class='TABLE-FILTER'>
<tbody>
<tr>
<td colspan=2><h4><nobr>PEOPLE COLUMNS</nobr></h4></td>
</tr>
<tr>
<td width='100%'><input ID='PEOPLE_COLUMNS-SEARCH' type='text' class='form-control' placeholder='SEARCH'/></td>
<td><button id="PEOPLE_COLUMNS-NEW" type="button" class="btn btn-primary"><i class="fa fa-plus padright"></i></button></td>
</tr>
</table>

<div class='scrollx'>
<table id='PEOPLE_COLUMNS-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
    <th>CATEGORY</th>
    <th>NAME</th>
    <th>TYPE</th>
    <th>LIST</th>
    <th>KEY</th>
    <th>QUICKEDIT</th>
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
		$.each(data.rows, function(key,list){ HAXDB_LISTS.push(list); });
		load_table();
	}
}


load_table_callback = function(data){
    $('#PEOPLE_COLUMNS-TABLE tbody').empty();
    if (api_success(data)){
        if (data.rows){
            $.each(data.rows, function(rowid,row){
                if (row["PEOPLE_COLUMNS_GUI"] == 1){

                tr = $('<tr>');
                rowid = row["PEOPLE_COLUMNS_ID"]

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_CATEGORY";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["PEOPLE_COLUMNS_CATEGORY"]);
                $(td).append(input);
                $(tr).append(td);

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_NAME";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["PEOPLE_COLUMNS_NAME"]);
                $(td).append(input);
                $(tr).append(td);


                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_TYPE";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "TEXT", text: "TEXT"}).appendTo(select);
                $("<option />", {value: "INT", text: "INTEGER"}).appendTo(select);
                $("<option />", {value: "FLOAT", text: "FLOAT"}).appendTo(select);
                $("<option />", {value: "DATE", text: "DATE"}).appendTo(select);
                $("<option />", {value: "LIST", text: "LIST"}).appendTo(select);
                $("<option />", {value: "FILE", text: "FILE"}).appendTo(select);
                $(select).val(row["PEOPLE_COLUMNS_TYPE"]);
                $(td).append(select);
                $(tr).append(td);

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_LISTS_ID";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
				$("<option />").appendTo(select);
				$.each(HAXDB_LISTS, function(key, list){
					$("<option />", { value: list.LISTS_ID, text: list.LISTS_NAME }).appendTo(select);
				});
				$(select).val(row["PEOPLE_COLUMNS_LISTS_ID"]);
                $(td).append(select);
                $(tr).append(td);

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_KEY";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "1", text: "Y"}).appendTo(select);
                $("<option />", {value: "0", text: "N"}).appendTo(select);
                $(select).val(row["PEOPLE_COLUMNS_KEY"]);
                $(td).append(select);
                $(tr).append(td);

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_QUICKEDIT";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "1", text: "Y"}).appendTo(select);
                $("<option />", {value: "0", text: "N"}).appendTo(select);
                $(select).val(row["PEOPLE_COLUMNS_QUICKEDIT"]);
                $(td).append(select);
                $(tr).append(td);

                id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_ENABLED";
                td = $('<td>').addClass("TD-EDIT");
                select = $('<select/>').attr( {"id": id }).addClass("TABLE-EDIT");
                $("<option />", {value: "1", text: "Y"}).appendTo(select);
                $("<option />", {value: "0", text: "N"}).appendTo(select);
                $(select).val(row["PEOPLE_COLUMNS_ENABLED"]);
                $(td).append(select);
                $(tr).append(td);

				id = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_ORDER";
                td = $('<td>').addClass("TD-EDIT");
                input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(row["PEOPLE_COLUMNS_ORDER"]);
                $(td).append(input);
                $(tr).append(td);

				td = $('<td>');
                rowkey1 = "PEOPLE_COLUMNS-" + rowid + "-PEOPLE_COLUMNS_NAME";
                btnid = "DELETE-PEOPLE_COLUMNS-" + rowid;
                button = $('<button/>').attr({id: btnid, "type":"button", "rowkey1": rowkey1 });
                $(button).addClass("btn").addClass("btn-sm").addClass("btn-danger").addClass("TABLE-DELETE");
                icon = $('<i/>').addClass("fa").addClass("fa-trash");
                $(button).append(icon);
                $(td).append(button);
                $(tr).append(td);

                $('#PEOPLE_COLUMNS-TABLE tbody').append(tr);
                }
            });
        }
        $('#PEOPLE_COLUMNS-TABLE').trigger("update");
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay("PEOPLE COLUMN CREATED","success");
        load_table(); 
    }
}

new_row = function(name){
    var call = "PEOPLE_COLUMNS/new"
    var data = { "name": name }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#PEOPLE_COLUMNS-SEARCH').val();
    var data = {};
    if (query){ data["query"] = query; }
    api("PEOPLE_COLUMNS/list", data, load_table_callback);
}

load_lists = function(){
	api("LISTS/list", {}, load_lists_callback);
}

$(function(){
    $('#PEOPLE_COLUMNS-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#PEOPLE_COLUMNS-NEW').click(function(){ haxGet("New Column?", "NEW_COLUMN", new_row); });
    $('#PEOPLE_COLUMNS-SEARCH').change(load_table);
    load_lists();
});

</script>
