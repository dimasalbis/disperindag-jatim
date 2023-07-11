<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MesinDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fmesindelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fmesindelete = currentForm = new ew.Form("fmesindelete", "delete");
    loadjs.done("fmesindelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.mesin) ew.vars.tables.mesin = <?= JsonEncode(GetClientVar("tables", "mesin")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fmesindelete" id="fmesindelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="mesin">
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
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_mesin_id" class="mesin_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <th class="<?= $Page->nama_mesin->headerCellClass() ?>"><span id="elh_mesin_nama_mesin" class="mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_seri->Visible) { // no_seri ?>
        <th class="<?= $Page->no_seri->headerCellClass() ?>"><span id="elh_mesin_no_seri" class="mesin_no_seri"><?= $Page->no_seri->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
        <th class="<?= $Page->nama_penyewa->headerCellClass() ?>"><span id="elh_mesin_nama_penyewa" class="mesin_nama_penyewa"><?= $Page->nama_penyewa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_mesin_alamat" class="mesin_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <th class="<?= $Page->no_hp->headerCellClass() ?>"><span id="elh_mesin_no_hp" class="mesin_no_hp"><?= $Page->no_hp->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <th class="<?= $Page->nilai_sewa->headerCellClass() ?>"><span id="elh_mesin_nilai_sewa" class="mesin_nilai_sewa"><?= $Page->nilai_sewa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <th class="<?= $Page->created_at->headerCellClass() ?>"><span id="elh_mesin_created_at" class="mesin_created_at"><?= $Page->created_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <th class="<?= $Page->updated_at->headerCellClass() ?>"><span id="elh_mesin_updated_at" class="mesin_updated_at"><?= $Page->updated_at->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
        <th class="<?= $Page->tanggal_sewa->headerCellClass() ?>"><span id="elh_mesin_tanggal_sewa" class="mesin_tanggal_sewa"><?= $Page->tanggal_sewa->caption() ?></span></th>
<?php } ?>
<?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
        <th class="<?= $Page->tanggal_kembali->headerCellClass() ?>"><span id="elh_mesin_tanggal_kembali" class="mesin_tanggal_kembali"><?= $Page->tanggal_kembali->caption() ?></span></th>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <th class="<?= $Page->foto->headerCellClass() ?>"><span id="elh_mesin_foto" class="mesin_foto"><?= $Page->foto->caption() ?></span></th>
<?php } ?>
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <th class="<?= $Page->gambar_mesin->headerCellClass() ?>"><span id="elh_mesin_gambar_mesin" class="mesin_gambar_mesin"><?= $Page->gambar_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_mesin_keterangan" class="mesin_keterangan"><?= $Page->keterangan->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_mesin_id" class="mesin_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <td <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_nama_mesin" class="mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_seri->Visible) { // no_seri ?>
        <td <?= $Page->no_seri->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_no_seri" class="mesin_no_seri">
<span<?= $Page->no_seri->viewAttributes() ?>>
<?= $Page->no_seri->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
        <td <?= $Page->nama_penyewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_nama_penyewa" class="mesin_nama_penyewa">
<span<?= $Page->nama_penyewa->viewAttributes() ?>>
<?= $Page->nama_penyewa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_alamat" class="mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <td <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_no_hp" class="mesin_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <td <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_nilai_sewa" class="mesin_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->created_at->Visible) { // created_at ?>
        <td <?= $Page->created_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_created_at" class="mesin_created_at">
<span<?= $Page->created_at->viewAttributes() ?>>
<?= $Page->created_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->updated_at->Visible) { // updated_at ?>
        <td <?= $Page->updated_at->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_updated_at" class="mesin_updated_at">
<span<?= $Page->updated_at->viewAttributes() ?>>
<?= $Page->updated_at->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
        <td <?= $Page->tanggal_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_tanggal_sewa" class="mesin_tanggal_sewa">
<span<?= $Page->tanggal_sewa->viewAttributes() ?>>
<?= $Page->tanggal_sewa->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
        <td <?= $Page->tanggal_kembali->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_tanggal_kembali" class="mesin_tanggal_kembali">
<span<?= $Page->tanggal_kembali->viewAttributes() ?>>
<?= $Page->tanggal_kembali->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->foto->Visible) { // foto ?>
        <td <?= $Page->foto->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_foto" class="mesin_foto">
<span<?= $Page->foto->viewAttributes() ?>>
<?= $Page->foto->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <td <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_gambar_mesin" class="mesin_gambar_mesin">
<span<?= $Page->gambar_mesin->viewAttributes() ?>>
<?= $Page->gambar_mesin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_mesin_keterangan" class="mesin_keterangan">
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
