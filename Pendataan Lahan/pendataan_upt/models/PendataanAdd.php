<?php

namespace PHPMaker2021\project1;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PendataanAdd extends Pendataan
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pendataan';

    // Page object name
    public $PageObjName = "PendataanAdd";

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

        // Table object (pendataan)
        if (!isset($GLOBALS["pendataan"]) || get_class($GLOBALS["pendataan"]) == PROJECT_NAMESPACE . "pendataan") {
            $GLOBALS["pendataan"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pendataan');
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
                $doc = new $class(Container("pendataan"));
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
                    if ($pageName == "pendataanview") {
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
        $this->nama->setVisibility();
        $this->penanggung_jawab->setVisibility();
        $this->alamat->setVisibility();
        $this->phone_number->setVisibility();
        $this->produk->setVisibility();
        $this->lokasi_lahan->setVisibility();
        $this->create_at->setVisibility();
        $this->updated_at->setVisibility();
        $this->luas_lahan->setVisibility();
        $this->nilai_sewa->setVisibility();
        $this->legalitas->setVisibility();
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
                    $this->terminate("pendataanlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "pendataanlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "pendataanview") {
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
        $this->legalitas->Upload->Index = $CurrentForm->Index;
        $this->legalitas->Upload->uploadFile();
        $this->legalitas->CurrentValue = $this->legalitas->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->penanggung_jawab->CurrentValue = null;
        $this->penanggung_jawab->OldValue = $this->penanggung_jawab->CurrentValue;
        $this->alamat->CurrentValue = null;
        $this->alamat->OldValue = $this->alamat->CurrentValue;
        $this->phone_number->CurrentValue = null;
        $this->phone_number->OldValue = $this->phone_number->CurrentValue;
        $this->produk->CurrentValue = null;
        $this->produk->OldValue = $this->produk->CurrentValue;
        $this->lokasi_lahan->CurrentValue = null;
        $this->lokasi_lahan->OldValue = $this->lokasi_lahan->CurrentValue;
        $this->create_at->CurrentValue = null;
        $this->create_at->OldValue = $this->create_at->CurrentValue;
        $this->updated_at->CurrentValue = null;
        $this->updated_at->OldValue = $this->updated_at->CurrentValue;
        $this->luas_lahan->CurrentValue = null;
        $this->luas_lahan->OldValue = $this->luas_lahan->CurrentValue;
        $this->nilai_sewa->CurrentValue = null;
        $this->nilai_sewa->OldValue = $this->nilai_sewa->CurrentValue;
        $this->legalitas->Upload->DbValue = null;
        $this->legalitas->OldValue = $this->legalitas->Upload->DbValue;
        $this->legalitas->CurrentValue = null; // Clear file related field
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'penanggung_jawab' first before field var 'x_penanggung_jawab'
        $val = $CurrentForm->hasValue("penanggung_jawab") ? $CurrentForm->getValue("penanggung_jawab") : $CurrentForm->getValue("x_penanggung_jawab");
        if (!$this->penanggung_jawab->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->penanggung_jawab->Visible = false; // Disable update for API request
            } else {
                $this->penanggung_jawab->setFormValue($val);
            }
        }

        // Check field name 'alamat' first before field var 'x_alamat'
        $val = $CurrentForm->hasValue("alamat") ? $CurrentForm->getValue("alamat") : $CurrentForm->getValue("x_alamat");
        if (!$this->alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->alamat->Visible = false; // Disable update for API request
            } else {
                $this->alamat->setFormValue($val);
            }
        }

        // Check field name 'phone_number' first before field var 'x_phone_number'
        $val = $CurrentForm->hasValue("phone_number") ? $CurrentForm->getValue("phone_number") : $CurrentForm->getValue("x_phone_number");
        if (!$this->phone_number->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->phone_number->Visible = false; // Disable update for API request
            } else {
                $this->phone_number->setFormValue($val);
            }
        }

        // Check field name 'produk' first before field var 'x_produk'
        $val = $CurrentForm->hasValue("produk") ? $CurrentForm->getValue("produk") : $CurrentForm->getValue("x_produk");
        if (!$this->produk->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->produk->Visible = false; // Disable update for API request
            } else {
                $this->produk->setFormValue($val);
            }
        }

        // Check field name 'lokasi_lahan' first before field var 'x_lokasi_lahan'
        $val = $CurrentForm->hasValue("lokasi_lahan") ? $CurrentForm->getValue("lokasi_lahan") : $CurrentForm->getValue("x_lokasi_lahan");
        if (!$this->lokasi_lahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lokasi_lahan->Visible = false; // Disable update for API request
            } else {
                $this->lokasi_lahan->setFormValue($val);
            }
        }

        // Check field name 'create_at' first before field var 'x_create_at'
        $val = $CurrentForm->hasValue("create_at") ? $CurrentForm->getValue("create_at") : $CurrentForm->getValue("x_create_at");
        if (!$this->create_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->create_at->Visible = false; // Disable update for API request
            } else {
                $this->create_at->setFormValue($val);
            }
            $this->create_at->CurrentValue = UnFormatDateTime($this->create_at->CurrentValue, 0);
        }

        // Check field name 'updated_at' first before field var 'x_updated_at'
        $val = $CurrentForm->hasValue("updated_at") ? $CurrentForm->getValue("updated_at") : $CurrentForm->getValue("x_updated_at");
        if (!$this->updated_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->updated_at->Visible = false; // Disable update for API request
            } else {
                $this->updated_at->setFormValue($val);
            }
            $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        }

        // Check field name 'luas_lahan' first before field var 'x_luas_lahan'
        $val = $CurrentForm->hasValue("luas_lahan") ? $CurrentForm->getValue("luas_lahan") : $CurrentForm->getValue("x_luas_lahan");
        if (!$this->luas_lahan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->luas_lahan->Visible = false; // Disable update for API request
            } else {
                $this->luas_lahan->setFormValue($val);
            }
        }

        // Check field name 'nilai_sewa' first before field var 'x_nilai_sewa'
        $val = $CurrentForm->hasValue("nilai_sewa") ? $CurrentForm->getValue("nilai_sewa") : $CurrentForm->getValue("x_nilai_sewa");
        if (!$this->nilai_sewa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nilai_sewa->Visible = false; // Disable update for API request
            } else {
                $this->nilai_sewa->setFormValue($val);
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
        $this->nama->CurrentValue = $this->nama->FormValue;
        $this->penanggung_jawab->CurrentValue = $this->penanggung_jawab->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->phone_number->CurrentValue = $this->phone_number->FormValue;
        $this->produk->CurrentValue = $this->produk->FormValue;
        $this->lokasi_lahan->CurrentValue = $this->lokasi_lahan->FormValue;
        $this->create_at->CurrentValue = $this->create_at->FormValue;
        $this->create_at->CurrentValue = UnFormatDateTime($this->create_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
        $this->luas_lahan->CurrentValue = $this->luas_lahan->FormValue;
        $this->nilai_sewa->CurrentValue = $this->nilai_sewa->FormValue;
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
        $this->nama->setDbValue($row['nama']);
        $this->penanggung_jawab->setDbValue($row['penanggung_jawab']);
        $this->alamat->setDbValue($row['alamat']);
        $this->phone_number->setDbValue($row['phone_number']);
        $this->produk->setDbValue($row['produk']);
        $this->lokasi_lahan->setDbValue($row['lokasi_lahan']);
        $this->create_at->setDbValue($row['create_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->luas_lahan->setDbValue($row['luas_lahan']);
        $this->nilai_sewa->setDbValue($row['nilai_sewa']);
        $this->legalitas->Upload->DbValue = $row['legalitas'];
        $this->legalitas->setDbValue($this->legalitas->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['penanggung_jawab'] = $this->penanggung_jawab->CurrentValue;
        $row['alamat'] = $this->alamat->CurrentValue;
        $row['phone_number'] = $this->phone_number->CurrentValue;
        $row['produk'] = $this->produk->CurrentValue;
        $row['lokasi_lahan'] = $this->lokasi_lahan->CurrentValue;
        $row['create_at'] = $this->create_at->CurrentValue;
        $row['updated_at'] = $this->updated_at->CurrentValue;
        $row['luas_lahan'] = $this->luas_lahan->CurrentValue;
        $row['nilai_sewa'] = $this->nilai_sewa->CurrentValue;
        $row['legalitas'] = $this->legalitas->Upload->DbValue;
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

        // nama

        // penanggung_jawab

        // alamat

        // phone_number

        // produk

        // lokasi_lahan

        // create_at

        // updated_at

        // luas_lahan

        // nilai_sewa

        // legalitas
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // penanggung_jawab
            $this->penanggung_jawab->ViewValue = $this->penanggung_jawab->CurrentValue;
            $this->penanggung_jawab->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // phone_number
            $this->phone_number->ViewValue = $this->phone_number->CurrentValue;
            $this->phone_number->ViewCustomAttributes = "";

            // produk
            $this->produk->ViewValue = $this->produk->CurrentValue;
            $this->produk->ViewCustomAttributes = "";

            // lokasi_lahan
            $this->lokasi_lahan->ViewValue = $this->lokasi_lahan->CurrentValue;
            $this->lokasi_lahan->ViewCustomAttributes = "";

            // create_at
            $this->create_at->ViewValue = $this->create_at->CurrentValue;
            $this->create_at->ViewValue = FormatDateTime($this->create_at->ViewValue, 0);
            $this->create_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // luas_lahan
            $this->luas_lahan->ViewValue = $this->luas_lahan->CurrentValue;
            $this->luas_lahan->ViewCustomAttributes = "";

            // nilai_sewa
            $this->nilai_sewa->ViewValue = $this->nilai_sewa->CurrentValue;
            $this->nilai_sewa->ViewCustomAttributes = "";

            // legalitas
            if (!EmptyValue($this->legalitas->Upload->DbValue)) {
                $this->legalitas->ImageWidth = 200;
                $this->legalitas->ImageHeight = 0;
                $this->legalitas->ImageAlt = $this->legalitas->alt();
                $this->legalitas->ViewValue = $this->legalitas->Upload->DbValue;
            } else {
                $this->legalitas->ViewValue = "";
            }
            $this->legalitas->ViewCustomAttributes = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // penanggung_jawab
            $this->penanggung_jawab->LinkCustomAttributes = "";
            $this->penanggung_jawab->HrefValue = "";
            $this->penanggung_jawab->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // phone_number
            $this->phone_number->LinkCustomAttributes = "";
            $this->phone_number->HrefValue = "";
            $this->phone_number->TooltipValue = "";

            // produk
            $this->produk->LinkCustomAttributes = "";
            $this->produk->HrefValue = "";
            $this->produk->TooltipValue = "";

            // lokasi_lahan
            $this->lokasi_lahan->LinkCustomAttributes = "";
            $this->lokasi_lahan->HrefValue = "";
            $this->lokasi_lahan->TooltipValue = "";

            // create_at
            $this->create_at->LinkCustomAttributes = "";
            $this->create_at->HrefValue = "";
            $this->create_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";

            // luas_lahan
            $this->luas_lahan->LinkCustomAttributes = "";
            $this->luas_lahan->HrefValue = "";
            $this->luas_lahan->TooltipValue = "";

            // nilai_sewa
            $this->nilai_sewa->LinkCustomAttributes = "";
            $this->nilai_sewa->HrefValue = "";
            $this->nilai_sewa->TooltipValue = "";

            // legalitas
            $this->legalitas->LinkCustomAttributes = "";
            if (!EmptyValue($this->legalitas->Upload->DbValue)) {
                $this->legalitas->HrefValue = GetFileUploadUrl($this->legalitas, $this->legalitas->htmlDecode($this->legalitas->Upload->DbValue)); // Add prefix/suffix
                $this->legalitas->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->legalitas->HrefValue = FullUrl($this->legalitas->HrefValue, "href");
                }
            } else {
                $this->legalitas->HrefValue = "";
            }
            $this->legalitas->ExportHrefValue = $this->legalitas->UploadPath . $this->legalitas->Upload->DbValue;
            $this->legalitas->TooltipValue = "";
            if ($this->legalitas->UseColorbox) {
                if (EmptyValue($this->legalitas->TooltipValue)) {
                    $this->legalitas->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->legalitas->LinkAttrs["data-rel"] = "pendataan_x_legalitas";
                $this->legalitas->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // nama
            $this->nama->EditAttrs["class"] = "form-control";
            $this->nama->EditCustomAttributes = "";
            if (!$this->nama->Raw) {
                $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
            }
            $this->nama->EditValue = HtmlEncode($this->nama->CurrentValue);
            $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

            // penanggung_jawab
            $this->penanggung_jawab->EditAttrs["class"] = "form-control";
            $this->penanggung_jawab->EditCustomAttributes = "";
            if (!$this->penanggung_jawab->Raw) {
                $this->penanggung_jawab->CurrentValue = HtmlDecode($this->penanggung_jawab->CurrentValue);
            }
            $this->penanggung_jawab->EditValue = HtmlEncode($this->penanggung_jawab->CurrentValue);
            $this->penanggung_jawab->PlaceHolder = RemoveHtml($this->penanggung_jawab->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // phone_number
            $this->phone_number->EditAttrs["class"] = "form-control";
            $this->phone_number->EditCustomAttributes = "";
            if (!$this->phone_number->Raw) {
                $this->phone_number->CurrentValue = HtmlDecode($this->phone_number->CurrentValue);
            }
            $this->phone_number->EditValue = HtmlEncode($this->phone_number->CurrentValue);
            $this->phone_number->PlaceHolder = RemoveHtml($this->phone_number->caption());

            // produk
            $this->produk->EditAttrs["class"] = "form-control";
            $this->produk->EditCustomAttributes = "";
            if (!$this->produk->Raw) {
                $this->produk->CurrentValue = HtmlDecode($this->produk->CurrentValue);
            }
            $this->produk->EditValue = HtmlEncode($this->produk->CurrentValue);
            $this->produk->PlaceHolder = RemoveHtml($this->produk->caption());

            // lokasi_lahan
            $this->lokasi_lahan->EditAttrs["class"] = "form-control";
            $this->lokasi_lahan->EditCustomAttributes = "";
            if (!$this->lokasi_lahan->Raw) {
                $this->lokasi_lahan->CurrentValue = HtmlDecode($this->lokasi_lahan->CurrentValue);
            }
            $this->lokasi_lahan->EditValue = HtmlEncode($this->lokasi_lahan->CurrentValue);
            $this->lokasi_lahan->PlaceHolder = RemoveHtml($this->lokasi_lahan->caption());

            // create_at
            $this->create_at->EditAttrs["class"] = "form-control";
            $this->create_at->EditCustomAttributes = "";
            $this->create_at->EditValue = HtmlEncode(FormatDateTime($this->create_at->CurrentValue, 8));
            $this->create_at->PlaceHolder = RemoveHtml($this->create_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // luas_lahan
            $this->luas_lahan->EditAttrs["class"] = "form-control";
            $this->luas_lahan->EditCustomAttributes = "";
            if (!$this->luas_lahan->Raw) {
                $this->luas_lahan->CurrentValue = HtmlDecode($this->luas_lahan->CurrentValue);
            }
            $this->luas_lahan->EditValue = HtmlEncode($this->luas_lahan->CurrentValue);
            $this->luas_lahan->PlaceHolder = RemoveHtml($this->luas_lahan->caption());

            // nilai_sewa
            $this->nilai_sewa->EditAttrs["class"] = "form-control";
            $this->nilai_sewa->EditCustomAttributes = "";
            if (!$this->nilai_sewa->Raw) {
                $this->nilai_sewa->CurrentValue = HtmlDecode($this->nilai_sewa->CurrentValue);
            }
            $this->nilai_sewa->EditValue = HtmlEncode($this->nilai_sewa->CurrentValue);
            $this->nilai_sewa->PlaceHolder = RemoveHtml($this->nilai_sewa->caption());

            // legalitas
            $this->legalitas->EditAttrs["class"] = "form-control";
            $this->legalitas->EditCustomAttributes = "";
            if (!EmptyValue($this->legalitas->Upload->DbValue)) {
                $this->legalitas->ImageWidth = 200;
                $this->legalitas->ImageHeight = 0;
                $this->legalitas->ImageAlt = $this->legalitas->alt();
                $this->legalitas->EditValue = $this->legalitas->Upload->DbValue;
            } else {
                $this->legalitas->EditValue = "";
            }
            if (!EmptyValue($this->legalitas->CurrentValue)) {
                $this->legalitas->Upload->FileName = $this->legalitas->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->legalitas);
            }

            // Add refer script

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // penanggung_jawab
            $this->penanggung_jawab->LinkCustomAttributes = "";
            $this->penanggung_jawab->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // phone_number
            $this->phone_number->LinkCustomAttributes = "";
            $this->phone_number->HrefValue = "";

            // produk
            $this->produk->LinkCustomAttributes = "";
            $this->produk->HrefValue = "";

            // lokasi_lahan
            $this->lokasi_lahan->LinkCustomAttributes = "";
            $this->lokasi_lahan->HrefValue = "";

            // create_at
            $this->create_at->LinkCustomAttributes = "";
            $this->create_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";

            // luas_lahan
            $this->luas_lahan->LinkCustomAttributes = "";
            $this->luas_lahan->HrefValue = "";

            // nilai_sewa
            $this->nilai_sewa->LinkCustomAttributes = "";
            $this->nilai_sewa->HrefValue = "";

            // legalitas
            $this->legalitas->LinkCustomAttributes = "";
            if (!EmptyValue($this->legalitas->Upload->DbValue)) {
                $this->legalitas->HrefValue = GetFileUploadUrl($this->legalitas, $this->legalitas->htmlDecode($this->legalitas->Upload->DbValue)); // Add prefix/suffix
                $this->legalitas->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->legalitas->HrefValue = FullUrl($this->legalitas->HrefValue, "href");
                }
            } else {
                $this->legalitas->HrefValue = "";
            }
            $this->legalitas->ExportHrefValue = $this->legalitas->UploadPath . $this->legalitas->Upload->DbValue;
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
        if ($this->nama->Required) {
            if (!$this->nama->IsDetailKey && EmptyValue($this->nama->FormValue)) {
                $this->nama->addErrorMessage(str_replace("%s", $this->nama->caption(), $this->nama->RequiredErrorMessage));
            }
        }
        if ($this->penanggung_jawab->Required) {
            if (!$this->penanggung_jawab->IsDetailKey && EmptyValue($this->penanggung_jawab->FormValue)) {
                $this->penanggung_jawab->addErrorMessage(str_replace("%s", $this->penanggung_jawab->caption(), $this->penanggung_jawab->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->phone_number->Required) {
            if (!$this->phone_number->IsDetailKey && EmptyValue($this->phone_number->FormValue)) {
                $this->phone_number->addErrorMessage(str_replace("%s", $this->phone_number->caption(), $this->phone_number->RequiredErrorMessage));
            }
        }
        if ($this->produk->Required) {
            if (!$this->produk->IsDetailKey && EmptyValue($this->produk->FormValue)) {
                $this->produk->addErrorMessage(str_replace("%s", $this->produk->caption(), $this->produk->RequiredErrorMessage));
            }
        }
        if ($this->lokasi_lahan->Required) {
            if (!$this->lokasi_lahan->IsDetailKey && EmptyValue($this->lokasi_lahan->FormValue)) {
                $this->lokasi_lahan->addErrorMessage(str_replace("%s", $this->lokasi_lahan->caption(), $this->lokasi_lahan->RequiredErrorMessage));
            }
        }
        if ($this->create_at->Required) {
            if (!$this->create_at->IsDetailKey && EmptyValue($this->create_at->FormValue)) {
                $this->create_at->addErrorMessage(str_replace("%s", $this->create_at->caption(), $this->create_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->create_at->FormValue)) {
            $this->create_at->addErrorMessage($this->create_at->getErrorMessage(false));
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
        }
        if ($this->luas_lahan->Required) {
            if (!$this->luas_lahan->IsDetailKey && EmptyValue($this->luas_lahan->FormValue)) {
                $this->luas_lahan->addErrorMessage(str_replace("%s", $this->luas_lahan->caption(), $this->luas_lahan->RequiredErrorMessage));
            }
        }
        if ($this->nilai_sewa->Required) {
            if (!$this->nilai_sewa->IsDetailKey && EmptyValue($this->nilai_sewa->FormValue)) {
                $this->nilai_sewa->addErrorMessage(str_replace("%s", $this->nilai_sewa->caption(), $this->nilai_sewa->RequiredErrorMessage));
            }
        }
        if ($this->legalitas->Required) {
            if ($this->legalitas->Upload->FileName == "" && !$this->legalitas->Upload->KeepFile) {
                $this->legalitas->addErrorMessage(str_replace("%s", $this->legalitas->caption(), $this->legalitas->RequiredErrorMessage));
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

        // nama
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, "", false);

        // penanggung_jawab
        $this->penanggung_jawab->setDbValueDef($rsnew, $this->penanggung_jawab->CurrentValue, "", false);

        // alamat
        $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, "", false);

        // phone_number
        $this->phone_number->setDbValueDef($rsnew, $this->phone_number->CurrentValue, "", false);

        // produk
        $this->produk->setDbValueDef($rsnew, $this->produk->CurrentValue, "", false);

        // lokasi_lahan
        $this->lokasi_lahan->setDbValueDef($rsnew, $this->lokasi_lahan->CurrentValue, "", false);

        // create_at
        $this->create_at->setDbValueDef($rsnew, UnFormatDateTime($this->create_at->CurrentValue, 0), null, false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, false);

        // luas_lahan
        $this->luas_lahan->setDbValueDef($rsnew, $this->luas_lahan->CurrentValue, "", false);

        // nilai_sewa
        $this->nilai_sewa->setDbValueDef($rsnew, $this->nilai_sewa->CurrentValue, "", false);

        // legalitas
        if ($this->legalitas->Visible && !$this->legalitas->Upload->KeepFile) {
            $this->legalitas->Upload->DbValue = ""; // No need to delete old file
            if ($this->legalitas->Upload->FileName == "") {
                $rsnew['legalitas'] = null;
            } else {
                $rsnew['legalitas'] = $this->legalitas->Upload->FileName;
            }
            $this->legalitas->ImageWidth = 1000; // Resize width
            $this->legalitas->ImageHeight = 0; // Resize height
        }
        if ($this->legalitas->Visible && !$this->legalitas->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->legalitas->Upload->DbValue) ? [] : [$this->legalitas->htmlDecode($this->legalitas->Upload->DbValue)];
            if (!EmptyValue($this->legalitas->Upload->FileName)) {
                $newFiles = [$this->legalitas->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->legalitas, $this->legalitas->Upload->Index);
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
                            $file1 = UniqueFilename($this->legalitas->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->legalitas->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->legalitas->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->legalitas->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->legalitas->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->legalitas->setDbValueDef($rsnew, $this->legalitas->Upload->FileName, null, false);
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
                if ($this->legalitas->Visible && !$this->legalitas->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->legalitas->Upload->DbValue) ? [] : [$this->legalitas->htmlDecode($this->legalitas->Upload->DbValue)];
                    if (!EmptyValue($this->legalitas->Upload->FileName)) {
                        $newFiles = [$this->legalitas->Upload->FileName];
                        $newFiles2 = [$this->legalitas->htmlDecode($rsnew['legalitas'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->legalitas, $this->legalitas->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->legalitas->Upload->ResizeAndSaveToFile($this->legalitas->ImageWidth, $this->legalitas->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                @unlink($this->legalitas->oldPhysicalUploadPath() . $oldFile);
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
            // legalitas
            CleanUploadTempPath($this->legalitas, $this->legalitas->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pendataanlist"), "", $this->TableVar, true);
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
