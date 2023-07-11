<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PerusahaanPenampungView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fperusahaan_penampungview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fperusahaan_penampungview = currentForm = new ew.Form("fperusahaan_penampungview", "view");
    loadjs.done("fperusahaan_penampungview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.perusahaan_penampung) ew.vars.tables.perusahaan_penampung = <?= JsonEncode(GetClientVar("tables", "perusahaan_penampung")) ?>;
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
<form name="fperusahaan_penampungview" id="fperusahaan_penampungview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perusahaan_penampung">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
    <tr id="r_nama_perusahaan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?></span></td>
        <td data-name="nama_perusahaan" <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el_perusahaan_penampung_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<?= $Page->nama_perusahaan->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
    <tr id="r_alamat">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_alamat"><?= $Page->alamat->caption() ?></span></td>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el_perusahaan_penampung_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
    <tr id="r_no_telpon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_no_telpon"><?= $Page->no_telpon->caption() ?></span></td>
        <td data-name="no_telpon" <?= $Page->no_telpon->cellAttributes() ?>>
<span id="el_perusahaan_penampung_no_telpon">
<span<?= $Page->no_telpon->viewAttributes() ?>>
<?= $Page->no_telpon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->contact_person->Visible) { // contact_person ?>
    <tr id="r_contact_person">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_contact_person"><?= $Page->contact_person->caption() ?></span></td>
        <td data-name="contact_person" <?= $Page->contact_person->cellAttributes() ?>>
<span id="el_perusahaan_penampung_contact_person">
<span<?= $Page->contact_person->viewAttributes() ?>>
<?= $Page->contact_person->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->bidang->Visible) { // bidang ?>
    <tr id="r_bidang">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_bidang"><?= $Page->bidang->caption() ?></span></td>
        <td data-name="bidang" <?= $Page->bidang->cellAttributes() ?>>
<span id="el_perusahaan_penampung_bidang">
<span<?= $Page->bidang->viewAttributes() ?>>
<?= $Page->bidang->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
    <tr id="r_keterangan">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_perusahaan_penampung_keterangan"><?= $Page->keterangan->caption() ?></span></td>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el_perusahaan_penampung_keterangan">
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
