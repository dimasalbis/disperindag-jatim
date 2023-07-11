<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PembuatanMesinView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpembuatan_mesinview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpembuatan_mesinview = currentForm = new ew.Form("fpembuatan_mesinview", "view");
    loadjs.done("fpembuatan_mesinview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pembuatan_mesin) ew.vars.tables.pembuatan_mesin = <?= JsonEncode(GetClientVar("tables", "pembuatan_mesin")) ?>;
</script>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpembuatan_mesinview" id="fpembuatan_mesinview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembuatan_mesin">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pembuatan_mesin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <tr id="r_nama_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></td>
        <td data-name="nama_mesin" <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
    <tr id="r_spesifikasi">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_spesifikasi"><?= $Page->spesifikasi->caption() ?></span></td>
        <td data-name="spesifikasi" <?= $Page->spesifikasi->cellAttributes() ?>>
<span id="el_pembuatan_mesin_spesifikasi">
<span<?= $Page->spesifikasi->viewAttributes() ?>>
<?= $Page->spesifikasi->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <tr id="r_jumlah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_jumlah"><?= $Page->jumlah->caption() ?></span></td>
        <td data-name="jumlah" <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_pembuatan_mesin_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
    <tr id="r_lama_pembuatan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_lama_pembuatan"><?= $Page->lama_pembuatan->caption() ?></span></td>
        <td data-name="lama_pembuatan" <?= $Page->lama_pembuatan->cellAttributes() ?>>
<span id="el_pembuatan_mesin_lama_pembuatan">
<span<?= $Page->lama_pembuatan->viewAttributes() ?>>
<?= $Page->lama_pembuatan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->pemesan->Visible) { // pemesan ?>
    <tr id="r_pemesan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_pemesan"><?= $Page->pemesan->caption() ?></span></td>
        <td data-name="pemesan" <?= $Page->pemesan->cellAttributes() ?>>
<span id="el_pembuatan_mesin_pemesan">
<span<?= $Page->pemesan->viewAttributes() ?>>
<?= $Page->pemesan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pembuatan_mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nomor_kontrak->Visible) { // nomor_kontrak ?>
    <tr id="r_nomor_kontrak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_nomor_kontrak"><?= $Page->nomor_kontrak->caption() ?></span></td>
        <td data-name="nomor_kontrak" <?= $Page->nomor_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nomor_kontrak">
<span<?= $Page->nomor_kontrak->viewAttributes() ?>>
<?= $Page->nomor_kontrak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
    <tr id="r_tanggal_kontrak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_tanggal_kontrak"><?= $Page->tanggal_kontrak->caption() ?></span></td>
        <td data-name="tanggal_kontrak" <?= $Page->tanggal_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_tanggal_kontrak">
<span<?= $Page->tanggal_kontrak->viewAttributes() ?>>
<?= $Page->tanggal_kontrak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_kontrak->Visible) { // nilai_kontrak ?>
    <tr id="r_nilai_kontrak">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_nilai_kontrak"><?= $Page->nilai_kontrak->caption() ?></span></td>
        <td data-name="nilai_kontrak" <?= $Page->nilai_kontrak->cellAttributes() ?>>
<span id="el_pembuatan_mesin_nilai_kontrak">
<span<?= $Page->nilai_kontrak->viewAttributes() ?>>
<?= $Page->nilai_kontrak->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->upload_ktp->Visible) { // upload_ktp ?>
    <tr id="r_upload_ktp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_upload_ktp"><?= $Page->upload_ktp->caption() ?></span></td>
        <td data-name="upload_ktp" <?= $Page->upload_ktp->cellAttributes() ?>>
<span id="el_pembuatan_mesin_upload_ktp">
<span>
<?= GetFileViewTag($Page->upload_ktp, $Page->upload_ktp->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
    <tr id="r_foto_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_foto_mesin"><?= $Page->foto_mesin->caption() ?></span></td>
        <td data-name="foto_mesin" <?= $Page->foto_mesin->cellAttributes() ?>>
<span id="el_pembuatan_mesin_foto_mesin">
<span>
<?= GetFileViewTag($Page->foto_mesin, $Page->foto_mesin->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_pembuatan_mesin_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pembuatan_mesin_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_pembuatan_mesin_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
<?php if (!$Page->IsModal) { ?>
<?php if (!$Page->isExport()) { ?>
<?= $Page->Pager->render() ?>
<div class="clearfix"></div>
<?php } ?>
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
