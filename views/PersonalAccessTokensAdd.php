<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PersonalAccessTokensAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpersonal_access_tokensadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpersonal_access_tokensadd = currentForm = new ew.Form("fpersonal_access_tokensadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "personal_access_tokens")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.personal_access_tokens)
        ew.vars.tables.personal_access_tokens = currentTable;
    fpersonal_access_tokensadd.addFields([
        ["tokenable_type", [fields.tokenable_type.visible && fields.tokenable_type.required ? ew.Validators.required(fields.tokenable_type.caption) : null], fields.tokenable_type.isInvalid],
        ["tokenable_id", [fields.tokenable_id.visible && fields.tokenable_id.required ? ew.Validators.required(fields.tokenable_id.caption) : null, ew.Validators.integer], fields.tokenable_id.isInvalid],
        ["name", [fields.name.visible && fields.name.required ? ew.Validators.required(fields.name.caption) : null], fields.name.isInvalid],
        ["_token", [fields._token.visible && fields._token.required ? ew.Validators.required(fields._token.caption) : null], fields._token.isInvalid],
        ["abilities", [fields.abilities.visible && fields.abilities.required ? ew.Validators.required(fields.abilities.caption) : null], fields.abilities.isInvalid],
        ["last_used_at", [fields.last_used_at.visible && fields.last_used_at.required ? ew.Validators.required(fields.last_used_at.caption) : null, ew.Validators.datetime(0)], fields.last_used_at.isInvalid],
        ["expires_at", [fields.expires_at.visible && fields.expires_at.required ? ew.Validators.required(fields.expires_at.caption) : null, ew.Validators.datetime(0)], fields.expires_at.isInvalid],
        ["created_at", [fields.created_at.visible && fields.created_at.required ? ew.Validators.required(fields.created_at.caption) : null, ew.Validators.datetime(0)], fields.created_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpersonal_access_tokensadd,
            fobj = f.getForm(),
            $fobj = $(fobj),
            $k = $fobj.find("#" + f.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            f.setInvalid(rowIndex);
        }
    });

    // Validate form
    fpersonal_access_tokensadd.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj);
        if ($fobj.find("#confirm").val() == "confirm")
            return true;
        var addcnt = 0,
            $k = $fobj.find("#" + this.formKeyCountName), // Get key_count
            rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1,
            startcnt = (rowcnt == 0) ? 0 : 1, // Check rowcnt == 0 => Inline-Add
            gridinsert = ["insert", "gridinsert"].includes($fobj.find("#action").val()) && $k[0];
        for (var i = startcnt; i <= rowcnt; i++) {
            var rowIndex = ($k[0]) ? String(i) : "";
            $fobj.data("rowindex", rowIndex);

            // Validate fields
            if (!this.validateFields(rowIndex))
                return false;

            // Call Form_CustomValidate event
            if (!this.customValidate(fobj)) {
                this.focus();
                return false;
            }
        }

        // Process detail forms
        var dfs = $fobj.find("input[name='detailpage']").get();
        for (var i = 0; i < dfs.length; i++) {
            var df = dfs[i],
                val = df.value,
                frm = ew.forms.get(val);
            if (val && frm && !frm.validate())
                return false;
        }
        return true;
    }

    // Form_CustomValidate
    fpersonal_access_tokensadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpersonal_access_tokensadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpersonal_access_tokensadd");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpersonal_access_tokensadd" id="fpersonal_access_tokensadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="personal_access_tokens">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->tokenable_type->Visible) { // tokenable_type ?>
    <div id="r_tokenable_type" class="form-group row">
        <label id="elh_personal_access_tokens_tokenable_type" for="x_tokenable_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tokenable_type->caption() ?><?= $Page->tokenable_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tokenable_type->cellAttributes() ?>>
<span id="el_personal_access_tokens_tokenable_type">
<input type="<?= $Page->tokenable_type->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_tokenable_type" name="x_tokenable_type" id="x_tokenable_type" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tokenable_type->getPlaceHolder()) ?>" value="<?= $Page->tokenable_type->EditValue ?>"<?= $Page->tokenable_type->editAttributes() ?> aria-describedby="x_tokenable_type_help">
<?= $Page->tokenable_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tokenable_type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tokenable_id->Visible) { // tokenable_id ?>
    <div id="r_tokenable_id" class="form-group row">
        <label id="elh_personal_access_tokens_tokenable_id" for="x_tokenable_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tokenable_id->caption() ?><?= $Page->tokenable_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tokenable_id->cellAttributes() ?>>
<span id="el_personal_access_tokens_tokenable_id">
<input type="<?= $Page->tokenable_id->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_tokenable_id" name="x_tokenable_id" id="x_tokenable_id" size="30" placeholder="<?= HtmlEncode($Page->tokenable_id->getPlaceHolder()) ?>" value="<?= $Page->tokenable_id->EditValue ?>"<?= $Page->tokenable_id->editAttributes() ?> aria-describedby="x_tokenable_id_help">
<?= $Page->tokenable_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tokenable_id->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->name->Visible) { // name ?>
    <div id="r_name" class="form-group row">
        <label id="elh_personal_access_tokens_name" for="x_name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->name->caption() ?><?= $Page->name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->name->cellAttributes() ?>>
<span id="el_personal_access_tokens_name">
<input type="<?= $Page->name->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->name->getPlaceHolder()) ?>" value="<?= $Page->name->EditValue ?>"<?= $Page->name->editAttributes() ?> aria-describedby="x_name_help">
<?= $Page->name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_token->Visible) { // token ?>
    <div id="r__token" class="form-group row">
        <label id="elh_personal_access_tokens__token" for="x__token" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_token->caption() ?><?= $Page->_token->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_token->cellAttributes() ?>>
<span id="el_personal_access_tokens__token">
<input type="<?= $Page->_token->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x__token" name="x__token" id="x__token" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_token->getPlaceHolder()) ?>" value="<?= $Page->_token->EditValue ?>"<?= $Page->_token->editAttributes() ?> aria-describedby="x__token_help">
<?= $Page->_token->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_token->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->abilities->Visible) { // abilities ?>
    <div id="r_abilities" class="form-group row">
        <label id="elh_personal_access_tokens_abilities" for="x_abilities" class="<?= $Page->LeftColumnClass ?>"><?= $Page->abilities->caption() ?><?= $Page->abilities->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->abilities->cellAttributes() ?>>
<span id="el_personal_access_tokens_abilities">
<textarea data-table="personal_access_tokens" data-field="x_abilities" name="x_abilities" id="x_abilities" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->abilities->getPlaceHolder()) ?>"<?= $Page->abilities->editAttributes() ?> aria-describedby="x_abilities_help"><?= $Page->abilities->EditValue ?></textarea>
<?= $Page->abilities->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->abilities->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->last_used_at->Visible) { // last_used_at ?>
    <div id="r_last_used_at" class="form-group row">
        <label id="elh_personal_access_tokens_last_used_at" for="x_last_used_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->last_used_at->caption() ?><?= $Page->last_used_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->last_used_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_last_used_at">
<input type="<?= $Page->last_used_at->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_last_used_at" name="x_last_used_at" id="x_last_used_at" placeholder="<?= HtmlEncode($Page->last_used_at->getPlaceHolder()) ?>" value="<?= $Page->last_used_at->EditValue ?>"<?= $Page->last_used_at->editAttributes() ?> aria-describedby="x_last_used_at_help">
<?= $Page->last_used_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->last_used_at->getErrorMessage() ?></div>
<?php if (!$Page->last_used_at->ReadOnly && !$Page->last_used_at->Disabled && !isset($Page->last_used_at->EditAttrs["readonly"]) && !isset($Page->last_used_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpersonal_access_tokensadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpersonal_access_tokensadd", "x_last_used_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->expires_at->Visible) { // expires_at ?>
    <div id="r_expires_at" class="form-group row">
        <label id="elh_personal_access_tokens_expires_at" for="x_expires_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->expires_at->caption() ?><?= $Page->expires_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->expires_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_expires_at">
<input type="<?= $Page->expires_at->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_expires_at" name="x_expires_at" id="x_expires_at" placeholder="<?= HtmlEncode($Page->expires_at->getPlaceHolder()) ?>" value="<?= $Page->expires_at->EditValue ?>"<?= $Page->expires_at->editAttributes() ?> aria-describedby="x_expires_at_help">
<?= $Page->expires_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->expires_at->getErrorMessage() ?></div>
<?php if (!$Page->expires_at->ReadOnly && !$Page->expires_at->Disabled && !isset($Page->expires_at->EditAttrs["readonly"]) && !isset($Page->expires_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpersonal_access_tokensadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpersonal_access_tokensadd", "x_expires_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <div id="r_created_at" class="form-group row">
        <label id="elh_personal_access_tokens_created_at" for="x_created_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->created_at->caption() ?><?= $Page->created_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->created_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_created_at">
<input type="<?= $Page->created_at->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_created_at" name="x_created_at" id="x_created_at" placeholder="<?= HtmlEncode($Page->created_at->getPlaceHolder()) ?>" value="<?= $Page->created_at->EditValue ?>"<?= $Page->created_at->editAttributes() ?> aria-describedby="x_created_at_help">
<?= $Page->created_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->created_at->getErrorMessage() ?></div>
<?php if (!$Page->created_at->ReadOnly && !$Page->created_at->Disabled && !isset($Page->created_at->EditAttrs["readonly"]) && !isset($Page->created_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpersonal_access_tokensadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpersonal_access_tokensadd", "x_created_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_personal_access_tokens_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_personal_access_tokens_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="personal_access_tokens" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpersonal_access_tokensadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpersonal_access_tokensadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("personal_access_tokens");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
