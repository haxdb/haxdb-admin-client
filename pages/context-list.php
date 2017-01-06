<table class='TABLE-FILTER'>
<tbody>
<tr> <td>
<button id="CONTEXT-NEW" type="button" class="pull-right btn btn-primary" style='margin-top: 10px;'><i class="fa fa-plus"></i> &nbsp;&nbsp; NEW</button>
<h4><?= $context ?><span id='CONTEXT-NAME'></span></h4>
</td> </tr>
<tr> <td>
<table width='100%'><tr>
<td> <input ID='CONTEXT-SEARCH' type='text' class='form-control' placeholder='SEARCH' VALUE='<?=$_DEFAULT_QUERY?>'/> </td>
<td width=110 class='hidden-xs hidden-sm'> 
<div class='btn-group' role='group' arial-label='QUERY/FILTER'>
    <div class='btn-group' role='group'>
        <button class='btn dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class='fa fa-filter'></i>
        </button>
        <ul class='dropdown-menu pull-right' ID='FILTER-DROPDOWN'>
			<li><a href='#'>SAVE</a></li>
			<li><a href='#'>SAVE AS...</a></li>
            <li class='divider'></li>
        </ul>
    </div>
    <div class='btn-group' role='group'>
        <button class='btn dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            <i class='fa fa-columns'></i> 
        </button>
        <ul class='dropdown-menu pull-right' ID='FIELDSET-DROPDOWN'>
            
        </ul>
    </div>
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

var CURRENT_QUERY = null;
var CURRENT_FIELDSET = null;
var CURRENT_HEADERS = [];

var COLS = [];
var _COLS = {}; 
var LISTS = []; 
var _LISTS = {};
var FIELDSETS = {};
var CONTEXT_NAME = null;
var CONTEXT_DATA = [];

load_fieldset_callback = function(data){
    if (api_success(data)){
        if (data.data){
            $('#FIELDSET-DROPDOWN').empty();

            $.each(data.data, function(key, fieldset){
                fieldset_id = fieldset["FIELDSET_ID"];
                if (!CURRENT_FIELDSET){
					CURRENT_FIELDSET = fieldset_id;
					CURRENT_COLS = fieldset["COLS"];
				}
                FIELDSETS[fieldset_id] = fieldset;
                name = fieldset["FIELDSET_NAME"]; 
                if (fieldset["FIELDSET_PEOPLE_ID"] != 0){ name += " [USER]"; }
                li = $("<li />");
				a = $('<a/>').attr("href","#").text(name).addClass("FIELDSET-SELECT");
				$(a).attr("FIELDSET-ID", fieldset_id);
                $(li).append( a );
                $('#FIELDSET-DROPDOWN').append(li);
            });
            $('#FIELDSET-DROPDOWN').prepend( $("<li/>").addClass("divider") );

			name = FIELDSETS[CURRENT_FIELDSET]["FIELDSET_NAME"];

            a = $("<a/>").attr({ "href":"#", "id": "FIELDSET-DELETE" }).text("DELETE");
            $(a).addClass("FIELDSET-OPTION");
            li = $("<li/>").append(a);
            $('#FIELDSET-DROPDOWN').prepend( li );

            a = $("<a/>").attr({ "href":"#", "id": "FIELDSET-SAVE-AS" }).text("SAVE AS..");
            li = $("<li/>").append(a);
            $(a).addClass("FIELDSET-OPTION");
            $('#FIELDSET-DROPDOWN').prepend( li );

            a = $("<a/>").attr({ "href":"#", "id": "FIELDSET-SAVE" }).text("SAVE ");
            $(a).addClass("FIELDSET-OPTION");
            li = $("<li/>").append(a);
            $('#FIELDSET-DROPDOWN').prepend( li );

            $('#FIELDSET-DROPDOWN').prepend( $("<li/>").addClass("divider") );

            a = $("<a/>").attr({ "href":"#", "id": "CURRENT_FIELDSET" }).text(name);
            li = $("<li/>").append(a);
            $('#FIELDSET-DROPDOWN').prepend( li );
 
            load_table();
        }else{
            data = { context: context, context_id: context_id };
            data["FIELDSET_NAME"] = "DEFAULT FIELDSET";
            data["COLS"] = ["<?= implode("\",\"", $_DEFAULT_FIELDSET) ?>"];
            data["global"] = 1;
            api("FIELDSET/new", data, function(data){
                if (api_success(data)){
                    load_fieldsets();
                }
            }); 
        }
    }
}

select_fieldset = function(){
	if (this){
		fid = $(this).attr("FIELDSET-ID");
		fname = FIELDSETS[fid]["FIELDSET_NAME"];
		CURRENT_FIELDSET=fid;
		CURRENT_COLS = FIELDSETS[fid]["COLS"];
		$('#CURRENT_FIELDSET').text(fname);
		draw_table();
	}
}

save_fieldset_callback = function(data){
	if (api_success(data)){
		if (data.message){ haxSay(data.message); }
		load_fieldsets();
	}
}

save_fieldset = function(){
	var data = { "COLS": CURRENT_COLS, "context": "<?= $context ?>", "context_id": <?= $context_id ?> }
	data["rowid"] = CURRENT_FIELDSET;
	api("FIELDSET/save", data, save_fieldset_callback);
}

save_as_fieldset_callback = function(data){
	if (api_success(data)){
		if (data.message){ haxSay(data.message); }
        if (data.meta.rowid){ CURRENT_FIELDSET = data.meta.rowid; }
		load_fieldsets();
	}
}

save_as_fieldset = function(){
	haxGet("FIELDSET NAME", "NEW_FIELDSET", function(fieldset_name){
		if (fieldset_name){
			var data = { "COLS": CURRENT_COLS, "context": "<?= $context ?>", "context_id": <?= $context_id ?> }
			data["FIELDSET_NAME"] = fieldset_name;
			api("FIELDSET/new", data, save_as_fieldset_callback);
		}	
	});
}


delete_fieldset_callback = function(data){
    if (api_success(data)){
        if (data.message){ haxSay(data.message); }
        CURRENT_FIELDSET = null;
        load_fieldsets();
    }
}

delete_fieldset = function(){
	fname = FIELDSETS[CURRENT_FIELDSET]["FIELDSET_NAME"]
	alertify.confirm("Are you sure you want to delete:<br/><strong>" + fname + "</strong>", function(){
        api("FIELDSET/delete", { "rowid": CURRENT_FIELDSET }, delete_fieldset_callback);
    });
}

load_table_callback = function(data){
    if (api_success(data)){
        CONTEXT_DATA = [];
        if (data.data){
            CONTEXT_DATA = data.data; 
            COLS = data.meta.cols;
            _LISTS = data.meta.lists;

			LISTS = [];
			$.each(_LISTS, function(key, list){ LISTS[list["LISTS_ID"]] = list; });

			_COLS = {};
			$.each(COLS, function(key,col){ _COLS[col["NAME"]] = col; });
        }

        if (data.meta && data.meta.context_name){
		    CONTEXT_NAME = data.meta.context_name;
	    	$('#CONTEXT-NAME').text(": " + data.meta.context_name);
    	}
        draw_table();
    }
}

draw_table = function(){
    $('#loader').hide();
    $('#CONTEXT-TABLE thead').empty();
    $('#CONTEXT-TABLE').trigger("destroy");

    tr = $('<tr>');

    total = 0;
    $.each(CURRENT_COLS, function(key,col){
        if (_COLS[col]){
            total += 1;
            header = _COLS[col]["HEADER"];
            th = $('<th>').html(header).attr("title",col);
            if (total > 3){ $(th).addClass("hidden-xs hidden-sm"); }
            tr.append(th);
        }
    });

    if (CONTEXT_NAME) href += "/" + CONTEXT_NAME;
    th = $('<th>').addClass("empty").css("width","1%").attr("colspan",2).css("text-align", "center");
    $(th).attr("id","COLS-EDIT"); //.attr("href",href);
    icon = $('<i/>').addClass("fa").addClass("fa-list");
    $(th).append(icon);
    tr.append(th);
    $('#CONTEXT-TABLE thead').append(tr);

    $('#CONTEXT-TABLE tbody').empty();
    if (CONTEXT_DATA){
        $.each(CONTEXT_DATA, function(rowid,row){
            tr = $('<tr>');

            total = 0;
            $.each(CURRENT_COLS, function(key,col){
                if (_COLS[col]){
                    total += 1;
	    			id = row["<?= $context ?>_ID"];
			    	type = _COLS[col]["TYPE"];
		    		val = row[col];
					td = haxdb_table_cell ( _COLS[col], context, id, val );
                    if (total > 3){ $(td).addClass("hidden-xs hidden-sm"); }
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

cols_edit_callback = function(data){
	$('#haxdb-fieldset-modal .modal-title').html("COLS: " + context);

    table = $("<table>").addClass("table table-striped table-bordered tablesorter tablesorter-default");
    tbody = $("<tbody>");
    $.each(COLS, function(key,col){
		tr = $("<tr>");
        id = "COLS-EDIT-COL-" + col["NAME"];
        checkbox = $("<input>").attr("type","checkbox").attr("id", id);
		$(checkbox).attr("colname", col["NAME"]);
		if (CURRENT_COLS.indexOf(col["NAME"]) >= 0){ $(checkbox).attr("checked", true); }
        $(checkbox).addClass("COLS-EDIT-CHECKBOX");
        $(checkbox).attr("COLS-COL", col);
        $("<td>").html(checkbox).appendTo(tr);
        $("<td>").html(col["HEADER"]).addClass("CHECKBOX-CLICK").attr("CHECKBOX-TARGET",id).appendTo(tr);
        tbody.append(tr);
    });

    table.append(tbody);
    $('#haxdb-fieldset-modal .modal-body').html(table);

	$('#haxdb-fieldset-modal').modal();
}

$(document).on("hidden.bs.modal", '#haxdb-fieldset-modal', function(){ 
	CURRENT_COLS = []
	$.each( $(".COLS-EDIT-CHECKBOX:checked") , function(key, checkbox){
		colname = $(checkbox).attr("colname");
		CURRENT_COLS.push(colname);
	});
	draw_table();
});

new_row_save_callback = function(data){
    if (data && data.success && data.success==1){ 
        haxSay(data.message,"success");
        $("#haxdb-new-modal").modal("hide");
        load_table(); 
    }else{

        if (data && data.message){
            $("#haxdb-new-modal .form-error").html(data.message);
        }else{
            $("#haxdb-new-modal .form-error").html("UNKOWN ERROR");
        }
        $("#haxdb-new-modal .form-error").show();
    }
}

new_row_save = function(){
    var url = context + "/new";
    var data = {}
    $("#haxdb-new-modal .modal-body .FORM-EDIT").each(function(key, input){
        col = $(input).attr("haxdb-col");
        val = $(input).val();
        data[col] = val;
    });
    api(url, data, new_row_save_callback);
}

new_row = function(data){
    $('#haxdb-new-modal .modal-title').html("NEW: " + context);

    body = $('#haxdb-new-modal .modal-body');
    $(body).html("");
    $("#haxdb-new-modal .form-error").hide();
     
    form = $("<form/>").addClass("form-horizontal").attr("role","form");
    
    $.each(COLS, function(key, col){
        if (col.NEW && col.NEW == 1){
            val = "";
            if (col.DEFAULT) val = col.DEFAULT;
            element = haxdb_form_cell( col, context, "NEW", val );
            $(form).append(element);
        }
    });
    $(body).append(form);
    
    $("#haxdb-new-modal").modal("show");
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

load_fieldsets = function(){
    api("FIELDSET/list", { "context": context, "context_id": context_id }, load_fieldset_callback);
}

$(function(){
    $('#CONTEXT-SEARCH').change(load_table);
    $('#CONTEXT-TABLE').tablesorter( {textExtraction: tablesortExtraction} );
    $('#CONTEXT-NEW').click(new_row);
    $(document).on("click",'#COLS-EDIT',cols_edit_callback);
	$(document).on("click","#FIELDSET-SAVE",save_fieldset);
	$(document).on("click","#FIELDSET-SAVE-AS",save_as_fieldset);
	$(document).on("click","#FIELDSET-DELETE",delete_fieldset);
	$(document).on("click",".FIELDSET-SELECT",select_fieldset);
    $('#haxdb-new-modal-save').click(new_row_save);
    load_fieldsets();
});

</script>
