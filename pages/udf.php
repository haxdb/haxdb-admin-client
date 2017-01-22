<?php
$_UDF_CONTEXT = $_GET["arg1"];
$_UDF_CONTEXT_ID = $_GET["arg2"];

$_API = "UDF";
$_API_CONTEXT = "UDF";
$_API_CONTEXT_ID = 0;
$_API_PARENT = "UDF";
$_API_PARENT_LINK = $_SERVER["HTTP_REFERER"];

$_ROW_EDIT = "";
$_ROW_ID = "UDF_ID";
$_ROW_INTERNAL = "UDF_INTERNAL";
$_ROW_NAME = "UDF_NAME";

$_TITLE = True;
$_NEW = True;
$_UDF = False;
$_UDF_LINK = "";

$_DEFAULT_QUERY = "";

?>

<script>
_DATA_LIST = {
  "UDF_CONTEXT": "<?= $_UDF_CONTEXT ?>",
  "UDF_CONTEXT_ID": "<?= $_UDF_CONTEXT_ID ?>",
  "disabled": 1,
};
_DATA_NEW = {
  "UDF_CONTEXT": "<?= $_UDF_CONTEXT ?>",
  "UDF_CONTEXT_ID": "<?= $_UDF_CONTEXT_ID ?>",
};
_DATA_SAVE = {};
</script>

<?php
include("api-list.php");
?>
