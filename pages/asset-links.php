<?php
$rowid = intval($_GET["arg1"]);

$api_name = "ASSET_LINKS";
$api_context = "ASSET_LINKS";
$api_context_id = $rowid;
$udf_context = "ASSET_LINKS";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "ASSET_LINKS_ID";
$_SHOW_TITLE = False;
$_PAGE_NAME = "ASSETS_NAME";
$_ROW_NAME = "ASSET_LINKS_NAME";

?>

<h5>
<a href='/page/assets'>ASSETS</a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span id='PAGE-PARENT-NAME'></span>
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
