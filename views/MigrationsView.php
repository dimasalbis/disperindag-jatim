<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MigrationsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmigrationsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmigrationsview = currentForm = new ew.Form("fmigrationsview", "view");
    loadjs.done("fmigrationsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.migrations) ew.vars.tables.migrations = <?= JsonEncode(GetClientVar("tables", "migrations")) ?>;
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
<form name="fmigrationsview" id="fmigrationsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="migrations">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_migrations_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_migrations_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->migration->Visible) { // migration ?>
    <tr id="r_migration">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_migrations_migration"><?= $Page->migration->caption() ?></span></td>
        <td data-name="migration" <?= $Page->migration->cellAttributes() ?>>
<span id="el_migrations_migration">
<span<?= $Page->migration->viewAttributes() ?>>
<?= $Page->migration->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->batch->Visible) { // batch ?>
    <tr id="r_batch">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_migrations_batch"><?= $Page->batch->caption() ?></span></td>
        <td data-name="batch" <?= $Page->batch->cellAttributes() ?>>
<span id="el_migrations_batch">
<span<?= $Page->batch->viewAttributes() ?>>
<?= $Page->batch->getViewValue() ?></span>
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
