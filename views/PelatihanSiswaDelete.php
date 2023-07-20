<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PelatihanSiswaDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpelatihan_siswadelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpelatihan_siswadelete = currentForm = new ew.Form("fpelatihan_siswadelete", "delete");
    loadjs.done("fpelatihan_siswadelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pelatihan_siswa) ew.vars.tables.pelatihan_siswa = <?= JsonEncode(GetClientVar("tables", "pelatihan_siswa")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpelatihan_siswadelete" id="fpelatihan_siswadelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pelatihan_siswa">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pelatihan_siswa_nama" class="pelatihan_siswa_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->asal_sekolah->Visible) { // asal_sekolah ?>
        <th class="<?= $Page->asal_sekolah->headerCellClass() ?>"><span id="elh_pelatihan_siswa_asal_sekolah" class="pelatihan_siswa_asal_sekolah"><?= $Page->asal_sekolah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tempat_lahir->Visible) { // tempat_lahir ?>
        <th class="<?= $Page->tempat_lahir->headerCellClass() ?>"><span id="elh_pelatihan_siswa_tempat_lahir" class="pelatihan_siswa_tempat_lahir"><?= $Page->tempat_lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_lahir->Visible) { // tanggal_lahir ?>
        <th class="<?= $Page->tanggal_lahir->headerCellClass() ?>"><span id="elh_pelatihan_siswa_tanggal_lahir" class="pelatihan_siswa_tanggal_lahir"><?= $Page->tanggal_lahir->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jenis_kelamin->Visible) { // jenis_kelamin ?>
        <th class="<?= $Page->jenis_kelamin->headerCellClass() ?>"><span id="elh_pelatihan_siswa_jenis_kelamin" class="pelatihan_siswa_jenis_kelamin"><?= $Page->jenis_kelamin->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pelatihan_siswa_nama" class="pelatihan_siswa_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->asal_sekolah->Visible) { // asal_sekolah ?>
        <td <?= $Page->asal_sekolah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pelatihan_siswa_asal_sekolah" class="pelatihan_siswa_asal_sekolah">
<span<?= $Page->asal_sekolah->viewAttributes() ?>>
<?= $Page->asal_sekolah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tempat_lahir->Visible) { // tempat_lahir ?>
        <td <?= $Page->tempat_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pelatihan_siswa_tempat_lahir" class="pelatihan_siswa_tempat_lahir">
<span<?= $Page->tempat_lahir->viewAttributes() ?>>
<?= $Page->tempat_lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_lahir->Visible) { // tanggal_lahir ?>
        <td <?= $Page->tanggal_lahir->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pelatihan_siswa_tanggal_lahir" class="pelatihan_siswa_tanggal_lahir">
<span<?= $Page->tanggal_lahir->viewAttributes() ?>>
<?= $Page->tanggal_lahir->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jenis_kelamin->Visible) { // jenis_kelamin ?>
        <td <?= $Page->jenis_kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pelatihan_siswa_jenis_kelamin" class="pelatihan_siswa_jenis_kelamin">
<span<?= $Page->jenis_kelamin->viewAttributes() ?>>
<?= $Page->jenis_kelamin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
