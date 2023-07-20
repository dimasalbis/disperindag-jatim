<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$StatuslevelsEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fstatuslevelsedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fstatuslevelsedit = currentForm = new ew.Form("fstatuslevelsedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "statuslevels")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.statuslevels)
        ew.vars.tables.statuslevels = currentTable;
    fstatuslevelsedit.addFields([
        ["statuslevelid", [fields.statuslevelid.visible && fields.statuslevelid.required ? ew.Validators.required(fields.statuslevelid.caption) : null, ew.Validators.integer], fields.statuslevelid.isInvalid],
        ["statuslevelname", [fields.statuslevelname.visible && fields.statuslevelname.required ? ew.Validators.required(fields.statuslevelname.caption) : null], fields.statuslevelname.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fstatuslevelsedit,
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
    fstatuslevelsedit.validate = function () {
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
    fstatuslevelsedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fstatuslevelsedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fstatuslevelsedit");
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
<form name="fstatuslevelsedit" id="fstatuslevelsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="statuslevels">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->statuslevelid->Visible) { // statuslevelid ?>
    <div id="r_statuslevelid" class="form-group row">
        <label id="elh_statuslevels_statuslevelid" for="x_statuslevelid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statuslevelid->caption() ?><?= $Page->statuslevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statuslevelid->cellAttributes() ?>>
<input type="<?= $Page->statuslevelid->getInputTextType() ?>" data-table="statuslevels" data-field="x_statuslevelid" name="x_statuslevelid" id="x_statuslevelid" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->statuslevelid->getPlaceHolder()) ?>" value="<?= $Page->statuslevelid->EditValue ?>"<?= $Page->statuslevelid->editAttributes() ?> aria-describedby="x_statuslevelid_help">
<?= $Page->statuslevelid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statuslevelid->getErrorMessage() ?></div>
<input type="hidden" data-table="statuslevels" data-field="x_statuslevelid" data-hidden="1" name="o_statuslevelid" id="o_statuslevelid" value="<?= HtmlEncode($Page->statuslevelid->OldValue ?? $Page->statuslevelid->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->statuslevelname->Visible) { // statuslevelname ?>
    <div id="r_statuslevelname" class="form-group row">
        <label id="elh_statuslevels_statuslevelname" for="x_statuslevelname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->statuslevelname->caption() ?><?= $Page->statuslevelname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->statuslevelname->cellAttributes() ?>>
<span id="el_statuslevels_statuslevelname">
<input type="<?= $Page->statuslevelname->getInputTextType() ?>" data-table="statuslevels" data-field="x_statuslevelname" name="x_statuslevelname" id="x_statuslevelname" size="30" maxlength="80" placeholder="<?= HtmlEncode($Page->statuslevelname->getPlaceHolder()) ?>" value="<?= $Page->statuslevelname->EditValue ?>"<?= $Page->statuslevelname->editAttributes() ?> aria-describedby="x_statuslevelname_help">
<?= $Page->statuslevelname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->statuslevelname->getErrorMessage() ?></div>
</span>
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
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("statuslevels");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
