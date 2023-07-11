<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PembuatanMesinEdit extends PembuatanMesin
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'pembuatan_mesin';

    // Page object name
    public $PageObjName = "PembuatanMesinEdit";

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

        // Table object (pembuatan_mesin)
        if (!isset($GLOBALS["pembuatan_mesin"]) || get_class($GLOBALS["pembuatan_mesin"]) == PROJECT_NAMESPACE . "pembuatan_mesin") {
            $GLOBALS["pembuatan_mesin"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'pembuatan_mesin');
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
                $doc = new $class(Container("pembuatan_mesin"));
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
                    if ($pageName == "pembuatanmesinview") {
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

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->Visible = false;
        $this->nama_mesin->setVisibility();
        $this->spesifikasi->setVisibility();
        $this->jumlah->setVisibility();
        $this->lama_pembuatan->setVisibility();
        $this->pemesan->setVisibility();
        $this->alamat->setVisibility();
        $this->nomor_kontrak->setVisibility();
        $this->tanggal_kontrak->setVisibility();
        $this->nilai_kontrak->setVisibility();
        $this->upload_ktp->setVisibility();
        $this->foto_mesin->setVisibility();
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
                    $this->terminate("pembuatanmesinlist"); // Return to list page
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
                    $this->terminate("pembuatanmesinlist"); // Return to list page
                    return;
                } else {
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "pembuatanmesinlist") {
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
        $this->upload_ktp->Upload->Index = $CurrentForm->Index;
        $this->upload_ktp->Upload->uploadFile();
        $this->upload_ktp->CurrentValue = $this->upload_ktp->Upload->FileName;
        $this->foto_mesin->Upload->Index = $CurrentForm->Index;
        $this->foto_mesin->Upload->uploadFile();
        $this->foto_mesin->CurrentValue = $this->foto_mesin->Upload->FileName;
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

        // Check field name 'spesifikasi' first before field var 'x_spesifikasi'
        $val = $CurrentForm->hasValue("spesifikasi") ? $CurrentForm->getValue("spesifikasi") : $CurrentForm->getValue("x_spesifikasi");
        if (!$this->spesifikasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->spesifikasi->Visible = false; // Disable update for API request
            } else {
                $this->spesifikasi->setFormValue($val);
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

        // Check field name 'lama_pembuatan' first before field var 'x_lama_pembuatan'
        $val = $CurrentForm->hasValue("lama_pembuatan") ? $CurrentForm->getValue("lama_pembuatan") : $CurrentForm->getValue("x_lama_pembuatan");
        if (!$this->lama_pembuatan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lama_pembuatan->Visible = false; // Disable update for API request
            } else {
                $this->lama_pembuatan->setFormValue($val);
            }
        }

        // Check field name 'pemesan' first before field var 'x_pemesan'
        $val = $CurrentForm->hasValue("pemesan") ? $CurrentForm->getValue("pemesan") : $CurrentForm->getValue("x_pemesan");
        if (!$this->pemesan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->pemesan->Visible = false; // Disable update for API request
            } else {
                $this->pemesan->setFormValue($val);
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

        // Check field name 'nomor_kontrak' first before field var 'x_nomor_kontrak'
        $val = $CurrentForm->hasValue("nomor_kontrak") ? $CurrentForm->getValue("nomor_kontrak") : $CurrentForm->getValue("x_nomor_kontrak");
        if (!$this->nomor_kontrak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nomor_kontrak->Visible = false; // Disable update for API request
            } else {
                $this->nomor_kontrak->setFormValue($val);
            }
        }

        // Check field name 'tanggal_kontrak' first before field var 'x_tanggal_kontrak'
        $val = $CurrentForm->hasValue("tanggal_kontrak") ? $CurrentForm->getValue("tanggal_kontrak") : $CurrentForm->getValue("x_tanggal_kontrak");
        if (!$this->tanggal_kontrak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal_kontrak->Visible = false; // Disable update for API request
            } else {
                $this->tanggal_kontrak->setFormValue($val);
            }
            $this->tanggal_kontrak->CurrentValue = UnFormatDateTime($this->tanggal_kontrak->CurrentValue, 0);
        }

        // Check field name 'nilai_kontrak' first before field var 'x_nilai_kontrak'
        $val = $CurrentForm->hasValue("nilai_kontrak") ? $CurrentForm->getValue("nilai_kontrak") : $CurrentForm->getValue("x_nilai_kontrak");
        if (!$this->nilai_kontrak->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->nilai_kontrak->Visible = false; // Disable update for API request
            } else {
                $this->nilai_kontrak->setFormValue($val);
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
        $this->spesifikasi->CurrentValue = $this->spesifikasi->FormValue;
        $this->jumlah->CurrentValue = $this->jumlah->FormValue;
        $this->lama_pembuatan->CurrentValue = $this->lama_pembuatan->FormValue;
        $this->pemesan->CurrentValue = $this->pemesan->FormValue;
        $this->alamat->CurrentValue = $this->alamat->FormValue;
        $this->nomor_kontrak->CurrentValue = $this->nomor_kontrak->FormValue;
        $this->tanggal_kontrak->CurrentValue = $this->tanggal_kontrak->FormValue;
        $this->tanggal_kontrak->CurrentValue = UnFormatDateTime($this->tanggal_kontrak->CurrentValue, 0);
        $this->nilai_kontrak->CurrentValue = $this->nilai_kontrak->FormValue;
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
        $this->spesifikasi->setDbValue($row['spesifikasi']);
        $this->jumlah->setDbValue($row['jumlah']);
        $this->lama_pembuatan->setDbValue($row['lama_pembuatan']);
        $this->pemesan->setDbValue($row['pemesan']);
        $this->alamat->setDbValue($row['alamat']);
        $this->nomor_kontrak->setDbValue($row['nomor_kontrak']);
        $this->tanggal_kontrak->setDbValue($row['tanggal_kontrak']);
        $this->nilai_kontrak->setDbValue($row['nilai_kontrak']);
        $this->upload_ktp->Upload->DbValue = $row['upload_ktp'];
        $this->upload_ktp->setDbValue($this->upload_ktp->Upload->DbValue);
        $this->foto_mesin->Upload->DbValue = $row['foto_mesin'];
        $this->foto_mesin->setDbValue($this->foto_mesin->Upload->DbValue);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['nama_mesin'] = null;
        $row['spesifikasi'] = null;
        $row['jumlah'] = null;
        $row['lama_pembuatan'] = null;
        $row['pemesan'] = null;
        $row['alamat'] = null;
        $row['nomor_kontrak'] = null;
        $row['tanggal_kontrak'] = null;
        $row['nilai_kontrak'] = null;
        $row['upload_ktp'] = null;
        $row['foto_mesin'] = null;
        $row['created_at'] = null;
        $row['updated_at'] = null;
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

        // spesifikasi

        // jumlah

        // lama_pembuatan

        // pemesan

        // alamat

        // nomor_kontrak

        // tanggal_kontrak

        // nilai_kontrak

        // upload_ktp

        // foto_mesin

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // nama_mesin
            $this->nama_mesin->ViewValue = $this->nama_mesin->CurrentValue;
            $this->nama_mesin->ViewCustomAttributes = "";

            // spesifikasi
            $this->spesifikasi->ViewValue = $this->spesifikasi->CurrentValue;
            $this->spesifikasi->ViewCustomAttributes = "";

            // jumlah
            $this->jumlah->ViewValue = $this->jumlah->CurrentValue;
            $this->jumlah->ViewCustomAttributes = "";

            // lama_pembuatan
            $this->lama_pembuatan->ViewValue = $this->lama_pembuatan->CurrentValue;
            $this->lama_pembuatan->ViewCustomAttributes = "";

            // pemesan
            $this->pemesan->ViewValue = $this->pemesan->CurrentValue;
            $this->pemesan->ViewCustomAttributes = "";

            // alamat
            $this->alamat->ViewValue = $this->alamat->CurrentValue;
            $this->alamat->ViewCustomAttributes = "";

            // nomor_kontrak
            $this->nomor_kontrak->ViewValue = $this->nomor_kontrak->CurrentValue;
            $this->nomor_kontrak->ViewCustomAttributes = "";

            // tanggal_kontrak
            $this->tanggal_kontrak->ViewValue = $this->tanggal_kontrak->CurrentValue;
            $this->tanggal_kontrak->ViewValue = FormatDateTime($this->tanggal_kontrak->ViewValue, 0);
            $this->tanggal_kontrak->ViewCustomAttributes = "";

            // nilai_kontrak
            $this->nilai_kontrak->ViewValue = $this->nilai_kontrak->CurrentValue;
            $this->nilai_kontrak->ViewCustomAttributes = "";

            // upload_ktp
            if (!EmptyValue($this->upload_ktp->Upload->DbValue)) {
                $this->upload_ktp->ImageWidth = 200;
                $this->upload_ktp->ImageHeight = 0;
                $this->upload_ktp->ImageAlt = $this->upload_ktp->alt();
                $this->upload_ktp->ViewValue = $this->upload_ktp->Upload->DbValue;
            } else {
                $this->upload_ktp->ViewValue = "";
            }
            $this->upload_ktp->ViewCustomAttributes = "";

            // foto_mesin
            if (!EmptyValue($this->foto_mesin->Upload->DbValue)) {
                $this->foto_mesin->ImageWidth = 200;
                $this->foto_mesin->ImageHeight = 0;
                $this->foto_mesin->ImageAlt = $this->foto_mesin->alt();
                $this->foto_mesin->ViewValue = $this->foto_mesin->Upload->DbValue;
            } else {
                $this->foto_mesin->ViewValue = "";
            }
            $this->foto_mesin->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";
            $this->nama_mesin->TooltipValue = "";

            // spesifikasi
            $this->spesifikasi->LinkCustomAttributes = "";
            $this->spesifikasi->HrefValue = "";
            $this->spesifikasi->TooltipValue = "";

            // jumlah
            $this->jumlah->LinkCustomAttributes = "";
            $this->jumlah->HrefValue = "";
            $this->jumlah->TooltipValue = "";

            // lama_pembuatan
            $this->lama_pembuatan->LinkCustomAttributes = "";
            $this->lama_pembuatan->HrefValue = "";
            $this->lama_pembuatan->TooltipValue = "";

            // pemesan
            $this->pemesan->LinkCustomAttributes = "";
            $this->pemesan->HrefValue = "";
            $this->pemesan->TooltipValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";
            $this->alamat->TooltipValue = "";

            // nomor_kontrak
            $this->nomor_kontrak->LinkCustomAttributes = "";
            $this->nomor_kontrak->HrefValue = "";
            $this->nomor_kontrak->TooltipValue = "";

            // tanggal_kontrak
            $this->tanggal_kontrak->LinkCustomAttributes = "";
            $this->tanggal_kontrak->HrefValue = "";
            $this->tanggal_kontrak->TooltipValue = "";

            // nilai_kontrak
            $this->nilai_kontrak->LinkCustomAttributes = "";
            $this->nilai_kontrak->HrefValue = "";
            $this->nilai_kontrak->TooltipValue = "";

            // upload_ktp
            $this->upload_ktp->LinkCustomAttributes = "";
            if (!EmptyValue($this->upload_ktp->Upload->DbValue)) {
                $this->upload_ktp->HrefValue = GetFileUploadUrl($this->upload_ktp, $this->upload_ktp->htmlDecode($this->upload_ktp->Upload->DbValue)); // Add prefix/suffix
                $this->upload_ktp->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->upload_ktp->HrefValue = FullUrl($this->upload_ktp->HrefValue, "href");
                }
            } else {
                $this->upload_ktp->HrefValue = "";
            }
            $this->upload_ktp->ExportHrefValue = $this->upload_ktp->UploadPath . $this->upload_ktp->Upload->DbValue;
            $this->upload_ktp->TooltipValue = "";
            if ($this->upload_ktp->UseColorbox) {
                if (EmptyValue($this->upload_ktp->TooltipValue)) {
                    $this->upload_ktp->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->upload_ktp->LinkAttrs["data-rel"] = "pembuatan_mesin_x_upload_ktp";
                $this->upload_ktp->LinkAttrs->appendClass("ew-lightbox");
            }

            // foto_mesin
            $this->foto_mesin->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto_mesin->Upload->DbValue)) {
                $this->foto_mesin->HrefValue = GetFileUploadUrl($this->foto_mesin, $this->foto_mesin->htmlDecode($this->foto_mesin->Upload->DbValue)); // Add prefix/suffix
                $this->foto_mesin->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto_mesin->HrefValue = FullUrl($this->foto_mesin->HrefValue, "href");
                }
            } else {
                $this->foto_mesin->HrefValue = "";
            }
            $this->foto_mesin->ExportHrefValue = $this->foto_mesin->UploadPath . $this->foto_mesin->Upload->DbValue;
            $this->foto_mesin->TooltipValue = "";
            if ($this->foto_mesin->UseColorbox) {
                if (EmptyValue($this->foto_mesin->TooltipValue)) {
                    $this->foto_mesin->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
                }
                $this->foto_mesin->LinkAttrs["data-rel"] = "pembuatan_mesin_x_foto_mesin";
                $this->foto_mesin->LinkAttrs->appendClass("ew-lightbox");
            }
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // nama_mesin
            $this->nama_mesin->EditAttrs["class"] = "form-control";
            $this->nama_mesin->EditCustomAttributes = "";
            if (!$this->nama_mesin->Raw) {
                $this->nama_mesin->CurrentValue = HtmlDecode($this->nama_mesin->CurrentValue);
            }
            $this->nama_mesin->EditValue = HtmlEncode($this->nama_mesin->CurrentValue);
            $this->nama_mesin->PlaceHolder = RemoveHtml($this->nama_mesin->caption());

            // spesifikasi
            $this->spesifikasi->EditAttrs["class"] = "form-control";
            $this->spesifikasi->EditCustomAttributes = "";
            $this->spesifikasi->EditValue = HtmlEncode($this->spesifikasi->CurrentValue);
            $this->spesifikasi->PlaceHolder = RemoveHtml($this->spesifikasi->caption());

            // jumlah
            $this->jumlah->EditAttrs["class"] = "form-control";
            $this->jumlah->EditCustomAttributes = "";
            if (!$this->jumlah->Raw) {
                $this->jumlah->CurrentValue = HtmlDecode($this->jumlah->CurrentValue);
            }
            $this->jumlah->EditValue = HtmlEncode($this->jumlah->CurrentValue);
            $this->jumlah->PlaceHolder = RemoveHtml($this->jumlah->caption());

            // lama_pembuatan
            $this->lama_pembuatan->EditAttrs["class"] = "form-control";
            $this->lama_pembuatan->EditCustomAttributes = "";
            if (!$this->lama_pembuatan->Raw) {
                $this->lama_pembuatan->CurrentValue = HtmlDecode($this->lama_pembuatan->CurrentValue);
            }
            $this->lama_pembuatan->EditValue = HtmlEncode($this->lama_pembuatan->CurrentValue);
            $this->lama_pembuatan->PlaceHolder = RemoveHtml($this->lama_pembuatan->caption());

            // pemesan
            $this->pemesan->EditAttrs["class"] = "form-control";
            $this->pemesan->EditCustomAttributes = "";
            if (!$this->pemesan->Raw) {
                $this->pemesan->CurrentValue = HtmlDecode($this->pemesan->CurrentValue);
            }
            $this->pemesan->EditValue = HtmlEncode($this->pemesan->CurrentValue);
            $this->pemesan->PlaceHolder = RemoveHtml($this->pemesan->caption());

            // alamat
            $this->alamat->EditAttrs["class"] = "form-control";
            $this->alamat->EditCustomAttributes = "";
            if (!$this->alamat->Raw) {
                $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
            }
            $this->alamat->EditValue = HtmlEncode($this->alamat->CurrentValue);
            $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

            // nomor_kontrak
            $this->nomor_kontrak->EditAttrs["class"] = "form-control";
            $this->nomor_kontrak->EditCustomAttributes = "";
            if (!$this->nomor_kontrak->Raw) {
                $this->nomor_kontrak->CurrentValue = HtmlDecode($this->nomor_kontrak->CurrentValue);
            }
            $this->nomor_kontrak->EditValue = HtmlEncode($this->nomor_kontrak->CurrentValue);
            $this->nomor_kontrak->PlaceHolder = RemoveHtml($this->nomor_kontrak->caption());

            // tanggal_kontrak
            $this->tanggal_kontrak->EditAttrs["class"] = "form-control";
            $this->tanggal_kontrak->EditCustomAttributes = "";
            $this->tanggal_kontrak->EditValue = HtmlEncode(FormatDateTime($this->tanggal_kontrak->CurrentValue, 8));
            $this->tanggal_kontrak->PlaceHolder = RemoveHtml($this->tanggal_kontrak->caption());

            // nilai_kontrak
            $this->nilai_kontrak->EditAttrs["class"] = "form-control";
            $this->nilai_kontrak->EditCustomAttributes = "";
            if (!$this->nilai_kontrak->Raw) {
                $this->nilai_kontrak->CurrentValue = HtmlDecode($this->nilai_kontrak->CurrentValue);
            }
            $this->nilai_kontrak->EditValue = HtmlEncode($this->nilai_kontrak->CurrentValue);
            $this->nilai_kontrak->PlaceHolder = RemoveHtml($this->nilai_kontrak->caption());

            // upload_ktp
            $this->upload_ktp->EditAttrs["class"] = "form-control";
            $this->upload_ktp->EditCustomAttributes = "";
            if (!EmptyValue($this->upload_ktp->Upload->DbValue)) {
                $this->upload_ktp->ImageWidth = 200;
                $this->upload_ktp->ImageHeight = 0;
                $this->upload_ktp->ImageAlt = $this->upload_ktp->alt();
                $this->upload_ktp->EditValue = $this->upload_ktp->Upload->DbValue;
            } else {
                $this->upload_ktp->EditValue = "";
            }
            if (!EmptyValue($this->upload_ktp->CurrentValue)) {
                $this->upload_ktp->Upload->FileName = $this->upload_ktp->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->upload_ktp);
            }

            // foto_mesin
            $this->foto_mesin->EditAttrs["class"] = "form-control";
            $this->foto_mesin->EditCustomAttributes = "";
            if (!EmptyValue($this->foto_mesin->Upload->DbValue)) {
                $this->foto_mesin->ImageWidth = 200;
                $this->foto_mesin->ImageHeight = 0;
                $this->foto_mesin->ImageAlt = $this->foto_mesin->alt();
                $this->foto_mesin->EditValue = $this->foto_mesin->Upload->DbValue;
            } else {
                $this->foto_mesin->EditValue = "";
            }
            if (!EmptyValue($this->foto_mesin->CurrentValue)) {
                $this->foto_mesin->Upload->FileName = $this->foto_mesin->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->foto_mesin);
            }

            // Edit refer script

            // nama_mesin
            $this->nama_mesin->LinkCustomAttributes = "";
            $this->nama_mesin->HrefValue = "";

            // spesifikasi
            $this->spesifikasi->LinkCustomAttributes = "";
            $this->spesifikasi->HrefValue = "";

            // jumlah
            $this->jumlah->LinkCustomAttributes = "";
            $this->jumlah->HrefValue = "";

            // lama_pembuatan
            $this->lama_pembuatan->LinkCustomAttributes = "";
            $this->lama_pembuatan->HrefValue = "";

            // pemesan
            $this->pemesan->LinkCustomAttributes = "";
            $this->pemesan->HrefValue = "";

            // alamat
            $this->alamat->LinkCustomAttributes = "";
            $this->alamat->HrefValue = "";

            // nomor_kontrak
            $this->nomor_kontrak->LinkCustomAttributes = "";
            $this->nomor_kontrak->HrefValue = "";

            // tanggal_kontrak
            $this->tanggal_kontrak->LinkCustomAttributes = "";
            $this->tanggal_kontrak->HrefValue = "";

            // nilai_kontrak
            $this->nilai_kontrak->LinkCustomAttributes = "";
            $this->nilai_kontrak->HrefValue = "";

            // upload_ktp
            $this->upload_ktp->LinkCustomAttributes = "";
            if (!EmptyValue($this->upload_ktp->Upload->DbValue)) {
                $this->upload_ktp->HrefValue = GetFileUploadUrl($this->upload_ktp, $this->upload_ktp->htmlDecode($this->upload_ktp->Upload->DbValue)); // Add prefix/suffix
                $this->upload_ktp->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->upload_ktp->HrefValue = FullUrl($this->upload_ktp->HrefValue, "href");
                }
            } else {
                $this->upload_ktp->HrefValue = "";
            }
            $this->upload_ktp->ExportHrefValue = $this->upload_ktp->UploadPath . $this->upload_ktp->Upload->DbValue;

            // foto_mesin
            $this->foto_mesin->LinkCustomAttributes = "";
            if (!EmptyValue($this->foto_mesin->Upload->DbValue)) {
                $this->foto_mesin->HrefValue = GetFileUploadUrl($this->foto_mesin, $this->foto_mesin->htmlDecode($this->foto_mesin->Upload->DbValue)); // Add prefix/suffix
                $this->foto_mesin->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->foto_mesin->HrefValue = FullUrl($this->foto_mesin->HrefValue, "href");
                }
            } else {
                $this->foto_mesin->HrefValue = "";
            }
            $this->foto_mesin->ExportHrefValue = $this->foto_mesin->UploadPath . $this->foto_mesin->Upload->DbValue;
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
        if ($this->spesifikasi->Required) {
            if (!$this->spesifikasi->IsDetailKey && EmptyValue($this->spesifikasi->FormValue)) {
                $this->spesifikasi->addErrorMessage(str_replace("%s", $this->spesifikasi->caption(), $this->spesifikasi->RequiredErrorMessage));
            }
        }
        if ($this->jumlah->Required) {
            if (!$this->jumlah->IsDetailKey && EmptyValue($this->jumlah->FormValue)) {
                $this->jumlah->addErrorMessage(str_replace("%s", $this->jumlah->caption(), $this->jumlah->RequiredErrorMessage));
            }
        }
        if ($this->lama_pembuatan->Required) {
            if (!$this->lama_pembuatan->IsDetailKey && EmptyValue($this->lama_pembuatan->FormValue)) {
                $this->lama_pembuatan->addErrorMessage(str_replace("%s", $this->lama_pembuatan->caption(), $this->lama_pembuatan->RequiredErrorMessage));
            }
        }
        if ($this->pemesan->Required) {
            if (!$this->pemesan->IsDetailKey && EmptyValue($this->pemesan->FormValue)) {
                $this->pemesan->addErrorMessage(str_replace("%s", $this->pemesan->caption(), $this->pemesan->RequiredErrorMessage));
            }
        }
        if ($this->alamat->Required) {
            if (!$this->alamat->IsDetailKey && EmptyValue($this->alamat->FormValue)) {
                $this->alamat->addErrorMessage(str_replace("%s", $this->alamat->caption(), $this->alamat->RequiredErrorMessage));
            }
        }
        if ($this->nomor_kontrak->Required) {
            if (!$this->nomor_kontrak->IsDetailKey && EmptyValue($this->nomor_kontrak->FormValue)) {
                $this->nomor_kontrak->addErrorMessage(str_replace("%s", $this->nomor_kontrak->caption(), $this->nomor_kontrak->RequiredErrorMessage));
            }
        }
        if ($this->tanggal_kontrak->Required) {
            if (!$this->tanggal_kontrak->IsDetailKey && EmptyValue($this->tanggal_kontrak->FormValue)) {
                $this->tanggal_kontrak->addErrorMessage(str_replace("%s", $this->tanggal_kontrak->caption(), $this->tanggal_kontrak->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal_kontrak->FormValue)) {
            $this->tanggal_kontrak->addErrorMessage($this->tanggal_kontrak->getErrorMessage(false));
        }
        if ($this->nilai_kontrak->Required) {
            if (!$this->nilai_kontrak->IsDetailKey && EmptyValue($this->nilai_kontrak->FormValue)) {
                $this->nilai_kontrak->addErrorMessage(str_replace("%s", $this->nilai_kontrak->caption(), $this->nilai_kontrak->RequiredErrorMessage));
            }
        }
        if ($this->upload_ktp->Required) {
            if ($this->upload_ktp->Upload->FileName == "" && !$this->upload_ktp->Upload->KeepFile) {
                $this->upload_ktp->addErrorMessage(str_replace("%s", $this->upload_ktp->caption(), $this->upload_ktp->RequiredErrorMessage));
            }
        }
        if ($this->foto_mesin->Required) {
            if ($this->foto_mesin->Upload->FileName == "" && !$this->foto_mesin->Upload->KeepFile) {
                $this->foto_mesin->addErrorMessage(str_replace("%s", $this->foto_mesin->caption(), $this->foto_mesin->RequiredErrorMessage));
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
            $this->nama_mesin->setDbValueDef($rsnew, $this->nama_mesin->CurrentValue, null, $this->nama_mesin->ReadOnly);

            // spesifikasi
            $this->spesifikasi->setDbValueDef($rsnew, $this->spesifikasi->CurrentValue, "", $this->spesifikasi->ReadOnly);

            // jumlah
            $this->jumlah->setDbValueDef($rsnew, $this->jumlah->CurrentValue, "", $this->jumlah->ReadOnly);

            // lama_pembuatan
            $this->lama_pembuatan->setDbValueDef($rsnew, $this->lama_pembuatan->CurrentValue, "", $this->lama_pembuatan->ReadOnly);

            // pemesan
            $this->pemesan->setDbValueDef($rsnew, $this->pemesan->CurrentValue, "", $this->pemesan->ReadOnly);

            // alamat
            $this->alamat->setDbValueDef($rsnew, $this->alamat->CurrentValue, "", $this->alamat->ReadOnly);

            // nomor_kontrak
            $this->nomor_kontrak->setDbValueDef($rsnew, $this->nomor_kontrak->CurrentValue, "", $this->nomor_kontrak->ReadOnly);

            // tanggal_kontrak
            $this->tanggal_kontrak->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal_kontrak->CurrentValue, 0), CurrentDate(), $this->tanggal_kontrak->ReadOnly);

            // nilai_kontrak
            $this->nilai_kontrak->setDbValueDef($rsnew, $this->nilai_kontrak->CurrentValue, "", $this->nilai_kontrak->ReadOnly);

            // upload_ktp
            if ($this->upload_ktp->Visible && !$this->upload_ktp->ReadOnly && !$this->upload_ktp->Upload->KeepFile) {
                $this->upload_ktp->Upload->DbValue = $rsold['upload_ktp']; // Get original value
                if ($this->upload_ktp->Upload->FileName == "") {
                    $rsnew['upload_ktp'] = null;
                } else {
                    $rsnew['upload_ktp'] = $this->upload_ktp->Upload->FileName;
                }
                $this->upload_ktp->ImageWidth = 1000; // Resize width
                $this->upload_ktp->ImageHeight = 0; // Resize height
            }

            // foto_mesin
            if ($this->foto_mesin->Visible && !$this->foto_mesin->ReadOnly && !$this->foto_mesin->Upload->KeepFile) {
                $this->foto_mesin->Upload->DbValue = $rsold['foto_mesin']; // Get original value
                if ($this->foto_mesin->Upload->FileName == "") {
                    $rsnew['foto_mesin'] = null;
                } else {
                    $rsnew['foto_mesin'] = $this->foto_mesin->Upload->FileName;
                }
                $this->foto_mesin->ImageWidth = 1000; // Resize width
                $this->foto_mesin->ImageHeight = 0; // Resize height
            }
            if ($this->upload_ktp->Visible && !$this->upload_ktp->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->upload_ktp->Upload->DbValue) ? [] : [$this->upload_ktp->htmlDecode($this->upload_ktp->Upload->DbValue)];
                if (!EmptyValue($this->upload_ktp->Upload->FileName)) {
                    $newFiles = [$this->upload_ktp->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->upload_ktp, $this->upload_ktp->Upload->Index);
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
                                $file1 = UniqueFilename($this->upload_ktp->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->upload_ktp->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->upload_ktp->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->upload_ktp->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->upload_ktp->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->upload_ktp->setDbValueDef($rsnew, $this->upload_ktp->Upload->FileName, "", $this->upload_ktp->ReadOnly);
                }
            }
            if ($this->foto_mesin->Visible && !$this->foto_mesin->Upload->KeepFile) {
                $oldFiles = EmptyValue($this->foto_mesin->Upload->DbValue) ? [] : [$this->foto_mesin->htmlDecode($this->foto_mesin->Upload->DbValue)];
                if (!EmptyValue($this->foto_mesin->Upload->FileName)) {
                    $newFiles = [$this->foto_mesin->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->foto_mesin, $this->foto_mesin->Upload->Index);
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
                                $file1 = UniqueFilename($this->foto_mesin->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->foto_mesin->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->foto_mesin->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->foto_mesin->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->foto_mesin->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->foto_mesin->setDbValueDef($rsnew, $this->foto_mesin->Upload->FileName, "", $this->foto_mesin->ReadOnly);
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
                    if ($this->upload_ktp->Visible && !$this->upload_ktp->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->upload_ktp->Upload->DbValue) ? [] : [$this->upload_ktp->htmlDecode($this->upload_ktp->Upload->DbValue)];
                        if (!EmptyValue($this->upload_ktp->Upload->FileName)) {
                            $newFiles = [$this->upload_ktp->Upload->FileName];
                            $newFiles2 = [$this->upload_ktp->htmlDecode($rsnew['upload_ktp'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->upload_ktp, $this->upload_ktp->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->upload_ktp->Upload->ResizeAndSaveToFile($this->upload_ktp->ImageWidth, $this->upload_ktp->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->upload_ktp->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->foto_mesin->Visible && !$this->foto_mesin->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->foto_mesin->Upload->DbValue) ? [] : [$this->foto_mesin->htmlDecode($this->foto_mesin->Upload->DbValue)];
                        if (!EmptyValue($this->foto_mesin->Upload->FileName)) {
                            $newFiles = [$this->foto_mesin->Upload->FileName];
                            $newFiles2 = [$this->foto_mesin->htmlDecode($rsnew['foto_mesin'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->foto_mesin, $this->foto_mesin->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->foto_mesin->Upload->ResizeAndSaveToFile($this->foto_mesin->ImageWidth, $this->foto_mesin->ImageHeight, 100, $newFiles[$i], true, $i)) {
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
                                    @unlink($this->foto_mesin->oldPhysicalUploadPath() . $oldFile);
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
            // upload_ktp
            CleanUploadTempPath($this->upload_ktp, $this->upload_ktp->Upload->Index);

            // foto_mesin
            CleanUploadTempPath($this->foto_mesin, $this->foto_mesin->Upload->Index);
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("pembuatanmesinlist"), "", $this->TableVar, true);
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
