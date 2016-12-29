tablesortExtraction = function(node){ return $(node.childNodes[0]).val(); }

$(document).on("click",".CLICK-COPY",function(){
    $(this).find("input").select();
    if (document.execCommand("copy")){
        haxSay("COPIED","success");
    }else{
        haxSay("COPY FAILED","error");
    }
});


$(document).on("click",".BUTTON-COPY",function(){
    val = $(this).attr("copy");
	message = $(this).attr("message");
    $('#haxdb-copy-input').val(val).css("display","block");
	$("#haxdb-copy-input").select();
    if (document.execCommand("copy")){
        haxSay(message,"success");
    }else{
        haxSay("COPY FAILED","error");
    }
    $('#haxdb-copy-input').val("").css("display","none");
});

save_callback = function(data){
    if (api_success(data)){
        haxSay("SAVED","success");
        if (data.meta && data.meta.oid){ $("[id='" + data.meta.oid + "']").removeClass("saving"); }
    }else{
        if (data.meta && data.meta.oid){ $("[id='" + data.meta.oid + "']").addClass("error").removeClass("saving"); }
    }
    $('table').trigger("update");
}

$(document).on("change",'.TABLE-EDIT,.FORM-EDIT',function(){
    var tab = $(this).closest("table");
    var id = $(this).attr("id").split("-");
    var table = id[0];
    var rowid = id[1];
    var column = id[2];
    var val = $(this).val();
    var call = table + "/save"; ///" + escape(rowid) + "/" + escape(column) + "/" + escape(val);
    var data = { "rowid": rowid, "col": column, "val": val };
    $(this).addClass("saving").removeClass("error");
    $('table').trigger("update");
    api(call,data,save_callback);
});

$(document).on("click",".TABLE-DELETE",function(){
    var tr = $(this).closest("tr");
    var id = $(this).attr("id").split("-");
    var table = id[1];
    var rowid = id[2];
    var rowkey1 = $("[id='" + $(this).attr("rowkey1") + "']").val();
    var rowkey2 = $("[id='" + $(this).attr("rowkey2") + "']").val();
    var rowkey3 = $("[id='" + $(this).attr("rowkey3") + "']").val();
    var rowname = "";
    var call = table + "/delete/" + rowid;

    if (rowkey1){ rowname = escapeHTML(rowkey1); }
    if (rowkey2){ rowname = rowname + " " + escapeHTML(rowkey2); }
    if (rowkey3){ rowname = rowname + "<BR/>" + escapeHTML(rowkey3); }

    alertify.confirm("Are you sure you want to delete:<br/><div class='delete-ask-rowname'>" + rowname + "</div>", function(){ 
        api(call, {}, function(data){
            if (api_success(data)){
                $(tr).remove();
                $('table').trigger("update");
                haxSay("DELETED","error");
            }
        });
    });
});

$(document).on("click",".CONTEXT-ROW-DELETE:not(.disabled)", function(){
	var tr = $(this).closest("tr");
	var rowid = $(this).attr("DELETE-ROWID");
	var rowname = $(this).attr("DELETE-NAME");
	var call = context + "/delete/" + rowid;

	alertify.confirm("Are you sure you want to delete:<br/>"+rowname, function(){
        api(call, {}, function(data){
            if (api_success(data)){
                $(tr).remove();
                haxSay("DELETED","error");
            }
        });
	});
});

$(document).on("keydown", '.TABLE-EDIT', function(e){
    if (e.which == 38){
        // UP
        var cellIndex = $(this).closest("td").index();
        $(this).closest('tr').prev().children().eq(cellIndex).find(".TABLE-EDIT").focus();
    }
    if (e.which == 40){
        // DOWN 
        var cellIndex = $(this).closest("td").index();
        $(this).closest('tr').next().children().eq(cellIndex).find(".TABLE-EDIT").focus();
    }

});


// FILE

$(document).on("click",".TABLE-FILE-UPLOAD", function(){
    var tmp = $(this).attr("id").split("-");
    var table = tmp[0];
    var rowid = tmp[1];
    var column = tmp[2];
    var call = table + "/save/" + rowid + "/" + column;
    $('#haxdb-file-upload-call').val(call);
    $('#haxdb-file-upload').click();
    $('#haxdb-file-upload-cell-id').val($(this).closest("td").attr("id"));
});

$(document).on("change","#haxdb-file-upload", function(){
    var cellid = $('#haxdb-file-upload-cell-id').val();
    console.log(cellid);
    $("#" + cellid + " .TABLE-FILE-BUTTON-SPAN").hide();
    $("#" + cellid + " .TABLE-FILE-PROGRESS-SPAN").show();
    apiUpload(load_table);
});

$(document).on("click",".TABLE-FILE-DOWNLOAD", function(){
    var tmp = $(this).attr("id").split("-");
    var table = tmp[0];
    var rowid = tmp[1];
    var column = tmp[2];
    var call = API_URL + table + "/download";
    console.log(table);
    console.log(rowid);
    console.log(column);
    $('#haxdb-file-download-form').attr("action",call);
    $('#haxdb-file-download-rowid').val(rowid);
    $('#haxdb-file-download-col').val(column);
    $('#haxdb-file-download-api_key').val(localStorage["api_key"]);
    $('#haxdb-file-download-form').submit();
});

// FILE
//
$(document).on("click",".TABLE-LINK", function(){
    var url = $(this).attr("href");
    document.location=url;
});

haxdb_table_cell = function ( id, type, val, list ){
    td = $('<td>').addClass("TD-EDIT");

    if (type == "TEXT"){
        input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(val);
        $(td).append(input);
    }

    if (type == "DATE"){
        input = $('<input/>').attr({ id: id, type: 'text'}).addClass("TABLE-EDIT").val(val);
        $(td).append(input);
    }

    if (type == "INT"){
        input = $('<input/>').attr({ id: id, type: 'number', step: "1"}).addClass("TABLE-EDIT").val(val);
        $(td).append(input);
    }

    if (type == "FLOAT"){
        input = $('<input/>').attr({ id: id, type: 'number', step: "0.001"}).addClass("TABLE-EDIT").val(val);
        $(td).append(input);
    }

    if (type == "BOOL"){
        select = $('<select/>').attr("id",id).addClass("TABLE-EDIT");
        $("<option />", {value: 0, text: "NO"}).appendTo(select);
        $("<option />", {value: 1, text: "YES"}).appendTo(select);
        $(select).val(val);
        $(td).append(select);
    }

	if (type == "LIST"){
        select = $('<select/>').attr("id",id).addClass("TABLE-EDIT");
		$("<option />", {value: "", text: ""}).appendTo(select);
        $.each(list, function(key,item){
            $("<option />", {value: item["LIST_ITEMS_VALUE"], text: item["LIST_ITEMS_DESCRIPTION"]}).appendTo(select);
        });
        $(select).val(val);
        $(td).append(select);
	}

    if (type == "FILE"){
        btngroup = $("<div>").addClass("btn-group").attr("role","group").attr("aria-label","FILE");

        button = $("<button>").addClass("btn").attr("id",id).attr("file-action","download");
		if (!val){ $(button).addClass("disabled"); }
        icon = $("<i>").addClass("fa fa-cloud-download");
        $(button).append(icon);
        $(btngroup).append(button);

        button = $("<button>").addClass("btn").attr("id",id).attr("file-action","clear");
		if (!val){ $(button).addClass("disabled"); }
        icon = $("<i>").addClass("fa fa-trash-o");
        $(button).append(icon);
        $(btngroup).append(button);

        button = $("<button>").addClass("btn").attr("id",id).attr("file-action","upload");
        icon = $("<i>").addClass("fa fa-cloud-upload");
        $(button).append(icon);
        $(btngroup).append(button);

		$(td).addClass("TD-FILE").attr("align","center");
		$(td).append(btngroup);
    }
    return td;
}


$(document).on("click",'#FIELDSET-EDIT', function(){
    fid = $('#FIELDSET-SELECT').val();
    fname = FIELDSETS[fid]["NAME"];
    fquery = FIELDSETS[fid]["QUERY"];
    fcols = FIELDSETS[fid]["COLS"];

    fieldset_val = $("<input>").attr("id","FIELDSET-EDIT-ID").attr("type","hidden").val( fid );
    $('#haxdb-fieldset-modal .modal-title').html(fieldset_val);

    id = "FIELDSET-"+fid+"-FIELDSET_NAME";
    fieldset_name = $("<input>").attr( {"type":"text", "id":id} ).addClass("form-control FORM-EDIT").attr("placeholder","FIELDSET NAME");
    $(fieldset_name).val( fname );
    $('#haxdb-fieldset-modal .modal-title').append(fieldset_name);

    $('#haxdb-fieldset-modal .modal-title').append("<hr/>");

    id = "FIELDSET-"+fid+"-FIELDSET_QUERY";
    fieldset_query = $("<input>").attr({ "id": id, "type":"text" }).addClass("form-control FORM-EDIT").attr("placeholder","FIELDSET QUERY");
    $(fieldset_query).val( fquery );
    $('#haxdb-fieldset-modal .modal-title').append(fieldset_query);

    table = $("<table>").addClass("table table-striped table-bordered tablesorter tablesorter-default");
    tbody = $("<tbody>");
    $.each(COLS, function(col, row){
        tr = $("<tr>");
        id = "FIELDSET-EDIT-COL-" + col;
        checkbox = $("<input>").attr("type","checkbox").attr("id", id);
        $(checkbox).addClass("FIELDSET-EDIT-CHECKBOX");
        $(checkbox).attr("FIELDSET-COL", col);
        $("<td>").html(checkbox).appendTo(tr);
        $("<td>").html(row["HEADER"]).addClass("CHECKBOX-CLICK").attr("CHECKBOX-TARGET",id).appendTo(tr);
        $("<td>").html(row["ORDER"]).addClass("CHECKBOX-CLICK").attr("CHECKBOX-TARGET",id).appendTo(tr); 
        tbody.append(tr);
    });

    table.append(tbody);
    $('#haxdb-fieldset-modal .modal-body').html(table);

    $.each(fcols, function(key, col){
        id = "FIELDSET-EDIT-COL-" + col;
        $("[id='"+id+"']").prop("checked", true);
    });

	$('#haxdb-fieldset-modal').modal();
});

$(document).on("change",".FIELDSET-EDIT-CHECKBOX", function(){
    id = $('#FIELDSET-EDIT-ID').val();
    cols = []; $(".FIELDSET-EDIT-CHECKBOX:checked").each(function(){ cols.push( $(this).attr("FIELDSET-COL") ); });
    api("FIELDSET/save", { "rowid": id, "col": "COLS", val: cols }, save_callback);
});

$(document).on("click","#FIELDSET-NEW-USER", function(){
    name = "NEW FIELDSET"; 
    api("FIELDSET/new", { context: context, context_id: context_id, name: name, "global": 0 }, function(data){
        if (api_success(data)){
            $('#FIELDSET-SELECT').append( $("<option>", {value: data.meta.rowid, text: name}) );
            $('#FIELDSET-SELECT').val( data.meta.rowid );
            api("FIELDSET/list", { "context": context }, function(data){
                load_fieldset_callback(data);
                $('#FIELDSET-EDIT').click(); 
            });
        }
    });
});

$(document).on("click","#FIELDSET-NEW-GLOBAL", function(){
    name = "NEW FIELDSET";
    api("FIELDSET/new", { context: context, context_id: context_id, name: name, "global": 1 }, function(data){
        if (api_success(data)){
            $('#FIELDSET-SELECT').append( $("<option>", {value: data.meta.rowid, text: name}) );
            $('#FIELDSET-SELECT').val( data.meta.rowid );
            api("FIELDSET/list", { "context": context }, function(data){
                load_fieldset_callback(data);
                $('#FIELDSET-EDIT').click();
            });
        }
    });
});

$(document).on("click","#FIELDSET-DELETE", function(){
    fid = $('#FIELDSET-SELECT').val();
    fname = FIELDSETS[fid]["NAME"];
    alertify.confirm("Are you sure you want to delete:<br/><strong>" + fname + "</strong>", function(){
        api("FIELDSET/delete", { "rowid": fid }, function(data){
            if (api_success(data)){
                load_fieldsets();
            }
        });
    });
});

$('#haxdb-fieldset-modal').on("hidden.bs.modal", function(){ 
    load_fieldsets();
});

$(document).on("click",".CHECKBOX-CLICK", function(){
    target = $(this).attr("CHECKBOX-TARGET");
    $("[id='"+target+"']").trigger("click");
});

$(document).on("click", ".TD-LINK:not(.disabled)", function(){
	href = $(this).attr("href");
	document.location = href;
});

