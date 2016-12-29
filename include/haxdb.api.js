function api(call, data, func_success){
    url = API_URL + call;
    data["api_key"] = localStorage.getItem("api_key");
    data["meta"] = 1; 
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: func_success,
        error: api_error_callback,
        dataType: "json",
    });
    
}

function apiDownload(call){
    url = API_URL + call; // + "?api_key=" + API_KEY;
    document.location = url;
}

function apiUpload(func_success){
    var call = $('#haxdb-file-upload-call').val();
    var url = API_URL + call;
    var data = new FormData();
    data.append("api_key",localStorage.getItem("api_key"));
    data.append("value", $("#haxdb-file-upload")[0].files[0]);
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: func_success,
        error: api_error_callback,
        dataType: "json",
        contentType: false,
        processData: false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt){
              if (evt.lengthComputable) {
                var percentComplete = Math.floor( (evt.loaded / evt.total) * 100 );
                $('.TABLE-FILE-PROGRESS-SPAN:visible').text(percentComplete + "%");
                console.log(percentComplete + "%");
              }
            }, false);
            return xhr;
        }        
    });
    
}


api_error_callback = function (xhr, ajaxOptions, thrownError){ 
    var code = xhr.status

    if (code === 0){

        document.location='/noapi';

    } else if (code === 404){

        haxSay("Invalid API call: 404", "error");

    } else if (code === 500){

        haxSay("API Server Error: 500", "error");

    } else {

        haxSay("Unknown Error", "error");

    }
}

function api_success(data){
    if (!data || !data.authenticated || data.authenticated!=1){
        window.location = '/auth';
    }
    
    if (data && data.success && data.success==1){

		if (data && data.table && data.rowid && data.column){
            tdid = "[id='" + data.table + "-" + data.rowid + "-" + data.column + "']";
            $(tdid).removeClass("saving");
        }
        

        return true;
    }else{
        if (data && data.message){
            haxSay("API ERROR: " + data.message, "error");
        }else{
            haxSay("UNKNOWN ERROR"); 
        }

        if (data && data.table && data.rowid && data.column){
            tdid = "[id='" + data.table + "-" + data.rowid + "-" + data.column + "']";
            $(tdid).removeClass("saving").addClass("error");
        }

    }
}

//******************************************************************
//var api_key = localStorage.getItem("api_key");
//if (!api_key){ document.location = '/auth'; } 
//******************************************************************
