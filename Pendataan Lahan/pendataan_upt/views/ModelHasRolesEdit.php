<?php

namespace PHPMaker2021\project1;

// Page object
$ModelHasRolesEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmodel_has_rolesedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fmodel_has_rolesedit = currentForm = new ew.Form("fmodel_has_rolesedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "model_has_roles")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.model_has_roles)
        ew.vars.tables.model_has_roles = currentTable;
    fmodel_has_rolesedit.addFields([
        ["role_id", [fields.role_id.visible && fields.role_id.required ? ew.Validators.required(fields.role_id.caption) : null, ew.Validators.integer], fields.role_id.isInvalid],
        ["model_type", [fields.model_type.visible && fields.model_type.required ? ew.Validators.required(fields.model_type.caption) : null], fields.model_type.isInvalid],
        ["model_id", [fields.model_id.visible && fields.model_id.required ? ew.Validators.required(fields.model_id.caption) : null, ew.Validators.integer], fields.model_id.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmodel_has_rolesedit,
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
    fmodel_has_rolesedit.validate = function () {
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
    fmodel_has_rolesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmodel_has_rolesedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fmodel_has_rolesedit");
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
<form name="fmodel_has_rolesedit" id="fmodel_has_rolesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="model_has_roles">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->role_id->Visible) { // role_id ?>
    <div id="r_role_id" class="form-group row">
        <label id="elh_model_has_roles_role_id" for="x_role_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->role_id->caption() ?><?= $Page->role_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->role_id->cellAttributes() ?>>
<input type="<?= $Page->role_id->getInputTextType() ?>" data-table="model_has_roles" data-field="x_role_id" name="x_role_id" id="x_role_id" size="30" placeholder="<?= HtmlEncode($Page->role_id->getPlaceHolder()) ?>" value="<?= $Page->role_id->EditValue ?>"<?= $Page->role_id->editAttributes() ?> aria-describedby="x_role_id_help">
<?= $Page->role_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->role_id->getErrorMessage() ?></div>
<input type="hidden" data-table="model_has_roles" data-field="x_role_id" data-hidden="1" name="o_role_id" id="o_role_id" value="<?= HtmlEncode($Page->role_id->OldValue ?? $Page->role_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->model_type->Visible) { // model_type ?>
    <div id="r_model_type" class="form-group row">
        <label id="elh_model_has_roles_model_type" for="x_model_type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->model_type->caption() ?><?= $Page->model_type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->model_type->cellAttributes() ?>>
<input type="<?= $Page->model_type->getInputTextType() ?>" data-table="model_has_roles" data-field="x_model_type" name="x_model_type" id="x_model_type" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->model_type->getPlaceHolder()) ?>" value="<?= $Page->model_type->EditValue ?>"<?= $Page->model_type->editAttributes() ?> aria-describedby="x_model_type_help">
<?= $Page->model_type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->model_type->getErrorMessage() ?></div>
<input type="hidden" data-table="model_has_roles" data-field="x_model_type" data-hidden="1" name="o_model_type" id="o_model_type" value="<?= HtmlEncode($Page->model_type->OldValue ?? $Page->model_type->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->model_id->Visible) { // model_id ?>
    <div id="r_model_id" class="form-group row">
        <label id="elh_model_has_roles_model_id" for="x_model_id" class="<?= $Page->LeftColumnClass ?>"><?= $Page->model_id->caption() ?><?= $Page->model_id->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->model_id->cellAttributes() ?>>
<input type="<?= $Page->model_id->getInputTextType() ?>" data-table="model_has_roles" data-field="x_model_id" name="x_model_id" id="x_model_id" size="30" placeholder="<?= HtmlEncode($Page->model_id->getPlaceHolder()) ?>" value="<?= $Page->model_id->EditValue ?>"<?= $Page->model_id->editAttributes() ?> aria-describedby="x_model_id_help">
<?= $Page->model_id->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->model_id->getErrorMessage() ?></div>
<input type="hidden" data-table="model_has_roles" data-field="x_model_id" data-hidden="1" name="o_model_id" id="o_model_id" value="<?= HtmlEncode($Page->model_id->OldValue ?? $Page->model_id->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
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
    ew.addEventHandlers("model_has_roles");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
