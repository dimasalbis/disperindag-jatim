<?php

namespace PHPMaker2021\project1;

// Page object
$MesinView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fmesinview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fmesinview = currentForm = new ew.Form("fmesinview", "view");
    loadjs.done("fmesinview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.mesin) ew.vars.tables.mesin = <?= JsonEncode(GetClientVar("tables", "mesin")) ?>;
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
<form name="fmesinview" id="fmesinview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mesin">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_mesin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <tr id="r_nama_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></td>
        <td data-name="nama_mesin" <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_seri->Visible) { // no_seri ?>
    <tr id="r_no_seri">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_no_seri"><?= $Page->no_seri->caption() ?></span></td>
        <td data-name="no_seri" <?= $Page->no_seri->cellAttributes() ?>>
<span id="el_mesin_no_seri">
<span<?= $Page->no_seri->viewAttributes() ?>>
<?= $Page->no_seri->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
    <tr id="r_nama_penyewa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_nama_penyewa"><?= $Page->nama_penyewa->caption() ?></span></td>
        <td data-name="nama_penyewa" <?= $Page->nama_penyewa->cellAttributes() ?>>
<span id="el_mesin_nama_penyewa">
<span<?= $Page->nama_penyewa->viewAttributes() ?>>
<?= $Page->nama_penyewa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
    <tr id="r_no_hp">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_no_hp"><?= $Page->no_hp->caption() ?></span></td>
        <td data-name="no_hp" <?= $Page->no_hp->cellAttributes() ?>>
<span id="el_mesin_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
    <tr id="r_nilai_sewa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></td>
        <td data-name="nilai_sewa" <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el_mesin_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_mesin_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_mesin_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
    <tr id="r_tanggal_sewa">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_tanggal_sewa"><?= $Page->tanggal_sewa->caption() ?></span></td>
        <td data-name="tanggal_sewa" <?= $Page->tanggal_sewa->cellAttributes() ?>>
<span id="el_mesin_tanggal_sewa">
<span<?= $Page->tanggal_sewa->viewAttributes() ?>>
<?= $Page->tanggal_sewa->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
    <tr id="r_tanggal_kembali">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_tanggal_kembali"><?= $Page->tanggal_kembali->caption() ?></span></td>
        <td data-name="tanggal_kembali" <?= $Page->tanggal_kembali->cellAttributes() ?>>
<span id="el_mesin_tanggal_kembali">
<span<?= $Page->tanggal_kembali->viewAttributes() ?>>
<?= $Page->tanggal_kembali->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
    <tr id="r_foto">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_foto"><?= $Page->foto->caption() ?></span></td>
        <td data-name="foto" <?= $Page->foto->cellAttributes() ?>>
<span id="el_mesin_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= $Page->foto->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
    <tr id="r_gambar_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_gambar_mesin"><?= $Page->gambar_mesin->caption() ?></span></td>
        <td data-name="gambar_mesin" <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el_mesin_gambar_mesin">
<span<?= $Page->gambar_mesin->viewAttributes() ?>>
<?= $Page->gambar_mesin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_mesin_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_mesin_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
