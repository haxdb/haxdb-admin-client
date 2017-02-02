<script>
var _API = "<?= $_API ?>";
var _API_CONTEXT = "<?= $_API_CONTEXT ?>";
var _API_CONTEXT_ID = "<?= $_API_CONTEXT_ID ?>";

var _ROW_EDIT = "<?= $_ROW_EDIT ?>";
var _ROW_ID = "<?= $_ROW_ID ?>";
var _ROW_INTERNAL = "<?= $_ROW_INTERNAL ?>";
var _ROW_NAME = "<?= $_ROW_NAME ?>";
</script>

<table class='TABLE-FILTER'>
<tbody>
<tr> <td>
  <?php  if ($_NEW !== false){ ?>
    <button id='PAGE-NEW' type="button" class="pull-right btn btn-primary" style='margin-top: 10px;'><i class="fa fa-plus"></i> &nbsp;&nbsp; NEW</button>
  <?php
  }
  ?>

  <?php  if ($_UDF !== false){ ?>
    <a href="<?=$_UDF_LINK?>" class="pull-right btn btn-info" style='margin-top: 10px; margin-right: 10px;'><i class="fa fa-columns"></i> &nbsp;&nbsp; UDF</a>
  <?php
  }
  ?>

  <?php  if ($_CSV !== false){ ?>
    <a href="<?=$_API?>/csv" class="HAXDB-LIST-CSV pull-right btn btn-info" style='margin-top: 10px; margin-right: 10px;'><i class="fa fa-table"></i> &nbsp;&nbsp; CSV</a>
  <?php
  }
  ?>

  <?php
  if ($_TITLE !== false){
    if (!empty($_API_PARENT)){
      echo "<h4><A HREF='$_API_PARENT_LINK'>$_API_PARENT</A> &raquo; <span id='PAGE-NAME'></span></h4>";
    }else{
      echo "<h4>$_API<span id='PAGE-NAME'></span></h4>";
    }
  }
  ?>
</td> </tr>
<tr> <td>
<div class="input-group">
  <input ID='PAGE-SEARCH' type='text' class='form-control' placeholder='SEARCH' VALUE='<?=$_DEFAULT_QUERY?>'/>
  <div class="input-group-btn">
      <button type=button class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fa fa-angle-down"></span>
      </button>
      <ul class='dropdown-menu dropdown-menu-right' ID='QUERY-DROPDOWN'>
      </ul>
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
