<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$FailedJobsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var ffailed_jobsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    ffailed_jobsview = currentForm = new ew.Form("ffailed_jobsview", "view");
    loadjs.done("ffailed_jobsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.failed_jobs) ew.vars.tables.failed_jobs = <?= JsonEncode(GetClientVar("tables", "failed_jobs")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffailed_jobsview" id="ffailed_jobsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="failed_jobs">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_failed_jobs_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->uuid->Visible) { // uuid ?>
    <tr id="r_uuid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_uuid"><?= $Page->uuid->caption() ?></span></td>
        <td data-name="uuid" <?= $Page->uuid->cellAttributes() ?>>
<span id="el_failed_jobs_uuid">
<span<?= $Page->uuid->viewAttributes() ?>>
<?= $Page->uuid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->connection->Visible) { // connection ?>
    <tr id="r_connection">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_connection"><?= $Page->connection->caption() ?></span></td>
        <td data-name="connection" <?= $Page->connection->cellAttributes() ?>>
<span id="el_failed_jobs_connection">
<span<?= $Page->connection->viewAttributes() ?>>
<?= $Page->connection->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->queue->Visible) { // queue ?>
    <tr id="r_queue">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_queue"><?= $Page->queue->caption() ?></span></td>
        <td data-name="queue" <?= $Page->queue->cellAttributes() ?>>
<span id="el_failed_jobs_queue">
<span<?= $Page->queue->viewAttributes() ?>>
<?= $Page->queue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->payload->Visible) { // payload ?>
    <tr id="r_payload">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_payload"><?= $Page->payload->caption() ?></span></td>
        <td data-name="payload" <?= $Page->payload->cellAttributes() ?>>
<span id="el_failed_jobs_payload">
<span<?= $Page->payload->viewAttributes() ?>>
<?= $Page->payload->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->exception->Visible) { // exception ?>
    <tr id="r_exception">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_exception"><?= $Page->exception->caption() ?></span></td>
        <td data-name="exception" <?= $Page->exception->cellAttributes() ?>>
<span id="el_failed_jobs_exception">
<span<?= $Page->exception->viewAttributes() ?>>
<?= $Page->exception->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->failed_at->Visible) { // failed_at ?>
    <tr id="r_failed_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_failed_jobs_failed_at"><?= $Page->failed_at->caption() ?></span></td>
        <td data-name="failed_at" <?= $Page->failed_at->cellAttributes() ?>>
<span id="el_failed_jobs_failed_at">
<span<?= $Page->failed_at->viewAttributes() ?>>
<?= $Page->failed_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
