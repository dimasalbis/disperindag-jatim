<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PendataanLahanEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendataan_lahanedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpendataan_lahanedit = currentForm = new ew.Form("fpendataan_lahanedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pendataan_lahan")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pendataan_lahan)
        ew.vars.tables.pendataan_lahan = currentTable;
    fpendataan_lahanedit.addFields([
        ["nama_ikm", [fields.nama_ikm.visible && fields.nama_ikm.required ? ew.Validators.required(fields.nama_ikm.caption) : null], fields.nama_ikm.isInvalid],
        ["penanggung_jawab", [fields.penanggung_jawab.visible && fields.penanggung_jawab.required ? ew.Validators.required(fields.penanggung_jawab.caption) : null], fields.penanggung_jawab.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["no_hp", [fields.no_hp.visible && fields.no_hp.required ? ew.Validators.required(fields.no_hp.caption) : null], fields.no_hp.isInvalid],
        ["produk", [fields.produk.visible && fields.produk.required ? ew.Validators.required(fields.produk.caption) : null], fields.produk.isInvalid],
        ["lokasi_lahan", [fields.lokasi_lahan.visible && fields.lokasi_lahan.required ? ew.Validators.required(fields.lokasi_lahan.caption) : null], fields.lokasi_lahan.isInvalid],
        ["luas_lahan", [fields.luas_lahan.visible && fields.luas_lahan.required ? ew.Validators.required(fields.luas_lahan.caption) : null], fields.luas_lahan.isInvalid],
        ["nilai_sewa", [fields.nilai_sewa.visible && fields.nilai_sewa.required ? ew.Validators.required(fields.nilai_sewa.caption) : null], fields.nilai_sewa.isInvalid],
        ["upload_legalitas", [fields.upload_legalitas.visible && fields.upload_legalitas.required ? ew.Validators.fileRequired(fields.upload_legalitas.caption) : null], fields.upload_legalitas.isInvalid],
        ["foto_lahan", [fields.foto_lahan.visible && fields.foto_lahan.required ? ew.Validators.fileRequired(fields.foto_lahan.caption) : null], fields.foto_lahan.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpendataan_lahanedit,
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
    fpendataan_lahanedit.validate = function () {
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
    fpendataan_lahanedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpendataan_lahanedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpendataan_lahanedit");
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
<form name="fpendataan_lahanedit" id="fpendataan_lahanedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan_lahan">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div d-none"><!-- page* -->
<?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
    <div id="r_nama_ikm" class="form-group row">
        <label id="elh_pendataan_lahan_nama_ikm" for="x_nama_ikm" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_nama_ikm"><?= $Page->nama_ikm->caption() ?><?= $Page->nama_ikm->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_ikm->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_nama_ikm"><span id="el_pendataan_lahan_nama_ikm">
<input type="<?= $Page->nama_ikm->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_nama_ikm" name="x_nama_ikm" id="x_nama_ikm" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_ikm->getPlaceHolder()) ?>" value="<?= $Page->nama_ikm->EditValue ?>"<?= $Page->nama_ikm->editAttributes() ?> aria-describedby="x_nama_ikm_help">
<?= $Page->nama_ikm->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_ikm->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
    <div id="r_penanggung_jawab" class="form-group row">
        <label id="elh_pendataan_lahan_penanggung_jawab" for="x_penanggung_jawab" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_penanggung_jawab"><?= $Page->penanggung_jawab->caption() ?><?= $Page->penanggung_jawab->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->penanggung_jawab->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_penanggung_jawab"><span id="el_pendataan_lahan_penanggung_jawab">
<input type="<?= $Page->penanggung_jawab->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_penanggung_jawab" name="x_penanggung_jawab" id="x_penanggung_jawab" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->penanggung_jawab->getPlaceHolder()) ?>" value="<?= $Page->penanggung_jawab->EditValue ?>"<?= $Page->penanggung_jawab->editAttributes() ?> aria-describedby="x_penanggung_jawab_help">
<?= $Page->penanggung_jawab->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->penanggung_jawab->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_pendataan_lahan_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_alamat"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_alamat"><span id="el_pendataan_lahan_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <div id="r_no_hp" class="form-group row">
        <label id="elh_pendataan_lahan_no_hp" for="x_no_hp" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_no_hp"><?= $Page->no_hp->caption() ?><?= $Page->no_hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_no_hp"><span id="el_pendataan_lahan_no_hp">
<input type="<?= $Page->no_hp->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_no_hp" name="x_no_hp" id="x_no_hp" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_hp->getPlaceHolder()) ?>" value="<?= $Page->no_hp->EditValue ?>"<?= $Page->no_hp->editAttributes() ?> aria-describedby="x_no_hp_help">
<?= $Page->no_hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <div id="r_produk" class="form-group row">
        <label id="elh_pendataan_lahan_produk" for="x_produk" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_produk"><?= $Page->produk->caption() ?><?= $Page->produk->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->produk->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_produk"><span id="el_pendataan_lahan_produk">
<input type="<?= $Page->produk->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_produk" name="x_produk" id="x_produk" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->produk->getPlaceHolder()) ?>" value="<?= $Page->produk->EditValue ?>"<?= $Page->produk->editAttributes() ?> aria-describedby="x_produk_help">
<?= $Page->produk->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->produk->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
    <div id="r_lokasi_lahan" class="form-group row">
        <label id="elh_pendataan_lahan_lokasi_lahan" for="x_lokasi_lahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_lokasi_lahan"><?= $Page->lokasi_lahan->caption() ?><?= $Page->lokasi_lahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lokasi_lahan->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_lokasi_lahan"><span id="el_pendataan_lahan_lokasi_lahan">
<input type="<?= $Page->lokasi_lahan->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_lokasi_lahan" name="x_lokasi_lahan" id="x_lokasi_lahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lokasi_lahan->getPlaceHolder()) ?>" value="<?= $Page->lokasi_lahan->EditValue ?>"<?= $Page->lokasi_lahan->editAttributes() ?> aria-describedby="x_lokasi_lahan_help">
<?= $Page->lokasi_lahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lokasi_lahan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
    <div id="r_luas_lahan" class="form-group row">
        <label id="elh_pendataan_lahan_luas_lahan" for="x_luas_lahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_luas_lahan"><?= $Page->luas_lahan->caption() ?><?= $Page->luas_lahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->luas_lahan->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_luas_lahan"><span id="el_pendataan_lahan_luas_lahan">
<input type="<?= $Page->luas_lahan->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_luas_lahan" name="x_luas_lahan" id="x_luas_lahan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->luas_lahan->getPlaceHolder()) ?>" value="<?= $Page->luas_lahan->EditValue ?>"<?= $Page->luas_lahan->editAttributes() ?> aria-describedby="x_luas_lahan_help">
<?= $Page->luas_lahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->luas_lahan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <div id="r_nilai_sewa" class="form-group row">
        <label id="elh_pendataan_lahan_nilai_sewa" for="x_nilai_sewa" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_nilai_sewa"><?= $Page->nilai_sewa->caption() ?><?= $Page->nilai_sewa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_sewa->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_nilai_sewa"><span id="el_pendataan_lahan_nilai_sewa">
<input type="<?= $Page->nilai_sewa->getInputTextType() ?>" data-table="pendataan_lahan" data-field="x_nilai_sewa" name="x_nilai_sewa" id="x_nilai_sewa" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nilai_sewa->getPlaceHolder()) ?>" value="<?= $Page->nilai_sewa->EditValue ?>"<?= $Page->nilai_sewa->editAttributes() ?> aria-describedby="x_nilai_sewa_help">
<?= $Page->nilai_sewa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_sewa->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->upload_legalitas->Visible) { // upload_legalitas ?>
    <div id="r_upload_legalitas" class="form-group row">
        <label id="elh_pendataan_lahan_upload_legalitas" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_upload_legalitas"><?= $Page->upload_legalitas->caption() ?><?= $Page->upload_legalitas->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->upload_legalitas->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_upload_legalitas"><span id="el_pendataan_lahan_upload_legalitas">
<div id="fd_x_upload_legalitas">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->upload_legalitas->title() ?>" data-table="pendataan_lahan" data-field="x_upload_legalitas" name="x_upload_legalitas" id="x_upload_legalitas" lang="<?= CurrentLanguageID() ?>"<?= $Page->upload_legalitas->editAttributes() ?><?= ($Page->upload_legalitas->ReadOnly || $Page->upload_legalitas->Disabled) ? " disabled" : "" ?> aria-describedby="x_upload_legalitas_help">
        <label class="custom-file-label ew-file-label" for="x_upload_legalitas"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->upload_legalitas->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->upload_legalitas->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_upload_legalitas" id= "fn_x_upload_legalitas" value="<?= $Page->upload_legalitas->Upload->FileName ?>">
<input type="hidden" name="fa_x_upload_legalitas" id= "fa_x_upload_legalitas" value="<?= (Post("fa_x_upload_legalitas") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_upload_legalitas" id= "fs_x_upload_legalitas" value="255">
<input type="hidden" name="fx_x_upload_legalitas" id= "fx_x_upload_legalitas" value="<?= $Page->upload_legalitas->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_upload_legalitas" id= "fm_x_upload_legalitas" value="<?= $Page->upload_legalitas->UploadMaxFileSize ?>">
</div>
<table id="ft_x_upload_legalitas" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
    <div id="r_foto_lahan" class="form-group row">
        <label id="elh_pendataan_lahan_foto_lahan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_foto_lahan"><?= $Page->foto_lahan->caption() ?><?= $Page->foto_lahan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto_lahan->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_foto_lahan"><span id="el_pendataan_lahan_foto_lahan">
<div id="fd_x_foto_lahan">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto_lahan->title() ?>" data-table="pendataan_lahan" data-field="x_foto_lahan" name="x_foto_lahan" id="x_foto_lahan" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto_lahan->editAttributes() ?><?= ($Page->foto_lahan->ReadOnly || $Page->foto_lahan->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_lahan_help">
        <label class="custom-file-label ew-file-label" for="x_foto_lahan"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto_lahan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto_lahan->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto_lahan" id= "fn_x_foto_lahan" value="<?= $Page->foto_lahan->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto_lahan" id= "fa_x_foto_lahan" value="<?= (Post("fa_x_foto_lahan") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_foto_lahan" id= "fs_x_foto_lahan" value="255">
<input type="hidden" name="fx_x_foto_lahan" id= "fx_x_foto_lahan" value="<?= $Page->foto_lahan->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto_lahan" id= "fm_x_foto_lahan" value="<?= $Page->foto_lahan->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto_lahan" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span></template>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_pendataan_lahan_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><template id="tpc_pendataan_lahan_keterangan"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></template></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<template id="tpx_pendataan_lahan_keterangan"><span id="el_pendataan_lahan_keterangan">
<textarea data-table="pendataan_lahan" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span></template>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="pendataan_lahan" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
<div id="tpd_pendataan_lahanedit" class="ew-custom-template"></div>
<template id="tpm_pendataan_lahanedit">
<div id="ct_PendataanLahanEdit"><?php require_once('pendataan-lahan.php'); ?>
</div>
</template>
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
<script class="ew-apply-template">
loadjs.ready(["jsrender", "makerjs"], function() {
    ew.templateData = { rows: <?= JsonEncode($Page->Rows) ?> };
    ew.applyTemplate("tpd_pendataan_lahanedit", "tpm_pendataan_lahanedit", "pendataan_lahanedit", "<?= $Page->CustomExport ?>", ew.templateData.rows[0]);
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
    ew.addEventHandlers("pendataan_lahan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
