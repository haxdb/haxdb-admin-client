<?php
$rowid = intval($_GET["arg1"]);

$_API = "ASSETS";
$_API_CONTEXT = "ASSETS";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "ASSET";
$_API_PARENT_LINK = "/page/assets";

$_ROW_EDIT = "";
$_ROW_ID = "ASSETS_ID";
$_ROW_INTERNAL = "";
$_ROW_NAME = "ASSETS_NAME";

$_TITLE = False;
$_NEW = False;
$_UDF = False;
$_UDF_LINK = "";

$_DEFAULT_QUERY = "";
?>
<h5>
  <a href='<?= $_API_PARENT_LINK ?>'><?= $_API ?></a>
  &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
  <span id='PAGE-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li class="active"><a href='#'>ASSET</a></li>
    <li><a href='/page/asset-auths/<?= $rowid ?>'>AUTHS</a></li>
    <li><a href='/page/asset-links/<?= $rowid ?>'>LINKS</a></li>
    <!--
        <li class='disabled'><a href='#'>FILES</a></li>
        <li class='disabled'><a href='#'>IMAGES</a></li>
    -->
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>

    <script>
      context = "<?= $context ?>";
      rowid = <?= $rowid ?>;
      page_name = [];
      <?php
      $cnames = explode(".", $_PAGE_NAME);
      foreach($cnames as $cname){
        echo "page_name.push(\"$cname\");";
      }
      ?>
    </script>

<?php
    include("api-view.php");
?>


  </div>
</div>
