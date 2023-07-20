<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PendataanLahanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendataan_lahanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpendataan_lahanview = currentForm = new ew.Form("fpendataan_lahanview", "view");
    loadjs.done("fpendataan_lahanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pendataan_lahan) ew.vars.tables.pendataan_lahan = <?= JsonEncode(GetClientVar("tables", "pendataan_lahan")) ?>;
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
<form name="fpendataan_lahanview" id="fpendataan_lahanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan_lahan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pendataan_lahan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
    <tr id="r_nama_ikm">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_nama_ikm"><?= $Page->nama_ikm->caption() ?></span></td>
        <td data-name="nama_ikm" <?= $Page->nama_ikm->cellAttributes() ?>>
<span id="el_pendataan_lahan_nama_ikm">
<span<?= $Page->nama_ikm->viewAttributes() ?>>
<?= $Page->nama_ikm->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
    <tr id="r_penanggung_jawab">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_penanggung_jawab"><?= $Page->penanggung_jawab->caption() ?></span></td>
        <td data-name="penanggung_jawab" <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el_pendataan_lahan_penanggung_jawab">
<span<?= $Page->penanggung_jawab->viewAttributes() ?>>
<?= $Page->penanggung_jawab->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pendataan_lahan_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <tr id="r_no_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_no_hp"><?= $Page->no_hp->caption() ?></span></td>
        <td data-name="no_hp" <?= $Page->no_hp->cellAttributes() ?>>
<span id="el_pendataan_lahan_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <tr id="r_produk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_produk"><?= $Page->produk->caption() ?></span></td>
        <td data-name="produk" <?= $Page->produk->cellAttributes() ?>>
<span id="el_pendataan_lahan_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
    <tr id="r_lokasi_lahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_lokasi_lahan"><?= $Page->lokasi_lahan->caption() ?></span></td>
        <td data-name="lokasi_lahan" <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el_pendataan_lahan_lokasi_lahan">
<span<?= $Page->lokasi_lahan->viewAttributes() ?>>
<?= $Page->lokasi_lahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
    <tr id="r_luas_lahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_luas_lahan"><?= $Page->luas_lahan->caption() ?></span></td>
        <td data-name="luas_lahan" <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el_pendataan_lahan_luas_lahan">
<span<?= $Page->luas_lahan->viewAttributes() ?>>
<?= $Page->luas_lahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <tr id="r_nilai_sewa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></td>
        <td data-name="nilai_sewa" <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el_pendataan_lahan_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->upload_legalitas->Visible) { // upload_legalitas ?>
    <tr id="r_upload_legalitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_upload_legalitas"><?= $Page->upload_legalitas->caption() ?></span></td>
        <td data-name="upload_legalitas" <?= $Page->upload_legalitas->cellAttributes() ?>>
<span id="el_pendataan_lahan_upload_legalitas">
<span>
<?= GetFileViewTag($Page->upload_legalitas, $Page->upload_legalitas->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
    <tr id="r_foto_lahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_foto_lahan"><?= $Page->foto_lahan->caption() ?></span></td>
        <td data-name="foto_lahan" <?= $Page->foto_lahan->cellAttributes() ?>>
<span id="el_pendataan_lahan_foto_lahan">
<span>
<?= GetFileViewTag($Page->foto_lahan, $Page->foto_lahan->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lahan_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_pendataan_lahan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
