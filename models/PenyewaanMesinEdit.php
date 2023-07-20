<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PenyewaanMesinEdit extends PenyewaanMesin
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'penyewaan_mesin';

    // Page object name
    public $PageObjName = "PenyewaanMesinEdit";

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

        // Table object (penyewaan_mesin)
        if (!isset($GLOBALS["penyewaan_mesin"]) || get_class($GLOBALS["penyewaan_mesin"]) == PROJECT_NAMESPACE . "penyewaan_mesin") {
            $GLOBALS["penyewaan_mesin"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'penyewaan_mesin');
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
                $doc = new $class(Container("penyewaan_mesin"));
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
                    if ($pageName == "penyewaanmesinview") {
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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->nama_mesin->setVisibility();
        $this->no_seri->setVisibility();
        $this->nama_penyewa->setVisibility();
        $this->alamat->setVisibility();
        $this->no_hp->setVisibility();
        $this->nilai_sewa->setVisibility();
        $this->created_at->Visible = false;
        $this->updated_at->Visible = false;
        $this->tanggal_sewa->setVisibility();
        $this->tanggal_kembali->setVisibility();
        $this->foto->setVisibility();
        $this->gambar_mesin->setVisibility();
        $this->keterangan->setVisibility();
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
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
                if (!$loadByQuery) {
                    $loadByPosition = true;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                $this->StartRecord = 1; // Initialize start position
                if ($rs = $this->loadRecordset()) { // Load records
                    $this->TotalRecords = $rs->recordCount(); // Get record count
                }
                if ($this->TotalRecords <= 0) { // No record found
                    if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                    }
                    $this->terminate("penyewaanmesinlist"); // Return to list page
                    return;
                } elseif ($loadByPosition) { // Load record by position
                    $this->setupStartRecord(); // Set up start record position
                    // Point to current record
                    if ($this->StartRecord <= $this->TotalRecords) {
                        $rs->move($this->StartRecord - 1);
                        $loaded = true;
                    }
                } else { // Match key values
                    if ($this->id->CurrentValue != null) {
                        while (!$rs->EOF) {
                            if (SameString($this->id->CurrentValue, $rs->fields['id'])) {
                                $this->setStartRecordNumber($this->StartRecord); // Save record position
                                $loaded = true;
                                break;
                            } else {
                                $this->StartRecord++;
                                $rs->moveNext();
                            }
                        }
                    }
                }

                // Load current row values
                if ($loaded) {
                    $this->loadRowValues($rs);
                }
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) {
                    if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                    }
                    $this->terminate("penyewaanmesinlist"); // Return to list page
                    return;
                } else {
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "penyewaanmesinlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
        $this->Pager = new PrevNextPager($this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager);

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
        $this->foto->Upload->Index = $CurrentForm->Index;
        $this->foto->Upload->uploadFile();
        $this->gambar_mesin->CurrentValue = $this->foto->Upload->FileName;
        $this->gambar_mesin->Upload->Index = $CurrentForm->Index;
        $this->gambar_mesin->Upload->uploadFile();
        $this->gambar_mesin->CurrentValue = $this->gambar_mesin->Upload->FileName;
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

        // Check field name 'no_seri' first before field var 'x_no_seri'
        $val = $CurrentForm->hasValue("no_seri") ? $CurrentForm->getValue("no_seri") : $CurrentForm->getValue("x_no_seri");
        if (!$this->no_seri->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_seri->Visible = false; // Disable update for API request
            } else {
                $this->no_seri->setFormValue($val);
            }
        }

        // Check field name 'nama_penyewa' first before field var 'x_nama_penyewa'
        $val = $CurrentForm->hasValue("nama_penyewa") ? $CurrentForm->getValue("nama_penyewa") : $CurrentForm->getValue("x_nama_penyewa");
        if (!$this->nama_penyewa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nama_penyewa->Visible = false; // Disable update for API request
            } else {
                $this->nama_penyewa->setFormValue($val);
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

        // Check field name 'no_hp' first before field var 'x_no_hp'
        $val = $CurrentForm->hasValue("no_hp") ? $CurrentForm->getValue("no_hp") : $CurrentForm->getValue("x_no_hp");
        if (!$this->no_hp->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->no_hp->Visible = false; // Disable update for API request
            } else {
                $this->no_hp->setFormValue($val);
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

        // Check field name 'tanggal_sewa' first before field var 'x_tanggal_sewa'
        $val = $CurrentForm->hasValue("tanggal_sewa") ? $CurrentForm->getValue("tanggal_sewa") : $CurrentForm->getValue("x_tanggal_sewa");
        if (!$this->tanggal_sewa->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_sewa->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_sewa->setFormValue($val);
            }
            $this->tanggal_sewa->CurrentValue = UnFormatDateTime($this->tanggal_sewa->CurrentValue, 0);
        }

        // Check field name 'tanggal_kembali' first before field var 'x_tanggal_kembali'
        $val = $CurrentForm->hasValue("tanggal_kembali") ? $CurrentForm->getValue("tanggal_kembali") : $CurrentForm->getValue("x_tanggal_kembali");
        if (!$this->tanggal_kembali->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_kembali->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_kembali->setFormValue($val);
            }
            $this->tanggal_kembali->CurrentValue = UnFormatDateTime($this->tanggal_kembali->CurrentValue, 0);
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
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->nama_mesin->CurrentValue = $this->nama_mesin->FormValue;
        $this->no_seri->CurrentValue = $this->no_seri->FormValue;
        $this->nama_penyewa->CurrentValue = $this->nama_penyewa->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->no_hp->CurrentValue = $this->no_hp->FormValue;
        $this->nilai_sewa->CurrentValue = $this->nilai_sewa->FormValue;
        $this->tanggal_sewa->CurrentValue = $this->tanggal_sewa->FormValue;
        $this->tanggal_sewa->CurrentValue = UnFormatDateTime($this->tanggal_sewa->CurrentValue, 0);
        $this->tanggal_kembali->CurrentValue = $this->tanggal_kembali->FormValue;
        $this->tanggal_kembali->CurrentValue = UnFormatDateTime($this->tanggal_kembali->CurrentValue, 0);
        $this->keterangan->CurrentValue = $this->keterangan->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
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
        $this->nama_mesin->setDbValue($row['nama_mesin']);
        $this->no_seri->setDbValue($row['no_seri']);
        $this->nama_penyewa->setDbValue($row['nama_penyewa']);
        $this->alamat->setDbValue($row['alamat']);
        $this->no_hp->setDbValue($row['no_hp']);
        $this->nilai_sewa->setDbValue($row['nilai_sewa']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
        $this->tanggal_sewa->setDbValue($row['tanggal_sewa']);
        $this->tanggal_kembali->setDbValue($row['tanggal_kembali']);
        $this->foto->Upload->DbValue = $row['foto'];
        $this->foto->setDbValue($this->foto->Upload->DbValue);
        $this->gambar_mesin->Upload->DbValue = $row['gambar_mesin'];
        $this->gambar_mesin->setDbValue($this->gambar_mesin->Upload->DbValue);
        $this->keterangan->setDbValue($row['keterangan']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['nama_mesin'] = null;
        $row['no_seri'] = null;
        $row['nama_penyewa'] = null;
        $row['alamat'] = null;
        $row['no_hp'] = null;
        $row['nilai_sewa'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
        $row['tanggal_sewa'] = null;
        $row['tanggal_kembali'] = null;
        $row['foto'] = null;
        $row['gambar_mesin'] = null;
        $row['keterangan'] = null;
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

        // nama_mesin

        // no_seri

        // nama_penyewa

        // alamat

        // no_hp

        // nilai_sewa

        // created_at

        // updated_at

        // tanggal_sewa

        // tanggal_kembali

        // foto

        // gambar_mesin

        // keterangan
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nama_mesin
            $this->nama_mesin->ViewValue = $this->nama_mesin->CurrentValue;
            $this->nama_mesin->ViewCustomAttributes = "";

            // no_seri
            $this->no_seri->ViewValue = $this->no_seri->CurrentValue;
            $this->no_seri->ViewCustomAttributes = "";

            // nama_penyewa
            $this->nama_penyewa->ViewValue = $this->nama_penyewa->CurrentValue;
            $this->nama_penyewa->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // no_hp
            $this->no_hp->ViewValue = $this->no_hp->CurrentValue;
            $this->no_hp->ViewCustomAttributes = "";

            // nilai_sewa
            $this->nilai_sewa->ViewValue = $this->nilai_sewa->CurrentValue;
            $this->nilai_sewa->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // tanggal_sewa
            $this->tanggal_sewa->ViewValue = $this->tanggal_sewa->CurrentValue;
            $this->tanggal_sewa->ViewValue = FormatDateTime($this->tanggal_sewa->ViewValue, 0);
            $this->tanggal_sewa->ViewCustomAttributes = "";

            // tanggal_kembali
            $this->tanggal_kembali->ViewValue = $this->tanggal_kembali->CurrentValue;
            $this->tanggal_kembali->ViewValue = FormatDateTime($this->tanggal_kembali->ViewValue, 0);
            $this->tanggal_kembali->ViewCustomAttributes = "";

            // foto
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 200;
                $this->foto->ImageHeight = 0;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->ViewValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->ViewValue = "";
            }
            $this->foto->ViewCustomAttributes = "";

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

            // keterangan
            $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
            $this->keterangan->ViewCustomAttributes = "";

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";
            $this->nama_mesin->TooltipValue = "";

            // no_seri
            $this->no_seri->LinkCustomAttributes = "";
            $this->no_seri->HrefValue = "";
            $this->no_seri->TooltipValue = "";

            // nama_penyewa
            $this->nama_penyewa->LinkCustomAttributes = "";
            $this->nama_penyewa->HrefValue = "";
            $this->nama_penyewa->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // no_hp
            $this->no_hp->LinkCustomAttributes = "";
            $this->no_hp->HrefValue = "";
            $this->no_hp->TooltipValue = "";

            // nilai_sewa
            $this->nilai_sewa->LinkCustomAttributes = "";
            $this->nilai_sewa->HrefValue = "";
            $this->nilai_sewa->TooltipValue = "";

            // tanggal_sewa
            $this->tanggal_sewa->LinkCustomAttributes = "";
            $this->tanggal_sewa->HrefValue = "";
            $this->tanggal_sewa->TooltipValue = "";

            // tanggal_kembali
            $this->tanggal_kembali->LinkCustomAttributes = "";
            $this->tanggal_kembali->HrefValue = "";
            $this->tanggal_kembali->TooltipValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = GetFileUploadUrl($this->foto, $this->foto->htmlDecode($this->foto->Upload->DbValue)); // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;
            $this->foto->TooltipValue = "";
            if ($this->foto->UseColorbox) {
                if (EmptyValue($this->foto->TooltipValue)) {
                    $this->foto->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto->LinkAttrs["data-rel"] = "penyewaan_mesin_x_foto";
                $this->foto->LinkAttrs->appendClass("ew-lightbox");
            }

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
                $this->gambar_mesin->LinkAttrs["data-rel"] = "penyewaan_mesin_x_gambar_mesin";
                $this->gambar_mesin->LinkAttrs->appendClass("ew-lightbox");
            }

            // keterangan
            $this->keterangan->LinkCustomAttributes = "";
            $this->keterangan->HrefValue = "";
            $this->keterangan->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // nama_mesin
            $this->nama_mesin->EditAttrs["class"] = "form-control";
            $this->nama_mesin->EditCustomAttributes = "";
            if (!$this->nama_mesin->Raw) {
                $this->nama_mesin->CurrentValue = HtmlDecode($this->nama_mesin->CurrentValue);
            }
            $this->nama_mesin->EditValue = HtmlEncode($this->nama_mesin->CurrentValue);
            $this->nama_mesin->PlaceHolder = RemoveHtml($this->nama_mesin->caption());

            // no_seri
            $this->no_seri->EditAttrs["class"] = "form-control";
            $this->no_seri->EditCustomAttributes = "";
            if (!$this->no_seri->Raw) {
                $this->no_seri->CurrentValue = HtmlDecode($this->no_seri->CurrentValue);
            }
            $this->no_seri->EditValue = HtmlEncode($this->no_seri->CurrentValue);
            $this->no_seri->PlaceHolder = RemoveHtml($this->no_seri->caption());

            // nama_penyewa
            $this->nama_penyewa->EditAttrs["class"] = "form-control";
            $this->nama_penyewa->EditCustomAttributes = "";
            if (!$this->nama_penyewa->Raw) {
                $this->nama_penyewa->CurrentValue = HtmlDecode($this->nama_penyewa->CurrentValue);
            }
            $this->nama_penyewa->EditValue = HtmlEncode($this->nama_penyewa->CurrentValue);
            $this->nama_penyewa->PlaceHolder = RemoveHtml($this->nama_penyewa->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // no_hp
            $this->no_hp->EditAttrs["class"] = "form-control";
            $this->no_hp->EditCustomAttributes = "";
            if (!$this->no_hp->Raw) {
                $this->no_hp->CurrentValue = HtmlDecode($this->no_hp->CurrentValue);
            }
            $this->no_hp->EditValue = HtmlEncode($this->no_hp->CurrentValue);
            $this->no_hp->PlaceHolder = RemoveHtml($this->no_hp->caption());

            // nilai_sewa
            $this->nilai_sewa->EditAttrs["class"] = "form-control";
            $this->nilai_sewa->EditCustomAttributes = "";
            if (!$this->nilai_sewa->Raw) {
                $this->nilai_sewa->CurrentValue = HtmlDecode($this->nilai_sewa->CurrentValue);
            }
            $this->nilai_sewa->EditValue = HtmlEncode($this->nilai_sewa->CurrentValue);
            $this->nilai_sewa->PlaceHolder = RemoveHtml($this->nilai_sewa->caption());

            // tanggal_sewa
            $this->tanggal_sewa->EditAttrs["class"] = "form-control";
            $this->tanggal_sewa->EditCustomAttributes = "";
            $this->tanggal_sewa->EditValue = HtmlEncode(FormatDateTime($this->tanggal_sewa->CurrentValue, 8));
            $this->tanggal_sewa->PlaceHolder = RemoveHtml($this->tanggal_sewa->caption());

            // tanggal_kembali
            $this->tanggal_kembali->EditAttrs["class"] = "form-control";
            $this->tanggal_kembali->EditCustomAttributes = "";
            $this->tanggal_kembali->EditValue = HtmlEncode(FormatDateTime($this->tanggal_kembali->CurrentValue, 8));
            $this->tanggal_kembali->PlaceHolder = RemoveHtml($this->tanggal_kembali->caption());

            // foto
            $this->foto->EditAttrs["class"] = "form-control";
            $this->foto->EditCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->ImageWidth = 200;
                $this->foto->ImageHeight = 0;
                $this->foto->ImageAlt = $this->foto->alt();
                $this->foto->EditValue = $this->foto->Upload->DbValue;
            } else {
                $this->foto->EditValue = "";
            }
            if (!EmptyValue($this->gambar_mesin->CurrentValue)) {
                $this->foto->Upload->FileName = $this->gambar_mesin->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->foto);
            }

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
            if ($this->isShow()) {
                RenderUploadField($this->gambar_mesin);
            }

            // keterangan
            $this->keterangan->EditAttrs["class"] = "form-control";
            $this->keterangan->EditCustomAttributes = "";
            $this->keterangan->EditValue = HtmlEncode($this->keterangan->CurrentValue);
            $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

            // Edit refer script

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";

            // no_seri
            $this->no_seri->LinkCustomAttributes = "";
            $this->no_seri->HrefValue = "";

            // nama_penyewa
            $this->nama_penyewa->LinkCustomAttributes = "";
            $this->nama_penyewa->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // no_hp
            $this->no_hp->LinkCustomAttributes = "";
            $this->no_hp->HrefValue = "";

            // nilai_sewa
            $this->nilai_sewa->LinkCustomAttributes = "";
            $this->nilai_sewa->HrefValue = "";

            // tanggal_sewa
            $this->tanggal_sewa->LinkCustomAttributes = "";
            $this->tanggal_sewa->HrefValue = "";

            // tanggal_kembali
            $this->tanggal_kembali->LinkCustomAttributes = "";
            $this->tanggal_kembali->HrefValue = "";

            // foto
            $this->foto->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto->Upload->DbValue)) {
                $this->foto->HrefValue = GetFileUploadUrl($this->foto, $this->foto->htmlDecode($this->foto->Upload->DbValue)); // Add prefix/suffix
                $this->foto->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto->HrefValue = FullUrl($this->foto->HrefValue, "href");
                }
            } else {
                $this->foto->HrefValue = "";
            }
            $this->foto->ExportHrefValue = $this->foto->UploadPath . $this->foto->Upload->DbValue;

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
        if ($this->nama_mesin->Required) {
            if (!$this->nama_mesin->IsDetailKey && EmptyValue($this->nama_mesin->FormValue)) {
                $this->nama_mesin->addErrorMessage(str_replace("%s", $this->nama_mesin->caption(), $this->nama_mesin->RequiredErrorMessage));
            }
        }
        if ($this->no_seri->Required) {
            if (!$this->no_seri->IsDetailKey && EmptyValue($this->no_seri->FormValue)) {
                $this->no_seri->addErrorMessage(str_replace("%s", $this->no_seri->caption(), $this->no_seri->RequiredErrorMessage));
            }
        }
        if ($this->nama_penyewa->Required) {
            if (!$this->nama_penyewa->IsDetailKey && EmptyValue($this->nama_penyewa->FormValue)) {
                $this->nama_penyewa->addErrorMessage(str_replace("%s", $this->nama_penyewa->caption(), $this->nama_penyewa->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->no_hp->Required) {
            if (!$this->no_hp->IsDetailKey && EmptyValue($this->no_hp->FormValue)) {
                $this->no_hp->addErrorMessage(str_replace("%s", $this->no_hp->caption(), $this->no_hp->RequiredErrorMessage));
            }
        }
        if ($this->nilai_sewa->Required) {
            if (!$this->nilai_sewa->IsDetailKey && EmptyValue($this->nilai_sewa->FormValue)) {
                $this->nilai_sewa->addErrorMessage(str_replace("%s", $this->nilai_sewa->caption(), $this->nilai_sewa->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_sewa->Required) {
            if (!$this->tanggal_sewa->IsDetailKey && EmptyValue($this->tanggal_sewa->FormValue)) {
                $this->tanggal_sewa->addErrorMessage(str_replace("%s", $this->tanggal_sewa->caption(), $this->tanggal_sewa->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_sewa->FormValue)) {
            $this->tanggal_sewa->addErrorMessage($this->tanggal_sewa->getErrorMessage(false));
        }
        if ($this->tanggal_kembali->Required) {
            if (!$this->tanggal_kembali->IsDetailKey && EmptyValue($this->tanggal_kembali->FormValue)) {
                $this->tanggal_kembali->addErrorMessage(str_replace("%s", $this->tanggal_kembali->caption(), $this->tanggal_kembali->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_kembali->FormValue)) {
            $this->tanggal_kembali->addErrorMessage($this->tanggal_kembali->getErrorMessage(false));
        }
        if ($this->foto->Required) {
            if ($this->foto->Upload->FileName == "" && !$this->foto->Upload->KeepFile) {
                $this->foto->addErrorMessage(str_replace("%s", $this->foto->caption(), $this->foto->RequiredErrorMessage));
            }
        }
        if ($this->gambar_mesin->Required) {
            if ($this->gambar_mesin->Upload->FileName == "" && !$this->gambar_mesin->Upload->KeepFile) {
                $this->gambar_mesin->addErrorMessage(str_replace("%s", $this->gambar_mesin->caption(), $this->gambar_mesin->RequiredErrorMessage));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // nama_mesin
            $this->nama_mesin->setDbValueDef($rsnew, $this->nama_mesin->CurrentValue, "", $this->nama_mesin->ReadOnly);

            // no_seri
            $this->no_seri->setDbValueDef($rsnew, $this->no_seri->CurrentValue, "", $this->no_seri->ReadOnly);

            // nama_penyewa
            $this->nama_penyewa->setDbValueDef($rsnew, $this->nama_penyewa->CurrentValue, "", $this->nama_penyewa->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, "", $this->alamat->ReadOnly);

            // no_hp
            $this->no_hp->setDbValueDef($rsnew, $this->no_hp->CurrentValue, "", $this->no_hp->ReadOnly);

            // nilai_sewa
            $this->nilai_sewa->setDbValueDef($rsnew, $this->nilai_sewa->CurrentValue, "", $this->nilai_sewa->ReadOnly);

            // tanggal_sewa
            $this->tanggal_sewa->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_sewa->CurrentValue, 0), CurrentDate(), $this->tanggal_sewa->ReadOnly);

            // tanggal_kembali
            $this->tanggal_kembali->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_kembali->CurrentValue, 0), CurrentDate(), $this->tanggal_kembali->ReadOnly);

            // foto
            if ($this->foto->Visible && !$this->foto->ReadOnly && !$this->foto->Upload->KeepFile) {
                $this->foto->Upload->DbValue = $rsold['foto']; // Get original value
                if ($this->foto->Upload->FileName == "") {
                    $rsnew['foto'] = null;
                } else {
                    $rsnew['foto'] = $this->foto->Upload->FileName;
                }
                $this->foto->ImageWidth = 1000; // Resize width
                $this->foto->ImageHeight = 0; // Resize height
            }

            // gambar_mesin

            // keterangan
            $this->keterangan->setDbValueDef($rsnew, $this->keterangan->CurrentValue, null, $this->keterangan->ReadOnly);
            if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
                if (!EmptyValue($this->foto->Upload->FileName)) {
                    $newFiles = [$this->foto->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->foto, $this->foto->Upload->Index);
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
                                $file1 = UniqueFilename($this->foto->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->foto->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->foto->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->foto->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->foto->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->foto->setDbValueDef($rsnew, $this->foto->Upload->FileName, null, $this->foto->ReadOnly);
                }
            }
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
                    $this->gambar_mesin->setDbValueDef($rsnew, $this->gambar_mesin->Upload->FileName, null, $this->gambar_mesin->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->foto->Visible && !$this->foto->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->foto->Upload->DbValue) ? [] : [$this->foto->htmlDecode($this->foto->Upload->DbValue)];
                        if (!EmptyValue($this->foto->Upload->FileName)) {
                            $newFiles = [$this->foto->Upload->FileName];
                            $newFiles2 = [$this->foto->htmlDecode($rsnew['foto'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->foto, $this->foto->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->foto->Upload->ResizeAndSaveToFile($this->foto->ImageWidth, $this->foto->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->foto->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
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
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // foto
            CleanUploadTempPath($this->foto, $this->foto->Upload->Index);

            // gambar_mesin
            CleanUploadTempPath($this->gambar_mesin, $this->gambar_mesin->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("penyewaanmesinlist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
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
