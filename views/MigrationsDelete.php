<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MigrationsDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmigrationsdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmigrationsdelete = currentForm = new ew.Form("fmigrationsdelete", "delete");
    loadjs.done("fmigrationsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.migrations) ew.vars.tables.migrations = <?= JsonEncode(GetClientVar("tables", "migrations")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmigrationsdelete" id="fmigrationsdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="migrations">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_migrations_id" class="migrations_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->migration->Visible) { // migration ?>
        <th class="<?= $Page->migration->headerCellClass() ?>"><span id="elh_migrations_migration" class="migrations_migration"><?= $Page->migration->caption() ?></span></th>
<?php } ?>
<?php if ($Page->batch->Visible) { // batch ?>
        <th class="<?= $Page->batch->headerCellClass() ?>"><span id="elh_migrations_batch" class="migrations_batch"><?= $Page->batch->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_migrations_id" class="migrations_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->migration->Visible) { // migration ?>
        <td <?= $Page->migration->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_migrations_migration" class="migrations_migration">
<span<?= $Page->migration->viewAttributes() ?>>
<?= $Page->migration->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->batch->Visible) { // batch ?>
        <td <?= $Page->batch->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_migrations_batch" class="migrations_batch">
<span<?= $Page->batch->viewAttributes() ?>>
<?= $Page->batch->getViewValue() ?></span>
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
