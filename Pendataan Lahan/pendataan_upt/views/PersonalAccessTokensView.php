<?php

namespace PHPMaker2021\project1;

// Page object
$PersonalAccessTokensView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpersonal_access_tokensview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpersonal_access_tokensview = currentForm = new ew.Form("fpersonal_access_tokensview", "view");
    loadjs.done("fpersonal_access_tokensview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.personal_access_tokens) ew.vars.tables.personal_access_tokens = <?= JsonEncode(GetClientVar("tables", "personal_access_tokens")) ?>;
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
<form name="fpersonal_access_tokensview" id="fpersonal_access_tokensview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="personal_access_tokens">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_personal_access_tokens_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tokenable_type->Visible) { // tokenable_type ?>
    <tr id="r_tokenable_type">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_tokenable_type"><?= $Page->tokenable_type->caption() ?></span></td>
        <td data-name="tokenable_type" <?= $Page->tokenable_type->cellAttributes() ?>>
<span id="el_personal_access_tokens_tokenable_type">
<span<?= $Page->tokenable_type->viewAttributes() ?>>
<?= $Page->tokenable_type->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tokenable_id->Visible) { // tokenable_id ?>
    <tr id="r_tokenable_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_tokenable_id"><?= $Page->tokenable_id->caption() ?></span></td>
        <td data-name="tokenable_id" <?= $Page->tokenable_id->cellAttributes() ?>>
<span id="el_personal_access_tokens_tokenable_id">
<span<?= $Page->tokenable_id->viewAttributes() ?>>
<?= $Page->tokenable_id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <tr id="r_name">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_name"><?= $Page->name->caption() ?></span></td>
        <td data-name="name" <?= $Page->name->cellAttributes() ?>>
<span id="el_personal_access_tokens_name">
<span<?= $Page->name->viewAttributes() ?>>
<?= $Page->name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <tr id="r__token">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens__token"><?= $Page->_token->caption() ?></span></td>
        <td data-name="_token" <?= $Page->_token->cellAttributes() ?>>
<span id="el_personal_access_tokens__token">
<span<?= $Page->_token->viewAttributes() ?>>
<?= $Page->_token->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->abilities->Visible) { // abilities ?>
    <tr id="r_abilities">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_abilities"><?= $Page->abilities->caption() ?></span></td>
        <td data-name="abilities" <?= $Page->abilities->cellAttributes() ?>>
<span id="el_personal_access_tokens_abilities">
<span<?= $Page->abilities->viewAttributes() ?>>
<?= $Page->abilities->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->last_used_at->Visible) { // last_used_at ?>
    <tr id="r_last_used_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_last_used_at"><?= $Page->last_used_at->caption() ?></span></td>
        <td data-name="last_used_at" <?= $Page->last_used_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_last_used_at">
<span<?= $Page->last_used_at->viewAttributes() ?>>
<?= $Page->last_used_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->expires_at->Visible) { // expires_at ?>
    <tr id="r_expires_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_expires_at"><?= $Page->expires_at->caption() ?></span></td>
        <td data-name="expires_at" <?= $Page->expires_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_expires_at">
<span<?= $Page->expires_at->viewAttributes() ?>>
<?= $Page->expires_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_personal_access_tokens_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
