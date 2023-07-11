<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MMesinView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fm_mesinview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fm_mesinview = currentForm = new ew.Form("fm_mesinview", "view");
    loadjs.done("fm_mesinview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.m_mesin) ew.vars.tables.m_mesin = <?= JsonEncode(GetClientVar("tables", "m_mesin")) ?>;
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
<form name="fm_mesinview" id="fm_mesinview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_mesin">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
    <tr id="r_gambar_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_gambar_mesin"><?= $Page->gambar_mesin->caption() ?></span></td>
        <td data-name="gambar_mesin" <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el_m_mesin_gambar_mesin">
<span>
<?= GetFileViewTag($Page->gambar_mesin, $Page->gambar_mesin->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
    <tr id="r_nama_mesin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></td>
        <td data-name="nama_mesin" <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el_m_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
    <tr id="r_jumlah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_jumlah"><?= $Page->jumlah->caption() ?></span></td>
        <td data-name="jumlah" <?= $Page->jumlah->cellAttributes() ?>>
<span id="el_m_mesin_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->dalam_penyewaan->Visible) { // dalam_penyewaan ?>
    <tr id="r_dalam_penyewaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_dalam_penyewaan"><?= $Page->dalam_penyewaan->caption() ?></span></td>
        <td data-name="dalam_penyewaan" <?= $Page->dalam_penyewaan->cellAttributes() ?>>
<span id="el_m_mesin_dalam_penyewaan">
<span<?= $Page->dalam_penyewaan->viewAttributes() ?>>
<?= $Page->dalam_penyewaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->sisa_barang->Visible) { // sisa_barang ?>
    <tr id="r_sisa_barang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_sisa_barang"><?= $Page->sisa_barang->caption() ?></span></td>
        <td data-name="sisa_barang" <?= $Page->sisa_barang->cellAttributes() ?>>
<span id="el_m_mesin_sisa_barang">
<span<?= $Page->sisa_barang->viewAttributes() ?>>
<?= $Page->sisa_barang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_m_mesin_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_m_mesin_keterangan">
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
