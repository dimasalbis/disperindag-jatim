<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MMesinEdit = &$Page;
?>
<script>
var currentForm, currentPageID;
var fm_mesinedit;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "edit";
    fm_mesinedit = currentForm = new ew.Form("fm_mesinedit", "edit");

    // Add fields
    var currentTable = <?= JsonEncode(GetClientVar("tables", "m_mesin")) ?>,
        fields = currentTable.fields;
    if (!ew.vars.tables.m_mesin)
        ew.vars.tables.m_mesin = currentTable;
    fm_mesinedit.addFields([
        ["gambar_mesin", [fields.gambar_mesin.visible && fields.gambar_mesin.required ? ew.Validators.fileRequired(fields.gambar_mesin.caption) : null], fields.gambar_mesin.isInvalid],
        ["nama_mesin", [fields.nama_mesin.visible && fields.nama_mesin.required ? ew.Validators.required(fields.nama_mesin.caption) : null], fields.nama_mesin.isInvalid],
        ["jumlah", [fields.jumlah.visible && fields.jumlah.required ? ew.Validators.required(fields.jumlah.caption) : null], fields.jumlah.isInvalid],
        ["dalam_penyewaan", [fields.dalam_penyewaan.visible && fields.dalam_penyewaan.required ? ew.Validators.required(fields.dalam_penyewaan.caption) : null], fields.dalam_penyewaan.isInvalid],
        ["sisa_barang", [fields.sisa_barang.visible && fields.sisa_barang.required ? ew.Validators.required(fields.sisa_barang.caption) : null], fields.sisa_barang.isInvalid],
        ["keterangan", [fields.keterangan.visible && fields.keterangan.required ? ew.Validators.required(fields.keterangan.caption) : null], fields.keterangan.isInvalid]
    ]);

    // Set invalid fields
    $(function() {
        var f = fm_mesinedit,
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
    fm_mesinedit.validate = function () {
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
    fm_mesinedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fm_mesinedit.validateRequired = <?= Config("CLIENT_VALIDATE") ? "true" : "false" ?>;

    // Dynamic selection lists
    loadjs.done("fm_mesinedit");
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
<form name="fm_mesinedit" id="fm_mesinedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_mesin">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
    <div id="r_gambar_mesin" class="form-group row">
        <label id="elh_m_mesin_gambar_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->gambar_mesin->caption() ?><?= $Page->gambar_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el_m_mesin_gambar_mesin">
<div id="fd_x_gambar_mesin">
<div class="input-group">
    <div class="custom-file">
        <input type="file" class="custom-file-input" title="<?= $Page->gambar_mesin->title() ?>" data-table="m_mesin" data-field="x_gambar_mesin" name="x_gambar_mesin" id="x_gambar_mesin" lang="<?= CurrentLanguageID() ?>"<?= $Page->gambar_mesin->editAttributes() ?><?= ($Page->gambar_mesin->ReadOnly || $Page->gambar_mesin->Disabled) ? " disabled" : "" ?> aria-describedby="x_gambar_mesin_help">
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
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <div id="r_nama_mesin" class="form-group row">
        <label id="elh_m_mesin_nama_mesin" for="x_nama_mesin" class="<?= $Page->LeftColumnClass ?>"><?= $Page->nama_mesin->caption() ?><?= $Page->nama_mesin->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_m_mesin_nama_mesin">
<input type="<?= $Page->nama_mesin->getInputTextType() ?>" data-table="m_mesin" data-field="x_nama_mesin" name="x_nama_mesin" id="x_nama_mesin" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->nama_mesin->getPlaceHolder()) ?>" value="<?= $Page->nama_mesin->EditValue ?>"<?= $Page->nama_mesin->editAttributes() ?> aria-describedby="x_nama_mesin_help">
<?= $Page->nama_mesin->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->nama_mesin->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <div id="r_jumlah" class="form-group row">
        <label id="elh_m_mesin_jumlah" for="x_jumlah" class="<?= $Page->LeftColumnClass ?>"><?= $Page->jumlah->caption() ?><?= $Page->jumlah->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_m_mesin_jumlah">
<input type="<?= $Page->jumlah->getInputTextType() ?>" data-table="m_mesin" data-field="x_jumlah" name="x_jumlah" id="x_jumlah" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->jumlah->getPlaceHolder()) ?>" value="<?= $Page->jumlah->EditValue ?>"<?= $Page->jumlah->editAttributes() ?> aria-describedby="x_jumlah_help">
<?= $Page->jumlah->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->jumlah->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->dalam_penyewaan->Visible) { // dalam_penyewaan ?>
    <div id="r_dalam_penyewaan" class="form-group row">
        <label id="elh_m_mesin_dalam_penyewaan" for="x_dalam_penyewaan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->dalam_penyewaan->caption() ?><?= $Page->dalam_penyewaan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->dalam_penyewaan->cellAttributes() ?>>
<span id="el_m_mesin_dalam_penyewaan">
<input type="<?= $Page->dalam_penyewaan->getInputTextType() ?>" data-table="m_mesin" data-field="x_dalam_penyewaan" name="x_dalam_penyewaan" id="x_dalam_penyewaan" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->dalam_penyewaan->getPlaceHolder()) ?>" value="<?= $Page->dalam_penyewaan->EditValue ?>"<?= $Page->dalam_penyewaan->editAttributes() ?> aria-describedby="x_dalam_penyewaan_help">
<?= $Page->dalam_penyewaan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->dalam_penyewaan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->sisa_barang->Visible) { // sisa_barang ?>
    <div id="r_sisa_barang" class="form-group row">
        <label id="elh_m_mesin_sisa_barang" for="x_sisa_barang" class="<?= $Page->LeftColumnClass ?>"><?= $Page->sisa_barang->caption() ?><?= $Page->sisa_barang->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->sisa_barang->cellAttributes() ?>>
<span id="el_m_mesin_sisa_barang">
<input type="<?= $Page->sisa_barang->getInputTextType() ?>" data-table="m_mesin" data-field="x_sisa_barang" name="x_sisa_barang" id="x_sisa_barang" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->sisa_barang->getPlaceHolder()) ?>" value="<?= $Page->sisa_barang->EditValue ?>"<?= $Page->sisa_barang->editAttributes() ?> aria-describedby="x_sisa_barang_help">
<?= $Page->sisa_barang->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->sisa_barang->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <div id="r_keterangan" class="form-group row">
        <label id="elh_m_mesin_keterangan" for="x_keterangan" class="<?= $Page->LeftColumnClass ?>"><?= $Page->keterangan->caption() ?><?= $Page->keterangan->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_m_mesin_keterangan">
<textarea data-table="m_mesin" data-field="x_keterangan" name="x_keterangan" id="x_keterangan" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->keterangan->getPlaceHolder()) ?>"<?= $Page->keterangan->editAttributes() ?> aria-describedby="x_keterangan_help"><?= $Page->keterangan->EditValue ?></textarea>
<?= $Page->keterangan->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->keterangan->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
    <input type="hidden" data-table="m_mesin" data-field="x_id" data-hidden="1" name="x_id" id="x_id" value="<?= HtmlEncode($Page->id->CurrentValue) ?>">
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
    ew.addEventHandlers("m_mesin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
