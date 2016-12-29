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
    <li class="active"><a href='#'>ASSET</a></li>
    <li><a href='/page/asset-rfid/<?= $rowid ?>'>RFID</a></li>
    <li><a href='/page/asset-auths/<?= $rowid ?>'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <li class='disabled'><a href='#'>FILES</a></li>
    <li class='disabled'><a href='#'>IMAGES</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>
<form>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_NAME' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>NAME</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS-<?=$rowid?>-ASSETS_NAME' placeholder='NAME'/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_TYPE' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>TYPE</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS-<?=$rowid?>-ASSETS_TYPE' placeholder='TYPE'/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_LOCATION' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>LOCATION</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'>
        <select class='form-control FORM-EDIT' id='ASSETS-<?=$rowid?>-ASSETS_LOCATION' placeholder='LOCATION'>
            <option value=''></option>
        </select>
    </div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_DESCRIPTION' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>DESCRIPTION</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><textarea class='form-control FORM-EDIT' rows='3' id='ASSETS-<?=$rowid?>-ASSETS_DESCRIPTION' placeholder='DESCRIPTION'></textarea></div>
</div>

<hr/>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_QUANTITY' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>QUANTITY</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='NUMBER' id='ASSETS-<?=$rowid?>-ASSETS_QUANTITY' placeholder='QUANTITY'/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_MANUFACTURER' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>MANUFACTURER</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS-<?=$rowid?>-ASSETS_MANUFACTURER' placeholder='MANUFACTURER'/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_MODEL' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>MODEL</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS-<?=$rowid?>-ASSETS_MODEL' placeholder='MODEL'/></div>
</div>

<div class='form-group row'>
    <label for='ASSETS-<?=$rowid?>-ASSETS_PRODUCT_ID' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>PRODUCT ID</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='ASSETS-<?=$rowid?>-ASSETS_PRODUCT_ID' placeholder='PRODUCT ID'/></div>
</div>

</form>

</div></div>

<script>

load_asset_callback = function(data){

    if (api_success(data)){
        if (data.meta && data.meta.lists && data.meta.lists["ASSET LOCATIONS"]){
            var id = "ASSETS-<?=$rowid?>-ASSETS_LOCATION";
            $("#"+id).find("option").remove();
            $("#"+id).append($("<option />").val("").text(""));
            $.each(data.meta.lists["ASSET LOCATIONS"], function(key, row){
                $('#'+id).append($("<option />").val(row["LIST_ITEMS_VALUE"]).text(row["LIST_ITEMS_DESCRIPTION"]));
            });

            var id = "ASSETS-<?=$rowid?>-ASSETS_STATUS";
            $("#"+id).find("option").remove();
            $("#"+id).append($("<option />").val("").text(""));
            $.each(data.meta.lists["ASSET STATUSES"], function(key, row){
                $('#'+id).append($("<option />").val(row["LIST_ITEMS_VALUE"]).text(row["LIST_ITEMS_DESCRIPTION"]));
            });
            
        }
        if (data.data){
            $.each(data.data, function(key,val){
                $('#ASSETS-<?=$rowid?>-'+key).val(val);
                $('.'+key).text(val);
            });
        }
    }

}

load_asset = function(){
    var rowid = <?= $rowid ?>;
    var data = { "rowid": rowid, "include_lists": 1 }
    api("ASSETS/view", data, load_asset_callback);
}

$(function(){
    load_asset();
});

</script>
