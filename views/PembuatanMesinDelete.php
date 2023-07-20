<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PembuatanMesinDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fpembuatan_mesindelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fpembuatan_mesindelete = currentForm = new ew.Form("fpembuatan_mesindelete", "delete");
    loadjs.done("fpembuatan_mesindelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.pembuatan_mesin) ew.vars.tables.pembuatan_mesin = <?= JsonEncode(GetClientVar("tables", "pembuatan_mesin")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fpembuatan_mesindelete" id="fpembuatan_mesindelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembuatan_mesin">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_pembuatan_mesin_id" class="pembuatan_mesin_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <th class="<?= $Page->nama_mesin->headerCellClass() ?>"><span id="elh_pembuatan_mesin_nama_mesin" class="pembuatan_mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
        <th class="<?= $Page->spesifikasi->headerCellClass() ?>"><span id="elh_pembuatan_mesin_spesifikasi" class="pembuatan_mesin_spesifikasi"><?= $Page->spesifikasi->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_pembuatan_mesin_jumlah" class="pembuatan_mesin_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
        <th class="<?= $Page->lama_pembuatan->headerCellClass() ?>"><span id="elh_pembuatan_mesin_lama_pembuatan" class="pembuatan_mesin_lama_pembuatan"><?= $Page->lama_pembuatan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->pemesan->Visible) { // pemesan ?>
        <th class="<?= $Page->pemesan->headerCellClass() ?>"><span id="elh_pembuatan_mesin_pemesan" class="pembuatan_mesin_pemesan"><?= $Page->pemesan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_pembuatan_mesin_alamat" class="pembuatan_mesin_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
        <th class="<?= $Page->tanggal_kontrak->headerCellClass() ?>"><span id="elh_pembuatan_mesin_tanggal_kontrak" class="pembuatan_mesin_tanggal_kontrak"><?= $Page->tanggal_kontrak->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
        <th class="<?= $Page->foto_mesin->headerCellClass() ?>"><span id="elh_pembuatan_mesin_foto_mesin" class="pembuatan_mesin_foto_mesin"><?= $Page->foto_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <th class="<?= $Page->status->headerCellClass() ?>"><span id="elh_pembuatan_mesin_status" class="pembuatan_mesin_status"><?= $Page->status->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_id" class="pembuatan_mesin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <td <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_nama_mesin" class="pembuatan_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
        <td <?= $Page->spesifikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_spesifikasi" class="pembuatan_mesin_spesifikasi">
<span<?= $Page->spesifikasi->viewAttributes() ?>>
<?= $Page->spesifikasi->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_jumlah" class="pembuatan_mesin_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
        <td <?= $Page->lama_pembuatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_lama_pembuatan" class="pembuatan_mesin_lama_pembuatan">
<span<?= $Page->lama_pembuatan->viewAttributes() ?>>
<?= $Page->lama_pembuatan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->pemesan->Visible) { // pemesan ?>
        <td <?= $Page->pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_pemesan" class="pembuatan_mesin_pemesan">
<span<?= $Page->pemesan->viewAttributes() ?>>
<?= $Page->pemesan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_alamat" class="pembuatan_mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
        <td <?= $Page->tanggal_kontrak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_tanggal_kontrak" class="pembuatan_mesin_tanggal_kontrak">
<span<?= $Page->tanggal_kontrak->viewAttributes() ?>>
<?= $Page->tanggal_kontrak->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
        <td <?= $Page->foto_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_foto_mesin" class="pembuatan_mesin_foto_mesin">
<span>
<?= GetFileViewTag($Page->foto_mesin, $Page->foto_mesin->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->status->Visible) { // status ?>
        <td <?= $Page->status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_status" class="pembuatan_mesin_status">
<span<?= $Page->status->viewAttributes() ?>>
<?= $Page->status->getViewValue() ?></span>
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
