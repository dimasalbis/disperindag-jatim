<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PelatihanSiswaAdd extends PelatihanSiswa
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pelatihan_siswa';

    // Page object name
    public $PageObjName = "PelatihanSiswaAdd";

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

        // Table object (pelatihan_siswa)
        if (!isset($GLOBALS["pelatihan_siswa"]) || get_class($GLOBALS["pelatihan_siswa"]) == PROJECT_NAMESPACE . "pelatihan_siswa") {
            $GLOBALS["pelatihan_siswa"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pelatihan_siswa');
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
                $doc = new $class(Container("pelatihan_siswa"));
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
                    if ($pageName == "pelatihansiswaview") {
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

        // Update last accessed time
        if (!$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            Write($Language->phrase("UserProfileCorrupted"));
            $this->terminate();
            return;
        }

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->nama->setVisibility();
        $this->asal_sekolah->setVisibility();
        $this->tempat_lahir->setVisibility();
        $this->tanggal_lahir->setVisibility();
        $this->jenis_kelamin->setVisibility();
        $this->no_telpon->setVisibility();
        $this->_email->setVisibility();
        $this->legalitas->setVisibility();
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
                    $this->terminate("pelatihansiswalist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "pelatihansiswalist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "pelatihansiswaview") {
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
        $this->jenis_kelamin->CurrentValue = $this->legalitas->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->nama->CurrentValue = null;
        $this->nama->OldValue = $this->nama->CurrentValue;
        $this->asal_sekolah->CurrentValue = null;
        $this->asal_sekolah->OldValue = $this->asal_sekolah->CurrentValue;
        $this->tempat_lahir->CurrentValue = null;
        $this->tempat_lahir->OldValue = $this->tempat_lahir->CurrentValue;
        $this->tanggal_lahir->CurrentValue = null;
        $this->tanggal_lahir->OldValue = $this->tanggal_lahir->CurrentValue;
        $this->jenis_kelamin->CurrentValue = null;
        $this->jenis_kelamin->OldValue = $this->jenis_kelamin->CurrentValue;
        $this->jenis_kelamin->CurrentValue = null; // Clear file related field
        $this->no_telpon->CurrentValue = null;
        $this->no_telpon->OldValue = $this->no_telpon->CurrentValue;
        $this->_email->CurrentValue = null;
        $this->_email->OldValue = $this->_email->CurrentValue;
        $this->legalitas->Upload->DbValue = null;
        $this->legalitas->OldValue = $this->legalitas->Upload->DbValue;
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

        // Check field name 'nama' first before field var 'x_nama'
        $val = $CurrentForm->hasValue("nama") ? $CurrentForm->getValue("nama") : $CurrentForm->getValue("x_nama");
        if (!$this->nama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama->Visible = false; // Disable update for API request
            } else {
                $this->nama->setFormValue($val);
            }
        }

        // Check field name 'asal_sekolah' first before field var 'x_asal_sekolah'
        $val = $CurrentForm->hasValue("asal_sekolah") ? $CurrentForm->getValue("asal_sekolah") : $CurrentForm->getValue("x_asal_sekolah");
        if (!$this->asal_sekolah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->asal_sekolah->Visible = false; // Disable update for API request
            } else {
                $this->asal_sekolah->setFormValue($val);
            }
        }

        // Check field name 'tempat_lahir' first before field var 'x_tempat_lahir'
        $val = $CurrentForm->hasValue("tempat_lahir") ? $CurrentForm->getValue("tempat_lahir") : $CurrentForm->getValue("x_tempat_lahir");
        if (!$this->tempat_lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tempat_lahir->Visible = false; // Disable update for API request
            } else {
                $this->tempat_lahir->setFormValue($val);
            }
        }

        // Check field name 'tanggal_lahir' first before field var 'x_tanggal_lahir'
        $val = $CurrentForm->hasValue("tanggal_lahir") ? $CurrentForm->getValue("tanggal_lahir") : $CurrentForm->getValue("x_tanggal_lahir");
        if (!$this->tanggal_lahir->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_lahir->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_lahir->setFormValue($val);
            }
            $this->tanggal_lahir->CurrentValue = UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0);
        }

        // Check field name 'jenis_kelamin' first before field var 'x_jenis_kelamin'
        $val = $CurrentForm->hasValue("jenis_kelamin") ? $CurrentForm->getValue("jenis_kelamin") : $CurrentForm->getValue("x_jenis_kelamin");
        if (!$this->jenis_kelamin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->jenis_kelamin->Visible = false; // Disable update for API request
            } else {
                $this->jenis_kelamin->setFormValue($val);
            }
        }

        // Check field name 'no_telpon' first before field var 'x_no_telpon'
        $val = $CurrentForm->hasValue("no_telpon") ? $CurrentForm->getValue("no_telpon") : $CurrentForm->getValue("x_no_telpon");
        if (!$this->no_telpon->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_telpon->Visible = false; // Disable update for API request
            } else {
                $this->no_telpon->setFormValue($val);
            }
        }

        // Check field name 'email' first before field var 'x__email'
        $val = $CurrentForm->hasValue("email") ? $CurrentForm->getValue("email") : $CurrentForm->getValue("x__email");
        if (!$this->_email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_email->Visible = false; // Disable update for API request
            } else {
                $this->_email->setFormValue($val);
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
        $this->asal_sekolah->CurrentValue = $this->asal_sekolah->FormValue;
        $this->tempat_lahir->CurrentValue = $this->tempat_lahir->FormValue;
        $this->tanggal_lahir->CurrentValue = $this->tanggal_lahir->FormValue;
        $this->tanggal_lahir->CurrentValue = UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0);
        $this->no_telpon->CurrentValue = $this->no_telpon->FormValue;
        $this->_email->CurrentValue = $this->_email->FormValue;
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
        $this->asal_sekolah->setDbValue($row['asal_sekolah']);
        $this->tempat_lahir->setDbValue($row['tempat_lahir']);
        $this->tanggal_lahir->setDbValue($row['tanggal_lahir']);
        $this->jenis_kelamin->setDbValue($row['jenis_kelamin']);
        $this->no_telpon->setDbValue($row['no_telpon']);
        $this->_email->setDbValue($row['email']);
        $this->legalitas->Upload->DbValue = $row['legalitas'];
        $this->legalitas->setDbValue($this->legalitas->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['nama'] = $this->nama->CurrentValue;
        $row['asal_sekolah'] = $this->asal_sekolah->CurrentValue;
        $row['tempat_lahir'] = $this->tempat_lahir->CurrentValue;
        $row['tanggal_lahir'] = $this->tanggal_lahir->CurrentValue;
        $row['jenis_kelamin'] = $this->jenis_kelamin->CurrentValue;
        $row['no_telpon'] = $this->no_telpon->CurrentValue;
        $row['email'] = $this->_email->CurrentValue;
        $row['legalitas'] = $this->legalitas->Upload->DbValue;
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

        // nama

        // asal_sekolah

        // tempat_lahir

        // tanggal_lahir

        // jenis_kelamin

        // no_telpon

        // email

        // legalitas

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nama
            $this->nama->ViewValue = $this->nama->CurrentValue;
            $this->nama->ViewCustomAttributes = "";

            // asal_sekolah
            $this->asal_sekolah->ViewValue = $this->asal_sekolah->CurrentValue;
            $this->asal_sekolah->ViewCustomAttributes = "";

            // tempat_lahir
            $this->tempat_lahir->ViewValue = $this->tempat_lahir->CurrentValue;
            $this->tempat_lahir->ViewCustomAttributes = "";

            // tanggal_lahir
            $this->tanggal_lahir->ViewValue = $this->tanggal_lahir->CurrentValue;
            $this->tanggal_lahir->ViewValue = FormatDateTime($this->tanggal_lahir->ViewValue, 0);
            $this->tanggal_lahir->ViewCustomAttributes = "";

            // jenis_kelamin
            if (strval($this->jenis_kelamin->CurrentValue) != "") {
                $this->jenis_kelamin->ViewValue = $this->jenis_kelamin->optionCaption($this->jenis_kelamin->CurrentValue);
            } else {
                $this->jenis_kelamin->ViewValue = null;
            }
            $this->jenis_kelamin->ViewCustomAttributes = "";

            // no_telpon
            $this->no_telpon->ViewValue = $this->no_telpon->CurrentValue;
            $this->no_telpon->ViewCustomAttributes = "";

            // email
            $this->_email->ViewValue = $this->_email->CurrentValue;
            $this->_email->ViewCustomAttributes = "";

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

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";
            $this->nama->TooltipValue = "";

            // asal_sekolah
            $this->asal_sekolah->LinkCustomAttributes = "";
            $this->asal_sekolah->HrefValue = "";
            $this->asal_sekolah->TooltipValue = "";

            // tempat_lahir
            $this->tempat_lahir->LinkCustomAttributes = "";
            $this->tempat_lahir->HrefValue = "";
            $this->tempat_lahir->TooltipValue = "";

            // tanggal_lahir
            $this->tanggal_lahir->LinkCustomAttributes = "";
            $this->tanggal_lahir->HrefValue = "";
            $this->tanggal_lahir->TooltipValue = "";

            // jenis_kelamin
            $this->jenis_kelamin->LinkCustomAttributes = "";
            $this->jenis_kelamin->HrefValue = "";
            $this->jenis_kelamin->TooltipValue = "";

            // no_telpon
            $this->no_telpon->LinkCustomAttributes = "";
            $this->no_telpon->HrefValue = "";
            $this->no_telpon->TooltipValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";
            $this->_email->TooltipValue = "";

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
                $this->legalitas->LinkAttrs["data-rel"] = "pelatihan_siswa_x_legalitas";
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

            // asal_sekolah
            $this->asal_sekolah->EditAttrs["class"] = "form-control";
            $this->asal_sekolah->EditCustomAttributes = "";
            if (!$this->asal_sekolah->Raw) {
                $this->asal_sekolah->CurrentValue = HtmlDecode($this->asal_sekolah->CurrentValue);
            }
            $this->asal_sekolah->EditValue = HtmlEncode($this->asal_sekolah->CurrentValue);
            $this->asal_sekolah->PlaceHolder = RemoveHtml($this->asal_sekolah->caption());

            // tempat_lahir
            $this->tempat_lahir->EditAttrs["class"] = "form-control";
            $this->tempat_lahir->EditCustomAttributes = "";
            if (!$this->tempat_lahir->Raw) {
                $this->tempat_lahir->CurrentValue = HtmlDecode($this->tempat_lahir->CurrentValue);
            }
            $this->tempat_lahir->EditValue = HtmlEncode($this->tempat_lahir->CurrentValue);
            $this->tempat_lahir->PlaceHolder = RemoveHtml($this->tempat_lahir->caption());

            // tanggal_lahir
            $this->tanggal_lahir->EditAttrs["class"] = "form-control";
            $this->tanggal_lahir->EditCustomAttributes = "";
            $this->tanggal_lahir->EditValue = HtmlEncode(FormatDateTime($this->tanggal_lahir->CurrentValue, 8));
            $this->tanggal_lahir->PlaceHolder = RemoveHtml($this->tanggal_lahir->caption());

            // jenis_kelamin
            $this->jenis_kelamin->EditAttrs["class"] = "form-control";
            $this->jenis_kelamin->EditCustomAttributes = "";
            $this->jenis_kelamin->EditValue = $this->jenis_kelamin->options(true);
            $this->jenis_kelamin->PlaceHolder = RemoveHtml($this->jenis_kelamin->caption());

            // no_telpon
            $this->no_telpon->EditAttrs["class"] = "form-control";
            $this->no_telpon->EditCustomAttributes = "";
            if (!$this->no_telpon->Raw) {
                $this->no_telpon->CurrentValue = HtmlDecode($this->no_telpon->CurrentValue);
            }
            $this->no_telpon->EditValue = HtmlEncode($this->no_telpon->CurrentValue);
            $this->no_telpon->PlaceHolder = RemoveHtml($this->no_telpon->caption());

            // email
            $this->_email->EditAttrs["class"] = "form-control";
            $this->_email->EditCustomAttributes = "";
            if (!$this->_email->Raw) {
                $this->_email->CurrentValue = HtmlDecode($this->_email->CurrentValue);
            }
            $this->_email->EditValue = HtmlEncode($this->_email->CurrentValue);
            $this->_email->PlaceHolder = RemoveHtml($this->_email->caption());

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
            if (!EmptyValue($this->jenis_kelamin->CurrentValue)) {
                $this->legalitas->Upload->FileName = $this->jenis_kelamin->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->legalitas);
            }

            // Add refer script

            // nama
            $this->nama->LinkCustomAttributes = "";
            $this->nama->HrefValue = "";

            // asal_sekolah
            $this->asal_sekolah->LinkCustomAttributes = "";
            $this->asal_sekolah->HrefValue = "";

            // tempat_lahir
            $this->tempat_lahir->LinkCustomAttributes = "";
            $this->tempat_lahir->HrefValue = "";

            // tanggal_lahir
            $this->tanggal_lahir->LinkCustomAttributes = "";
            $this->tanggal_lahir->HrefValue = "";

            // jenis_kelamin
            $this->jenis_kelamin->LinkCustomAttributes = "";
            $this->jenis_kelamin->HrefValue = "";

            // no_telpon
            $this->no_telpon->LinkCustomAttributes = "";
            $this->no_telpon->HrefValue = "";

            // email
            $this->_email->LinkCustomAttributes = "";
            $this->_email->HrefValue = "";

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
        if ($this->asal_sekolah->Required) {
            if (!$this->asal_sekolah->IsDetailKey && EmptyValue($this->asal_sekolah->FormValue)) {
                $this->asal_sekolah->addErrorMessage(str_replace("%s", $this->asal_sekolah->caption(), $this->asal_sekolah->RequiredErrorMessage));
            }
        }
        if ($this->tempat_lahir->Required) {
            if (!$this->tempat_lahir->IsDetailKey && EmptyValue($this->tempat_lahir->FormValue)) {
                $this->tempat_lahir->addErrorMessage(str_replace("%s", $this->tempat_lahir->caption(), $this->tempat_lahir->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_lahir->Required) {
            if (!$this->tanggal_lahir->IsDetailKey && EmptyValue($this->tanggal_lahir->FormValue)) {
                $this->tanggal_lahir->addErrorMessage(str_replace("%s", $this->tanggal_lahir->caption(), $this->tanggal_lahir->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_lahir->FormValue)) {
            $this->tanggal_lahir->addErrorMessage($this->tanggal_lahir->getErrorMessage(false));
        }
        if ($this->jenis_kelamin->Required) {
            if (!$this->jenis_kelamin->IsDetailKey && EmptyValue($this->jenis_kelamin->FormValue)) {
                $this->jenis_kelamin->addErrorMessage(str_replace("%s", $this->jenis_kelamin->caption(), $this->jenis_kelamin->RequiredErrorMessage));
            }
        }
        if ($this->no_telpon->Required) {
            if (!$this->no_telpon->IsDetailKey && EmptyValue($this->no_telpon->FormValue)) {
                $this->no_telpon->addErrorMessage(str_replace("%s", $this->no_telpon->caption(), $this->no_telpon->RequiredErrorMessage));
            }
        }
        if ($this->_email->Required) {
            if (!$this->_email->IsDetailKey && EmptyValue($this->_email->FormValue)) {
                $this->_email->addErrorMessage(str_replace("%s", $this->_email->caption(), $this->_email->RequiredErrorMessage));
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
        $this->nama->setDbValueDef($rsnew, $this->nama->CurrentValue, null, false);

        // asal_sekolah
        $this->asal_sekolah->setDbValueDef($rsnew, $this->asal_sekolah->CurrentValue, "", false);

        // tempat_lahir
        $this->tempat_lahir->setDbValueDef($rsnew, $this->tempat_lahir->CurrentValue, "", false);

        // tanggal_lahir
        $this->tanggal_lahir->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_lahir->CurrentValue, 0), CurrentDate(), false);

        // jenis_kelamin

        // no_telpon
        $this->no_telpon->setDbValueDef($rsnew, $this->no_telpon->CurrentValue, null, false);

        // email
        $this->_email->setDbValueDef($rsnew, $this->_email->CurrentValue, null, false);

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
                $this->legalitas->setDbValueDef($rsnew, $this->legalitas->Upload->FileName, "", false);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pelatihansiswalist"), "", $this->TableVar, true);
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
                case "x_jenis_kelamin":
                    break;
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
