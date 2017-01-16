<?php
$rowid = intval($_GET["arg1"]);

$api_name = "ASSETS";
$api_context = "ASSETS";
$api_context_id = $rowid;
$udf_context = "ASSETS";
$udf_context_id = 0;
$col_internal = "";
$col_rowid = "ASSETS_ID";

$_PAGE_NAME = "ASSETS_NAME";
$_PARENT_PAGE = "assets";
?>
<h5>
  <a href='/page/<?= $_PARENT_PAGE ?>'><?= $api_name ?></a>
  &nbsp;&nbsp;&gt;&nbsp;&nbsp;
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
