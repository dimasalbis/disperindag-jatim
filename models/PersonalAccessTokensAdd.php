<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class PersonalAccessTokensAdd extends PersonalAccessTokens
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'personal_access_tokens';

    // Page object name
    public $PageObjName = "PersonalAccessTokensAdd";

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

        // Table object (personal_access_tokens)
        if (!isset($GLOBALS["personal_access_tokens"]) || get_class($GLOBALS["personal_access_tokens"]) == PROJECT_NAMESPACE . "personal_access_tokens") {
            $GLOBALS["personal_access_tokens"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'personal_access_tokens');
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
                $doc = new $class(Container("personal_access_tokens"));
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
                    if ($pageName == "personalaccesstokensview") {
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
        $this->tokenable_type->setVisibility();
        $this->tokenable_id->setVisibility();
        $this->name->setVisibility();
        $this->_token->setVisibility();
        $this->abilities->setVisibility();
        $this->last_used_at->setVisibility();
        $this->expires_at->setVisibility();
        $this->created_at->setVisibility();
        $this->updated_at->setVisibility();
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
                    $this->terminate("personalaccesstokenslist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "personalaccesstokenslist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "personalaccesstokensview") {
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
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->id->CurrentValue = null;
        $this->id->OldValue = $this->id->CurrentValue;
        $this->tokenable_type->CurrentValue = null;
        $this->tokenable_type->OldValue = $this->tokenable_type->CurrentValue;
        $this->tokenable_id->CurrentValue = null;
        $this->tokenable_id->OldValue = $this->tokenable_id->CurrentValue;
        $this->name->CurrentValue = null;
        $this->name->OldValue = $this->name->CurrentValue;
        $this->_token->CurrentValue = null;
        $this->_token->OldValue = $this->_token->CurrentValue;
        $this->abilities->CurrentValue = null;
        $this->abilities->OldValue = $this->abilities->CurrentValue;
        $this->last_used_at->CurrentValue = null;
        $this->last_used_at->OldValue = $this->last_used_at->CurrentValue;
        $this->expires_at->CurrentValue = null;
        $this->expires_at->OldValue = $this->expires_at->CurrentValue;
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

        // Check field name 'tokenable_type' first before field var 'x_tokenable_type'
        $val = $CurrentForm->hasValue("tokenable_type") ? $CurrentForm->getValue("tokenable_type") : $CurrentForm->getValue("x_tokenable_type");
        if (!$this->tokenable_type->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tokenable_type->Visible = false; // Disable update for API request
            } else {
                $this->tokenable_type->setFormValue($val);
            }
        }

        // Check field name 'tokenable_id' first before field var 'x_tokenable_id'
        $val = $CurrentForm->hasValue("tokenable_id") ? $CurrentForm->getValue("tokenable_id") : $CurrentForm->getValue("x_tokenable_id");
        if (!$this->tokenable_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tokenable_id->Visible = false; // Disable update for API request
            } else {
                $this->tokenable_id->setFormValue($val);
            }
        }

        // Check field name 'name' first before field var 'x_name'
        $val = $CurrentForm->hasValue("name") ? $CurrentForm->getValue("name") : $CurrentForm->getValue("x_name");
        if (!$this->name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->name->Visible = false; // Disable update for API request
            } else {
                $this->name->setFormValue($val);
            }
        }

        // Check field name 'token' first before field var 'x__token'
        $val = $CurrentForm->hasValue("token") ? $CurrentForm->getValue("token") : $CurrentForm->getValue("x__token");
        if (!$this->_token->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_token->Visible = false; // Disable update for API request
            } else {
                $this->_token->setFormValue($val);
            }
        }

        // Check field name 'abilities' first before field var 'x_abilities'
        $val = $CurrentForm->hasValue("abilities") ? $CurrentForm->getValue("abilities") : $CurrentForm->getValue("x_abilities");
        if (!$this->abilities->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->abilities->Visible = false; // Disable update for API request
            } else {
                $this->abilities->setFormValue($val);
            }
        }

        // Check field name 'last_used_at' first before field var 'x_last_used_at'
        $val = $CurrentForm->hasValue("last_used_at") ? $CurrentForm->getValue("last_used_at") : $CurrentForm->getValue("x_last_used_at");
        if (!$this->last_used_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->last_used_at->Visible = false; // Disable update for API request
            } else {
                $this->last_used_at->setFormValue($val);
            }
            $this->last_used_at->CurrentValue = UnFormatDateTime($this->last_used_at->CurrentValue, 0);
        }

        // Check field name 'expires_at' first before field var 'x_expires_at'
        $val = $CurrentForm->hasValue("expires_at") ? $CurrentForm->getValue("expires_at") : $CurrentForm->getValue("x_expires_at");
        if (!$this->expires_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->expires_at->Visible = false; // Disable update for API request
            } else {
                $this->expires_at->setFormValue($val);
            }
            $this->expires_at->CurrentValue = UnFormatDateTime($this->expires_at->CurrentValue, 0);
        }

        // Check field name 'created_at' first before field var 'x_created_at'
        $val = $CurrentForm->hasValue("created_at") ? $CurrentForm->getValue("created_at") : $CurrentForm->getValue("x_created_at");
        if (!$this->created_at->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_at->Visible = false; // Disable update for API request
            } else {
                $this->created_at->setFormValue($val);
            }
            $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
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

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->tokenable_type->CurrentValue = $this->tokenable_type->FormValue;
        $this->tokenable_id->CurrentValue = $this->tokenable_id->FormValue;
        $this->name->CurrentValue = $this->name->FormValue;
        $this->_token->CurrentValue = $this->_token->FormValue;
        $this->abilities->CurrentValue = $this->abilities->FormValue;
        $this->last_used_at->CurrentValue = $this->last_used_at->FormValue;
        $this->last_used_at->CurrentValue = UnFormatDateTime($this->last_used_at->CurrentValue, 0);
        $this->expires_at->CurrentValue = $this->expires_at->FormValue;
        $this->expires_at->CurrentValue = UnFormatDateTime($this->expires_at->CurrentValue, 0);
        $this->created_at->CurrentValue = $this->created_at->FormValue;
        $this->created_at->CurrentValue = UnFormatDateTime($this->created_at->CurrentValue, 0);
        $this->updated_at->CurrentValue = $this->updated_at->FormValue;
        $this->updated_at->CurrentValue = UnFormatDateTime($this->updated_at->CurrentValue, 0);
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
        $this->tokenable_type->setDbValue($row['tokenable_type']);
        $this->tokenable_id->setDbValue($row['tokenable_id']);
        $this->name->setDbValue($row['name']);
        $this->_token->setDbValue($row['token']);
        $this->abilities->setDbValue($row['abilities']);
        $this->last_used_at->setDbValue($row['last_used_at']);
        $this->expires_at->setDbValue($row['expires_at']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['id'] = $this->id->CurrentValue;
        $row['tokenable_type'] = $this->tokenable_type->CurrentValue;
        $row['tokenable_id'] = $this->tokenable_id->CurrentValue;
        $row['name'] = $this->name->CurrentValue;
        $row['token'] = $this->_token->CurrentValue;
        $row['abilities'] = $this->abilities->CurrentValue;
        $row['last_used_at'] = $this->last_used_at->CurrentValue;
        $row['expires_at'] = $this->expires_at->CurrentValue;
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

        // tokenable_type

        // tokenable_id

        // name

        // token

        // abilities

        // last_used_at

        // expires_at

        // created_at

        // updated_at
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // tokenable_type
            $this->tokenable_type->ViewValue = $this->tokenable_type->CurrentValue;
            $this->tokenable_type->ViewCustomAttributes = "";

            // tokenable_id
            $this->tokenable_id->ViewValue = $this->tokenable_id->CurrentValue;
            $this->tokenable_id->ViewValue = FormatNumber($this->tokenable_id->ViewValue, 0, -2, -2, -2);
            $this->tokenable_id->ViewCustomAttributes = "";

            // name
            $this->name->ViewValue = $this->name->CurrentValue;
            $this->name->ViewCustomAttributes = "";

            // token
            $this->_token->ViewValue = $this->_token->CurrentValue;
            $this->_token->ViewCustomAttributes = "";

            // abilities
            $this->abilities->ViewValue = $this->abilities->CurrentValue;
            $this->abilities->ViewCustomAttributes = "";

            // last_used_at
            $this->last_used_at->ViewValue = $this->last_used_at->CurrentValue;
            $this->last_used_at->ViewValue = FormatDateTime($this->last_used_at->ViewValue, 0);
            $this->last_used_at->ViewCustomAttributes = "";

            // expires_at
            $this->expires_at->ViewValue = $this->expires_at->CurrentValue;
            $this->expires_at->ViewValue = FormatDateTime($this->expires_at->ViewValue, 0);
            $this->expires_at->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // updated_at
            $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
            $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
            $this->updated_at->ViewCustomAttributes = "";

            // tokenable_type
            $this->tokenable_type->LinkCustomAttributes = "";
            $this->tokenable_type->HrefValue = "";
            $this->tokenable_type->TooltipValue = "";

            // tokenable_id
            $this->tokenable_id->LinkCustomAttributes = "";
            $this->tokenable_id->HrefValue = "";
            $this->tokenable_id->TooltipValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";
            $this->name->TooltipValue = "";

            // token
            $this->_token->LinkCustomAttributes = "";
            $this->_token->HrefValue = "";
            $this->_token->TooltipValue = "";

            // abilities
            $this->abilities->LinkCustomAttributes = "";
            $this->abilities->HrefValue = "";
            $this->abilities->TooltipValue = "";

            // last_used_at
            $this->last_used_at->LinkCustomAttributes = "";
            $this->last_used_at->HrefValue = "";
            $this->last_used_at->TooltipValue = "";

            // expires_at
            $this->expires_at->LinkCustomAttributes = "";
            $this->expires_at->HrefValue = "";
            $this->expires_at->TooltipValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";
            $this->created_at->TooltipValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
            $this->updated_at->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // tokenable_type
            $this->tokenable_type->EditAttrs["class"] = "form-control";
            $this->tokenable_type->EditCustomAttributes = "";
            if (!$this->tokenable_type->Raw) {
                $this->tokenable_type->CurrentValue = HtmlDecode($this->tokenable_type->CurrentValue);
            }
            $this->tokenable_type->EditValue = HtmlEncode($this->tokenable_type->CurrentValue);
            $this->tokenable_type->PlaceHolder = RemoveHtml($this->tokenable_type->caption());

            // tokenable_id
            $this->tokenable_id->EditAttrs["class"] = "form-control";
            $this->tokenable_id->EditCustomAttributes = "";
            $this->tokenable_id->EditValue = HtmlEncode($this->tokenable_id->CurrentValue);
            $this->tokenable_id->PlaceHolder = RemoveHtml($this->tokenable_id->caption());

            // name
            $this->name->EditAttrs["class"] = "form-control";
            $this->name->EditCustomAttributes = "";
            if (!$this->name->Raw) {
                $this->name->CurrentValue = HtmlDecode($this->name->CurrentValue);
            }
            $this->name->EditValue = HtmlEncode($this->name->CurrentValue);
            $this->name->PlaceHolder = RemoveHtml($this->name->caption());

            // token
            $this->_token->EditAttrs["class"] = "form-control";
            $this->_token->EditCustomAttributes = "";
            if (!$this->_token->Raw) {
                $this->_token->CurrentValue = HtmlDecode($this->_token->CurrentValue);
            }
            $this->_token->EditValue = HtmlEncode($this->_token->CurrentValue);
            $this->_token->PlaceHolder = RemoveHtml($this->_token->caption());

            // abilities
            $this->abilities->EditAttrs["class"] = "form-control";
            $this->abilities->EditCustomAttributes = "";
            $this->abilities->EditValue = HtmlEncode($this->abilities->CurrentValue);
            $this->abilities->PlaceHolder = RemoveHtml($this->abilities->caption());

            // last_used_at
            $this->last_used_at->EditAttrs["class"] = "form-control";
            $this->last_used_at->EditCustomAttributes = "";
            $this->last_used_at->EditValue = HtmlEncode(FormatDateTime($this->last_used_at->CurrentValue, 8));
            $this->last_used_at->PlaceHolder = RemoveHtml($this->last_used_at->caption());

            // expires_at
            $this->expires_at->EditAttrs["class"] = "form-control";
            $this->expires_at->EditCustomAttributes = "";
            $this->expires_at->EditValue = HtmlEncode(FormatDateTime($this->expires_at->CurrentValue, 8));
            $this->expires_at->PlaceHolder = RemoveHtml($this->expires_at->caption());

            // created_at
            $this->created_at->EditAttrs["class"] = "form-control";
            $this->created_at->EditCustomAttributes = "";
            $this->created_at->EditValue = HtmlEncode(FormatDateTime($this->created_at->CurrentValue, 8));
            $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

            // updated_at
            $this->updated_at->EditAttrs["class"] = "form-control";
            $this->updated_at->EditCustomAttributes = "";
            $this->updated_at->EditValue = HtmlEncode(FormatDateTime($this->updated_at->CurrentValue, 8));
            $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

            // Add refer script

            // tokenable_type
            $this->tokenable_type->LinkCustomAttributes = "";
            $this->tokenable_type->HrefValue = "";

            // tokenable_id
            $this->tokenable_id->LinkCustomAttributes = "";
            $this->tokenable_id->HrefValue = "";

            // name
            $this->name->LinkCustomAttributes = "";
            $this->name->HrefValue = "";

            // token
            $this->_token->LinkCustomAttributes = "";
            $this->_token->HrefValue = "";

            // abilities
            $this->abilities->LinkCustomAttributes = "";
            $this->abilities->HrefValue = "";

            // last_used_at
            $this->last_used_at->LinkCustomAttributes = "";
            $this->last_used_at->HrefValue = "";

            // expires_at
            $this->expires_at->LinkCustomAttributes = "";
            $this->expires_at->HrefValue = "";

            // created_at
            $this->created_at->LinkCustomAttributes = "";
            $this->created_at->HrefValue = "";

            // updated_at
            $this->updated_at->LinkCustomAttributes = "";
            $this->updated_at->HrefValue = "";
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
        if ($this->tokenable_type->Required) {
            if (!$this->tokenable_type->IsDetailKey && EmptyValue($this->tokenable_type->FormValue)) {
                $this->tokenable_type->addErrorMessage(str_replace("%s", $this->tokenable_type->caption(), $this->tokenable_type->RequiredErrorMessage));
            }
        }
        if ($this->tokenable_id->Required) {
            if (!$this->tokenable_id->IsDetailKey && EmptyValue($this->tokenable_id->FormValue)) {
                $this->tokenable_id->addErrorMessage(str_replace("%s", $this->tokenable_id->caption(), $this->tokenable_id->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->tokenable_id->FormValue)) {
            $this->tokenable_id->addErrorMessage($this->tokenable_id->getErrorMessage(false));
        }
        if ($this->name->Required) {
            if (!$this->name->IsDetailKey && EmptyValue($this->name->FormValue)) {
                $this->name->addErrorMessage(str_replace("%s", $this->name->caption(), $this->name->RequiredErrorMessage));
            }
        }
        if ($this->_token->Required) {
            if (!$this->_token->IsDetailKey && EmptyValue($this->_token->FormValue)) {
                $this->_token->addErrorMessage(str_replace("%s", $this->_token->caption(), $this->_token->RequiredErrorMessage));
            }
        }
        if ($this->abilities->Required) {
            if (!$this->abilities->IsDetailKey && EmptyValue($this->abilities->FormValue)) {
                $this->abilities->addErrorMessage(str_replace("%s", $this->abilities->caption(), $this->abilities->RequiredErrorMessage));
            }
        }
        if ($this->last_used_at->Required) {
            if (!$this->last_used_at->IsDetailKey && EmptyValue($this->last_used_at->FormValue)) {
                $this->last_used_at->addErrorMessage(str_replace("%s", $this->last_used_at->caption(), $this->last_used_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->last_used_at->FormValue)) {
            $this->last_used_at->addErrorMessage($this->last_used_at->getErrorMessage(false));
        }
        if ($this->expires_at->Required) {
            if (!$this->expires_at->IsDetailKey && EmptyValue($this->expires_at->FormValue)) {
                $this->expires_at->addErrorMessage(str_replace("%s", $this->expires_at->caption(), $this->expires_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->expires_at->FormValue)) {
            $this->expires_at->addErrorMessage($this->expires_at->getErrorMessage(false));
        }
        if ($this->created_at->Required) {
            if (!$this->created_at->IsDetailKey && EmptyValue($this->created_at->FormValue)) {
                $this->created_at->addErrorMessage(str_replace("%s", $this->created_at->caption(), $this->created_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->created_at->FormValue)) {
            $this->created_at->addErrorMessage($this->created_at->getErrorMessage(false));
        }
        if ($this->updated_at->Required) {
            if (!$this->updated_at->IsDetailKey && EmptyValue($this->updated_at->FormValue)) {
                $this->updated_at->addErrorMessage(str_replace("%s", $this->updated_at->caption(), $this->updated_at->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->updated_at->FormValue)) {
            $this->updated_at->addErrorMessage($this->updated_at->getErrorMessage(false));
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
        if ($this->_token->CurrentValue != "") { // Check field with unique index
            $filter = "(`token` = '" . AdjustSql($this->_token->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->_token->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->_token->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
        }
        $rsnew = [];

        // tokenable_type
        $this->tokenable_type->setDbValueDef($rsnew, $this->tokenable_type->CurrentValue, "", false);

        // tokenable_id
        $this->tokenable_id->setDbValueDef($rsnew, $this->tokenable_id->CurrentValue, 0, false);

        // name
        $this->name->setDbValueDef($rsnew, $this->name->CurrentValue, "", false);

        // token
        $this->_token->setDbValueDef($rsnew, $this->_token->CurrentValue, "", false);

        // abilities
        $this->abilities->setDbValueDef($rsnew, $this->abilities->CurrentValue, null, false);

        // last_used_at
        $this->last_used_at->setDbValueDef($rsnew, UnFormatDateTime($this->last_used_at->CurrentValue, 0), null, false);

        // expires_at
        $this->expires_at->setDbValueDef($rsnew, UnFormatDateTime($this->expires_at->CurrentValue, 0), null, false);

        // created_at
        $this->created_at->setDbValueDef($rsnew, UnFormatDateTime($this->created_at->CurrentValue, 0), null, false);

        // updated_at
        $this->updated_at->setDbValueDef($rsnew, UnFormatDateTime($this->updated_at->CurrentValue, 0), null, false);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("personalaccesstokenslist"), "", $this->TableVar, true);
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
