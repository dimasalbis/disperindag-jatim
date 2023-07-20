<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$StatuslevelsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstatuslevelsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fstatuslevelsdelete = currentForm = new ew.Form("fstatuslevelsdelete", "delete");
    loadjs.done("fstatuslevelsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.statuslevels) ew.vars.tables.statuslevels = <?= JsonEncode(GetClientVar("tables", "statuslevels")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fstatuslevelsdelete" id="fstatuslevelsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="statuslevels">
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
<?php if ($Page->statuslevelid->Visible) { // statuslevelid ?>
        <th class="<?= $Page->statuslevelid->headerCellClass() ?>"><span id="elh_statuslevels_statuslevelid" class="statuslevels_statuslevelid"><?= $Page->statuslevelid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->statuslevelname->Visible) { // statuslevelname ?>
        <th class="<?= $Page->statuslevelname->headerCellClass() ?>"><span id="elh_statuslevels_statuslevelname" class="statuslevels_statuslevelname"><?= $Page->statuslevelname->caption() ?></span></th>
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
<?php if ($Page->statuslevelid->Visible) { // statuslevelid ?>
        <td <?= $Page->statuslevelid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_statuslevels_statuslevelid" class="statuslevels_statuslevelid">
<span<?= $Page->statuslevelid->viewAttributes() ?>>
<?= $Page->statuslevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->statuslevelname->Visible) { // statuslevelname ?>
        <td <?= $Page->statuslevelname->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_statuslevels_statuslevelname" class="statuslevels_statuslevelname">
<span<?= $Page->statuslevelname->viewAttributes() ?>>
<?= $Page->statuslevelname->getViewValue() ?></span>
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
