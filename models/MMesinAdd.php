<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class MMesinAdd extends MMesin
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'm_mesin';

    // Page object name
    public $PageObjName = "MMesinAdd";

    // Rendering View
    public $RenderingView = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (m_mesin)
        if (!isset($GLOBALS["m_mesin"]) || get_class($GLOBALS["m_mesin"]) == PROJECT_NAMESPACE . "m_mesin") {
            $GLOBALS["m_mesin"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'm_mesin');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("m_mesin"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "mmesinview") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }
    public $FormClassName = "ew-horizontal ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->gambar_mesin->setVisibility();
        $this->nama_mesin->setVisibility();
        $this->jumlah->setVisibility();
        $this->dalam_penyewaan->setVisibility();
        $this->sisa_barang->setVisibility();
        $this->keterangan->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form ew-horizontal";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("mmesinlist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "mmesinlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "mmesinview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->gambar_mesin->Upload->Index = $CurrentForm->Index;
        $this->gambar_mesin->Upload->uploadFile();
        $this->gambar_mesin->CurrentValue = $this->gambar_mesin->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->gambar_mesin->Upload->DbValue = null;
        $this->gambar_mesin->OldValue = $this->gambar_mesin->Upload->DbValue;
        $this->gambar_mesin->CurrentValue = null; // Clear file related field
        $this->nama_mesin->CurrentValue = null;
        $this->nama_mesin->OldValue = $this->nama_mesin->CurrentValue;
        $this->jumlah->CurrentValue = null;
        $this->jumlah->OldValue = $this->jumlah->CurrentValue;
        $this->dalam_penyewaan->CurrentValue = null;
        $this->dalam_penyewaan->OldValue = $this->dalam_penyewaan->CurrentValue;
        $this->sisa_barang->CurrentValue = null;
        $this->sisa_barang->OldValue = $this->sisa_barang->CurrentValue;
        $this->keterangan->CurrentValue = null;
        $this->keterangan->OldValue = $this->keterangan->CurrentValue;
        $this->created_at->CurrentValue = null;
        $this->created_at->OldValue = $this->created_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'nama_mesin' first before field var 'x_nama_mesin'
        $val = $CurrentForm->hasValue("nama_mesin") ? $CurrentForm->getValue("nama_mesin") : $CurrentForm->getValue("x_nama_mesin");
        if (!$this->nama_mesin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_mesin->Visible = false; // Disable update for API request
            } else {
                $this->nama_mesin->setFormValue($val);
            }
        }

        // Check field name 'jumlah' first before field var 'x_jumlah'
        $val = $CurrentForm->hasValue("jumlah") ? $CurrentForm->getValue("jumlah") : $CurrentForm->getValue("x_jumlah");
        if (!$this->jumlah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jumlah->Visible = false; // Disable update for API request
            } else {
                $this->jumlah->setFormValue($val);
            }
        }

        // Check field name 'dalam_penyewaan' first before field var 'x_dalam_penyewaan'
        $val = $CurrentForm->hasValue("dalam_penyewaan") ? $CurrentForm->getValue("dalam_penyewaan") : $CurrentForm->getValue("x_dalam_penyewaan");
        if (!$this->dalam_penyewaan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dalam_penyewaan->Visible = false; // Disable update for API request
            } else {
                $this->dalam_penyewaan->setFormValue($val);
            }
        }

        // Check field name 'sisa_barang' first before field var 'x_sisa_barang'
        $val = $CurrentForm->hasValue("sisa_barang") ? $CurrentForm->getValue("sisa_barang") : $CurrentForm->getValue("x_sisa_barang");
        if (!$this->sisa_barang->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sisa_barang->Visible = false; // Disable update for API request
            } else {
                $this->sisa_barang->setFormValue($val);
            }
        }

        // Check field name 'keterangan' first before field var 'x_keterangan'
        $val = $CurrentForm->hasValue("keterangan") ? $CurrentForm->getValue("keterangan") : $CurrentForm->getValue("x_keterangan");
        if (!$this->keterangan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->keterangan->Visible = false; // Disable update for API request
            } else {
                $this->keterangan->setFormValue($val);
            }
        }

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->nama_mesin->CurrentValue = $this->nama_mesin->FormValue;
        $this->jumlah->CurrentValue = $this->jumlah->FormValue;
        $this->dalam_penyewaan->CurrentValue = $this->dalam_penyewaan->FormValue;
        $this->sisa_barang->CurrentValue = $this->sisa_barang->FormValue;
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
            return;
        }
        $this->id->setDbValue($row['id']);
        $this->gambar_mesin->Upload->DbValue = $row['gambar_mesin'];
        $this->gambar_mesin->setDbValue($this->gambar_mesin->Upload->DbValue);
        $this->nama_mesin->setDbValue($row['nama_mesin']);
        $this->jumlah->setDbValue($row['jumlah']);
        $this->dalam_penyewaan->setDbValue($row['dalam_penyewaan']);
        $this->sisa_barang->setDbValue($row['sisa_barang']);
        $this->keterangan->setDbValue($row['keterangan']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['gambar_mesin'] = $this->gambar_mesin->Upload->DbValue;
        $row['nama_mesin'] = $this->nama_mesin->CurrentValue;
        $row['jumlah'] = $this->jumlah->CurrentValue;
        $row['dalam_penyewaan'] = $this->dalam_penyewaan->CurrentValue;
        $row['sisa_barang'] = $this->sisa_barang->CurrentValue;
        $row['keterangan'] = $this->keterangan->CurrentValue;
        $row['created_at'] = $this->created_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // gambar_mesin

        // nama_mesin

        // jumlah

        // dalam_penyewaan

        // sisa_barang

        // keterangan

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // gambar_mesin
            if (!EmptyValue($this->gambar_mesin->Upload->DbValue)) {
                $this->gambar_mesin->ImageWidth = 200;
                $this->gambar_mesin->ImageHeight = 0;
                $this->gambar_mesin->ImageAlt = $this->gambar_mesin->alt();
                $this->gambar_mesin->ViewValue = $this->gambar_mesin->Upload->DbValue;
            } else {
                $this->gambar_mesin->ViewValue = "";
            }
            $this->gambar_mesin->ViewCustomAttributes = "";

            // nama_mesin
            $this->nama_mesin->ViewValue = $this->nama_mesin->CurrentValue;
            $this->nama_mesin->ViewCustomAttributes = "";

            // jumlah
            $this->jumlah->ViewValue = $this->jumlah->CurrentValue;
            $this->jumlah->ViewCustomAttributes = "";

            // dalam_penyewaan
            $this->dalam_penyewaan->ViewValue = $this->dalam_penyewaan->CurrentValue;
            $this->dalam_penyewaan->ViewCustomAttributes = "";

            // sisa_barang
            $this->sisa_barang->ViewValue = $this->sisa_barang->CurrentValue;
            $this->sisa_barang->ViewCustomAttributes = "";

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // gambar_mesin
            $this->gambar_mesin->LinkCustomAttributes = "";
            if (!EmptyValue($this->gambar_mesin->Upload->DbValue)) {
                $this->gambar_mesin->HrefValue = GetFileUploadUrl($this->gambar_mesin, $this->gambar_mesin->htmlDecode($this->gambar_mesin->Upload->DbValue)); // Add prefix/suffix
                $this->gambar_mesin->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->gambar_mesin->HrefValue = FullUrl($this->gambar_mesin->HrefValue, "href");
                }
            } else {
                $this->gambar_mesin->HrefValue = "";
            }
            $this->gambar_mesin->ExportHrefValue = $this->gambar_mesin->UploadPath . $this->gambar_mesin->Upload->DbValue;
            $this->gambar_mesin->TooltipValue = "";
            if ($this->gambar_mesin->UseColorbox) {
                if (EmptyValue($this->gambar_mesin->TooltipValue)) {
                    $this->gambar_mesin->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->gambar_mesin->LinkAttrs["data-rel"] = "m_mesin_x_gambar_mesin";
                $this->gambar_mesin->LinkAttrs->appendClass("ew-lightbox");
            }

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";
            $this->nama_mesin->TooltipValue = "";

            // jumlah
            $this->jumlah->LinkCustomAttributes = "";
            $this->jumlah->HrefValue = "";
            $this->jumlah->TooltipValue = "";

            // dalam_penyewaan
            $this->dalam_penyewaan->LinkCustomAttributes = "";
            $this->dalam_penyewaan->HrefValue = "";
            $this->dalam_penyewaan->TooltipValue = "";

            // sisa_barang
            $this->sisa_barang->LinkCustomAttributes = "";
            $this->sisa_barang->HrefValue = "";
            $this->sisa_barang->TooltipValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // gambar_mesin
            $this->gambar_mesin->EditAttrs["class"] = "form-control";
            $this->gambar_mesin->EditCustomAttributes = "";
            if (!EmptyValue($this->gambar_mesin->Upload->DbValue)) {
                $this->gambar_mesin->ImageWidth = 200;
                $this->gambar_mesin->ImageHeight = 0;
                $this->gambar_mesin->ImageAlt = $this->gambar_mesin->alt();
                $this->gambar_mesin->EditValue = $this->gambar_mesin->Upload->DbValue;
            } else {
                $this->gambar_mesin->EditValue = "";
            }
            if (!EmptyValue($this->gambar_mesin->CurrentValue)) {
                $this->gambar_mesin->Upload->FileName = $this->gambar_mesin->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->gambar_mesin);
            }

            // nama_mesin
            $this->nama_mesin->EditAttrs["class"] = "form-control";
            $this->nama_mesin->EditCustomAttributes = "";
            if (!$this->nama_mesin->Raw) {
                $this->nama_mesin->CurrentValue = HtmlDecode($this->nama_mesin->CurrentValue);
            }
            $this->nama_mesin->EditValue = HtmlEncode($this->nama_mesin->CurrentValue);
            $this->nama_mesin->PlaceHolder = RemoveHtml($this->nama_mesin->caption());

            // jumlah
            $this->jumlah->EditAttrs["class"] = "form-control";
            $this->jumlah->EditCustomAttributes = "";
            if (!$this->jumlah->Raw) {
                $this->jumlah->CurrentValue = HtmlDecode($this->jumlah->CurrentValue);
            }
            $this->jumlah->EditValue = HtmlEncode($this->jumlah->CurrentValue);
            $this->jumlah->PlaceHolder = RemoveHtml($this->jumlah->caption());

            // dalam_penyewaan
            $this->dalam_penyewaan->EditAttrs["class"] = "form-control";
            $this->dalam_penyewaan->EditCustomAttributes = "";
            if (!$this->dalam_penyewaan->Raw) {
                $this->dalam_penyewaan->CurrentValue = HtmlDecode($this->dalam_penyewaan->CurrentValue);
            }
            $this->dalam_penyewaan->EditValue = HtmlEncode($this->dalam_penyewaan->CurrentValue);
            $this->dalam_penyewaan->PlaceHolder = RemoveHtml($this->dalam_penyewaan->caption());

            // sisa_barang
            $this->sisa_barang->EditAttrs["class"] = "form-control";
            $this->sisa_barang->EditCustomAttributes = "";
            if (!$this->sisa_barang->Raw) {
                $this->sisa_barang->CurrentValue = HtmlDecode($this->sisa_barang->CurrentValue);
            }
            $this->sisa_barang->EditValue = HtmlEncode($this->sisa_barang->CurrentValue);
            $this->sisa_barang->PlaceHolder = RemoveHtml($this->sisa_barang->caption());

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // Add refer script

            // gambar_mesin
            $this->gambar_mesin->LinkCustomAttributes = "";
            if (!EmptyValue($this->gambar_mesin->Upload->DbValue)) {
                $this->gambar_mesin->HrefValue = GetFileUploadUrl($this->gambar_mesin, $this->gambar_mesin->htmlDecode($this->gambar_mesin->Upload->DbValue)); // Add prefix/suffix
                $this->gambar_mesin->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->gambar_mesin->HrefValue = FullUrl($this->gambar_mesin->HrefValue, "href");
                }
            } else {
                $this->gambar_mesin->HrefValue = "";
            }
            $this->gambar_mesin->ExportHrefValue = $this->gambar_mesin->UploadPath . $this->gambar_mesin->Upload->DbValue;

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";

            // jumlah
            $this->jumlah->LinkCustomAttributes = "";
            $this->jumlah->HrefValue = "";

            // dalam_penyewaan
            $this->dalam_penyewaan->LinkCustomAttributes = "";
            $this->dalam_penyewaan->HrefValue = "";

            // sisa_barang
            $this->sisa_barang->LinkCustomAttributes = "";
            $this->sisa_barang->HrefValue = "";

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->gambar_mesin->Required) {
            if ($this->gambar_mesin->Upload->FileName == "" && !$this->gambar_mesin->Upload->KeepFile) {
                $this->gambar_mesin->addErrorMessage(str_replace("%s", $this->gambar_mesin->caption(), $this->gambar_mesin->RequiredErrorMessage));
            }
        }
        if ($this->nama_mesin->Required) {
            if (!$this->nama_mesin->IsDetailKey && EmptyValue($this->nama_mesin->FormValue)) {
                $this->nama_mesin->addErrorMessage(str_replace("%s", $this->nama_mesin->caption(), $this->nama_mesin->RequiredErrorMessage));
            }
        }
        if ($this->jumlah->Required) {
            if (!$this->jumlah->IsDetailKey && EmptyValue($this->jumlah->FormValue)) {
                $this->jumlah->addErrorMessage(str_replace("%s", $this->jumlah->caption(), $this->jumlah->RequiredErrorMessage));
            }
        }
        if ($this->dalam_penyewaan->Required) {
            if (!$this->dalam_penyewaan->IsDetailKey && EmptyValue($this->dalam_penyewaan->FormValue)) {
                $this->dalam_penyewaan->addErrorMessage(str_replace("%s", $this->dalam_penyewaan->caption(), $this->dalam_penyewaan->RequiredErrorMessage));
            }
        }
        if ($this->sisa_barang->Required) {
            if (!$this->sisa_barang->IsDetailKey && EmptyValue($this->sisa_barang->FormValue)) {
                $this->sisa_barang->addErrorMessage(str_replace("%s", $this->sisa_barang->caption(), $this->sisa_barang->RequiredErrorMessage));
            }
        }
        if ($this->keterangan->Required) {
            if (!$this->keterangan->IsDetailKey && EmptyValue($this->keterangan->FormValue)) {
                $this->keterangan->addErrorMessage(str_replace("%s", $this->keterangan->caption(), $this->keterangan->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // gambar_mesin
        if ($this->gambar_mesin->Visible && !$this->gambar_mesin->Upload->KeepFile) {
            $this->gambar_mesin->Upload->DbValue = ""; // No need to delete old file
            if ($this->gambar_mesin->Upload->FileName == "") {
                $rsnew['gambar_mesin'] = null;
            } else {
                $rsnew['gambar_mesin'] = $this->gambar_mesin->Upload->FileName;
            }
            $this->gambar_mesin->ImageWidth = 1000; // Resize width
            $this->gambar_mesin->ImageHeight = 0; // Resize height
        }

        // nama_mesin
        $this->nama_mesin->setDbValueDef($rsnew, $this->nama_mesin->CurrentValue, "", false);

        // jumlah
        $this->jumlah->setDbValueDef($rsnew, $this->jumlah->CurrentValue, "", false);

        // dalam_penyewaan
        $this->dalam_penyewaan->setDbValueDef($rsnew, $this->dalam_penyewaan->CurrentValue, null, false);

        // sisa_barang
        $this->sisa_barang->setDbValueDef($rsnew, $this->sisa_barang->CurrentValue, null, false);

        // keterangan
        $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, "", false);
        if ($this->gambar_mesin->Visible && !$this->gambar_mesin->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->gambar_mesin->Upload->DbValue) ? [] : [$this->gambar_mesin->htmlDecode($this->gambar_mesin->Upload->DbValue)];
            if (!EmptyValue($this->gambar_mesin->Upload->FileName)) {
                $newFiles = [$this->gambar_mesin->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->gambar_mesin, $this->gambar_mesin->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->gambar_mesin->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->gambar_mesin->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->gambar_mesin->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->gambar_mesin->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->gambar_mesin->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->gambar_mesin->setDbValueDef($rsnew, $this->gambar_mesin->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        $addRow = false;
        if ($insertRow) {
            try {
                $addRow = $this->insert($rsnew);
            } catch (\Exception $e) {
                $this->setFailureMessage($e->getMessage());
            }
            if ($addRow) {
                if ($this->gambar_mesin->Visible && !$this->gambar_mesin->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->gambar_mesin->Upload->DbValue) ? [] : [$this->gambar_mesin->htmlDecode($this->gambar_mesin->Upload->DbValue)];
                    if (!EmptyValue($this->gambar_mesin->Upload->FileName)) {
                        $newFiles = [$this->gambar_mesin->Upload->FileName];
                        $newFiles2 = [$this->gambar_mesin->htmlDecode($rsnew['gambar_mesin'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->gambar_mesin, $this->gambar_mesin->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->gambar_mesin->Upload->ResizeAndSaveToFile($this->gambar_mesin->ImageWidth, $this->gambar_mesin->ImageHeight, 100, $newFiles[$i], true, $i)) {
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->gambar_mesin->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // gambar_mesin
            CleanUploadTempPath($this->gambar_mesin, $this->gambar_mesin->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("mmesinlist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }
}
