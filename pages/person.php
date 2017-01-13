<?php
$rowid = intval($_GET["arg1"]);

$context = "PEOPLE";
$context_id = 0;

$list_link = "/page/people";
$list_name = "PEOPLE";

$_CONTEXT_NAME = "PEOPLE_NAME_FIRST.PEOPLE_NAME_LAST";
?>
<h5>
<a href='<?= $list_link ?>'><?= $list_name ?></a>
&nbsp;&nbsp;&gt;&nbsp;&nbsp;
<span id='CONTEXT-NAME'></span>
</h5>
<hr/>

<ul class = "nav nav-tabs">
    <li class="active"><a href='#'>PERSON</a></li>
    <li><a href='/page/person-rfid/<?= $rowid ?>'>RFID</a></li>
</ul>

<div class='panel panel-default'>
  <div class='panel-body'>

<script>
  context = "<?= $context ?>";
  rowid = <?= $rowid ?>;
  context_name = [];
  <?php
  $cnames = explode(".", $_CONTEXT_NAME);
  foreach($cnames as $cname){
    echo "context_name.push(\"$cname\");";
  }
  ?>
</script>

<?php
include("context-view.php");
?>

  </div>
</div>
