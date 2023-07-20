<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PendataanLahanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendataan_lahandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpendataan_lahandelete = currentForm = new ew.Form("fpendataan_lahandelete", "delete");
    loadjs.done("fpendataan_lahandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pendataan_lahan) ew.vars.tables.pendataan_lahan = <?= JsonEncode(GetClientVar("tables", "pendataan_lahan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpendataan_lahandelete" id="fpendataan_lahandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan_lahan">
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
<?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
        <th class="<?= $Page->nama_ikm->headerCellClass() ?>"><span id="elh_pendataan_lahan_nama_ikm" class="pendataan_lahan_nama_ikm"><?= $Page->nama_ikm->caption() ?></span></th>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <th class="<?= $Page->penanggung_jawab->headerCellClass() ?>"><span id="elh_pendataan_lahan_penanggung_jawab" class="pendataan_lahan_penanggung_jawab"><?= $Page->penanggung_jawab->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_pendataan_lahan_alamat" class="pendataan_lahan_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <th class="<?= $Page->no_hp->headerCellClass() ?>"><span id="elh_pendataan_lahan_no_hp" class="pendataan_lahan_no_hp"><?= $Page->no_hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
        <th class="<?= $Page->produk->headerCellClass() ?>"><span id="elh_pendataan_lahan_produk" class="pendataan_lahan_produk"><?= $Page->produk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <th class="<?= $Page->lokasi_lahan->headerCellClass() ?>"><span id="elh_pendataan_lahan_lokasi_lahan" class="pendataan_lahan_lokasi_lahan"><?= $Page->lokasi_lahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <th class="<?= $Page->luas_lahan->headerCellClass() ?>"><span id="elh_pendataan_lahan_luas_lahan" class="pendataan_lahan_luas_lahan"><?= $Page->luas_lahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <th class="<?= $Page->nilai_sewa->headerCellClass() ?>"><span id="elh_pendataan_lahan_nilai_sewa" class="pendataan_lahan_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
        <th class="<?= $Page->foto_lahan->headerCellClass() ?>"><span id="elh_pendataan_lahan_foto_lahan" class="pendataan_lahan_foto_lahan"><?= $Page->foto_lahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_pendataan_lahan_keterangan" class="pendataan_lahan_keterangan"><?= $Page->keterangan->caption() ?></span></th>
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
<?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
        <td <?= $Page->nama_ikm->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_nama_ikm" class="pendataan_lahan_nama_ikm">
<span<?= $Page->nama_ikm->viewAttributes() ?>>
<?= $Page->nama_ikm->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <td <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_penanggung_jawab" class="pendataan_lahan_penanggung_jawab">
<span<?= $Page->penanggung_jawab->viewAttributes() ?>>
<?= $Page->penanggung_jawab->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_alamat" class="pendataan_lahan_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <td <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_no_hp" class="pendataan_lahan_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
        <td <?= $Page->produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_produk" class="pendataan_lahan_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <td <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_lokasi_lahan" class="pendataan_lahan_lokasi_lahan">
<span<?= $Page->lokasi_lahan->viewAttributes() ?>>
<?= $Page->lokasi_lahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <td <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_luas_lahan" class="pendataan_lahan_luas_lahan">
<span<?= $Page->luas_lahan->viewAttributes() ?>>
<?= $Page->luas_lahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <td <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_nilai_sewa" class="pendataan_lahan_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
        <td <?= $Page->foto_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_foto_lahan" class="pendataan_lahan_foto_lahan">
<span>
<?= GetFileViewTag($Page->foto_lahan, $Page->foto_lahan->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_keterangan" class="pendataan_lahan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
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
