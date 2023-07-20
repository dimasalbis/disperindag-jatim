<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PelatihanSiswaAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpelatihan_siswaadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpelatihan_siswaadd = currentForm = new ew.Form("fpelatihan_siswaadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pelatihan_siswa")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pelatihan_siswa)
        ew.vars.tables.pelatihan_siswa = currentTable;
    fpelatihan_siswaadd.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["asal_sekolah", [fields.asal_sekolah.visible && fields.asal_sekolah.required ? ew.Validators.required(fields.asal_sekolah.caption) : null], fields.asal_sekolah.isInvalid],
        ["tempat_lahir", [fields.tempat_lahir.visible && fields.tempat_lahir.required ? ew.Validators.required(fields.tempat_lahir.caption) : null], fields.tempat_lahir.isInvalid],
        ["tanggal_lahir", [fields.tanggal_lahir.visible && fields.tanggal_lahir.required ? ew.Validators.required(fields.tanggal_lahir.caption) : null, ew.Validators.datetime(0)], fields.tanggal_lahir.isInvalid],
        ["jenis_kelamin", [fields.jenis_kelamin.visible && fields.jenis_kelamin.required ? ew.Validators.required(fields.jenis_kelamin.caption) : null], fields.jenis_kelamin.isInvalid],
        ["no_telpon", [fields.no_telpon.visible && fields.no_telpon.required ? ew.Validators.required(fields.no_telpon.caption) : null], fields.no_telpon.isInvalid],
        ["_email", [fields._email.visible && fields._email.required ? ew.Validators.required(fields._email.caption) : null], fields._email.isInvalid],
        ["legalitas", [fields.legalitas.visible && fields.legalitas.required ? ew.Validators.fileRequired(fields.legalitas.caption) : null], fields.legalitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpelatihan_siswaadd,
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
    fpelatihan_siswaadd.validate = function () {
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
    fpelatihan_siswaadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpelatihan_siswaadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    fpelatihan_siswaadd.lists.jenis_kelamin = <?= $Page->jenis_kelamin->toClientList($Page) ?>;
    loadjs.done("fpelatihan_siswaadd");
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
<form name="fpelatihan_siswaadd" id="fpelatihan_siswaadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pelatihan_siswa">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pelatihan_siswa_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pelatihan_siswa_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->asal_sekolah->Visible) { // asal_sekolah ?>
    <div id="r_asal_sekolah" class="form-group row">
        <label id="elh_pelatihan_siswa_asal_sekolah" for="x_asal_sekolah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->asal_sekolah->caption() ?><?= $Page->asal_sekolah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->asal_sekolah->cellAttributes() ?>>
<span id="el_pelatihan_siswa_asal_sekolah">
<input type="<?= $Page->asal_sekolah->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x_asal_sekolah" name="x_asal_sekolah" id="x_asal_sekolah" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->asal_sekolah->getPlaceHolder()) ?>" value="<?= $Page->asal_sekolah->EditValue ?>"<?= $Page->asal_sekolah->editAttributes() ?> aria-describedby="x_asal_sekolah_help">
<?= $Page->asal_sekolah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->asal_sekolah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tempat_lahir->Visible) { // tempat_lahir ?>
    <div id="r_tempat_lahir" class="form-group row">
        <label id="elh_pelatihan_siswa_tempat_lahir" for="x_tempat_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tempat_lahir->caption() ?><?= $Page->tempat_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tempat_lahir->cellAttributes() ?>>
<span id="el_pelatihan_siswa_tempat_lahir">
<input type="<?= $Page->tempat_lahir->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x_tempat_lahir" name="x_tempat_lahir" id="x_tempat_lahir" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->tempat_lahir->getPlaceHolder()) ?>" value="<?= $Page->tempat_lahir->EditValue ?>"<?= $Page->tempat_lahir->editAttributes() ?> aria-describedby="x_tempat_lahir_help">
<?= $Page->tempat_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tempat_lahir->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_lahir->Visible) { // tanggal_lahir ?>
    <div id="r_tanggal_lahir" class="form-group row">
        <label id="elh_pelatihan_siswa_tanggal_lahir" for="x_tanggal_lahir" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_lahir->caption() ?><?= $Page->tanggal_lahir->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_lahir->cellAttributes() ?>>
<span id="el_pelatihan_siswa_tanggal_lahir">
<input type="<?= $Page->tanggal_lahir->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x_tanggal_lahir" name="x_tanggal_lahir" id="x_tanggal_lahir" maxlength="10" placeholder="<?= HtmlEncode($Page->tanggal_lahir->getPlaceHolder()) ?>" value="<?= $Page->tanggal_lahir->EditValue ?>"<?= $Page->tanggal_lahir->editAttributes() ?> aria-describedby="x_tanggal_lahir_help">
<?= $Page->tanggal_lahir->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_lahir->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_lahir->ReadOnly && !$Page->tanggal_lahir->Disabled && !isset($Page->tanggal_lahir->EditAttrs["readonly"]) && !isset($Page->tanggal_lahir->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpelatihan_siswaadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpelatihan_siswaadd", "x_tanggal_lahir", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jenis_kelamin->Visible) { // jenis_kelamin ?>
    <div id="r_jenis_kelamin" class="form-group row">
        <label id="elh_pelatihan_siswa_jenis_kelamin" for="x_jenis_kelamin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jenis_kelamin->caption() ?><?= $Page->jenis_kelamin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jenis_kelamin->cellAttributes() ?>>
<span id="el_pelatihan_siswa_jenis_kelamin">
    <select
        id="x_jenis_kelamin"
        name="x_jenis_kelamin"
        class="form-control ew-select<?= $Page->jenis_kelamin->isInvalidClass() ?>"
        data-select2-id="pelatihan_siswa_x_jenis_kelamin"
        data-table="pelatihan_siswa"
        data-field="x_jenis_kelamin"
        data-value-separator="<?= $Page->jenis_kelamin->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->jenis_kelamin->getPlaceHolder()) ?>"
        <?= $Page->jenis_kelamin->editAttributes() ?>>
        <?= $Page->jenis_kelamin->selectOptionListHtml("x_jenis_kelamin") ?>
    </select>
    <?= $Page->jenis_kelamin->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->jenis_kelamin->getErrorMessage() ?></div>
<script>
loadjs.ready("head", function() {
    var el = document.querySelector("select[data-select2-id='pelatihan_siswa_x_jenis_kelamin']"),
        options = { name: "x_jenis_kelamin", selectId: "pelatihan_siswa_x_jenis_kelamin", language: ew.LANGUAGE_ID, dir: ew.IS_RTL ? "rtl" : "ltr" };
    options.data = ew.vars.tables.pelatihan_siswa.fields.jenis_kelamin.lookupOptions;
    options.dropdownParent = $(el).closest("#ew-modal-dialog, #ew-add-opt-dialog")[0];
    Object.assign(options, ew.vars.tables.pelatihan_siswa.fields.jenis_kelamin.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
    <div id="r_no_telpon" class="form-group row">
        <label id="elh_pelatihan_siswa_no_telpon" for="x_no_telpon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_telpon->caption() ?><?= $Page->no_telpon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_telpon->cellAttributes() ?>>
<span id="el_pelatihan_siswa_no_telpon">
<input type="<?= $Page->no_telpon->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x_no_telpon" name="x_no_telpon" id="x_no_telpon" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_telpon->getPlaceHolder()) ?>" value="<?= $Page->no_telpon->EditValue ?>"<?= $Page->no_telpon->editAttributes() ?> aria-describedby="x_no_telpon_help">
<?= $Page->no_telpon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_telpon->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <div id="r__email" class="form-group row">
        <label id="elh_pelatihan_siswa__email" for="x__email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_email->caption() ?><?= $Page->_email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_email->cellAttributes() ?>>
<span id="el_pelatihan_siswa__email">
<input type="<?= $Page->_email->getInputTextType() ?>" data-table="pelatihan_siswa" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_email->getPlaceHolder()) ?>" value="<?= $Page->_email->EditValue ?>"<?= $Page->_email->editAttributes() ?> aria-describedby="x__email_help">
<?= $Page->_email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_email->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->legalitas->Visible) { // legalitas ?>
    <div id="r_legalitas" class="form-group row">
        <label id="elh_pelatihan_siswa_legalitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->legalitas->caption() ?><?= $Page->legalitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->legalitas->cellAttributes() ?>>
<span id="el_pelatihan_siswa_legalitas">
<div id="fd_x_legalitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->legalitas->title() ?>" data-table="pelatihan_siswa" data-field="x_legalitas" name="x_legalitas" id="x_legalitas" lang="<?= CurrentLanguageID() ?>"<?= $Page->legalitas->editAttributes() ?><?= ($Page->legalitas->ReadOnly || $Page->legalitas->Disabled) ? " disabled" : "" ?> aria-describedby="x_legalitas_help">
        <label class="custom-file-label ew-file-label" for="x_legalitas"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->legalitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->legalitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_legalitas" id= "fn_x_legalitas" value="<?= $Page->legalitas->Upload->FileName ?>">
<input type="hidden" name="fa_x_legalitas" id= "fa_x_legalitas" value="0">
<input type="hidden" name="fs_x_legalitas" id= "fs_x_legalitas" value="255">
<input type="hidden" name="fx_x_legalitas" id= "fx_x_legalitas" value="<?= $Page->legalitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_legalitas" id= "fm_x_legalitas" value="<?= $Page->legalitas->UploadMaxFileSize ?>">
</div>
<table id="ft_x_legalitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("pelatihan_siswa");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
