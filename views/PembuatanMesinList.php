<?php

namespace PHPMaker2021\buat_mesin;

// Page object
$PembuatanMesinList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentForm, currentPageID;
var fpembuatan_mesinlist;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object
    currentPageID = ew.PAGE_ID = "list";
    fpembuatan_mesinlist = currentForm = new ew.Form("fpembuatan_mesinlist", "list");
    fpembuatan_mesinlist.formKeyCountName = '<?= $Page->FormKeyCountName ?>';
    loadjs.done("fpembuatan_mesinlist");
});
var fpembuatan_mesinlistsrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready("head", function () {
    var $ = jQuery;
    // Form object for search
    fpembuatan_mesinlistsrch = currentSearchForm = new ew.Form("fpembuatan_mesinlistsrch");

    // Dynamic selection lists

    // Filters
    fpembuatan_mesinlistsrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fpembuatan_mesinlistsrch");
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
<form name="fpembuatan_mesinlistsrch" id="fpembuatan_mesinlistsrch" class="form-inline ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fpembuatan_mesinlistsrch-search-panel" class="<?= $Page->SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="pembuatan_mesin">
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> pembuatan_mesin">
<form name="fpembuatan_mesinlist" id="fpembuatan_mesinlist" class="form-inline ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="pembuatan_mesin">
<div id="gmp_pembuatan_mesin" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_pembuatan_mesinlist" class="table ew-table"><!-- .ew-table -->
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
        <th data-name="nama_mesin" class="<?= $Page->nama_mesin->headerCellClass() ?>"><div id="elh_pembuatan_mesin_nama_mesin" class="pembuatan_mesin_nama_mesin"><?= $Page->renderSort($Page->nama_mesin) ?></div></th>
<?php } ?>
<?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
        <th data-name="spesifikasi" class="<?= $Page->spesifikasi->headerCellClass() ?>"><div id="elh_pembuatan_mesin_spesifikasi" class="pembuatan_mesin_spesifikasi"><?= $Page->renderSort($Page->spesifikasi) ?></div></th>
<?php } ?>
<?php if ($Page->jumlah->Visible) { // jumlah ?>
        <th data-name="jumlah" class="<?= $Page->jumlah->headerCellClass() ?>"><div id="elh_pembuatan_mesin_jumlah" class="pembuatan_mesin_jumlah"><?= $Page->renderSort($Page->jumlah) ?></div></th>
<?php } ?>
<?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
        <th data-name="lama_pembuatan" class="<?= $Page->lama_pembuatan->headerCellClass() ?>"><div id="elh_pembuatan_mesin_lama_pembuatan" class="pembuatan_mesin_lama_pembuatan"><?= $Page->renderSort($Page->lama_pembuatan) ?></div></th>
<?php } ?>
<?php if ($Page->pemesan->Visible) { // pemesan ?>
        <th data-name="pemesan" class="<?= $Page->pemesan->headerCellClass() ?>"><div id="elh_pembuatan_mesin_pemesan" class="pembuatan_mesin_pemesan"><?= $Page->renderSort($Page->pemesan) ?></div></th>
<?php } ?>
<?php if ($Page->alamat->Visible) { // alamat ?>
        <th data-name="alamat" class="<?= $Page->alamat->headerCellClass() ?>"><div id="elh_pembuatan_mesin_alamat" class="pembuatan_mesin_alamat"><?= $Page->renderSort($Page->alamat) ?></div></th>
<?php } ?>
<?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
        <th data-name="tanggal_kontrak" class="<?= $Page->tanggal_kontrak->headerCellClass() ?>"><div id="elh_pembuatan_mesin_tanggal_kontrak" class="pembuatan_mesin_tanggal_kontrak"><?= $Page->renderSort($Page->tanggal_kontrak) ?></div></th>
<?php } ?>
<?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
        <th data-name="foto_mesin" class="<?= $Page->foto_mesin->headerCellClass() ?>"><div id="elh_pembuatan_mesin_foto_mesin" class="pembuatan_mesin_foto_mesin"><?= $Page->renderSort($Page->foto_mesin) ?></div></th>
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
        $Page->RowAttrs->merge(["data-rowindex" => $Page->RowCount, "id" => "r" . $Page->RowCount . "_pembuatan_mesin", "data-rowtype" => $Page->RowType]);

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
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_nama_mesin">
<span<?= $Page->nama_mesin->viewAttributes() ?>>
<?= $Page->nama_mesin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->spesifikasi->Visible) { // spesifikasi ?>
        <td data-name="spesifikasi" <?= $Page->spesifikasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_spesifikasi">
<span<?= $Page->spesifikasi->viewAttributes() ?>>
<?= $Page->spesifikasi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->jumlah->Visible) { // jumlah ?>
        <td data-name="jumlah" <?= $Page->jumlah->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_jumlah">
<span<?= $Page->jumlah->viewAttributes() ?>>
<?= $Page->jumlah->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->lama_pembuatan->Visible) { // lama_pembuatan ?>
        <td data-name="lama_pembuatan" <?= $Page->lama_pembuatan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_lama_pembuatan">
<span<?= $Page->lama_pembuatan->viewAttributes() ?>>
<?= $Page->lama_pembuatan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->pemesan->Visible) { // pemesan ?>
        <td data-name="pemesan" <?= $Page->pemesan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_pemesan">
<span<?= $Page->pemesan->viewAttributes() ?>>
<?= $Page->pemesan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->alamat->Visible) { // alamat ?>
        <td data-name="alamat" <?= $Page->alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_alamat">
<span<?= $Page->alamat->viewAttributes() ?>>
<?= $Page->alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->tanggal_kontrak->Visible) { // tanggal_kontrak ?>
        <td data-name="tanggal_kontrak" <?= $Page->tanggal_kontrak->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_tanggal_kontrak">
<span<?= $Page->tanggal_kontrak->viewAttributes() ?>>
<?= $Page->tanggal_kontrak->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->foto_mesin->Visible) { // foto_mesin ?>
        <td data-name="foto_mesin" <?= $Page->foto_mesin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_pembuatan_mesin_foto_mesin">
<span>
<?= GetFileViewTag($Page->foto_mesin, $Page->foto_mesin->getViewValue(), false) ?>
</span>
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
    ew.addEventHandlers("pembuatan_mesin");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
