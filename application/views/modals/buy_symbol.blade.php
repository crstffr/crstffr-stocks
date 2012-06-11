<!--
***********************************************************
Modal Form - Buy Shares (./views/modals/buy_symbol.php)
***********************************************************
-->

<div class="modal modal-medium hide" id="buyShares">
    <form class="modal-form form-horizontal" action="{{URL::current()}}/buy" method="POST">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Track a Purchase of Shares</h3>
        </div>
        <div class="modal-body">
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Quantity</label>
                    <div class="controls">
                        <input name="quantity" type="text" class="span1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Symbol</label>
                    <div class="controls">
                        <input name="symbol" type="text" class="input-small">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Date of Purchase</label>
                    <div class="controls">
                        <input name="date" type="text" class="span2">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Price Paid</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">$</span><input name="price" type="text" class="span1">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Fees</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">$</span><input name="fees" type="text" class="span1">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Notes</label>
                    <div class="controls">
                        <textarea name="notes" rows="3"></textarea>
                    </div>
                </div>

            </fieldset>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-success" value="Submit">
        </div>
    </form>
</div>

<!-- end modal form -->
