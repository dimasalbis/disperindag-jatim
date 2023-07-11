<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PenyewaanMesinEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpenyewaan_mesinedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fpenyewaan_mesinedit = currentForm = new ew.Form("fpenyewaan_mesinedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "penyewaan_mesin")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.penyewaan_mesin)
        ew.vars.tables.penyewaan_mesin = currentTable;
    fpenyewaan_mesinedit.addFields([
        ["nama_mesin", [fields.nama_mesin.visible && fields.nama_mesin.required ? ew.Validators.required(fields.nama_mesin.caption) : null], fields.nama_mesin.isInvalid],
        ["no_seri", [fields.no_seri.visible && fields.no_seri.required ? ew.Validators.required(fields.no_seri.caption) : null], fields.no_seri.isInvalid],
        ["nama_penyewa", [fields.nama_penyewa.visible && fields.nama_penyewa.required ? ew.Validators.required(fields.nama_penyewa.caption) : null], fields.nama_penyewa.isInvalid],
        ["alamat", [fields.alamat.visible && fields.alamat.required ? ew.Validators.required(fields.alamat.caption) : null], fields.alamat.isInvalid],
        ["no_hp", [fields.no_hp.visible && fields.no_hp.required ? ew.Validators.required(fields.no_hp.caption) : null], fields.no_hp.isInvalid],
        ["nilai_sewa", [fields.nilai_sewa.visible && fields.nilai_sewa.required ? ew.Validators.required(fields.nilai_sewa.caption) : null], fields.nilai_sewa.isInvalid],
        ["tanggal_sewa", [fields.tanggal_sewa.visible && fields.tanggal_sewa.required ? ew.Validators.required(fields.tanggal_sewa.caption) : null, ew.Validators.datetime(0)], fields.tanggal_sewa.isInvalid],
        ["tanggal_kembali", [fields.tanggal_kembali.visible && fields.tanggal_kembali.required ? ew.Validators.required(fields.tanggal_kembali.caption) : null, ew.Validators.datetime(0)], fields.tanggal_kembali.isInvalid],
        ["foto", [fields.foto.visible && fields.foto.required ? ew.Validators.fileRequired(fields.foto.caption) : null], fields.foto.isInvalid],
        ["gambar_mesin", [fields.gambar_mesin.visible && fields.gambar_mesin.required ? ew.Validators.fileRequired(fields.gambar_mesin.caption) : null], fields.gambar_mesin.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fpenyewaan_mesinedit,
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
    fpenyewaan_mesinedit.validate = function () {
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
    fpenyewaan_mesinedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fpenyewaan_mesinedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fpenyewaan_mesinedit");
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
<form name="fpenyewaan_mesinedit" id="fpenyewaan_mesinedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penyewaan_mesin">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <div id="r_nama_mesin" class="form-group row">
        <label id="elh_penyewaan_mesin_nama_mesin" for="x_nama_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_mesin->caption() ?><?= $Page->nama_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_penyewaan_mesin_nama_mesin">
<input type="<?= $Page->nama_mesin->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_nama_mesin" name="x_nama_mesin" id="x_nama_mesin" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_mesin->getPlaceHolder()) ?>" value="<?= $Page->nama_mesin->EditValue ?>"<?= $Page->nama_mesin->editAttributes() ?> aria-describedby="x_nama_mesin_help">
<?= $Page->nama_mesin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_mesin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_seri->Visible) { // no_seri ?>
    <div id="r_no_seri" class="form-group row">
        <label id="elh_penyewaan_mesin_no_seri" for="x_no_seri" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_seri->caption() ?><?= $Page->no_seri->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_seri->cellAttributes() ?>>
<span id="el_penyewaan_mesin_no_seri">
<input type="<?= $Page->no_seri->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_no_seri" name="x_no_seri" id="x_no_seri" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_seri->getPlaceHolder()) ?>" value="<?= $Page->no_seri->EditValue ?>"<?= $Page->no_seri->editAttributes() ?> aria-describedby="x_no_seri_help">
<?= $Page->no_seri->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_seri->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
    <div id="r_nama_penyewa" class="form-group row">
        <label id="elh_penyewaan_mesin_nama_penyewa" for="x_nama_penyewa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_penyewa->caption() ?><?= $Page->nama_penyewa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_penyewa->cellAttributes() ?>>
<span id="el_penyewaan_mesin_nama_penyewa">
<input type="<?= $Page->nama_penyewa->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_nama_penyewa" name="x_nama_penyewa" id="x_nama_penyewa" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_penyewa->getPlaceHolder()) ?>" value="<?= $Page->nama_penyewa->EditValue ?>"<?= $Page->nama_penyewa->editAttributes() ?> aria-describedby="x_nama_penyewa_help">
<?= $Page->nama_penyewa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_penyewa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <div id="r_alamat" class="form-group row">
        <label id="elh_penyewaan_mesin_alamat" for="x_alamat" class="<?= $Page->LeftColumnClass ?>"><?= $Page->alamat->caption() ?><?= $Page->alamat->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->alamat->cellAttributes() ?>>
<span id="el_penyewaan_mesin_alamat">
<input type="<?= $Page->alamat->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_alamat" name="x_alamat" id="x_alamat" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->alamat->getPlaceHolder()) ?>" value="<?= $Page->alamat->EditValue ?>"<?= $Page->alamat->editAttributes() ?> aria-describedby="x_alamat_help">
<?= $Page->alamat->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->alamat->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <div id="r_no_hp" class="form-group row">
        <label id="elh_penyewaan_mesin_no_hp" for="x_no_hp" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no_hp->caption() ?><?= $Page->no_hp->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->no_hp->cellAttributes() ?>>
<span id="el_penyewaan_mesin_no_hp">
<input type="<?= $Page->no_hp->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_no_hp" name="x_no_hp" id="x_no_hp" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->no_hp->getPlaceHolder()) ?>" value="<?= $Page->no_hp->EditValue ?>"<?= $Page->no_hp->editAttributes() ?> aria-describedby="x_no_hp_help">
<?= $Page->no_hp->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no_hp->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <div id="r_nilai_sewa" class="form-group row">
        <label id="elh_penyewaan_mesin_nilai_sewa" for="x_nilai_sewa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nilai_sewa->caption() ?><?= $Page->nilai_sewa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el_penyewaan_mesin_nilai_sewa">
<input type="<?= $Page->nilai_sewa->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_nilai_sewa" name="x_nilai_sewa" id="x_nilai_sewa" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nilai_sewa->getPlaceHolder()) ?>" value="<?= $Page->nilai_sewa->EditValue ?>"<?= $Page->nilai_sewa->editAttributes() ?> aria-describedby="x_nilai_sewa_help">
<?= $Page->nilai_sewa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nilai_sewa->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
    <div id="r_tanggal_sewa" class="form-group row">
        <label id="elh_penyewaan_mesin_tanggal_sewa" for="x_tanggal_sewa" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_sewa->caption() ?><?= $Page->tanggal_sewa->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_sewa->cellAttributes() ?>>
<span id="el_penyewaan_mesin_tanggal_sewa">
<input type="<?= $Page->tanggal_sewa->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_tanggal_sewa" name="x_tanggal_sewa" id="x_tanggal_sewa" maxlength="10" placeholder="<?= HtmlEncode($Page->tanggal_sewa->getPlaceHolder()) ?>" value="<?= $Page->tanggal_sewa->EditValue ?>"<?= $Page->tanggal_sewa->editAttributes() ?> aria-describedby="x_tanggal_sewa_help">
<?= $Page->tanggal_sewa->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_sewa->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_sewa->ReadOnly && !$Page->tanggal_sewa->Disabled && !isset($Page->tanggal_sewa->EditAttrs["readonly"]) && !isset($Page->tanggal_sewa->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenyewaan_mesinedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenyewaan_mesinedit", "x_tanggal_sewa", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
    <div id="r_tanggal_kembali" class="form-group row">
        <label id="elh_penyewaan_mesin_tanggal_kembali" for="x_tanggal_kembali" class="<?= $Page->LeftColumnClass ?>"><?= $Page->tanggal_kembali->caption() ?><?= $Page->tanggal_kembali->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->tanggal_kembali->cellAttributes() ?>>
<span id="el_penyewaan_mesin_tanggal_kembali">
<input type="<?= $Page->tanggal_kembali->getInputTextType() ?>" data-table="penyewaan_mesin" data-field="x_tanggal_kembali" name="x_tanggal_kembali" id="x_tanggal_kembali" maxlength="10" placeholder="<?= HtmlEncode($Page->tanggal_kembali->getPlaceHolder()) ?>" value="<?= $Page->tanggal_kembali->EditValue ?>"<?= $Page->tanggal_kembali->editAttributes() ?> aria-describedby="x_tanggal_kembali_help">
<?= $Page->tanggal_kembali->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->tanggal_kembali->getErrorMessage() ?></div>
<?php if (!$Page->tanggal_kembali->ReadOnly && !$Page->tanggal_kembali->Disabled && !isset($Page->tanggal_kembali->EditAttrs["readonly"]) && !isset($Page->tanggal_kembali->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fpenyewaan_mesinedit", "datetimepicker"], function() {
    ew.createDateTimePicker("fpenyewaan_mesinedit", "x_tanggal_kembali", {"ignoreReadonly":true,"useCurrent":false,"format":0});
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <div id="r_foto" class="form-group row">
        <label id="elh_penyewaan_mesin_foto" class="<?= $Page->LeftColumnClass ?>"><?= $Page->foto->caption() ?><?= $Page->foto->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->foto->cellAttributes() ?>>
<span id="el_penyewaan_mesin_foto">
<div id="fd_x_foto">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->foto->title() ?>" data-table="penyewaan_mesin" data-field="x_foto" name="x_foto" id="x_foto" lang="<?= CurrentLanguageID() ?>"<?= $Page->foto->editAttributes() ?><?= ($Page->foto->ReadOnly || $Page->foto->Disabled) ? " disabled" : "" ?> aria-describedby="x_foto_help">
        <label class="custom-file-label ew-file-label" for="x_foto"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->foto->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->foto->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_foto" id= "fn_x_foto" value="<?= $Page->foto->Upload->FileName ?>">
<input type="hidden" name="fa_x_foto" id= "fa_x_foto" value="<?= (Post("fa_x_foto") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_foto" id= "fs_x_foto" value="255">
<input type="hidden" name="fx_x_foto" id= "fx_x_foto" value="<?= $Page->foto->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_foto" id= "fm_x_foto" value="<?= $Page->foto->UploadMaxFileSize ?>">
</div>
<table id="ft_x_foto" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
    <div id="r_gambar_mesin" class="form-group row">
        <label id="elh_penyewaan_mesin_gambar_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar_mesin->caption() ?><?= $Page->gambar_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el_penyewaan_mesin_gambar_mesin">
<div id="fd_x_gambar_mesin">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar_mesin->title() ?>" data-table="penyewaan_mesin" data-field="x_gambar_mesin" name="x_gambar_mesin" id="x_gambar_mesin" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar_mesin->editAttributes() ?><?= ($Page->gambar_mesin->ReadOnly || $Page->gambar_mesin->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_mesin_help">
        <label class="custom-file-label ew-file-label" for="x_gambar_mesin"><?= $Language->phrase("ChooseFile") ?></label>
    </div>
</div>
<?= $Page->gambar_mesin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->gambar_mesin->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_gambar_mesin" id= "fn_x_gambar_mesin" value="<?= $Page->gambar_mesin->Upload->FileName ?>">
<input type="hidden" name="fa_x_gambar_mesin" id= "fa_x_gambar_mesin" value="<?= (Post("fa_x_gambar_mesin") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_gambar_mesin" id= "fs_x_gambar_mesin" value="255">
<input type="hidden" name="fx_x_gambar_mesin" id= "fx_x_gambar_mesin" value="<?= $Page->gambar_mesin->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_gambar_mesin" id= "fm_x_gambar_mesin" value="<?= $Page->gambar_mesin->UploadMaxFileSize ?>">
</div>
<table id="ft_x_gambar_mesin" class="table table-sm float-left ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_penyewaan_mesin_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_penyewaan_mesin_keterangan">
<textarea data-table="penyewaan_mesin" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="penyewaan_mesin" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("penyewaan_mesin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
