<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PelatihanSiswaView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpelatihan_siswaview;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "view";
    fpelatihan_siswaview = currentForm = new ew.Form("fpelatihan_siswaview", "view");
    loadjs.done("fpelatihan_siswaview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<script>
if (!ew.vars.tables.pelatihan_siswa) ew.vars.tables.pelatihan_siswa = <?= JsonEncode(GetClientVar("tables", "pelatihan_siswa")) ?>;
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
<form name="fpelatihan_siswaview" id="fpelatihan_siswaview" class="form-inline ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pelatihan_siswa">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id" <?= $Page->id->cellAttributes() ?>>
<span id="el_pelatihan_siswa_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
    <tr id="r_nama">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_nama"><?= $Page->nama->caption() ?></span></td>
        <td data-name="nama" <?= $Page->nama->cellAttributes() ?>>
<span id="el_pelatihan_siswa_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->asal_sekolah->Visible) { // asal_sekolah ?>
    <tr id="r_asal_sekolah">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_asal_sekolah"><?= $Page->asal_sekolah->caption() ?></span></td>
        <td data-name="asal_sekolah" <?= $Page->asal_sekolah->cellAttributes() ?>>
<span id="el_pelatihan_siswa_asal_sekolah">
<span<?= $Page->asal_sekolah->viewAttributes() ?>>
<?= $Page->asal_sekolah->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tempat_lahir->Visible) { // tempat_lahir ?>
    <tr id="r_tempat_lahir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_tempat_lahir"><?= $Page->tempat_lahir->caption() ?></span></td>
        <td data-name="tempat_lahir" <?= $Page->tempat_lahir->cellAttributes() ?>>
<span id="el_pelatihan_siswa_tempat_lahir">
<span<?= $Page->tempat_lahir->viewAttributes() ?>>
<?= $Page->tempat_lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->tanggal_lahir->Visible) { // tanggal_lahir ?>
    <tr id="r_tanggal_lahir">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_tanggal_lahir"><?= $Page->tanggal_lahir->caption() ?></span></td>
        <td data-name="tanggal_lahir" <?= $Page->tanggal_lahir->cellAttributes() ?>>
<span id="el_pelatihan_siswa_tanggal_lahir">
<span<?= $Page->tanggal_lahir->viewAttributes() ?>>
<?= $Page->tanggal_lahir->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->jenis_kelamin->Visible) { // jenis_kelamin ?>
    <tr id="r_jenis_kelamin">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_jenis_kelamin"><?= $Page->jenis_kelamin->caption() ?></span></td>
        <td data-name="jenis_kelamin" <?= $Page->jenis_kelamin->cellAttributes() ?>>
<span id="el_pelatihan_siswa_jenis_kelamin">
<span<?= $Page->jenis_kelamin->viewAttributes() ?>>
<?= $Page->jenis_kelamin->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
    <tr id="r_no_telpon">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_no_telpon"><?= $Page->no_telpon->caption() ?></span></td>
        <td data-name="no_telpon" <?= $Page->no_telpon->cellAttributes() ?>>
<span id="el_pelatihan_siswa_no_telpon">
<span<?= $Page->no_telpon->viewAttributes() ?>>
<?= $Page->no_telpon->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_email->Visible) { // email ?>
    <tr id="r__email">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa__email"><?= $Page->_email->caption() ?></span></td>
        <td data-name="_email" <?= $Page->_email->cellAttributes() ?>>
<span id="el_pelatihan_siswa__email">
<span<?= $Page->_email->viewAttributes() ?>>
<?= $Page->_email->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->legalitas->Visible) { // legalitas ?>
    <tr id="r_legalitas">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_legalitas"><?= $Page->legalitas->caption() ?></span></td>
        <td data-name="legalitas" <?= $Page->legalitas->cellAttributes() ?>>
<span id="el_pelatihan_siswa_legalitas">
<span>
<?= GetFileViewTag($Page->legalitas, $Page->legalitas->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
    <tr id="r_created_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_created_at"><?= $Page->created_at->caption() ?></span></td>
        <td data-name="created_at" <?= $Page->created_at->cellAttributes() ?>>
<span id="el_pelatihan_siswa_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
    <tr id="r_updated_at">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_pelatihan_siswa_updated_at"><?= $Page->updated_at->caption() ?></span></td>
        <td data-name="updated_at" <?= $Page->updated_at->cellAttributes() ?>>
<span id="el_pelatihan_siswa_updated_at">
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
