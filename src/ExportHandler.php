<?php

namespace PHPMaker2023\pembuatan_mesin;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use DiDom\Document;
use DiDom\Element;

/**
 * Export Handler class
 */
class ExportHandler
{
    /**
     * Export data
     * - api/export/guid
     * - api/export/search
     * - api/export/type/object
     *
     * @return bool Whether data is exported successfully
     */
    public function export(Request $request, Response $response): Response
    {
        global $Response;

        // Set up response
        $Response = $response;

        // Get parameters
        $exportType = strtolower(Get(Config("API_EXPORT_NAME"), Route(1)) ?? "");
        $table = Get(Config("API_OBJECT_NAME"), Route(2));
        $recordKey = Get(Config("API_KEY_NAME"));
        if ($table === null) {
            if (Route(1) === Config("EXPORT_LOG_SEARCH")) {
                $output = ConvertToBool(Get(Config("API_EXPORT_OUTPUT"), true)); // Output by default unless output=0
                $this->searchExportLog($output);
            } else {
                $this->writeExportFile($exportType, Get(Config("API_EXPORT_FILE_NAME")));
            }
        } else {
            $save = ConvertToBool(Get(Config("API_EXPORT_SAVE"))) && !EmptyValue(Config("EXPORT_LOG_TABLE_VAR"));
            $output = ConvertToBool(Get(Config("API_EXPORT_OUTPUT"), true)) || !$save; // Output by default unless output=0 and not save
            $this->exportData($exportType, $table, $recordKey, $output, $save);
        }
        return $Response;
    }

    // Search export log
    protected function searchExportLog($output)
    {
        global $Security, $Language;
        $Language = Container("language");
        $zipNames = [];
        $zipNames[] = Config("EXPORT_LOG_ARCHIVE_PREFIX");
        $exportLogTable = Config("EXPORT_LOG_TABLE_VAR");
        if (EmptyValue($exportLogTable)) {
            return;
        }
        $tbl = Container($exportLogTable);
        $Security->loadTablePermissions($exportLogTable);
        if (!$Security->canList()) {
            SetStatus(401);
            return;
        }
        $filter = $tbl->applyUserIDFilters("");
        // Handle export type
        $fld = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_EXPORT_TYPE")];
        $fld->AdvancedSearch->parseSearchValue(Get(Config("EXPORT_LOG_FIELD_NAME_EXPORT_TYPE_ALIAS")));
        $exportType = $fld->AdvancedSearch->SearchValue;
        if (!EmptyValue($exportType)) {
            $zipNames[] = $exportType;
            $opr = $fld->AdvancedSearch->SearchOperator ?: "=";
            $wrk = GetSearchSql($fld, $exportType, $opr, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchValue2, $fld->AdvancedSearch->SearchOperator2, Config("EXPORT_LOG_DBID"));
            AddFilter($filter, $wrk);
        }
        // Handle tablename
        $fld = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_TABLE")];
        $fld->AdvancedSearch->parseSearchValue(Get(Config("EXPORT_LOG_FIELD_NAME_TABLE_ALIAS")));
        $tableName = $fld->AdvancedSearch->SearchValue;
        if (!EmptyValue($tableName)) {
            $zipNames[] = $tableName;
            $opr = $fld->AdvancedSearch->SearchOperator ?: "LIKE";
            $wrk = GetSearchSql($fld, $tableName, $opr, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchValue2, $fld->AdvancedSearch->SearchOperator2, Config("EXPORT_LOG_DBID"));
            AddFilter($filter, $wrk);
        }
        // Handle filename
        $fld = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_FILENAME")];
        $fld->AdvancedSearch->parseSearchValue(Get(Config("EXPORT_LOG_FIELD_NAME_FILENAME_ALIAS")));
        $fileName = $fld->AdvancedSearch->SearchValue;
        if (!EmptyValue($fileName)) {
            $zipNames[] = $fileName;
            $opr = $fld->AdvancedSearch->SearchOperator ?: "LIKE";
            $wrk = GetSearchSql($fld, $fileName, $opr, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchValue2, $fld->AdvancedSearch->SearchOperator2, Config("EXPORT_LOG_DBID"));
            AddFilter($filter, $wrk);
        }
        // Handle datetime
        $fld = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_DATETIME")];
        if (!$fld->AdvancedSearch->get()) {
            $fld->AdvancedSearch->parseSearchValue(Get(Config("EXPORT_LOG_FIELD_NAME_DATETIME_ALIAS")));
        }
        $dt = $fld->AdvancedSearch->SearchValue;
        if (!CheckDate($dt)) {
            WriteJson([ "success" => false, "error" => str_replace("%s", $dt, $Language->phrase("IncorrectDate")) . ": " . Config("EXPORT_LOG_FIELD_NAME_DATETIME_ALIAS") ]);
            return;
        }
        if (!EmptyValue($dt)) {
            $dt = UnFormatDateTime($dt, 1);
            $zipNames[] = $dt;
            $opr = $fld->AdvancedSearch->SearchOperator ?: "=";
            if ($opr == "=") {
                $wrk = GetDateFilterSql($fld->Expression, $opr, $dt, $fld->DataType, Config("EXPORT_LOG_DBID"));
            } else {
                $wrk = GetSearchSql($fld, $dt, $opr, $fld->AdvancedSearch->SearchCondition, $fld->AdvancedSearch->SearchValue2, $fld->AdvancedSearch->SearchOperator2, Config("EXPORT_LOG_DBID"));
            }
            AddFilter($filter, $wrk);
        }
        // Validate limit
        $limit = Get(Config("EXPORT_LOG_LIMIT"), 0);
        if ($limit && (!is_numeric($limit) || ParseInteger($limit) <= 0)) {
            WriteJson([ "success" => false, "error" => $Language->phrase("IncorrectInteger") . ": " . Config("EXPORT_LOG_LIMIT") ]);
            return;
        }
        // Handle limit
        if ($limit) {
            $zipNames[] = $limit;
            $dateTimeField = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_DATETIME")];
            $sql = $tbl->getSqlAsQueryBuilder($filter, $dateTimeField->Expression . " DESC")->setMaxResults($limit);
            $rows = Conn($tbl->Dbid)->fetchAllAssociative($sql);
        } elseif (!EmptyValue($filter)) {
            $rows = $tbl->loadRs($filter)->fetchAllAssociative();
        } else {
            return;
        }
        $fileIds = array_map(fn($t) => $t[Config("EXPORT_LOG_FIELD_NAME_FILE_ID")], $rows);
        if ($output && count($fileIds) >= 1) {
            if (count($fileIds) == 1) { // Single file, just output
                $this->writeExportfile($fileIds[0]);
                return;
            } else { // More than one file, zip for output
                try {
                    $zip = new \ZipArchive();
                    $zipFile = ExportPath(true) . implode("_", $zipNames) . ".zip";
                    if ($zip->open($zipFile, \ZipArchive::CREATE) === true) {
                        foreach ($fileIds as $fileId) {
                            $info = $this->getExportFileByGuid($fileId);
                            if ($info) {
                                $fileName = $info[0];
                                $file = $info[1];
                                if (file_exists($file)) {
                                    $zip->addFile($file, $fileName);
                                }
                            }
                        }
                        $zip->close();
                        AddHeader("Content-type", "application/zip");
                        AddHeader("Content-Disposition", "attachment; filename=\"" . pathinfo($zipFile, PATHINFO_FILENAME) . "\"");
                        $data = file_get_contents($zipFile);
                        Write($data);
                        @unlink($zipFile);
                        return;
                    }
                } catch (\Throwable $e) {
                    if (Config("DEBUG")) {
                        throw $e;
                    }
                }
            }
        }
        WriteJson([ "success" => true, Config("EXPORT_LOG_FIELD_NAME_FILE_ID") => $fileIds ]);
    }

    // Write export file
    protected function writeExportFile($guid, $fileName = null)
    {
        $info = $this->getExportFileByGuid($guid, $fileName);
        if ($info) {
            $fileName = $info[0];
            $file = $info[1];
            if (file_exists($file) || @fopen($file, "rb") !== false) {
                $ct = MimeContentType($file);
                if ($ct) {
                    AddHeader("Content-type", $ct);
                }
                $data = "";
                $ext = pathinfo($file, PATHINFO_EXTENSION);
                if (in_array($ext, explode(",", Config("IMAGE_ALLOWED_FILE_EXT")))) { // Skip "Content-Disposition" header if images
                    $data = file_get_contents($file);
                } elseif (in_array($ext, explode(",", Config("DOWNLOAD_ALLOWED_FILE_EXT")))) {
                    AddHeader("Content-Disposition", "attachment" . ($fileName ? "; filename=\"" . $fileName . "\"" : ""));
                    $data = file_get_contents($file);
                }
                Write($data);
            }
        }
    }

    // Get export file
    protected function getExportFileByGuid($guid, $fileName = null)
    {
        global $Security;
        $exportLogTable = Config("EXPORT_LOG_TABLE_VAR");
        if (EmptyValue($exportLogTable) || !CheckGuid($guid)) {
            return null;
        }
        $tbl = Container($exportLogTable);
        $fileIdField = $tbl->Fields[Config("EXPORT_LOG_FIELD_NAME_FILE_ID")];
        $filter = $fileIdField->Expression . " = " . QuotedValue($guid, DATATYPE_GUID, Config("EXPORT_LOG_DBID"));
        $row = $tbl->loadRs($filter)->fetchAssociative();
        if ($row !== false) {
            $fileName ??= $row[Config("EXPORT_LOG_FIELD_NAME_FILENAME")]; // Get file name
            $table = $row[Config("EXPORT_LOG_FIELD_NAME_TABLE")];
            $Security->loadTablePermissions($table);
            if (!$Security->canExport()) {
                SetStatus(401);
            } else {
                $info = pathinfo($fileName);
                $ext = strtolower($info["extension"] ?? "");
                $file = ExportPath(true) . $guid . "." . $ext;
                $file = str_replace("\0", "", $file);
                return [$fileName, $file];
            }
        }
        return null;
    }

    // Export data
    protected function exportData($exportType, $table, $key, $output, $save)
    {
        global $Security, $Response, $ResponseFactory, $Language, $ExportId;

        // Set up id for temp folder
        $ExportId = Random();

        // Get table/page class
        $tbl = Container($table);
        if ($tbl === null) { // Check if valid table
            WriteJson(["success" => false, "error" => $Language->phrase("InvalidParameter") . ": table=" . $table]);
            return;
        }

        // Get record key from query string or form data
        $isList = EmptyValue($key);
        if ($tbl->TableType != "REPORT") { // Skip reports
            if ($isList) { // List/View page
                $recordKeys = $tbl->getRecordKeys();
                $recordKey = count($recordKeys) > 0
                    ? (is_array($recordKeys[0]) ? $recordKeys[0] : [$recordKeys[0]])
                    : [];
            } else { // View page
                $recordKey = explode(",", $key);
            }
        }

        // Check permission
        $Security->loadTablePermissions($table);
        if (!$Security->canExport()) {
            SetStatus(401);
            return;
        }

        // Validate export type
        if (
            $tbl->TableType == "REPORT" && !in_array($exportType, array_keys(Config("REPORT_EXPORT_CLASSES"))) ||
            !in_array($exportType, array_keys(Config("EXPORT_CLASSES")))
        ) {
            WriteJson(["success" => false, "error" => $Language->phrase("InvalidParameter") . ": type=" . $exportType]);
            return;
        }

        // Export data
        $doc = null;
        $keyValue = $isList ? "" : implode("_", $recordKey);
        $fileName = Get(Config("API_EXPORT_FILE_NAME"), $tbl->TableVar . ($isList ? "" : "_" . $keyValue));
        $pageName = $tbl->getApiPageName($isList ? Config("API_LIST_ACTION") : Config("API_VIEW_ACTION"));
        $pageClass = PROJECT_NAMESPACE . $pageName;
        $isReport = $tbl->TableType == "REPORT";
        $custom = $isReport;
        $exportClass = PROJECT_NAMESPACE . Config($isReport ? "REPORT_EXPORT_CLASSES" : "EXPORT_CLASSES")[$exportType];
        if (class_exists($pageClass) && class_exists($exportClass)) {
            $page = new $pageClass();
            $page->Export = $exportType;

            // Create export object
            $doc = new $exportClass($page);
            if (!$isReport) {
                $doc->setHorizontal($isList);
            }

            // File ID
            $fileId = "";
            $fileName = $doc->fixFileName($fileName);

            // Make sure export folder exists
            if ($save) {
                CreateFolder(ExportPath(true));
            }

            // Export charts
            $files = $this->exportCharts($tbl, $exportType);
            if (is_string($files)) {
                WriteJson(["success" => false, "error" => $files]);
                return;
            }

            // Handle custom template (post back)
            $data = Post("data");
            if (IsPost() && $data !== null) {
                $html = $this->replaceCharts(ConvertFromUtf8($data), $files, $exportType); // Data posted by fetch(), need to convert from utf-8
                $doc->loadHtml($html);
            } else {
                $page->run();
                if ($custom) { // Custom export / Report
                    if (!$page->isTerminated()) {
                        $template = ($page->View ?? $pageName) . ".php"; // View
                        $GLOBALS["Title"] ??= $page->Title; // Title
                        $page->RenderingView = true;
                        try {
                            $view = Container("view");
                            $Response = $view->render($Response, $template, $GLOBALS); // Render view with $GLOBALS
                            $html = $this->replaceCharts($page->getContents(), $files, $exportType);
                            $doc->loadHtml($html);
                            $Response = $ResponseFactory->createResponse(); // Reset
                        } finally {
                            $page->RenderingView = false;
                            $page->terminate(true); // Terminate page and clean up
                        }
                    }
                } else { // Table export
                    if ($isList) { // List page
                        // Add top/left charts
                        foreach ($files as $id => $file) {
                            $chart = $tbl->Charts[$id] ?? null;
                            if ($chart && $chart->Position <= 2) {
                                $doc->addImage($file, "after");
                            }
                        }
                        // Export
                        $page->exportData($doc);
                        // Add right/bottom charts
                        foreach ($files as $id => $file) {
                            $chart = $tbl->Charts[$id] ?? null;
                            if ($chart && $chart->Position > 2) {
                                $doc->addImage($file, "before");
                            }
                        }
                    } else { // View page
                        $page->exportData($doc, $recordKey);
                    }
                }
            }

            // Export
            $result = $doc->export($fileName, $output, $save);
            if ($exportType == "email") { // Return email result
                WriteJson($result);
            } elseif ($save) {
                // Get file ID
                $fileId = $doc->getFileId();
                // Write export log for saved file
                WriteExportLog($fileId, DbCurrentDateTime(), CurrentUser(), $exportType, $table, $keyValue, $fileName, ServerVar("REQUEST_URI"));
                // Return file ID if export file not returned
                if (!$output) {
                    WriteJson(["success" => true, "fileId" => $fileId]);
                }
            }
        } else {
            WriteJson(["success" => false, "message" => $Language->phrase("InvalidParameter") . ": table = " . $table . ", export type = " . $exportType]);
        }

        // Clean up export files
        if (Config("EXPORT_FILES_EXPIRY_TIME") > 0) {
            CleanPath(ExportPath(true), false, function ($file) {
                if (file_exists($file)) {
                    $lastmdtime = filemtime($file);
                    if ((time() - $lastmdtime) / 86400 > Config("EXPORT_FILES_EXPIRY_TIME")) {
                        unlink($file);
                        Log("export file '" . $file . "' deleted");
                    }
                }
            });
        }

        // Delete temp images
        CleanPath(UploadTempPath(), true);
    }

    // Export charts
    public function exportCharts($tbl, $exportType)
    {
        global $Language;
        $json = Post("charts", "[]");
        $charts = json_decode($json);
        $files = [];
        foreach ($charts as $chart) {
            $img = false;
            // Charts base64
            if ($chart->streamType == "base64") {
                try {
                    $img = base64_decode(preg_replace('/^data:image\/\w+;base64,/', "", $chart->stream));
                } catch (\Throwable $e) {
                    return $e->getMessage();
                }
            }
            if ($img === false) {
                return str_replace(["%t", "%e"], [$chart->streamType, $chart->chartEngine], $Language->phrase("ChartExportError1"));
            }
            // Save the file
            $filename = $chart->fileName;
            if ($filename == "") {
                return $Language->phrase("ChartExportError2");
            }
            $path = UploadTempPath();
            if (!file_exists($path)) {
                return $Language->phrase("ChartExportError3");
            }
            if (!is_writable($path)) {
                return $Language->phrase("ChartExportError4");
            }
            $filepath = IncludeTrailingDelimiter($path, true) . $filename;
            $id = preg_replace('/^chart_/', '', pathinfo($filepath, PATHINFO_FILENAME));
            $this->resizeAndSaveChart($tbl, $img, $exportType, $filepath);
            $files[$id] = $filepath;
        }

        // Return file array
        return $files;
    }

    // Resize and save chart image
    public function resizeAndSaveChart($tbl, $img, $exportType, $filepath)
    {
        $exportPdf = ($exportType == "pdf");
        $exportWord = ($exportType == "word" && Config("USE_PHPWORD"));
        $exportExcel = ($exportType == "excel" && Config("USE_PHPEXCEL"));
        $dimension = $this->chartDimension($tbl, $img, $exportType);
        if (($exportPdf || $exportWord || $exportExcel) && $dimension["width"] > 0 && $dimension["height"] > 0) {
            ResizeBinary($img, $dimension["width"], $dimension["height"], 100, [], ["keepAspectRatio" => true]); // Keep aspect ratio for chart
        }
        file_put_contents($filepath, $img);
        return true;
    }

    // Get chart export width and height
    public function chartDimension($tbl, $img, $exportType)
    {
        $portrait = SameText($tbl->ExportPageOrientation, "portrait");
        $exportPdf = ($exportType == "pdf");
        $exportWord = ($exportType == "word" && Config("USE_PHPWORD"));
        $exportExcel = ($exportType == "excel" && Config("USE_PHPEXCEL"));
        if ($exportPdf) {
            $maxWidth = $portrait ? Config("PDF_MAX_IMAGE_WIDTH") : Config("PDF_MAX_IMAGE_HEIGHT");
            $maxHeight = $portrait ? Config("PDF_MAX_IMAGE_HEIGHT") : Config("PDF_MAX_IMAGE_WIDTH");
        } elseif ($exportWord) {
            global $WORD_MAX_IMAGE_WIDTH, $WORD_MAX_IMAGE_HEIGHT;
            $maxWidth = $portrait ? $WORD_MAX_IMAGE_WIDTH : $WORD_MAX_IMAGE_HEIGHT;
            $maxHeight = $portrait ? $WORD_MAX_IMAGE_HEIGHT : $WORD_MAX_IMAGE_WIDTH;
        } elseif ($exportExcel) {
            global $EXCEL_MAX_IMAGE_WIDTH, $EXCEL_MAX_IMAGE_HEIGHT;
            $maxWidth = $portrait ? $EXCEL_MAX_IMAGE_WIDTH : $EXCEL_MAX_IMAGE_HEIGHT;
            $maxHeight = $portrait ? $EXCEL_MAX_IMAGE_HEIGHT : $EXCEL_MAX_IMAGE_WIDTH;
        }
        if ($exportPdf || $exportWord || $exportExcel) {
            $size = @getimagesizefromstring($img);
            $w = (@$size[0] > 0) ? min($size[0], $maxWidth) : $maxWidth;
            $h = (@$size[1] > 0) ? min($size[1], $maxHeight) : $maxHeight;
            return ["width" => $w, "height" => $h];
        }
        return ["width" => 0, "height" => 0];
    }

    // Replace charts in custom template
    public function replaceCharts($text, $files, $exportType)
    {
        $doc = new Document(null, false, strtoupper(Config("PROJECT_CHARSET"))); // Note: This will add <body> tag
        @$doc->load($text);
        $charts = $doc->find(".ew-chart");
        foreach ($charts as $chart) {
            $id = preg_replace('/^div_cht_/', '', $chart->getAttribute("id"));
            $file = $files[$id] ?? null;
            if ($file) {
                $div = $doc->createElement("div");
                $div->setAttribute("class", $chart->getAttribute("class")); // Copy classes, e.g. "ew-chart break-before-page"
                $img = $doc->createElement("img");
                $size = @getimagesize($file);
                $img->setAttribute("src", ImageFileToBase64Url($file));
                if (@$size[0] > 0) {
                    $img->setAttribute("width", $size[0]);
                }
                if (@$size[1] > 0) {
                    $img->setAttribute("height", $size[1]);
                }
                $div->appendChild($img);
                $chart->replace($div);
            }
        }
        return $doc->first("body")->innerHtml();
    }
}
