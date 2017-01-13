<table class='TABLE-FILTER'>
<tbody>
<tr> <td>
<button id="CONTEXT-NEW" type="button" class="pull-right btn btn-primary" style='margin-top: 10px;'><i class="fa fa-plus"></i> &nbsp;&nbsp; NEW</button>
<h4><?= $context ?><span id='CONTEXT-NAME'></span></h4>
</td> </tr>
<tr> <td>
<div class="input-group">
  <input ID='CONTEXT-SEARCH' type='text' class='form-control' placeholder='SEARCH' VALUE='<?=$_DEFAULT_QUERY?>'/>
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

<div class='scrollx'>
<table id='CONTEXT-TABLE' class='table table-bordered table-striped tablesorter'>
<thead>
</thead>
<tbody>

</tbody>
</table>
<div id='loader'></div>
</div>

<script>
var _DEFAULT_FIELDSET = ["<?= implode("\",\"", $_DEFAULT_FIELDSET) ?>"];
var _EDIT_PAGE = "<?= $_EDIT_PAGE ?>";
var _ROW_NAME = "<?= $_ROW_NAME ?>";
var context = "<?= $context ?>";
var context_id = <?= $context_id ?>;
</script>
<script src="/include/haxdb.context-list.js"></script>
