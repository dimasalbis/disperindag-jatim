<?php

namespace PHPMaker2023\pembuatan_mesin;

/**
 * Abstract base class for export
 */
abstract class AbstractExportBase
{
    protected $Table; // Table/Page object
    protected $FileId; // File ID for saving to folder
    public $Text = ""; // Text or HTML to be exported
    public $ContentType = ""; // Content type
    public $UseCharset = false; // Add charset to content type
    public $UseBom = false; // Output byte order mark
    public $CacheControl = "no-store, no-cache"; // Cache control
    public $FileName = ""; // User specified file name
    public $FileExtension = ""; // File extension without "."
    public $Disposition = "attachment"; // Disposition for Content-Disposition header or email attachment
    public $Download;

    // Constructor
    public function __construct($table = null)
    {
        $this->Table = $table;
        $this->UseCharset = ConvertToBool(Get(Config("API_EXPORT_USE_CHARSET"), $this->UseCharset));
        $this->UseBom = ConvertToBool(Get(Config("API_EXPORT_USE_BOM"), $this->UseBom));
        $this->CacheControl = Get(Config("API_EXPORT_CACHE_CONTROL"), $this->CacheControl);
        $this->Disposition = Get(Config("API_EXPORT_DISPOSITION"), $this->Disposition);
        $this->Download = Get(Config("API_EXPORT_DOWNLOAD")); // Override $this->Disposition if not null
        $this->ContentType = Get(Config("API_EXPORT_CONTENT_TYPE"), $this->ContentType);
        $this->StyleSheet = Config("PROJECT_STYLESHEET_FILENAME");
        if (!$this->ContentType && $this->FileExtension) {
            $this->ContentType = Config("MIME_TYPES." . $this->FileExtension);
        }
    }

    /**
     * Get table
     *
     * @return Table/Page object
     */
    public function getTable()
    {
        return $this->Table;
    }

    /**
     * Set table
     *
     * @param mixed $value Table/Page object
     * @return void
     */
    public function setTable($value)
    {
        $this->Table = $value;
    }

    /**
     * Get file ID (GUID)
     *
     * @return string
     */
    public function getFileId()
    {
        $this->FileId ??= NewGuid();
        return $this->FileId;
    }

    /**
     * Get save file name (<guid>.<ext>)
     *
     * @return string
     */
    public function getSaveFileName()
    {
        return $this->fixFileName($this->getFileId());
    }

    /**
     * Get Content-Type header
     *
     * @return string
     */
    public function contentTypeHeader()
    {
        $header = $this->ContentType;
        if ($this->UseCharset) {
            $charset = Config("PROJECT_CHARSET");
            $header .= $charset != "" ? "; charset=" . $charset : "";
        }
        return "Content-Type: " . $header;
    }

    /**
     * Get Content-Disposition header
     *
     * @param string $fileName File name
     * @return string
     */
    public function contentDispositionHeader(string $fileName = "")
    {
        $header = $this->getDisposition();
        if ($header == "attachment" && $fileName != "") {
                $header .= "; filename=\"" . $fileName . "\"";
        }
        return "Content-Disposition: " . $header;
    }

    /**
     * Get Cache-Control header
     *
     * @return string
     */
    public function cacheControlHeader()
    {
        return "Cache-Control: " . $this->CacheControl;
    }

    /**
     * Write BOM
     *
     * @return void
     */
    public function writeBom()
    {
        if ($this->UseBom && SameText(Config("PROJECT_CHARSET"), "utf-8")) {
            echo "\xEF\xBB\xBF";
        }
    }

    /**
     * Write content
     *
     * @return void
     */
    public function write()
    {
        echo $this->Text;
    }

    /**
     * Clean (erase) the output buffer and turn off output buffering
     *
     * @return void
     */
    public function cleanBuffer()
    {
        if (!Config("DEBUG") && ob_get_length()) {
            ob_end_clean();
        }
    }

    /**
     * Get disposition
     *
     * @return string "inline" or "attachment"
     */
    public function getDisposition()
    {
        if ($this->Download !== null) {
            return ConvertToBool($this->Download) ? "attachment" : "inline";
        }
        $value = strtolower($this->Disposition);
        if (in_array($value, ["inline", "attachment"])) {
            return $value;
        }
        return "attachment";
    }

    /**
     * Fix file extension
     *
     * @param string $fileName File name
     * @return string
     */
    public function fixFileName($fileName)
    {
        if (!$fileName) {
            $fileName = ($this->Table ? $this->Table->TableVar . "_" : "") . (new \DateTime())->format("YmdHisu"); // Temporary file name
        }
        $pathinfo = pathinfo($fileName);
        $fileName .= SameText($pathinfo["extension"] ?? "", $this->FileExtension) ? "" : "." . $this->FileExtension;
        return $fileName;
    }

    /**
     * Clean output buffer, write headers and BOM before export
     *
     * @param string $fileName File name. If specified, it will override the
     * @return void
     */
    public function writeHeaders($fileName = "")
    {
        $this->cleanBuffer();
        header($this->contentTypeHeader());
        header($this->contentDispositionHeader($this->FileName ?: $fileName)); // Use $this->FileName specified by user first
        header($this->cacheControlHeader());
        $this->writeBOM();
    }

    /**
     * Import data from table/page object
     *
     * @return void
     */
    public function import()
    {
        if (method_exists($this->Table, "exportData")) {
            $this->Table->exportData($this);
        }
    }

    /**
     * Export
     *
     * @param string $fileName Output file name
     * @param bool $output Whether output to browser
     * @param bool $save Whether save to folder
     * @return void
     */
    abstract public function export($fileName = "", $output = true, $save = false);
}
