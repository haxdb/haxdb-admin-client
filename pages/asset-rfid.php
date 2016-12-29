<script>
function convertTimestamp(timestamp) {
  var d = new Date(timestamp * 1000),	// Convert the passed timestamp to milliseconds
		yyyy = d.getFullYear(),
		mm = ('0' + (d.getMonth() + 1)).slice(-2),	// Months are zero based. Add leading 0.
		dd = ('0' + d.getDate()).slice(-2),			// Add leading 0.
		hh = d.getHours(),
		h = hh,
		min = ('0' + d.getMinutes()).slice(-2),		// Add leading 0.
		sec = ('0' + d.getSeconds()),
		time;
			
	time = yyyy + '-' + mm + '-' + dd + ', ' + h + ':' + min + ":" + sec;
		
	return time;
}
</script>
<?php
$rowid = intval($_GET["arg1"]);
?>

<h5>
<a href='/page/assets'>ASSETS</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span class='ASSETS_NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
<li><a href='/page/asset/<?= $rowid ?>'>ASSET</a></li>
    <li class="active"><a href='#'>RFID</a></li>
    <li><a href='/page/asset-auths/<?= $rowid ?>'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <li class='disabled'><a href='#'>FILES</a></li>
    <li class='disabled'><a href='#'>IMAGES</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>
<form>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_REQUIRE_RFID' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>REQUIRE RFID</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'>
        <select class='form-control FORM-EDIT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_REQUIRE_RFID' placeholder='REQUIRE RFID'>
            <option value=''></option>
            <option value='0'>NO</option>
            <option value='1'>YES</option> 
        </select>
    </div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_REQUIRE_AUTH' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>REQUIRE AUTH</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'>
        <select class='form-control FORM-EDIT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_REQUIRE_AUTH' placeholder='REQUIRE AUTH'>
            <option value=''></option>
            <option value='0'>NO</option>
            <option value='1'>YES</option> 
        </select>
    </div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_TIMEOUT' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>AUTH TIMEOUT</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_TIMEOUT' placeholder='AUTH TIMEOUT (SECONDS)'/></div>
</div>

<hr/>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>STATUS</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><select class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS' placeholder='STATUS'><option value=''></option></select></div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS_DESC' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>STATUS DESC</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><textarea class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS_DESC' placeholder='STATUS DESCRIPTION'></textarea></div>
</div>

<hr/>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_IN_USE' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>IN USE</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><select class='form-control FORM-EDIT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_IN_USE' placeholder='IN USE' READONLY>
    <option value='0'>NOT IN USE</option>
    <option value='1'>IN USE</option>
    </select></div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_FIRST_NAME' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>AUTH USER</label>
    <div class='col-xs-6 col-sm-6 col-md-4 col-lg-5'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_FIRST_NAME' placeholder='FIRST NAME' READONLY/></div>
	<div class='col-xs-6 col-sm-6 col-md-5 col-lg-5'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_LAST_NAME' placeholder='LAST NAME' READONLY/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_START' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>AUTH START</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_START' placeholder='AUTH START' READONLY/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_LAST' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>AUTH LAST</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_LAST' placeholder='AUTH LAST' READONLY/></div>
</div>

</form>

</div></div>

<script>

load_asset_callback = function(data){

    if (api_success(data)){
        if (data.meta && data.meta.lists){
            $('#ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS').find("option").remove();
            $.each(data.meta.lists["ASSET STATUSES"], function (key, row){
                $('#ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_STATUS').append($("<option />").val(row["LIST_ITEMS_VALUE"]).text(row["LIST_ITEMS_DESCRIPTION"]));
            });
        }
        if (data.data){
            $.each(data.data, function(key,val){
                $('#ASSETS_RFID-<?=$rowid?>-'+key).val(val);
                $('.'+key).text(val);
            });

			auth_start = convertTimestamp(data.row["ASSETS_RFID_AUTH_START"]);
			auth_last = convertTimestamp(data.row["ASSETS_RFID_AUTH_LAST"]); 

			$('#ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_START').val(auth_start);
			$('#ASSETS_RFID-<?=$rowid?>-ASSETS_RFID_AUTH_LAST').val(auth_last);
        }
    }

}

load_asset = function(){
    var rowid = <?= $rowid ?>;
    var data = { "rowid": rowid, "lists": 1 }
    api("ASSETS_RFID/view", data, load_asset_callback);
}

$(function(){
    load_asset();
});

</script>
