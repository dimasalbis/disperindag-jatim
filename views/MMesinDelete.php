<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$MMesinDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fm_mesindelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fm_mesindelete = currentForm = new ew.Form("fm_mesindelete", "delete");
    loadjs.done("fm_mesindelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.m_mesin) ew.vars.tables.m_mesin = <?= JsonEncode(GetClientVar("tables", "m_mesin")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fm_mesindelete" id="fm_mesindelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="m_mesin">
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
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <th class="<?= $Page->gambar_mesin->headerCellClass() ?>"><span id="elh_m_mesin_gambar_mesin" class="m_mesin_gambar_mesin"><?= $Page->gambar_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <th class="<?= $Page->nama_mesin->headerCellClass() ?>"><span id="elh_m_mesin_nama_mesin" class="m_mesin_nama_mesin"><?= $Page->nama_mesin->caption() ?></span></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th class="<?= $Page->jumlah->headerCellClass() ?>"><span id="elh_m_mesin_jumlah" class="m_mesin_jumlah"><?= $Page->jumlah->caption() ?></span></th>
<?php } ?>
<?php if ($Page->dalam_penyewaan->Visible) { // dalam_penyewaan ?>
        <th class="<?= $Page->dalam_penyewaan->headerCellClass() ?>"><span id="elh_m_mesin_dalam_penyewaan" class="m_mesin_dalam_penyewaan"><?= $Page->dalam_penyewaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->sisa_barang->Visible) { // sisa_barang ?>
        <th class="<?= $Page->sisa_barang->headerCellClass() ?>"><span id="elh_m_mesin_sisa_barang" class="m_mesin_sisa_barang"><?= $Page->sisa_barang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_m_mesin_keterangan" class="m_mesin_keterangan"><?= $Page->keterangan->caption() ?></span></th>
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
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <td <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_gambar_mesin" class="m_mesin_gambar_mesin">
<span>
<?= GetFileViewTag($Page->gambar_mesin, $Page->gambar_mesin->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <td <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_nama_mesin" class="m_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_jumlah" class="m_mesin_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->dalam_penyewaan->Visible) { // dalam_penyewaan ?>
        <td <?= $Page->dalam_penyewaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_dalam_penyewaan" class="m_mesin_dalam_penyewaan">
<span<?= $Page->dalam_penyewaan->viewAttributes() ?>>
<?= $Page->dalam_penyewaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->sisa_barang->Visible) { // sisa_barang ?>
        <td <?= $Page->sisa_barang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_sisa_barang" class="m_mesin_sisa_barang">
<span<?= $Page->sisa_barang->viewAttributes() ?>>
<?= $Page->sisa_barang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_m_mesin_keterangan" class="m_mesin_keterangan">
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
