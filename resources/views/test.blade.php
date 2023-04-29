<div class="col-lg-12 col-sm-12 ">
    <form method="GET" action="">
        <div class="enquiry">
            <a class="btn btn-danger" href="#" role="button" data-toggle="modal" data-target="#confirmReportModal">Report</a>
        </div>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmReportModal" tabindex="-1" role="dialog" aria-labelledby="confirmReportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmReportModalLabel">Confirm Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to report this?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitReportForm()">Report</button>
            </div>
        </div>
    </div>
</div>

<script>
    function submitReportForm() {
        document.forms[0].submit();
    }
</script>
