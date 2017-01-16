<script>
var _ROW_NAME = "<?= $_ROW_NAME ?>";
var api_name = "<?= $api_name ?>";
var col_rowid = "<?= $col_rowid ?>";
var col_internal = "<?= $col_internal ?>";
var api_name = "<?= $api_name ?>";
var col_rowid = "<?= $col_rowid ?>";
var col_internal = "<?= $col_internal ?>";
var api_context = "<?= $api_context ?>";
var api_context_id = <?= $api_context_id ?>;
var udf_context = "<?= $udf_context ?>";
var udf_context_id = <?= $udf_context_id ?>;
var rowid = <?= $rowid ?>;
var page_name = [];
<?php
  $cnames = explode(".", $_PAGE_NAME);
  foreach($cnames as $cname){
    echo "page_name.push(\"$cname\");";
  }
?>
</script>

<form ID='PAGE-VIEW-FORM'>

</form>

<script src="/include/haxdb.api-view.js"></script>
