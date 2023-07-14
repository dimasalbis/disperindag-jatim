<?php

namespace PHPMaker2021\project1;

// Page object
$PendataanDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpendataandelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpendataandelete = currentForm = new ew.Form("fpendataandelete", "delete");
    loadjs.done("fpendataandelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pendataan) ew.vars.tables.pendataan = <?= JsonEncode(GetClientVar("tables", "pendataan")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpendataandelete" id="fpendataandelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan">
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
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_pendataan_id" class="pendataan_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <th class="<?= $Page->nama->headerCellClass() ?>"><span id="elh_pendataan_nama" class="pendataan_nama"><?= $Page->nama->caption() ?></span></th>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <th class="<?= $Page->penanggung_jawab->headerCellClass() ?>"><span id="elh_pendataan_penanggung_jawab" class="pendataan_penanggung_jawab"><?= $Page->penanggung_jawab->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_pendataan_alamat" class="pendataan_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->phone_number->Visible) { // phone_number ?>
        <th class="<?= $Page->phone_number->headerCellClass() ?>"><span id="elh_pendataan_phone_number" class="pendataan_phone_number"><?= $Page->phone_number->caption() ?></span></th>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
        <th class="<?= $Page->produk->headerCellClass() ?>"><span id="elh_pendataan_produk" class="pendataan_produk"><?= $Page->produk->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <th class="<?= $Page->lokasi_lahan->headerCellClass() ?>"><span id="elh_pendataan_lokasi_lahan" class="pendataan_lokasi_lahan"><?= $Page->lokasi_lahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
        <th class="<?= $Page->create_at->headerCellClass() ?>"><span id="elh_pendataan_create_at" class="pendataan_create_at"><?= $Page->create_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_pendataan_updated_at" class="pendataan_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <th class="<?= $Page->luas_lahan->headerCellClass() ?>"><span id="elh_pendataan_luas_lahan" class="pendataan_luas_lahan"><?= $Page->luas_lahan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <th class="<?= $Page->nilai_sewa->headerCellClass() ?>"><span id="elh_pendataan_nilai_sewa" class="pendataan_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></th>
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
<?php if ($Page->id->Visible) { // id ?>
        <td <?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_id" class="pendataan_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama->Visible) { // nama ?>
        <td <?= $Page->nama->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_nama" class="pendataan_nama">
<span<?= $Page->nama->viewAttributes() ?>>
<?= $Page->nama->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <td <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_penanggung_jawab" class="pendataan_penanggung_jawab">
<span<?= $Page->penanggung_jawab->viewAttributes() ?>>
<?= $Page->penanggung_jawab->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_alamat" class="pendataan_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->phone_number->Visible) { // phone_number ?>
        <td <?= $Page->phone_number->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_phone_number" class="pendataan_phone_number">
<span<?= $Page->phone_number->viewAttributes() ?>>
<?= $Page->phone_number->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
        <td <?= $Page->produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_produk" class="pendataan_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <td <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lokasi_lahan" class="pendataan_lokasi_lahan">
<span<?= $Page->lokasi_lahan->viewAttributes() ?>>
<?= $Page->lokasi_lahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->create_at->Visible) { // create_at ?>
        <td <?= $Page->create_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_create_at" class="pendataan_create_at">
<span<?= $Page->create_at->viewAttributes() ?>>
<?= $Page->create_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_updated_at" class="pendataan_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <td <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_luas_lahan" class="pendataan_luas_lahan">
<span<?= $Page->luas_lahan->viewAttributes() ?>>
<?= $Page->luas_lahan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <td <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_nilai_sewa" class="pendataan_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
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
