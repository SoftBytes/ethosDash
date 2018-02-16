<?php

require './classes/regex.class.php';

?>


<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLongTitle">Global Settings</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="result-modal">

      <table class="table table-striped" style='100%'>
        <colgroup>
          <col width="20%">
          <col width="80%">
        </colgroup>
        <tbody>


         <?php include './classes/configTableGlobals.class.php'; ?>


        </tbody>
      </table>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="saveGlobals">Save changes</button>
    </div>
  </div>
</div>

<?php include './inc/footer.php'; ?>