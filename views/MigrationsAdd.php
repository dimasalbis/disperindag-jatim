<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MigrationsAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmigrationsadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fmigrationsadd = currentForm = new ew.Form("fmigrationsadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "migrations")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.migrations)
        ew.vars.tables.migrations = currentTable;
    fmigrationsadd.addFields([
        ["migration", [fields.migration.visible && fields.migration.required ? ew.Validators.required(fields.migration.caption) : null], fields.migration.isInvalid],
        ["batch", [fields.batch.visible && fields.batch.required ? ew.Validators.required(fields.batch.caption) : null, ew.Validators.integer], fields.batch.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fmigrationsadd,
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
    fmigrationsadd.validate = function () {
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
    fmigrationsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fmigrationsadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fmigrationsadd");
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
<form name="fmigrationsadd" id="fmigrationsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="migrations">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->migration->Visible) { // migration ?>
    <div id="r_migration" class="form-group row">
        <label id="elh_migrations_migration" for="x_migration" class="<?= $Page->LeftColumnClass ?>"><?= $Page->migration->caption() ?><?= $Page->migration->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->migration->cellAttributes() ?>>
<span id="el_migrations_migration">
<input type="<?= $Page->migration->getInputTextType() ?>" data-table="migrations" data-field="x_migration" name="x_migration" id="x_migration" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->migration->getPlaceHolder()) ?>" value="<?= $Page->migration->EditValue ?>"<?= $Page->migration->editAttributes() ?> aria-describedby="x_migration_help">
<?= $Page->migration->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->migration->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->batch->Visible) { // batch ?>
    <div id="r_batch" class="form-group row">
        <label id="elh_migrations_batch" for="x_batch" class="<?= $Page->LeftColumnClass ?>"><?= $Page->batch->caption() ?><?= $Page->batch->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->batch->cellAttributes() ?>>
<span id="el_migrations_batch">
<input type="<?= $Page->batch->getInputTextType() ?>" data-table="migrations" data-field="x_batch" name="x_batch" id="x_batch" size="30" placeholder="<?= HtmlEncode($Page->batch->getPlaceHolder()) ?>" value="<?= $Page->batch->EditValue ?>"<?= $Page->batch->editAttributes() ?> aria-describedby="x_batch_help">
<?= $Page->batch->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->batch->getErrorMessage() ?></div>
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
    ew.addEventHandlers("migrations");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
