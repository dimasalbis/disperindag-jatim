<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PenyewaanMesinList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpenyewaan_mesinlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpenyewaan_mesinlist = currentForm = new ew.Form("fpenyewaan_mesinlist", "list");
    fpenyewaan_mesinlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpenyewaan_mesinlist");
});
var fpenyewaan_mesinlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpenyewaan_mesinlistsrch = currentSearchForm = new ew.Form("fpenyewaan_mesinlistsrch");

    // Dynamic selection lists

    // Filters
    fpenyewaan_mesinlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpenyewaan_mesinlistsrch");
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
<form name="fpenyewaan_mesinlistsrch" id="fpenyewaan_mesinlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpenyewaan_mesinlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="penyewaan_mesin">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> penyewaan_mesin">
<form name="fpenyewaan_mesinlist" id="fpenyewaan_mesinlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="penyewaan_mesin">
<div id="gmp_penyewaan_mesin" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_penyewaan_mesinlist" class="table ew-table"><!-- .ew-table -->
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
<?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <th data-name="nama_mesin" class="<?= $Page->nama_mesin->headerCellClass() ?>"><div id="elh_penyewaan_mesin_nama_mesin" class="penyewaan_mesin_nama_mesin"><?= $Page->renderSort($Page->nama_mesin) ?></div></th>
<?php } ?>
<?php if ($Page->no_seri->Visible) { // no_seri ?>
        <th data-name="no_seri" class="<?= $Page->no_seri->headerCellClass() ?>"><div id="elh_penyewaan_mesin_no_seri" class="penyewaan_mesin_no_seri"><?= $Page->renderSort($Page->no_seri) ?></div></th>
<?php } ?>
<?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
        <th data-name="nama_penyewa" class="<?= $Page->nama_penyewa->headerCellClass() ?>"><div id="elh_penyewaan_mesin_nama_penyewa" class="penyewaan_mesin_nama_penyewa"><?= $Page->renderSort($Page->nama_penyewa) ?></div></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Page->alamat->headerCellClass() ?>"><div id="elh_penyewaan_mesin_alamat" class="penyewaan_mesin_alamat"><?= $Page->renderSort($Page->alamat) ?></div></th>
<?php } ?>
<?php if ($Page->no_hp->Visible) { // no_hp ?>
        <th data-name="no_hp" class="<?= $Page->no_hp->headerCellClass() ?>"><div id="elh_penyewaan_mesin_no_hp" class="penyewaan_mesin_no_hp"><?= $Page->renderSort($Page->no_hp) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
        <th data-name="tanggal_sewa" class="<?= $Page->tanggal_sewa->headerCellClass() ?>"><div id="elh_penyewaan_mesin_tanggal_sewa" class="penyewaan_mesin_tanggal_sewa"><?= $Page->renderSort($Page->tanggal_sewa) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
        <th data-name="tanggal_kembali" class="<?= $Page->tanggal_kembali->headerCellClass() ?>"><div id="elh_penyewaan_mesin_tanggal_kembali" class="penyewaan_mesin_tanggal_kembali"><?= $Page->renderSort($Page->tanggal_kembali) ?></div></th>
<?php } ?>
<?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <th data-name="gambar_mesin" class="<?= $Page->gambar_mesin->headerCellClass() ?>"><div id="elh_penyewaan_mesin_gambar_mesin" class="penyewaan_mesin_gambar_mesin"><?= $Page->renderSort($Page->gambar_mesin) ?></div></th>
<?php } ?>
<?php if ($Page->keterangan->Visible) { // keterangan ?>
        <th data-name="keterangan" class="<?= $Page->keterangan->headerCellClass() ?>"><div id="elh_penyewaan_mesin_keterangan" class="penyewaan_mesin_keterangan"><?= $Page->renderSort($Page->keterangan) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_penyewaan_mesin", "data-rowtype" => $Page->RowType]);

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
    <?php if ($Page->nama_mesin->Visible) { // nama_mesin ?>
        <td data-name="nama_mesin" <?= $Page->nama_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_seri->Visible) { // no_seri ?>
        <td data-name="no_seri" <?= $Page->no_seri->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_no_seri">
<span<?= $Page->no_seri->viewAttributes() ?>>
<?= $Page->no_seri->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->nama_penyewa->Visible) { // nama_penyewa ?>
        <td data-name="nama_penyewa" <?= $Page->nama_penyewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_nama_penyewa">
<span<?= $Page->nama_penyewa->viewAttributes() ?>>
<?= $Page->nama_penyewa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->no_hp->Visible) { // no_hp ?>
        <td data-name="no_hp" <?= $Page->no_hp->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_no_hp">
<span<?= $Page->no_hp->viewAttributes() ?>>
<?= $Page->no_hp->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_sewa->Visible) { // tanggal_sewa ?>
        <td data-name="tanggal_sewa" <?= $Page->tanggal_sewa->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_tanggal_sewa">
<span<?= $Page->tanggal_sewa->viewAttributes() ?>>
<?= $Page->tanggal_sewa->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_kembali->Visible) { // tanggal_kembali ?>
        <td data-name="tanggal_kembali" <?= $Page->tanggal_kembali->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_tanggal_kembali">
<span<?= $Page->tanggal_kembali->viewAttributes() ?>>
<?= $Page->tanggal_kembali->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->gambar_mesin->Visible) { // gambar_mesin ?>
        <td data-name="gambar_mesin" <?= $Page->gambar_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_gambar_mesin">
<span>
<?= GetFileViewTag($Page->gambar_mesin, $Page->gambar_mesin->getViewValue(), false) ?>
</span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->keterangan->Visible) { // keterangan ?>
        <td data-name="keterangan" <?= $Page->keterangan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_penyewaan_mesin_keterangan">
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
    ew.addEventHandlers("penyewaan_mesin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
