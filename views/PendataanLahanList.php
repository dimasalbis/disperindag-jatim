<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PendataanLahanList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpendataan_lahanlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpendataan_lahanlist = currentForm = new ew.Form("fpendataan_lahanlist", "list");
    fpendataan_lahanlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpendataan_lahanlist");
});
var fpendataan_lahanlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpendataan_lahanlistsrch = currentSearchForm = new ew.Form("fpendataan_lahanlistsrch");

    // Dynamic selection lists

    // Filters
    fpendataan_lahanlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpendataan_lahanlistsrch");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction) { ?>
<form name="fpendataan_lahanlistsrch" id="fpendataan_lahanlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpendataan_lahanlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pendataan_lahan">
    <div class="ew-extended-search">
<div id="xsr_<?= $Page->SearchRowCount + 1 ?>" class="ew-row d-sm-flex">
    <div class="ew-quick-search input-group">
        <input type="text" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>">
        <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
        <div class="input-group-append">
            <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
            <button type="button" data-toggle="dropdown" class="btn btn-primary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false"><span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span></button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this);"><?= $Language->phrase("QuickSearchAuto") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "=") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, '=');"><?= $Language->phrase("QuickSearchExact") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "AND") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'AND');"><?= $Language->phrase("QuickSearchAll") ?></a>
                <a class="dropdown-item<?php if ($Page->BasicSearch->getType() == "OR") { ?> active<?php } ?>" href="#" onclick="return ew.setSearchType(this, 'OR');"><?= $Language->phrase("QuickSearchAny") ?></a>
            </div>
        </div>
    </div>
</div>
    </div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pendataan_lahan">
<form name="fpendataan_lahanlist" id="fpendataan_lahanlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pendataan_lahan">
<div id="gmp_pendataan_lahan" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_pendataan_lahanlist" class="table ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
        <th data-name="nama_ikm" class="<?= $Page->nama_ikm->headerCellClass() ?>"><div id="elh_pendataan_lahan_nama_ikm" class="pendataan_lahan_nama_ikm"><?= $Page->renderSort($Page->nama_ikm) ?></div></th>
<?php } ?>
<?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <th data-name="penanggung_jawab" class="<?= $Page->penanggung_jawab->headerCellClass() ?>"><div id="elh_pendataan_lahan_penanggung_jawab" class="pendataan_lahan_penanggung_jawab"><?= $Page->renderSort($Page->penanggung_jawab) ?></div></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Page->alamat->headerCellClass() ?>"><div id="elh_pendataan_lahan_alamat" class="pendataan_lahan_alamat"><?= $Page->renderSort($Page->alamat) ?></div></th>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <th data-name="no_hp" class="<?= $Page->no_hp->headerCellClass() ?>"><div id="elh_pendataan_lahan_no_hp" class="pendataan_lahan_no_hp"><?= $Page->renderSort($Page->no_hp) ?></div></th>
<?php } ?>
<?php if ($Page->produk->Visible) { // produk ?>
        <th data-name="produk" class="<?= $Page->produk->headerCellClass() ?>"><div id="elh_pendataan_lahan_produk" class="pendataan_lahan_produk"><?= $Page->renderSort($Page->produk) ?></div></th>
<?php } ?>
<?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <th data-name="lokasi_lahan" class="<?= $Page->lokasi_lahan->headerCellClass() ?>"><div id="elh_pendataan_lahan_lokasi_lahan" class="pendataan_lahan_lokasi_lahan"><?= $Page->renderSort($Page->lokasi_lahan) ?></div></th>
<?php } ?>
<?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <th data-name="luas_lahan" class="<?= $Page->luas_lahan->headerCellClass() ?>"><div id="elh_pendataan_lahan_luas_lahan" class="pendataan_lahan_luas_lahan"><?= $Page->renderSort($Page->luas_lahan) ?></div></th>
<?php } ?>
<?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <th data-name="nilai_sewa" class="<?= $Page->nilai_sewa->headerCellClass() ?>"><div id="elh_pendataan_lahan_nilai_sewa" class="pendataan_lahan_nilai_sewa"><?= $Page->renderSort($Page->nilai_sewa) ?></div></th>
<?php } ?>
<?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
        <th data-name="foto_lahan" class="<?= $Page->foto_lahan->headerCellClass() ?>"><div id="elh_pendataan_lahan_foto_lahan" class="pendataan_lahan_foto_lahan"><?= $Page->renderSort($Page->foto_lahan) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_pendataan_lahan_keterangan" class="pendataan_lahan_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif (!$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view

        // Set up row id / data-rowindex
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_pendataan_lahan", "data-rowtype" => $Page->RowType]);

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->nama_ikm->Visible) { // nama_ikm ?>
        <td data-name="nama_ikm" <?= $Page->nama_ikm->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_nama_ikm">
<span<?= $Page->nama_ikm->viewAttributes() ?>>
<?= $Page->nama_ikm->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->penanggung_jawab->Visible) { // penanggung_jawab ?>
        <td data-name="penanggung_jawab" <?= $Page->penanggung_jawab->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_penanggung_jawab">
<span<?= $Page->penanggung_jawab->viewAttributes() ?>>
<?= $Page->penanggung_jawab->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_hp->Visible) { // no_hp ?>
        <td data-name="no_hp" <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->produk->Visible) { // produk ?>
        <td data-name="produk" <?= $Page->produk->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_produk">
<span<?= $Page->produk->viewAttributes() ?>>
<?= $Page->produk->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lokasi_lahan->Visible) { // lokasi_lahan ?>
        <td data-name="lokasi_lahan" <?= $Page->lokasi_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_lokasi_lahan">
<span<?= $Page->lokasi_lahan->viewAttributes() ?>>
<?= $Page->lokasi_lahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->luas_lahan->Visible) { // luas_lahan ?>
        <td data-name="luas_lahan" <?= $Page->luas_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_luas_lahan">
<span<?= $Page->luas_lahan->viewAttributes() ?>>
<?= $Page->luas_lahan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nilai_sewa->Visible) { // nilai_sewa ?>
        <td data-name="nilai_sewa" <?= $Page->nilai_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_nilai_sewa">
<span<?= $Page->nilai_sewa->viewAttributes() ?>>
<?= $Page->nilai_sewa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->foto_lahan->Visible) { // foto_lahan ?>
        <td data-name="foto_lahan" <?= $Page->foto_lahan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_foto_lahan">
<span>
<?= GetFileViewTag($Page->foto_lahan, $Page->foto_lahan->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pendataan_lahan_keterangan">
<span<?= $Page->keterangan->viewAttributes() ?>>
<?= $Page->keterangan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
    if (!$Page->isGridAdd()) {
        $Page->Recordset->moveNext();
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="form-inline ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("pendataan_lahan");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
