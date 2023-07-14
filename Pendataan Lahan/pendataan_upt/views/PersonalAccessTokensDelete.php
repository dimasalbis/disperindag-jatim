<?php

namespace PHPMaker2021\project1;

// Page object
$PersonalAccessTokensDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpersonal_access_tokensdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpersonal_access_tokensdelete = currentForm = new ew.Form("fpersonal_access_tokensdelete", "delete");
    loadjs.done("fpersonal_access_tokensdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.personal_access_tokens) ew.vars.tables.personal_access_tokens = <?= JsonEncode(GetClientVar("tables", "personal_access_tokens")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpersonal_access_tokensdelete" id="fpersonal_access_tokensdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="personal_access_tokens">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_personal_access_tokens_id" class="personal_access_tokens_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tokenable_type->Visible) { // tokenable_type ?>
        <th class="<?= $Page->tokenable_type->headerCellClass() ?>"><span id="elh_personal_access_tokens_tokenable_type" class="personal_access_tokens_tokenable_type"><?= $Page->tokenable_type->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tokenable_id->Visible) { // tokenable_id ?>
        <th class="<?= $Page->tokenable_id->headerCellClass() ?>"><span id="elh_personal_access_tokens_tokenable_id" class="personal_access_tokens_tokenable_id"><?= $Page->tokenable_id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <th class="<?= $Page->name->headerCellClass() ?>"><span id="elh_personal_access_tokens_name" class="personal_access_tokens_name"><?= $Page->name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
        <th class="<?= $Page->_token->headerCellClass() ?>"><span id="elh_personal_access_tokens__token" class="personal_access_tokens__token"><?= $Page->_token->caption() ?></span></th>
<?php } ?>
<?php if ($Page->last_used_at->Visible) { // last_used_at ?>
        <th class="<?= $Page->last_used_at->headerCellClass() ?>"><span id="elh_personal_access_tokens_last_used_at" class="personal_access_tokens_last_used_at"><?= $Page->last_used_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->expires_at->Visible) { // expires_at ?>
        <th class="<?= $Page->expires_at->headerCellClass() ?>"><span id="elh_personal_access_tokens_expires_at" class="personal_access_tokens_expires_at"><?= $Page->expires_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_personal_access_tokens_created_at" class="personal_access_tokens_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_personal_access_tokens_updated_at" class="personal_access_tokens_updated_at"><?= $Page->updated_at->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_id" class="personal_access_tokens_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tokenable_type->Visible) { // tokenable_type ?>
        <td <?= $Page->tokenable_type->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_tokenable_type" class="personal_access_tokens_tokenable_type">
<span<?= $Page->tokenable_type->viewAttributes() ?>>
<?= $Page->tokenable_type->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tokenable_id->Visible) { // tokenable_id ?>
        <td <?= $Page->tokenable_id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_tokenable_id" class="personal_access_tokens_tokenable_id">
<span<?= $Page->tokenable_id->viewAttributes() ?>>
<?= $Page->tokenable_id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
        <td <?= $Page->name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_name" class="personal_access_tokens_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
        <td <?= $Page->_token->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens__token" class="personal_access_tokens__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->last_used_at->Visible) { // last_used_at ?>
        <td <?= $Page->last_used_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_last_used_at" class="personal_access_tokens_last_used_at">
<span<?= $Page->last_used_at->viewAttributes() ?>>
<?= $Page->last_used_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->expires_at->Visible) { // expires_at ?>
        <td <?= $Page->expires_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_expires_at" class="personal_access_tokens_expires_at">
<span<?= $Page->expires_at->viewAttributes() ?>>
<?= $Page->expires_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_created_at" class="personal_access_tokens_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_personal_access_tokens_updated_at" class="personal_access_tokens_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
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
