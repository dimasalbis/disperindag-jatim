<?php

namespace PHPMaker2021\project1;

// Page object
$ModelHasRolesDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmodel_has_rolesdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmodel_has_rolesdelete = currentForm = new ew.Form("fmodel_has_rolesdelete", "delete");
    loadjs.done("fmodel_has_rolesdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.model_has_roles) ew.vars.tables.model_has_roles = <?= JsonEncode(GetClientVar("tables", "model_has_roles")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmodel_has_rolesdelete" id="fmodel_has_rolesdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="model_has_roles">
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
<?php if ($Page->role_id->Visible) { // role_id ?>
        <th class="<?= $Page->role_id->headerCellClass() ?>"><span id="elh_model_has_roles_role_id" class="model_has_roles_role_id"><?= $Page->role_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->model_type->Visible) { // model_type ?>
        <th class="<?= $Page->model_type->headerCellClass() ?>"><span id="elh_model_has_roles_model_type" class="model_has_roles_model_type"><?= $Page->model_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->model_id->Visible) { // model_id ?>
        <th class="<?= $Page->model_id->headerCellClass() ?>"><span id="elh_model_has_roles_model_id" class="model_has_roles_model_id"><?= $Page->model_id->caption() ?></span></th>
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
<?php if ($Page->role_id->Visible) { // role_id ?>
        <td <?= $Page->role_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_model_has_roles_role_id" class="model_has_roles_role_id">
<span<?= $Page->role_id->viewAttributes() ?>>
<?= $Page->role_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->model_type->Visible) { // model_type ?>
        <td <?= $Page->model_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_model_has_roles_model_type" class="model_has_roles_model_type">
<span<?= $Page->model_type->viewAttributes() ?>>
<?= $Page->model_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->model_id->Visible) { // model_id ?>
        <td <?= $Page->model_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_model_has_roles_model_id" class="model_has_roles_model_id">
<span<?= $Page->model_id->viewAttributes() ?>>
<?= $Page->model_id->getViewValue() ?></span>
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
