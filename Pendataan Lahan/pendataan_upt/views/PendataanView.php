<?php

namespace PHPMaker2021\project1;

// Page object
$PendataanView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendataanview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpendataanview = currentForm = new ew.Form("fpendataanview", "view");
    loadjs.done("fpendataanview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pendataan) ew.vars.tables.pendataan = <?= JsonEncode(GetClientVar("tables", "pendataan")) ?>;
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
<form name="fpendataanview" id="fpendataanview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pendataan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pendataan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
    <tr id="r_penanggung_jawab">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_penanggung_jawab"><?= $Page->penanggung_jawab->caption() ?></span></td>
        <td data-name="penanggung_jawab" <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el_pendataan_penanggung_jawab">
<span<?= $Page->penanggung_jawab->viewAttributes() ?>>
<?= $Page->penanggung_jawab->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_pendataan_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->phone_number->Visible) { // phone_number ?>
    <tr id="r_phone_number">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_phone_number"><?= $Page->phone_number->caption() ?></span></td>
        <td data-name="phone_number" <?= $Page->phone_number->cellAttributes() ?>>
<span id="el_pendataan_phone_number">
<span<?= $Page->phone_number->viewAttributes() ?>>
<?= $Page->phone_number->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
    <tr id="r_produk">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_produk"><?= $Page->produk->caption() ?></span></td>
        <td data-name="produk" <?= $Page->produk->cellAttributes() ?>>
<span id="el_pendataan_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
    <tr id="r_lokasi_lahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_lokasi_lahan"><?= $Page->lokasi_lahan->caption() ?></span></td>
        <td data-name="lokasi_lahan" <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el_pendataan_lokasi_lahan">
<span<?= $Page->lokasi_lahan->viewAttributes() ?>>
<?= $Page->lokasi_lahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
    <tr id="r_create_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_create_at"><?= $Page->create_at->caption() ?></span></td>
        <td data-name="create_at" <?= $Page->create_at->cellAttributes() ?>>
<span id="el_pendataan_create_at">
<span<?= $Page->create_at->viewAttributes() ?>>
<?= $Page->create_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_pendataan_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
    <tr id="r_luas_lahan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_luas_lahan"><?= $Page->luas_lahan->caption() ?></span></td>
        <td data-name="luas_lahan" <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el_pendataan_luas_lahan">
<span<?= $Page->luas_lahan->viewAttributes() ?>>
<?= $Page->luas_lahan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <tr id="r_nilai_sewa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></td>
        <td data-name="nilai_sewa" <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el_pendataan_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->legalitas->Visible) { // legalitas ?>
    <tr id="r_legalitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pendataan_legalitas"><?= $Page->legalitas->caption() ?></span></td>
        <td data-name="legalitas" <?= $Page->legalitas->cellAttributes() ?>>
<span id="el_pendataan_legalitas">
<span>
<?= GetFileViewTag($Page->legalitas, $Page->legalitas->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
</table>
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
