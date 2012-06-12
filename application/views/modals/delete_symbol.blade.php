<!--
***********************************************************
Modal Form - Delete Symbol (./views/modals/delete_symbol.php)
***********************************************************
-->

<div class="modal modal-medium hide" id="deleteSymbol">
    <form class="modal-form form-horizontal" action="{{URL::current()}}/delete" method="POST">
        <input type="hidden" name="symbol" class='js-symbol-input'>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Are You Sure</h3>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete <strong class='js-symbol-text'></strong> from your page?</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-danger" value="Delete">
        </div>
    </form>
</div>

