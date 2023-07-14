<?php

namespace PHPMaker2021\project1;

// Page object
$PendataanAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendataanadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpendataanadd = currentForm = new ew.Form("fpendataanadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pendataan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pendataan)
        ew.vars.tables.pendataan = currentTable;
    fpendataanadd.addFields([
        ["nama", [fields.nama.visible && fields.nama.required ? ew.Validators.required(fields.nama.caption) : null], fields.nama.isInvalid],
        ["penanggung_jawab", [fields.penanggung_jawab.visible && fields.penanggung_jawab.required ? ew.Validators.required(fields.penanggung_jawab.caption) : null], fields.penanggung_jawab.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["phone_number", [fields.phone_number.visible && fields.phone_number.required ? ew.Validators.required(fields.phone_number.caption) : null], fields.phone_number.isInvalid],
        ["produk", [fields.produk.visible && fields.produk.required ? ew.Validators.required(fields.produk.caption) : null], fields.produk.isInvalid],
        ["lokasi_lahan", [fields.lokasi_lahan.visible && fields.lokasi_lahan.required ? ew.Validators.required(fields.lokasi_lahan.caption) : null], fields.lokasi_lahan.isInvalid],
        ["create_at", [fields.create_at.visible && fields.create_at.required ? ew.Validators.required(fields.create_at.caption) : null, ew.Validators.datetime(0)], fields.create_at.isInvalid],
        ["updated_at", [fields.updated_at.visible && fields.updated_at.required ? ew.Validators.required(fields.updated_at.caption) : null, ew.Validators.datetime(0)], fields.updated_at.isInvalid],
        ["luas_lahan", [fields.luas_lahan.visible && fields.luas_lahan.required ? ew.Validators.required(fields.luas_lahan.caption) : null], fields.luas_lahan.isInvalid],
        ["nilai_sewa", [fields.nilai_sewa.visible && fields.nilai_sewa.required ? ew.Validators.required(fields.nilai_sewa.caption) : null], fields.nilai_sewa.isInvalid],
        ["legalitas", [fields.legalitas.visible && fields.legalitas.required ? ew.Validators.fileRequired(fields.legalitas.caption) : null], fields.legalitas.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpendataanadd,
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
    fpendataanadd.validate = function () {
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
    fpendataanadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendataanadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpendataanadd");
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
<form name="fpendataanadd" id="fpendataanadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nama->Visible) { // nama ?>
    <div id="r_nama" class="form-group row">
        <label id="elh_pendataan_nama" for="x_nama" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama->caption() ?><?= $Page->nama->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendataan_nama">
<input type="<?= $Page->nama->getInputTextType() ?>" data-table="pendataan" data-field="x_nama" name="x_nama" id="x_nama" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama->getPlaceHolder()) ?>" value="<?= $Page->nama->EditValue ?>"<?= $Page->nama->editAttributes() ?> aria-describedby="x_nama_help">
<?= $Page->nama->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
    <div id="r_penanggung_jawab" class="form-group row">
        <label id="elh_pendataan_penanggung_jawab" for="x_penanggung_jawab" class="<?= $Page->LeftColumnClass ?>"><?= $Page->penanggung_jawab->caption() ?><?= $Page->penanggung_jawab->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el_pendataan_penanggung_jawab">
<input type="<?= $Page->penanggung_jawab->getInputTextType() ?>" data-table="pendataan" data-field="x_penanggung_jawab" name="x_penanggung_jawab" id="x_penanggung_jawab" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->penanggung_jawab->getPlaceHolder()) ?>" value="<?= $Page->penanggung_jawab->EditValue ?>"<?= $Page->penanggung_jawab->editAttributes() ?> aria-describedby="x_penanggung_jawab_help">
<?= $Page->penanggung_jawab->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->penanggung_jawab->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_pendataan_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pendataan_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pendataan" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->phone_number->Visible) { // phone_number ?>
    <div id="r_phone_number" class="form-group row">
        <label id="elh_pendataan_phone_number" for="x_phone_number" class="<?= $Page->LeftColumnClass ?>"><?= $Page->phone_number->caption() ?><?= $Page->phone_number->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->phone_number->cellAttributes() ?>>
<span id="el_pendataan_phone_number">
<input type="<?= $Page->phone_number->getInputTextType() ?>" data-table="pendataan" data-field="x_phone_number" name="x_phone_number" id="x_phone_number" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->phone_number->getPlaceHolder()) ?>" value="<?= $Page->phone_number->EditValue ?>"<?= $Page->phone_number->editAttributes() ?> aria-describedby="x_phone_number_help">
<?= $Page->phone_number->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->phone_number->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <div id="r_produk" class="form-group row">
        <label id="elh_pendataan_produk" for="x_produk" class="<?= $Page->LeftColumnClass ?>"><?= $Page->produk->caption() ?><?= $Page->produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk->cellAttributes() ?>>
<span id="el_pendataan_produk">
<input type="<?= $Page->produk->getInputTextType() ?>" data-table="pendataan" data-field="x_produk" name="x_produk" id="x_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->produk->getPlaceHolder()) ?>" value="<?= $Page->produk->EditValue ?>"<?= $Page->produk->editAttributes() ?> aria-describedby="x_produk_help">
<?= $Page->produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
    <div id="r_lokasi_lahan" class="form-group row">
        <label id="elh_pendataan_lokasi_lahan" for="x_lokasi_lahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lokasi_lahan->caption() ?><?= $Page->lokasi_lahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el_pendataan_lokasi_lahan">
<input type="<?= $Page->lokasi_lahan->getInputTextType() ?>" data-table="pendataan" data-field="x_lokasi_lahan" name="x_lokasi_lahan" id="x_lokasi_lahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lokasi_lahan->getPlaceHolder()) ?>" value="<?= $Page->lokasi_lahan->EditValue ?>"<?= $Page->lokasi_lahan->editAttributes() ?> aria-describedby="x_lokasi_lahan_help">
<?= $Page->lokasi_lahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lokasi_lahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
    <div id="r_create_at" class="form-group row">
        <label id="elh_pendataan_create_at" for="x_create_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->create_at->caption() ?><?= $Page->create_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->create_at->cellAttributes() ?>>
<span id="el_pendataan_create_at">
<input type="<?= $Page->create_at->getInputTextType() ?>" data-table="pendataan" data-field="x_create_at" name="x_create_at" id="x_create_at" placeholder="<?= HtmlEncode($Page->create_at->getPlaceHolder()) ?>" value="<?= $Page->create_at->EditValue ?>"<?= $Page->create_at->editAttributes() ?> aria-describedby="x_create_at_help">
<?= $Page->create_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->create_at->getErrorMessage() ?></div>
<?php if (!$Page->create_at->ReadOnly && !$Page->create_at->Disabled && !isset($Page->create_at->EditAttrs["readonly"]) && !isset($Page->create_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendataanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendataanadd", "x_create_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <div id="r_updated_at" class="form-group row">
        <label id="elh_pendataan_updated_at" for="x_updated_at" class="<?= $Page->LeftColumnClass ?>"><?= $Page->updated_at->caption() ?><?= $Page->updated_at->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_pendataan_updated_at">
<input type="<?= $Page->updated_at->getInputTextType() ?>" data-table="pendataan" data-field="x_updated_at" name="x_updated_at" id="x_updated_at" placeholder="<?= HtmlEncode($Page->updated_at->getPlaceHolder()) ?>" value="<?= $Page->updated_at->EditValue ?>"<?= $Page->updated_at->editAttributes() ?> aria-describedby="x_updated_at_help">
<?= $Page->updated_at->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->updated_at->getErrorMessage() ?></div>
<?php if (!$Page->updated_at->ReadOnly && !$Page->updated_at->Disabled && !isset($Page->updated_at->EditAttrs["readonly"]) && !isset($Page->updated_at->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpendataanadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpendataanadd", "x_updated_at", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
    <div id="r_luas_lahan" class="form-group row">
        <label id="elh_pendataan_luas_lahan" for="x_luas_lahan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->luas_lahan->caption() ?><?= $Page->luas_lahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el_pendataan_luas_lahan">
<input type="<?= $Page->luas_lahan->getInputTextType() ?>" data-table="pendataan" data-field="x_luas_lahan" name="x_luas_lahan" id="x_luas_lahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->luas_lahan->getPlaceHolder()) ?>" value="<?= $Page->luas_lahan->EditValue ?>"<?= $Page->luas_lahan->editAttributes() ?> aria-describedby="x_luas_lahan_help">
<?= $Page->luas_lahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->luas_lahan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <div id="r_nilai_sewa" class="form-group row">
        <label id="elh_pendataan_nilai_sewa" for="x_nilai_sewa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai_sewa->caption() ?><?= $Page->nilai_sewa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el_pendataan_nilai_sewa">
<input type="<?= $Page->nilai_sewa->getInputTextType() ?>" data-table="pendataan" data-field="x_nilai_sewa" name="x_nilai_sewa" id="x_nilai_sewa" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nilai_sewa->getPlaceHolder()) ?>" value="<?= $Page->nilai_sewa->EditValue ?>"<?= $Page->nilai_sewa->editAttributes() ?> aria-describedby="x_nilai_sewa_help">
<?= $Page->nilai_sewa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_sewa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->legalitas->Visible) { // legalitas ?>
    <div id="r_legalitas" class="form-group row">
        <label id="elh_pendataan_legalitas" class="<?= $Page->LeftColumnClass ?>"><?= $Page->legalitas->caption() ?><?= $Page->legalitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->legalitas->cellAttributes() ?>>
<span id="el_pendataan_legalitas">
<div id="fd_x_legalitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->legalitas->title() ?>" data-table="pendataan" data-field="x_legalitas" name="x_legalitas" id="x_legalitas" lang="<?= CurrentLanguageID() ?>"<?= $Page->legalitas->editAttributes() ?><?= ($Page->legalitas->ReadOnly || $Page->legalitas->Disabled) ? " disabled" : "" ?> aria-describedby="x_legalitas_help">
        <label class="custom-file-label ew-file-label" for="x_legalitas"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->legalitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->legalitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_legalitas" id= "fn_x_legalitas" value="<?= $Page->legalitas->Upload->FileName ?>">
<input type="hidden" name="fa_x_legalitas" id= "fa_x_legalitas" value="0">
<input type="hidden" name="fs_x_legalitas" id= "fs_x_legalitas" value="128">
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
    ew.addEventHandlers("pendataan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
