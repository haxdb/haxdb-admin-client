<script>
var _DEFAULT_FIELDSET = ["<?= implode("\",\"", $_DEFAULT_FIELDSET) ?>"];
var _EDIT_PAGE = "<?= $_EDIT_PAGE ?>";
var _ROW_NAME = "<?= $_ROW_NAME ?>";
var api_name = "<?= $api_name ?>";
var col_rowid = "<?= $col_rowid ?>";
var col_internal = "<?= $col_internal ?>";
var api_context = "<?= $api_context ?>";
var api_context_id = <?= $api_context_id ?>;
var udf_context = "<?= $udf_context ?>";
var udf_context_id = <?= $udf_context_id ?>;
</script>

<table class='TABLE-FILTER'>
<tbody>
<tr> <td>
  <?php  if ($_SHOW_NEW !== false){ ?>
    <button id='PAGE-NEW' type="button" class="pull-right btn btn-primary" style='margin-top: 10px;'><i class="fa fa-plus"></i> &nbsp;&nbsp; NEW</button>
  <?php
  }
  ?>
  <?php  if ($_SHOW_UDF !== false){ ?>
    <a href="/page/udf/<?=$udf_context?>/<?=$udf_context_id?>" class="pull-right btn" style='margin-top: 10px; margin-right: 10px;'><i class="fa fa-columns"></i> &nbsp;&nbsp; UDF</a>
  <?php
  }
  ?>
  <?php if ($_SHOW_TITLE !== false){ ?>
  <h4><?=$api_name?><span id='PAGE-NAME'></span></h4>
  <?php
  }
  ?>
</td> </tr>
<tr> <td>
<div class="input-group">
  <input ID='PAGE-SEARCH' type='text' class='form-control' placeholder='SEARCH' VALUE='<?=$_DEFAULT_QUERY?>'/>
  <div class="input-group-btn">
    <div class="btn-group">
      <button type=button class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fa fa-gear"></span>
      </button>
      <ul class='dropdown-menu dropdown-menu-right' ID='QUERY-OPTIONS'>
      </ul>
    </div>
    <div class="btn-group">
      <button type=button class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fa fa-angle-down"></span>
      </button>
      <ul class='dropdown-menu dropdown-menu-right' ID='QUERY-DROPDOWN'>
      </ul>
    </div>
  </div>
</div>
</td> </tr>
</table>

<div id='PAGE-WRAPPER' class='scrollx'>
<table id='LIST-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
</thead>
<tbody>

</tbody>
</table>
<div id='loader'></div>
</div>

<script src="/include/haxdb.api-list.js"></script>
