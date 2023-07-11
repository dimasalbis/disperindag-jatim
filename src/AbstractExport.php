<?php

namespace PHPMaker2023\pembuatan_mesin;

use DiDom\Document;
use DiDom\Element;

/**
 * Abstract class for export
 */
abstract class AbstractExport extends AbstractExportBase
{
    public static $Selectors = "table.ew-table, table.ew-export-table, div.ew-chart, *.ew-export"; // Elements to be exported
    public $Line = "";
    public $Header = "";
    public $Style = "h"; // "v"(Vertical) or "h"(Horizontal)
    public $Horizontal = true; // Horizontal
    public $ExportCustom = false;
    public $StyleSheet = ""; // Style sheet path (relative to project folder)
    public $UseInlineStyles = false; // Use inline styles for page breaks
    public $ExportImages = true; // Allow exporting images
    public $ExportPageBreaks = true; // Page breaks when export
    public $ExportStyles = true; // CSS styles when export
    protected $RowCnt = 0;
    protected $FldCnt = 0;

    // Constructor
    public function __construct($table = null)
    {
        parent::__construct($table);
        $this->StyleSheet = Config("PROJECT_STYLESHEET_FILENAME");
        $this->ExportStyles = Config("EXPORT_CSS_STYLES");
    }

    // Style
    public function setStyle($style)
    {
        $style = strtolower($style);
        if (in_array($style, ["v", "h"])) {
            $this->Style = $style;
        }
        $this->Horizontal = $this->Style != "v";
    }

    // Set horizontal
    public function setHorizontal(bool $value)
    {
        $this->Horizontal = $value;
        $this->Style = $this->Horizontal ? "h" : "v";
    }

    // Field caption
    public function exportCaption($fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $this->exportValueEx($fld, $fld->exportCaption());
    }

    // Field value
    public function exportValue($fld)
    {
        $this->exportValueEx($fld, $fld->exportValue());
    }

    // Field aggregate
    public function exportAggregate($fld, $type)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        if ($this->Horizontal) {
            global $Language;
            $val = "";
            if (in_array($type, ["TOTAL", "COUNT", "AVERAGE"])) {
                $val = $Language->phrase($type) . ": " . $fld->exportValue();
            }
            $this->exportValueEx($fld, $val);
        }
    }

    // Get meta tag for charset
    protected function charsetMetaTag()
    {
        return "<meta http-equiv=\"Content-Type\" content=\"text/html" . ((Config("PROJECT_CHARSET") != "") ? "; charset=" . Config("PROJECT_CHARSET") : "") . "\">\r\n";
    }

    // Table header
    public function exportTableHeader()
    {
        $this->Text .= "<table class=\"ew-export-table\">";
    }

    // Cell styles
    protected function cellStyles($fld)
    {
        return $this->ExportStyles ? $fld->cellStyles() : "";
    }

    // Export a value (caption, field value, or aggregate)
    protected function exportValueEx($fld, $val)
    {
        $this->Text .= "<td" . $this->cellStyles($fld) . ">" . strval($val) . "</td>";
    }

    // Begin a row
    public function beginExportRow($rowCnt = 0)
    {
        $this->RowCnt++;
        $this->FldCnt = 0;
        if ($this->Horizontal) {
            if ($rowCnt == -1) {
                $classname = "ew-export-table-footer";
            } elseif ($rowCnt == 0) {
                $classname = "ew-export-table-header";
            } else {
                $classname = (($rowCnt % 2) == 1) ? "ew-export-table-row" : "ew-export-table-alt-row";
            }
            $this->Text .= "<tr" . ($this->ExportStyles ? ' class="' . $classname . '"' : '') . ">";
        }
    }

    // End a row
    public function endExportRow($rowCnt = 0)
    {
        if ($this->Horizontal) {
            $this->Text .= "</tr>";
        }
    }

    // Empty row
    public function exportEmptyRow()
    {
        $this->RowCnt++;
        $this->Text .= "<br>";
    }

    // Page break
    public function exportPageBreak()
    {
    }

    // Export field value
    public function exportFieldValue($fld)
    {
        $exportValue = "";
        if ($fld->ExportFieldImage && $fld->ExportHrefValue != "" && is_object($fld->Upload)) { // Upload field
            // Note: Cannot show image, show empty content
            //if (!EmptyValue($fld->Upload->DbValue)) {
            //    $wrkExportValue = GetFileATag($fld, $fld->ExportHrefValue);
            //}
        } else {
            $exportValue = $fld->exportValue();
        }
        return $exportValue;
    }

    // Export a field
    public function exportField($fld)
    {
        if (!$fld->Exportable) {
            return;
        }
        $this->FldCnt++;
        $exportValue = $this->exportFieldValue($fld);
        if ($this->Horizontal) {
            $this->exportValueEx($fld, $exportValue);
        } else { // Vertical, export as a row
            $this->RowCnt++;
            $this->Text .= "<tr class=\"" . (($this->FldCnt % 2 == 1) ? "ew-export-table-row" : "ew-export-table-alt-row") . "\">" .
                "<td" . $this->cellStyles($fld) . ">" . $fld->exportCaption() . "</td>" .
                "<td" . $this->cellStyles($fld) . ">" . $exportValue . "</td></tr>";
        }
    }

    // Table Footer
    public function exportTableFooter()
    {
        $this->Text .= "</table>";
    }

    // Add HTML tags
    public function exportHeaderAndFooter()
    {
        $this->Text = "<html><head>" . $this->charsetMetaTag() .
            "<style>" . $this->styles() . "</style></head>" .
            "<body>" . $this->Text . "</body></html>";
    }

    // Get CSS rules
    public function styles()
    {
        if ($this->ExportStyles && $this->StyleSheet != "") {
            $path = __DIR__ . "/../" . $this->StyleSheet;
            if (file_exists($path)) {
                return file_get_contents($path);
            }
        }
        return "";
    }

    // Adjust page break
    protected function adjustPageBreak($doc)
    {
        // Remove empty charts
        $divs = $doc->find("div.ew-chart");
        foreach ($divs as $div) {
            $script = $div->nextSibling("script");
            !$script || $script->remove(); // Remove script for chart
            $div->has("img") || $div->remove(); // No image inside => Remove
        }
        // Remove empty cards
        $cards = $doc->find("div.card");
        array_walk($cards, fn($el) => $el->has(self::$Selectors) || $el->remove()); // Nothing to export => Remove
        // Find and process all elements to be exported
        $elements = $doc->first("body")->findInDocument(self::$Selectors);
        $break = $this->Table ? $this->Table->ExportPageBreaks : $this->ExportPageBreaks;
        $avoid = false;
        for ($i = 0, $cnt = count($elements); $i < $cnt; $i++) {
            $element = $elements[$i];
            $classes = $element->classes();
            $style = $element->style();
            if ($this->UseInlineStyles) { // Use inline styles
                $classes->remove("break-before-page")->remove("break-after-page"); // Remove classes
            } else { // Use classes
                $style->removeProperty("page-break-before")->removeProperty("page-break-after"); // Remove styles
            }
            if ($i == 0) { // First, remove page break before content
                if ($this->UseInlineStyles) {
                    $style->removeProperty("page-break-before")->removeProperty("page-break-after");
                } else {
                    $classes->remove("break-before-page")->remove("break-after-page");
                }
            } elseif ($i == $cnt - 1) { // Last, remove page break after content
                if ($this->UseInlineStyles) {
                    $break && !$avoid ? $style->setProperty("page-break-before", "always") : $style->removeProperty("page-break-before");
                    $style->removeProperty("page-break-after");
                } else {
                    $break && !$avoid ? $classes->add("break-before-page") : $classes->remove("break-before-page");
                    $classes->remove("break-after-page");
                }
            } else {
                if ($this->UseInlineStyles) {
                    $break && !$avoid ? $style->setProperty("page-break-before", "always") : $style->removeProperty("page-break-before");
                    $style->removeProperty("page-break-after");
                } else {
                    $break && !$avoid ? $classes->add("break-before-page") : $classes->remove("break-before-page");
                    $classes->remove("break-after-page");
                }
            }
            $avoid = $classes->contains("break-after-avoid");
        }
    }

    // Get Document
    public function &getDocument($string = null)
    {
        $doc = new Document(null, false, strtoupper(Config("PROJECT_CHARSET")));
        $string ??= $this->Text;
        !$string || @$doc->load($string);
        return $doc;
    }

    // Set Document
    public function setDocument(Document $doc)
    {
        $this->Text = $doc->format()->html();
    }

    // Adjust HTML before export (to be called in export())
    protected function adjustHtml()
    {
        if (!ContainsText($this->Text, "</body>")) {
            $this->exportHeaderAndFooter(); // Add header and footer to $this->Text
        }
        $doc = &$this->getDocument($this->Text); // Load $this->Text again
        // Images
        if (!$this->ExportImages) {
            $imgs = $doc->find("img");
            array_walk($imgs, fn($el) => $el->remove());
        }
        // Adjust page break
        $this->adjustPageBreak($doc);
        // Grid and table container
        $divs = $doc->find("div[class*='ew-grid'], div[class*='table-responsive']"); // div.ew-grid(-middle-panel), div.table-responsive(-sm|-md|-lg|-xl)
        foreach ($divs as $div) {
            $div->removeAttribute("class");
        }
        // Table
        $tables = $doc->find(".ew-table, .ew-export-table");
        foreach ($tables as $table) {
            $classes = $table->classes();
            $noBorder = $classes->contains("no-border");
            if ($classes->contains("ew-table")) {
                if ($this->UseInlineStyles) {
                    $classes->removeAll()->add("ew-export-table"); // Use single class (for MS Word/Excel)
                } else {
                    $classes->removeAll(["break-before-page", "break-after-page"])->add("ew-export-table");
                }
            }
            $table->style()->setProperty("border-collapse", "collapse"); // Set border-collapse
            $rows = $table->findInDocument("tr"); // Note: Use findInDocument() to change styles
            $cellStyles = Config("EXPORT_TABLE_CELL_STYLES");
            if ($noBorder) {
                $cellStyles["border"] = "0";
            }
            foreach ($rows as $row) {
                $cells = $row->findInDocument("td, th"); // Note: Use findInDocument() to change styles
                foreach ($cells as $cell) {
                    $cell->style()->setMultipleProperties($cellStyles); // Add cell styles
                }
            }
        }
        $this->setDocument($doc);
    }

    // Load HTML
    public function loadHtml($html)
    {
        $this->Text .= $html;
    }

    // Add image (virtual)
    public function addImage($imagefn, $break = false)
    {
        // To be implemented by subclass
    }

    // Export
    abstract public function export($fileName = "", $output = true, $save = false);
}
