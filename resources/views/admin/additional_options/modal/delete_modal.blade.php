<div class="modal fade custom-modal" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="customModal"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Delete Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>

            </div>
            <form id="delete_form">
                @csrf
                <input type="hidden" name="id" id="deleteRecordId">
                <div class="modal-body">
                    <strong class="para3"> Are you sure you want to Delete this record?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="deleteRecordBtn" class="btn btn-danger">Delete</button>
                </div>
            </form>

        </div>
    </div>
</div>
