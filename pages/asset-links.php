<?php
$rowid = $_GET["arg1"];

$_API = "ASSET_LINKS";
$_API_CONTEXT = "ASSET_LINKS";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "ASSET";
$_API_PARENT_LINK = "/page/assets";

$_ROW_EDIT = "";
$_ROW_ID = "ASSET_LINKS_ID";
$_ROW_INTERNAL = "";
$_ROW_NAME = "ASSET_LINKS_NAME";

$_TITLE = False;
$_NEW = True;
$_UDF = True;
$_UDF_LINK = "/page/udf/ASSET_LINKS/0";

$_DEFAULT_QUERY = "";

?>

<script>
var _DATA_LIST = {
  "ASSETS_ID": <?= $rowid ?>,
};
var _DATA_NEW = {
  "ASSETS_ID": <?= $rowid ?>,
};
var _DATA_SAVE = {};
</script>

<h5>
  <a href='<?= $_API_PARENT_LINK ?>'><?= $_API_PARENT ?></a>
  &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
  <span id='PAGE-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li><a href='/page/asset/<?= $rowid ?>'>ASSET</a></li>
    <li><a href='/page/asset-auths/<?= $rowid ?>'>AUTHS</a></li>
    <li class='active'><a href='#'>LINKS</a></li>
    <!--
        <li class='disabled'><a href='#'>FILES</a></li>
        <li class='disabled'><a href='#'>IMAGES</a></li>
    -->
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>
<?php
    include("api-list.php");
?>
  </div>
</div>
