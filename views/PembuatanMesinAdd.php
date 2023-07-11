<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PembuatanMesinAdd = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpembuatan_mesinadd;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "add";
    fpembuatan_mesinadd = currentForm = new ew.Form("fpembuatan_mesinadd", "add");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "pembuatan_mesin")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.pembuatan_mesin)
        ew.vars.tables.pembuatan_mesin = currentTable;
    fpembuatan_mesinadd.addFields([
        ["nama_mesin", [fields.nama_mesin.visible && fields.nama_mesin.required ? ew.Validators.required(fields.nama_mesin.caption) : null], fields.nama_mesin.isInvalid],
        ["spesifikasi", [fields.spesifikasi.visible && fields.spesifikasi.required ? ew.Validators.required(fields.spesifikasi.caption) : null], fields.spesifikasi.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null], fields.jumlah.isInvalid],
        ["lama_pembuatan", [fields.lama_pembuatan.visible && fields.lama_pembuatan.required ? ew.Validators.required(fields.lama_pembuatan.caption) : null], fields.lama_pembuatan.isInvalid],
        ["pemesan", [fields.pemesan.visible && fields.pemesan.required ? ew.Validators.required(fields.pemesan.caption) : null], fields.pemesan.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["nomor_kontrak", [fields.nomor_kontrak.visible && fields.nomor_kontrak.required ? ew.Validators.required(fields.nomor_kontrak.caption) : null], fields.nomor_kontrak.isInvalid],
        ["tanggal_kontrak", [fields.tanggal_kontrak.visible && fields.tanggal_kontrak.required ? ew.Validators.required(fields.tanggal_kontrak.caption) : null, ew.Validators.datetime(0)], fields.tanggal_kontrak.isInvalid],
        ["nilai_kontrak", [fields.nilai_kontrak.visible && fields.nilai_kontrak.required ? ew.Validators.required(fields.nilai_kontrak.caption) : null], fields.nilai_kontrak.isInvalid],
        ["upload_ktp", [fields.upload_ktp.visible && fields.upload_ktp.required ? ew.Validators.fileRequired(fields.upload_ktp.caption) : null], fields.upload_ktp.isInvalid],
        ["foto_mesin", [fields.foto_mesin.visible && fields.foto_mesin.required ? ew.Validators.fileRequired(fields.foto_mesin.caption) : null], fields.foto_mesin.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpembuatan_mesinadd,
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
    fpembuatan_mesinadd.validate = function () {
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
    fpembuatan_mesinadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpembuatan_mesinadd.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpembuatan_mesinadd");
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
<form name="fpembuatan_mesinadd" id="fpembuatan_mesinadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembuatan_mesin">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <div id="r_nama_mesin" class="form-group row">
        <label id="elh_pembuatan_mesin_nama_mesin" for="x_nama_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_mesin->caption() ?><?= $Page->nama_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nama_mesin">
<input type="<?= $Page->nama_mesin->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_nama_mesin" name="x_nama_mesin" id="x_nama_mesin" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_mesin->getPlaceHolder()) ?>" value="<?= $Page->nama_mesin->EditValue ?>"<?= $Page->nama_mesin->editAttributes() ?> aria-describedby="x_nama_mesin_help">
<?= $Page->nama_mesin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_mesin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
    <div id="r_spesifikasi" class="form-group row">
        <label id="elh_pembuatan_mesin_spesifikasi" for="x_spesifikasi" class="<?= $Page->LeftColumnClass ?>"><?= $Page->spesifikasi->caption() ?><?= $Page->spesifikasi->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->spesifikasi->cellAttributes() ?>>
<span id="el_pembuatan_mesin_spesifikasi">
<textarea data-table="pembuatan_mesin" data-field="x_spesifikasi" name="x_spesifikasi" id="x_spesifikasi" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->spesifikasi->getPlaceHolder()) ?>"<?= $Page->spesifikasi->editAttributes() ?> aria-describedby="x_spesifikasi_help"><?= $Page->spesifikasi->EditValue ?></textarea>
<?= $Page->spesifikasi->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->spesifikasi->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_pembuatan_mesin_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_pembuatan_mesin_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
    <div id="r_lama_pembuatan" class="form-group row">
        <label id="elh_pembuatan_mesin_lama_pembuatan" for="x_lama_pembuatan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->lama_pembuatan->caption() ?><?= $Page->lama_pembuatan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->lama_pembuatan->cellAttributes() ?>>
<span id="el_pembuatan_mesin_lama_pembuatan">
<input type="<?= $Page->lama_pembuatan->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_lama_pembuatan" name="x_lama_pembuatan" id="x_lama_pembuatan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->lama_pembuatan->getPlaceHolder()) ?>" value="<?= $Page->lama_pembuatan->EditValue ?>"<?= $Page->lama_pembuatan->editAttributes() ?> aria-describedby="x_lama_pembuatan_help">
<?= $Page->lama_pembuatan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->lama_pembuatan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->pemesan->Visible) { // pemesan ?>
    <div id="r_pemesan" class="form-group row">
        <label id="elh_pembuatan_mesin_pemesan" for="x_pemesan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->pemesan->caption() ?><?= $Page->pemesan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->pemesan->cellAttributes() ?>>
<span id="el_pembuatan_mesin_pemesan">
<input type="<?= $Page->pemesan->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_pemesan" name="x_pemesan" id="x_pemesan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->pemesan->getPlaceHolder()) ?>" value="<?= $Page->pemesan->EditValue ?>"<?= $Page->pemesan->editAttributes() ?> aria-describedby="x_pemesan_help">
<?= $Page->pemesan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->pemesan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_pembuatan_mesin_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pembuatan_mesin_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nomor_kontrak->Visible) { // nomor_kontrak ?>
    <div id="r_nomor_kontrak" class="form-group row">
        <label id="elh_pembuatan_mesin_nomor_kontrak" for="x_nomor_kontrak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nomor_kontrak->caption() ?><?= $Page->nomor_kontrak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nomor_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nomor_kontrak">
<input type="<?= $Page->nomor_kontrak->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_nomor_kontrak" name="x_nomor_kontrak" id="x_nomor_kontrak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nomor_kontrak->getPlaceHolder()) ?>" value="<?= $Page->nomor_kontrak->EditValue ?>"<?= $Page->nomor_kontrak->editAttributes() ?> aria-describedby="x_nomor_kontrak_help">
<?= $Page->nomor_kontrak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nomor_kontrak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
    <div id="r_tanggal_kontrak" class="form-group row">
        <label id="elh_pembuatan_mesin_tanggal_kontrak" for="x_tanggal_kontrak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_kontrak->caption() ?><?= $Page->tanggal_kontrak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_tanggal_kontrak">
<input type="<?= $Page->tanggal_kontrak->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_tanggal_kontrak" name="x_tanggal_kontrak" id="x_tanggal_kontrak" placeholder="<?= HtmlEncode($Page->tanggal_kontrak->getPlaceHolder()) ?>" value="<?= $Page->tanggal_kontrak->EditValue ?>"<?= $Page->tanggal_kontrak->editAttributes() ?> aria-describedby="x_tanggal_kontrak_help">
<?= $Page->tanggal_kontrak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_kontrak->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_kontrak->ReadOnly && !$Page->tanggal_kontrak->Disabled && !isset($Page->tanggal_kontrak->EditAttrs["readonly"]) && !isset($Page->tanggal_kontrak->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpembuatan_mesinadd", "datetimepicker"], function() {
    ew.createDateTimePicker("fpembuatan_mesinadd", "x_tanggal_kontrak", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_kontrak->Visible) { // nilai_kontrak ?>
    <div id="r_nilai_kontrak" class="form-group row">
        <label id="elh_pembuatan_mesin_nilai_kontrak" for="x_nilai_kontrak" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai_kontrak->caption() ?><?= $Page->nilai_kontrak->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nilai_kontrak">
<input type="<?= $Page->nilai_kontrak->getInputTextType() ?>" data-table="pembuatan_mesin" data-field="x_nilai_kontrak" name="x_nilai_kontrak" id="x_nilai_kontrak" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nilai_kontrak->getPlaceHolder()) ?>" value="<?= $Page->nilai_kontrak->EditValue ?>"<?= $Page->nilai_kontrak->editAttributes() ?> aria-describedby="x_nilai_kontrak_help">
<?= $Page->nilai_kontrak->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_kontrak->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->upload_ktp->Visible) { // upload_ktp ?>
    <div id="r_upload_ktp" class="form-group row">
        <label id="elh_pembuatan_mesin_upload_ktp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->upload_ktp->caption() ?><?= $Page->upload_ktp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->upload_ktp->cellAttributes() ?>>
<span id="el_pembuatan_mesin_upload_ktp">
<div id="fd_x_upload_ktp">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->upload_ktp->title() ?>" data-table="pembuatan_mesin" data-field="x_upload_ktp" name="x_upload_ktp" id="x_upload_ktp" lang="<?= CurrentLanguageID() ?>"<?= $Page->upload_ktp->editAttributes() ?><?= ($Page->upload_ktp->ReadOnly || $Page->upload_ktp->Disabled) ? " disabled" : "" ?> aria-describedby="x_upload_ktp_help">
        <label class="custom-file-label ew-file-label" for="x_upload_ktp"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->upload_ktp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->upload_ktp->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_upload_ktp" id= "fn_x_upload_ktp" value="<?= $Page->upload_ktp->Upload->FileName ?>">
<input type="hidden" name="fa_x_upload_ktp" id= "fa_x_upload_ktp" value="0">
<input type="hidden" name="fs_x_upload_ktp" id= "fs_x_upload_ktp" value="255">
<input type="hidden" name="fx_x_upload_ktp" id= "fx_x_upload_ktp" value="<?= $Page->upload_ktp->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_upload_ktp" id= "fm_x_upload_ktp" value="<?= $Page->upload_ktp->UploadMaxFileSize ?>">
</div>
<table id="ft_x_upload_ktp" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
    <div id="r_foto_mesin" class="form-group row">
        <label id="elh_pembuatan_mesin_foto_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto_mesin->caption() ?><?= $Page->foto_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto_mesin->cellAttributes() ?>>
<span id="el_pembuatan_mesin_foto_mesin">
<div id="fd_x_foto_mesin">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto_mesin->title() ?>" data-table="pembuatan_mesin" data-field="x_foto_mesin" name="x_foto_mesin" id="x_foto_mesin" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto_mesin->editAttributes() ?><?= ($Page->foto_mesin->ReadOnly || $Page->foto_mesin->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_mesin_help">
        <label class="custom-file-label ew-file-label" for="x_foto_mesin"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto_mesin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto_mesin->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto_mesin" id= "fn_x_foto_mesin" value="<?= $Page->foto_mesin->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto_mesin" id= "fa_x_foto_mesin" value="0">
<input type="hidden" name="fs_x_foto_mesin" id= "fs_x_foto_mesin" value="255">
<input type="hidden" name="fx_x_foto_mesin" id= "fx_x_foto_mesin" value="<?= $Page->foto_mesin->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto_mesin" id= "fm_x_foto_mesin" value="<?= $Page->foto_mesin->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto_mesin" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
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
    ew.addEventHandlers("pembuatan_mesin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
