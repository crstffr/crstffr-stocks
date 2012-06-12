<!--
***********************************************************
Modal Form - Settings
***********************************************************
-->

<div class="modal modal-medium hide" id="settings">
    <form class="modal-form form-horizontal" action="{{URL::base()}}/settings" method="POST">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Default Settings</h3>
        </div>
        <div class="modal-body">

            <h4>Chart Zoom Level</h4>
            <p>
                Select a zoom level to apply to all of the charts on all of your lists.
                This setting stays with you in a cookie.</p>
            <input type="hidden" name="zoom">

            <div class="btn-group" data-toggle="buttons-radio">
                <a class="btn btn-large" data-unit="w" data-qty="2" href='#'>2w</a>
                <a class="btn btn-large" data-unit="M" data-qty="1" href='#'>1m</a>
                <a class="btn btn-large" data-unit="M" data-qty="3" href='#'>3m</a>
                <a class="btn btn-large" data-unit="M" data-qty="6" href='#'>6m</a>
                <a class="btn btn-large" data-unit="y" data-qty="1" href='#'>1y</a>
                <a class="btn btn-large" data-unit="y" data-qty="2" href='#'>2y</a>
                <a class="btn btn-large" data-unit="y" data-qty="3" href='#'>3y</a>
                <a class="btn btn-large" data-unit="y" data-qty="5" href='#'>5y</a>
            </div>

        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Cancel</a>
            <input type="submit" class="btn btn-primary" value="Save">
        </div>
    </form>
</div>

<script>
    $(function(){
        var form = $("#settings");
        var zoom = '<?php echo $zoom; ?>';
        form.find("a.btn").bind('click', function(){
            var val = $(this).text();
            form.find("input[name='zoom']").val(val);
        });
        if (zoom.length > 0) {
            form.find("a.btn:contains(" + zoom + ")").click().addClass('active');
        }
    });
</script>

