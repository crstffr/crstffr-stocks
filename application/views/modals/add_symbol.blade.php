<!--
***********************************************************
Modal Form - Add Symbol (./views/modals/add_symbol.php)
***********************************************************
-->

<div class="modal hide" id="addSymbol">
    <form class="modal-form form-horizontal" action="{{URL::current()}}/add" method="POST">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Add a Symbol to Watch</h3>
        </div>
        <div class="modal-body">

            <fieldset>
                <div class="control-group">
                    <label class="control-label">Search</label>
                    <div class="controls">
                        <input type="text" class="autocomplete-symbol-search">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input01">Symbol</label>
                    <div class="controls">
                        <input name="symbol" type="text" class="input-small" id="input01">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02">Company Name</label>
                    <div class="controls">
                        <input name="company" type="text" id="input02">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="description" class="input-xlarge-pended" rows="6"></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input04">Website</label>

                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">http://</span><input name="sites[company]" class="input-xlarge" type="text" id="input03">
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input04">Wiki Page</label>

                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on">http://</span><input name="sites[wiki]" class="input-xlarge" type="text" id="input04">
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>

<!-- end modal form -->
