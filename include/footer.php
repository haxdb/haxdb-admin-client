        </div>
      </div>
    </div>

    <div id="haxdb-id-picker-modal" class="modal" role="dialog">
      <div class='modal-dialog'>
          <div class='modal-content'>
              <div class='modal-header'> <h4 class='modal-title'></h4> </div>
              <div class='modal-body'>
                <input id='PICKER-SEARCH' type='text' class='form-control' placeholder='SEARCH'/>
                <hr/>
                <table id='PICKER-TABLE' class="table table-bordered table-striped tablesorter tablesorter-default">
                  <tbody>
                  </tbody>
                </table>
                <hr/>
                <div id='PICKER-RESULTS'></div>
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-warning' data-dismiss='modal'>CANCEL</button>
                <button type='button' id='PICKER-CLEAR' class='btn btn-primary'>CLEAR</button>
              </div>
          </div>
      </div>
    </div>

    <div id='haxdb-fieldset-modal' class='modal' role='dialog'>
      <div class='modal-dialog'>
          <div class='modal-content'>
              <div class='modal-header'> <h4 class='modal-title'></h4> </div>
              <div class='modal-body'></div>
          </div>
      </div>
    </div>

    <div id='haxdb-new-modal' class='modal' role='dialog'>
        <div class='modal-dialog modal-lg'>
            <div class='modal-content'>
                <div class='modal-header'> <h4 class='modal-title'></h4> </div>
                <div class='modal-body'></div>
                <div class='modal-footer'>
                  <div class='alert alert-danger form-error' role='alert'></div>
                  <button type='button' class='btn btn-warning' data-dismiss='modal'>CANCEL</button>
                  <button type='button' id='haxdb-new-modal-save' class='btn btn-primary'>SAVE</button>
                </div>
            </div>
        </div>
    </div>

    <form id='haxdb-file-upload-form' class='hidden' enctype='multipart/form-data'>
    <input type='hidden' id='haxdb-file-upload-call' value=''/>
    <input type='hidden' id='haxdb-file-upload-cell-id' value=''/>
    <input type='file' id='haxdb-file-upload' class='hidden'/>
    </form>

    <form METHOD='POST' id='haxdb-file-download-form' class='hidden' enctype='multipart/form-data' target='_blank'>
    <input type='hidden' id='haxdb-file-download-rowid' name='rowid' value=''/>
    <input type='hidden' id='haxdb-file-download-col' name='col' value=''/>
    <input type='hidden' id='haxdb-file-download-api_key' name='api_key' value=''/>
	</form>

    <input type='TEXT' id='haxdb-copy-input' style='position: absolute; display: none; left: -5000px; top: -5000px;'/>

    <script src="/third-party/tablesorter/jquery.tablesorter.min.js"></script>
    <script src="/third-party/bootstrap/js/bootstrap.min.js"></script>
    <script src="/third-party/alertify/alertify.js"></script>
    <script src="/include/haxdb.js"></script>
    <script src="/include/haxdb.api.js"></script>
    <script src="/include/haxdb.table.js"></script>
    <script src="/include/haxdb.picker.js"></script>

  </body>
</html>
