<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PerusahaanPenampungAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fperusahaan_penampungadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fperusahaan_penampungadd = currentForm = new ew.Form("fperusahaan_penampungadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "perusahaan_penampung")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.perusahaan_penampung)
        ew.vars.tables.perusahaan_penampung = currentTable;
    fperusahaan_penampungadd.addFields([
        ["nama_perusahaan", [fields.nama_perusahaan.visible && fields.nama_perusahaan.required ? ew.Validators.required(fields.nama_perusahaan.caption) : null], fields.nama_perusahaan.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["no_telpon", [fields.no_telpon.visible && fields.no_telpon.required ? ew.Validators.required(fields.no_telpon.caption) : null], fields.no_telpon.isInvalid],
        ["contact_person", [fields.contact_person.visible && fields.contact_person.required ? ew.Validators.required(fields.contact_person.caption) : null], fields.contact_person.isInvalid],
        ["bidang", [fields.bidang.visible && fields.bidang.required ? ew.Validators.required(fields.bidang.caption) : null], fields.bidang.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fperusahaan_penampungadd,
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
    fperusahaan_penampungadd.validate = function () {
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
    fperusahaan_penampungadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fperusahaan_penampungadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fperusahaan_penampungadd");
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
<form name="fperusahaan_penampungadd" id="fperusahaan_penampungadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perusahaan_penampung">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div d-none"><!-- page* -->
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
    <div id="r_nama_perusahaan" class="form-group row">
        <label id="elh_perusahaan_penampung_nama_perusahaan" for="x_nama_perusahaan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?><?= $Page->nama_perusahaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_perusahaan->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_nama_perusahaan"><span id="el_perusahaan_penampung_nama_perusahaan">
<input type="<?= $Page->nama_perusahaan->getInputTextType() ?>" data-table="perusahaan_penampung" data-field="x_nama_perusahaan" name="x_nama_perusahaan" id="x_nama_perusahaan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_perusahaan->getPlaceHolder()) ?>" value="<?= $Page->nama_perusahaan->EditValue ?>"<?= $Page->nama_perusahaan->editAttributes() ?> aria-describedby="x_nama_perusahaan_help">
<?= $Page->nama_perusahaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_perusahaan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_perusahaan_penampung_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_alamat"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_alamat"><span id="el_perusahaan_penampung_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="perusahaan_penampung" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
    <div id="r_no_telpon" class="form-group row">
        <label id="elh_perusahaan_penampung_no_telpon" for="x_no_telpon" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_no_telpon"><?= $Page->no_telpon->caption() ?><?= $Page->no_telpon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_telpon->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_no_telpon"><span id="el_perusahaan_penampung_no_telpon">
<input type="<?= $Page->no_telpon->getInputTextType() ?>" data-table="perusahaan_penampung" data-field="x_no_telpon" name="x_no_telpon" id="x_no_telpon" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_telpon->getPlaceHolder()) ?>" value="<?= $Page->no_telpon->EditValue ?>"<?= $Page->no_telpon->editAttributes() ?> aria-describedby="x_no_telpon_help">
<?= $Page->no_telpon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_telpon->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->contact_person->Visible) { // contact_person ?>
    <div id="r_contact_person" class="form-group row">
        <label id="elh_perusahaan_penampung_contact_person" for="x_contact_person" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_contact_person"><?= $Page->contact_person->caption() ?><?= $Page->contact_person->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->contact_person->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_contact_person"><span id="el_perusahaan_penampung_contact_person">
<input type="<?= $Page->contact_person->getInputTextType() ?>" data-table="perusahaan_penampung" data-field="x_contact_person" name="x_contact_person" id="x_contact_person" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->contact_person->getPlaceHolder()) ?>" value="<?= $Page->contact_person->EditValue ?>"<?= $Page->contact_person->editAttributes() ?> aria-describedby="x_contact_person_help">
<?= $Page->contact_person->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->contact_person->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->bidang->Visible) { // bidang ?>
    <div id="r_bidang" class="form-group row">
        <label id="elh_perusahaan_penampung_bidang" for="x_bidang" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_bidang"><?= $Page->bidang->caption() ?><?= $Page->bidang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->bidang->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_bidang"><span id="el_perusahaan_penampung_bidang">
<input type="<?= $Page->bidang->getInputTextType() ?>" data-table="perusahaan_penampung" data-field="x_bidang" name="x_bidang" id="x_bidang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->bidang->getPlaceHolder()) ?>" value="<?= $Page->bidang->EditValue ?>"<?= $Page->bidang->editAttributes() ?> aria-describedby="x_bidang_help">
<?= $Page->bidang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->bidang->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_perusahaan_penampung_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_perusahaan_penampung_keterangan"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<template id="tpx_perusahaan_penampung_keterangan"><span id="el_perusahaan_penampung_keterangan">
<textarea data-table="perusahaan_penampung" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<div id="tpd_perusahaan_penampungadd" class="ew-custom-template"></div>
<template id="tpm_perusahaan_penampungadd">
<div id="ct_PerusahaanPenampungAdd"><?php require_once('perusahaan-penampung.php'); ?>
</div>
</template>
<?php if (!$Page->IsModal) { ?>
<div class="form-group row"><!-- buttons .form-group -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_perusahaan_penampungadd", "tpm_perusahaan_penampungadd", "perusahaan_penampungadd", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
    loadjs.done("customtemplate");
});
</script>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("perusahaan_penampung");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
