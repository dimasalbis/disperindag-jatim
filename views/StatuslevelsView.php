<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$StatuslevelsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fstatuslevelsview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fstatuslevelsview = currentForm = new ew.Form("fstatuslevelsview", "view");
    loadjs.done("fstatuslevelsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.statuslevels) ew.vars.tables.statuslevels = <?= JsonEncode(GetClientVar("tables", "statuslevels")) ?>;
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
<form name="fstatuslevelsview" id="fstatuslevelsview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="statuslevels">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->statuslevelid->Visible) { // statuslevelid ?>
    <tr id="r_statuslevelid">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_statuslevels_statuslevelid"><?= $Page->statuslevelid->caption() ?></span></td>
        <td data-name="statuslevelid" <?= $Page->statuslevelid->cellAttributes() ?>>
<span id="el_statuslevels_statuslevelid">
<span<?= $Page->statuslevelid->viewAttributes() ?>>
<?= $Page->statuslevelid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->statuslevelname->Visible) { // statuslevelname ?>
    <tr id="r_statuslevelname">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_statuslevels_statuslevelname"><?= $Page->statuslevelname->caption() ?></span></td>
        <td data-name="statuslevelname" <?= $Page->statuslevelname->cellAttributes() ?>>
<span id="el_statuslevels_statuslevelname">
<span<?= $Page->statuslevelname->viewAttributes() ?>>
<?= $Page->statuslevelname->getViewValue() ?></span>
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
