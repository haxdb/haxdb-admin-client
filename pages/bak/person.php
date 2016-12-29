<?php
$rowid = intval($_GET["arg1"]);
?>

<h5>
<a href='/page/people'>PEOPLE</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span class='PEOPLE_NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li class="active"><a href='#'>PERSON</a></li>
    <li><a href='/page/person-rfid/<?= $rowid ?>'>RFID</a></li>
</ul>

<div class='panel panel-default'><div class='panel-body'>
<form>

<div class='form-group row'>
    <label for='PEOPLE-<?=$rowid?>-PEOPLE_ID' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>ID</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='PEOPLE-<?=$rowid?>-PEOPLE_ID' placeholder='ID' readonly/></div>
</div>

<div class='form-group row'>
    <label for='PEOPLE-<?=$rowid?>-PEOPLE_NAME_FIRST' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>FIRST NAME</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='PEOPLE-<?=$rowid?>-PEOPLE_NAME_FIRST' placeholder='FIRST NAME'/></div>
</div>

<div class='form-group row'>
    <label for='PEOPLE-<?=$rowid?>-PEOPLE_NAME_LAST' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>LAST NAME</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='PEOPLE-<?=$rowid?>-PEOPLE_NAME_LAST' placeholder='LAST NAME'/></div>
</div>

<div class='form-group row'>
    <label for='PEOPLE-<?=$rowid?>-PEOPLE_EMAIL' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>EMAIL</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'><input class='form-control FORM-EDIT' type='TEXT' id='PEOPLE-<?=$rowid?>-PEOPLE_EMAIL' placeholder='EMAIL'/></div>
</div>


<div class='form-group row'>
    <label for='PEOPLE-<?=$rowid?>-PEOPLE_DBA' class='col-xs-12 col-sm-12 col-md-3 col-lg-2 col-form-label'>DBA</label>
    <div class='col-xs-12 col-sm-12 col-md-9 col-lg-10'>
        <select class='form-control FORM-EDIT' id='PEOPLE-<?=$rowid?>-PEOPLE_DBA' placeholder='DBA'>
            <option value='0'>NO</option>
			<option value='1'>YES</option>
        </select>
    </div>
</div>

<hr/>

</form>

</div></div>

<script>

load_asset_callback = function(data){

    if (api_success(data)){
        if (data.data){
			$('span.PEOPLE_NAME').text(data.data["PEOPLE_NAME_FIRST"] + " " + data.data["PEOPLE_NAME_LAST"]);
            $.each(data.data, function(key,val){
                $("[id='PEOPLE-<?=$rowid?>-"+key+"']").val(val);
                //$('.'+key).text(val);
            });
        }
    }

}

load_asset = function(){
    var rowid = <?= $rowid ?>;
    var data = { "rowid": rowid, "lists": 1 }
    api("PEOPLE/view", data, load_asset_callback);
}

$(function(){
    load_asset();
});

</script>
