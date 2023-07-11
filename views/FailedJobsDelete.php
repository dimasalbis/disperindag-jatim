<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$FailedJobsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var ffailed_jobsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    ffailed_jobsdelete = currentForm = new ew.Form("ffailed_jobsdelete", "delete");
    loadjs.done("ffailed_jobsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.failed_jobs) ew.vars.tables.failed_jobs = <?= JsonEncode(GetClientVar("tables", "failed_jobs")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="ffailed_jobsdelete" id="ffailed_jobsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="failed_jobs">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_failed_jobs_id" class="failed_jobs_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->uuid->Visible) { // uuid ?>
        <th class="<?= $Page->uuid->headerCellClass() ?>"><span id="elh_failed_jobs_uuid" class="failed_jobs_uuid"><?= $Page->uuid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->failed_at->Visible) { // failed_at ?>
        <th class="<?= $Page->failed_at->headerCellClass() ?>"><span id="elh_failed_jobs_failed_at" class="failed_jobs_failed_at"><?= $Page->failed_at->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_failed_jobs_id" class="failed_jobs_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->uuid->Visible) { // uuid ?>
        <td <?= $Page->uuid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_failed_jobs_uuid" class="failed_jobs_uuid">
<span<?= $Page->uuid->viewAttributes() ?>>
<?= $Page->uuid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->failed_at->Visible) { // failed_at ?>
        <td <?= $Page->failed_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_failed_jobs_failed_at" class="failed_jobs_failed_at">
<span<?= $Page->failed_at->viewAttributes() ?>>
<?= $Page->failed_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
