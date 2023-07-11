<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PerusahaanPenampungDelete = &$Page;
?>
<script>
var currentForm, currentPageID;
var fperusahaan_penampungdelete;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "delete";
    fperusahaan_penampungdelete = currentForm = new ew.Form("fperusahaan_penampungdelete", "delete");
    loadjs.done("fperusahaan_penampungdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<script>
if (!ew.vars.tables.perusahaan_penampung) ew.vars.tables.perusahaan_penampung = <?= JsonEncode(GetClientVar("tables", "perusahaan_penampung")) ?>;
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fperusahaan_penampungdelete" id="fperusahaan_penampungdelete" class="form-inline ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="perusahaan_penampung">
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
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <th class="<?= $Page->nama_perusahaan->headerCellClass() ?>"><span id="elh_perusahaan_penampung_nama_perusahaan" class="perusahaan_penampung_nama_perusahaan"><?= $Page->nama_perusahaan->caption() ?></span></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th class="<?= $Page->alamat->headerCellClass() ?>"><span id="elh_perusahaan_penampung_alamat" class="perusahaan_penampung_alamat"><?= $Page->alamat->caption() ?></span></th>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
        <th class="<?= $Page->no_telpon->headerCellClass() ?>"><span id="elh_perusahaan_penampung_no_telpon" class="perusahaan_penampung_no_telpon"><?= $Page->no_telpon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->contact_person->Visible) { // contact_person ?>
        <th class="<?= $Page->contact_person->headerCellClass() ?>"><span id="elh_perusahaan_penampung_contact_person" class="perusahaan_penampung_contact_person"><?= $Page->contact_person->caption() ?></span></th>
<?php } ?>
<?php if ($Page->bidang->Visible) { // bidang ?>
        <th class="<?= $Page->bidang->headerCellClass() ?>"><span id="elh_perusahaan_penampung_bidang" class="perusahaan_penampung_bidang"><?= $Page->bidang->caption() ?></span></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th class="<?= $Page->keterangan->headerCellClass() ?>"><span id="elh_perusahaan_penampung_keterangan" class="perusahaan_penampung_keterangan"><?= $Page->keterangan->caption() ?></span></th>
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
<?php if ($Page->nama_perusahaan->Visible) { // nama_perusahaan ?>
        <td <?= $Page->nama_perusahaan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_nama_perusahaan" class="perusahaan_penampung_nama_perusahaan">
<span<?= $Page->nama_perusahaan->viewAttributes() ?>>
<?= $Page->nama_perusahaan->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <td <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_alamat" class="perusahaan_penampung_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->no_telpon->Visible) { // no_telpon ?>
        <td <?= $Page->no_telpon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_no_telpon" class="perusahaan_penampung_no_telpon">
<span<?= $Page->no_telpon->viewAttributes() ?>>
<?= $Page->no_telpon->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->contact_person->Visible) { // contact_person ?>
        <td <?= $Page->contact_person->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_contact_person" class="perusahaan_penampung_contact_person">
<span<?= $Page->contact_person->viewAttributes() ?>>
<?= $Page->contact_person->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->bidang->Visible) { // bidang ?>
        <td <?= $Page->bidang->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_bidang" class="perusahaan_penampung_bidang">
<span<?= $Page->bidang->viewAttributes() ?>>
<?= $Page->bidang->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_perusahaan_penampung_keterangan" class="perusahaan_penampung_keterangan">
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
