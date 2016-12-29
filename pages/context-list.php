<table class='TABLE-FILTER'>
<tbody>
<tr> <td>
<button id="CONTEXT-NEW" type="button" class="pull-right btn btn-primary" style='margin-top: 10px;'><i class="fa fa-plus"></i> &nbsp;&nbsp; NEW</button>
<h4><?= $context ?><span id='CONTEXT-NAME'></span></h4>
</td> </tr>
<tr> <td>
<table width='100%'><tr>
<td> <input ID='CONTEXT-SEARCH' type='text' class='form-control' placeholder='SEARCH' VALUE='<?=$_DEFAULT_QUERY?>'/> </td>
<td width=300 class='hidden-xs hidden-sm'> 
<select class='form-control' id='FIELDSET-SELECT' class='pull-right'> <option value='0'>DEFAULT FIELDSET</option> </select> 
</td>
<td width=150 ALIGN=RIGHT class='hidden-xs hidden-sm'>
<div class='btn-group' role='group' aria-label="FIELDSET ACTIONS">
    <div class='btn-group' role='group'>
        <button class='btn dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class='fa fa-plus'></i>
        </button>
        <ul class='dropdown-menu'>
            <li><a href='#' id='FIELDSET-NEW-USER'>NEW USER FIELDSET</a></li>
            <li><a href='#' id='FIELDSET-NEW-GLOBAL'>NEW GLOBAL FIELDSET</a></li>
        </ul>
    </div>
    <button id='FIELDSET-EDIT' class='btn'><i class='fa fa-edit'></i></button>
    <button id='FIELDSET-DELETE' class='btn'><i class='fa fa-trash'></i></button>
</div>
</td>
</tr></table>
</td> </tr>
</table>

<div class='scrollx'>
<table id='CONTEXT-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
</thead>
<tbody>

</tbody>
</table>
<div id='loader'></div>
</div>

<script>

var context = "<?= $context ?>";
var context_id = <?= $context_id ?>;

var COLS = {}; 
<?php
foreach ($_COLS as $col => $def){
    echo "COLS['$col'] = { 'ORDER': ".$def["ORDER"].", 'HEADER': '".$def["HEADER"]."', 'TYPE': '".$def["TYPE"]."'";
    if (!empty($def["LIST"])) echo ", 'LIST_NAME': '".$def["LIST"]."'";
    echo "}\n";
}
?>

var FIELDSETS = {};
var CONTEXT_NAME = null;
var CONTEXT_DATA = Array();
var LISTS = Array();
var LISTS_BY_NAME = {}; 

load_fieldset_callback = function(data){
    if (api_success(data)){
        if (data.data){
            var val = $('#FIELDSET-SELECT').val();
            $('#FIELDSET-SELECT').find('option').remove();
            $.each(data.data, function(key, fieldset){
                fieldset_id = fieldset["FIELDSET_ID"];
                fieldset_name = fieldset["FIELDSET_NAME"];
                fieldset_cols = fieldset["COLS"];
                FIELDSETS[fieldset_id] = {};
                FIELDSETS[fieldset_id]["NAME"] = fieldset_name;
                FIELDSETS[fieldset_id]["COLS"] = [];
                FIELDSETS[fieldset_id]["QUERY"] = fieldset["FIELDSET_QUERY"];
                $.each(fieldset_cols, function(key,row){ FIELDSETS[fieldset_id]["COLS"].push(row["FIELDSET_COLS_COL"]); });
                name = fieldset_name;
                console.log(fieldset);
                if (fieldset["FIELDSET_PEOPLE_ID"] != 0){
                    name += " [USER]";
                }
                option = $("<option />", {value: fieldset_id, text: name} );
                $('#FIELDSET-SELECT').append(option);
            });
            if (val){ 
                var exists = false;
                $('#FIELDSET-SELECT option').each(function(){ if (this.value == val){ exists = true; return false; } });
                if (exists){ $('#FIELDSET-SELECT').val(val); }
            }
            $("#FIELDSET-SELECT").change();
        }else{
            data = { context: context, context_id: context_id };
            data["name"] = "DEFAULT FIELDSET";
            data["query"] = "<?=$_DEFAULT_QUERY?>";
            data["cols"] = ["<?= implode("\",\"", $_DEFAULT_FIELDSET) ?>"];
            data["global"] = 1;
            api("FIELDSET/new", data, function(data){
                if (api_success(data)){
                    load_fieldsets();
                }
            }); 
        }
    }
}

load_list_callback = function(data){
    if (api_success(data)){
        if (data.data){
			lists_id = data.data[0]["LISTS_ID"];
            lists_name = data.data[0]["LISTS_NAME"];
            LISTS[lists_id] = data.data;
            LISTS_BY_NAME[lists_name] = lists_id;
        }
    }
}

load_udf_callback = function(data){
    UDF = Array();
    if (api_success(data)){ 
        if (data.data){ 
            $.each(data.data, function(key, row){
                name = row["UDF_NAME"];
                type = row["UDF_TYPE"];
                order = row["UDF_ORDER"];
                list = null;
                if (row["UDF_TYPE"] == "LIST" && row["UDF_LISTS_ID"]){
                    list = row["UDF_LISTS_ID"];
                    if (!(LISTS[row["UDF_LISTS_ID"]])){
                        api("LIST_ITEMS/list", { "lists_id": row["UDF_LISTS_ID"] }, load_list_callback);
                    }
                }
                COLS[name] = { "ORDER": order, "HEADER": name, "TYPE": type, "LIST": list }
            });
        } 
    }
}

load_table_callback = function(data){
    if (api_success(data)){
        if (data.data){ CONTEXT_DATA = data.data; }else{ CONTEXT_DATA = {}; }
        if (data.meta && data.meta.context_name){
		CONTEXT_NAME = data.meta.context_name;
		$('#CONTEXT-NAME').text(": " + data.meta.context_name);
	}
        draw_table();
    }
}

draw_table = function(){
    fieldset = FIELDSETS[$('#FIELDSET-SELECT').val()];
    if (fieldset["COLS"]){
        fields = fieldset["COLS"];
    }else{
        fields = [];
    }
    $('#loader').hide();
    $('#CONTEXT-TABLE thead').empty();
    $('#CONTEXT-TABLE').trigger("destroy");

    tr = $('<tr>');

    th = $('<th>').css("width","1%").html("ID").attr("title","<?=$context?>_ID");
    tr.append(th);

    total = 0;
    $.each(fields, function(key,col){
        if (COLS[col]){
            total += 1;
            header = COLS[col]["HEADER"];
            th = $('<th>').html(header).attr("title",col);
            if (total > 2){ $(th).addClass("hidden-xs hidden-sm"); }
            tr.append(th);
        }
    });

    href = "/page/udf/<?=$context?>/<?=$context_id?>";
    if (CONTEXT_NAME) href += "/" + CONTEXT_NAME;
    th = $('<th>').addClass("empty").css("width","1%").attr("colspan",2).css("text-align", "center");
    $(th).addClass("TD-LINK BUTTON-TD").attr("href",href);
    icon = $('<i/>').addClass("fa").addClass("fa-list");
    $(th).append(icon);
    tr.append(th);
    $('#CONTEXT-TABLE thead').append(tr);

    $('#CONTEXT-TABLE tbody').empty();
    if (CONTEXT_DATA){
        $.each(CONTEXT_DATA, function(rowid,row){
            tr = $('<tr>');

            td = $('<td>').addClass("TD-EDIT");
            input = $('<input/>').attr({ type: 'text', disabled: true}).addClass("TABLE-EDIT").val(row["<?= $context ?>_ID"]);
            $(td).append(input);
            $(tr).append(td);

            total = 0;
            $.each(fields, function(key,col){
                if (COLS[col]){
                    total += 1;
	    			id = "<?= $context ?>-" + row["<?= $context ?>_ID"] + "-" + col;
			    	type = COLS[col]["TYPE"];
		    		val = row[col];
                    list = null;
                    if (COLS[col]["LIST"]){ list = LISTS[COLS[col]["LIST"]]; }
                    if (COLS[col]["LIST_NAME"]){ list = LISTS[LISTS_BY_NAME[COLS[col]["LIST_NAME"]]]; }
                    td = haxdb_table_cell ( id, type, val, list );
                    if (total > 2){ $(td).addClass("hidden-xs hidden-sm"); }
			    	$(tr).append(td);
                }
            });

            href = "/page/<?= $_EDIT_PAGE ?>/" + row["<?=$context?>_ID"];
            td = $('<td>').addClass("BUTTON-TD").addClass("TD-LINK").attr("href", href);
            <?php if (empty($_EDIT_PAGE)){ echo "$(td).addClass('disabled');"; } ?>
            icon = $('<i/>').addClass("fa").addClass("fa-search");
            $(td).append(icon);
            $(tr).append(td);

            td = $('<td>').addClass("CONTEXT-ROW-DELETE").addClass("BUTTON-TD");
            if (row[context+"_INTERNAL"] && row[context+"_INTERNAL"] == 1){ $(td).addClass("disabled"); }
            delete_name = "";
            <?php foreach($_ROW_NAME as $key => $col){ echo "            delete_name += ' ' + row['$col'];\n"; } ?>
            $(td).attr("DELETE-ROWID", row["<?=$context?>_ID"]);
            $(td).attr("DELETE-NAME", delete_name);
            icon = $('<i/>').addClass("fa").addClass("fa-trash");
            $(td).append(icon);
            $(tr).append(td);
                
            $('#CONTEXT-TABLE tbody').append(tr);
        });
        $('#CONTEXT-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    }
}

new_callback = function(data){
    if (api_success(data)){
        haxSay(data.message,"success");
        load_table(); 
    }
}

new_row = function(data){
    var call = "<?=$context?>/new";
    var data = { "<?=$_NEW_ASK?>": data, context_id: context_id }
    api(call,data,new_callback);
}

load_table = function(){
    var query = $('#CONTEXT-SEARCH').val();
    var data = { context_id: context_id };
    if (query){ data["query"] = query; }
    $('#CONTEXT-TABLE thead').empty();
    $('#CONTEXT-TABLE tbody').empty();
    $('#loader').show();
    api("<?= $context ?>/list", data, load_table_callback);
}

load_lists = function(){
<?php
    $seenlist = Array();
    foreach ($_COLS as $col => $def){
        if (!empty($def["LIST"]) && empty($seenlist[$def["LIST"]])){
?>
        api("LIST_ITEMS/list", { "lists_name": "<?=$def["LIST"]?>" }, load_list_callback);
<?php
        }
    }
?>
}

load_udf = function(){
	api("UDF/list", { "context": "<?= $context ?>", "context_id": <?= intval($context_id) ?> }, load_udf_callback);
}

load_fieldsets = function(){
    api("FIELDSET/list", { "context": context, "context_id": context_id }, load_fieldset_callback);
}

$(function(){
    $('#FIELDSET-SELECT').change( function(){ 
        fieldset = $('#FIELDSET-SELECT').val();
        old_query = $('#CONTEXT-SEARCH').val();
        query = FIELDSETS[fieldset]["QUERY"];
        if (old_query != query){
            $('#CONTEXT-SEARCH').val(query);
            load_table();
        }else{
            draw_table(); 
        }
    });
    $('#CONTEXT-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#CONTEXT-NEW').click(function(){ haxGet("<?= strtoupper($_NEW_ASK) ?>", "<?= $_NEW_ASK_DEFAULT ?>", new_row); });
    $('#CONTEXT-SEARCH').change(load_table);
    load_fieldsets();
    load_lists();
	load_udf();
    load_table();
});

</script>
