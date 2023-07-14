<?php

namespace PHPMaker2021\project1;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for pendataan
 */
class Pendataan extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $id;
    public $nama;
    public $penanggung_jawab;
    public $alamat;
    public $phone_number;
    public $produk;
    public $lokasi_lahan;
    public $create_at;
    public $updated_at;
    public $luas_lahan;
    public $nilai_sewa;
    public $legalitas;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'pendataan';
        $this->TableName = 'pendataan';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`pendataan`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // id
        $this->id = new DbField('pendataan', 'pendataan', 'x_id', 'id', '`id`', '`id`', 21, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // nama
        $this->nama = new DbField('pendataan', 'pendataan', 'x_nama', 'nama', '`nama`', '`nama`', 200, 255, -1, false, '`nama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama->Nullable = false; // NOT NULL field
        $this->nama->Required = true; // Required field
        $this->nama->Sortable = true; // Allow sort
        $this->nama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama->Param, "CustomMsg");
        $this->Fields['nama'] = &$this->nama;

        // penanggung_jawab
        $this->penanggung_jawab = new DbField('pendataan', 'pendataan', 'x_penanggung_jawab', 'penanggung_jawab', '`penanggung_jawab`', '`penanggung_jawab`', 200, 255, -1, false, '`penanggung_jawab`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->penanggung_jawab->Nullable = false; // NOT NULL field
        $this->penanggung_jawab->Required = true; // Required field
        $this->penanggung_jawab->Sortable = true; // Allow sort
        $this->penanggung_jawab->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->penanggung_jawab->Param, "CustomMsg");
        $this->Fields['penanggung_jawab'] = &$this->penanggung_jawab;

        // alamat
        $this->alamat = new DbField('pendataan', 'pendataan', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Nullable = false; // NOT NULL field
        $this->alamat->Required = true; // Required field
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // phone_number
        $this->phone_number = new DbField('pendataan', 'pendataan', 'x_phone_number', 'phone_number', '`phone_number`', '`phone_number`', 200, 255, -1, false, '`phone_number`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->phone_number->Nullable = false; // NOT NULL field
        $this->phone_number->Required = true; // Required field
        $this->phone_number->Sortable = true; // Allow sort
        $this->phone_number->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->phone_number->Param, "CustomMsg");
        $this->Fields['phone_number'] = &$this->phone_number;

        // produk
        $this->produk = new DbField('pendataan', 'pendataan', 'x_produk', 'produk', '`produk`', '`produk`', 200, 255, -1, false, '`produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->produk->Nullable = false; // NOT NULL field
        $this->produk->Required = true; // Required field
        $this->produk->Sortable = true; // Allow sort
        $this->produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->produk->Param, "CustomMsg");
        $this->Fields['produk'] = &$this->produk;

        // lokasi_lahan
        $this->lokasi_lahan = new DbField('pendataan', 'pendataan', 'x_lokasi_lahan', 'lokasi_lahan', '`lokasi_lahan`', '`lokasi_lahan`', 200, 255, -1, false, '`lokasi_lahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lokasi_lahan->Nullable = false; // NOT NULL field
        $this->lokasi_lahan->Required = true; // Required field
        $this->lokasi_lahan->Sortable = true; // Allow sort
        $this->lokasi_lahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lokasi_lahan->Param, "CustomMsg");
        $this->Fields['lokasi_lahan'] = &$this->lokasi_lahan;

        // create_at
        $this->create_at = new DbField('pendataan', 'pendataan', 'x_create_at', 'create_at', '`create_at`', CastDateFieldForLike("`create_at`", 0, "DB"), 135, 19, 0, false, '`create_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->create_at->Sortable = true; // Allow sort
        $this->create_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->create_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->create_at->Param, "CustomMsg");
        $this->Fields['create_at'] = &$this->create_at;

        // updated_at
        $this->updated_at = new DbField('pendataan', 'pendataan', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // luas_lahan
        $this->luas_lahan = new DbField('pendataan', 'pendataan', 'x_luas_lahan', 'luas_lahan', '`luas_lahan`', '`luas_lahan`', 200, 255, -1, false, '`luas_lahan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->luas_lahan->Nullable = false; // NOT NULL field
        $this->luas_lahan->Required = true; // Required field
        $this->luas_lahan->Sortable = true; // Allow sort
        $this->luas_lahan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->luas_lahan->Param, "CustomMsg");
        $this->Fields['luas_lahan'] = &$this->luas_lahan;

        // nilai_sewa
        $this->nilai_sewa = new DbField('pendataan', 'pendataan', 'x_nilai_sewa', 'nilai_sewa', '`nilai_sewa`', '`nilai_sewa`', 200, 255, -1, false, '`nilai_sewa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_sewa->Nullable = false; // NOT NULL field
        $this->nilai_sewa->Required = true; // Required field
        $this->nilai_sewa->Sortable = true; // Allow sort
        $this->nilai_sewa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_sewa->Param, "CustomMsg");
        $this->Fields['nilai_sewa'] = &$this->nilai_sewa;

        // legalitas
        $this->legalitas = new DbField('pendataan', 'pendataan', 'x_legalitas', 'legalitas', '`legalitas`', '`legalitas`', 200, 128, -1, true, '`legalitas`', false, false, false, 'IMAGE', 'FILE');
        $this->legalitas->Required = true; // Required field
        $this->legalitas->Sortable = true; // Allow sort
        $this->legalitas->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->legalitas->Param, "CustomMsg");
        $this->Fields['legalitas'] = &$this->legalitas;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pendataan`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->id->DbValue = $row['id'];
        $this->nama->DbValue = $row['nama'];
        $this->penanggung_jawab->DbValue = $row['penanggung_jawab'];
        $this->alamat->DbValue = $row['alamat'];
        $this->phone_number->DbValue = $row['phone_number'];
        $this->produk->DbValue = $row['produk'];
        $this->lokasi_lahan->DbValue = $row['lokasi_lahan'];
        $this->create_at->DbValue = $row['create_at'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->luas_lahan->DbValue = $row['luas_lahan'];
        $this->nilai_sewa->DbValue = $row['nilai_sewa'];
        $this->legalitas->Upload->DbValue = $row['legalitas'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['legalitas']) ? [] : [$row['legalitas']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->legalitas->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->legalitas->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("pendataanlist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "pendataanview") {
            return $Language->phrase("View");
        } elseif ($pageName == "pendataanedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "pendataanadd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "PendataanView";
            case Config("API_ADD_ACTION"):
                return "PendataanAdd";
            case Config("API_EDIT_ACTION"):
                return "PendataanEdit";
            case Config("API_DELETE_ACTION"):
                return "PendataanDelete";
            case Config("API_LIST_ACTION"):
                return "PendataanList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "pendataanlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("pendataanview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("pendataanview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "pendataanadd?" . $this->getUrlParm($parm);
        } else {
            $url = "pendataanadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("pendataanedit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("pendataanadd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("pendataandelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 1);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // nama
        $this->nama->EditAttrs["class"] = "form-control";
        $this->nama->EditCustomAttributes = "";
        if (!$this->nama->Raw) {
            $this->nama->CurrentValue = HtmlDecode($this->nama->CurrentValue);
        }
        $this->nama->EditValue = $this->nama->CurrentValue;
        $this->nama->PlaceHolder = RemoveHtml($this->nama->caption());

        // penanggung_jawab
        $this->penanggung_jawab->EditAttrs["class"] = "form-control";
        $this->penanggung_jawab->EditCustomAttributes = "";
        if (!$this->penanggung_jawab->Raw) {
            $this->penanggung_jawab->CurrentValue = HtmlDecode($this->penanggung_jawab->CurrentValue);
        }
        $this->penanggung_jawab->EditValue = $this->penanggung_jawab->CurrentValue;
        $this->penanggung_jawab->PlaceHolder = RemoveHtml($this->penanggung_jawab->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // phone_number
        $this->phone_number->EditAttrs["class"] = "form-control";
        $this->phone_number->EditCustomAttributes = "";
        if (!$this->phone_number->Raw) {
            $this->phone_number->CurrentValue = HtmlDecode($this->phone_number->CurrentValue);
        }
        $this->phone_number->EditValue = $this->phone_number->CurrentValue;
        $this->phone_number->PlaceHolder = RemoveHtml($this->phone_number->caption());

        // produk
        $this->produk->EditAttrs["class"] = "form-control";
        $this->produk->EditCustomAttributes = "";
        if (!$this->produk->Raw) {
            $this->produk->CurrentValue = HtmlDecode($this->produk->CurrentValue);
        }
        $this->produk->EditValue = $this->produk->CurrentValue;
        $this->produk->PlaceHolder = RemoveHtml($this->produk->caption());

        // lokasi_lahan
        $this->lokasi_lahan->EditAttrs["class"] = "form-control";
        $this->lokasi_lahan->EditCustomAttributes = "";
        if (!$this->lokasi_lahan->Raw) {
            $this->lokasi_lahan->CurrentValue = HtmlDecode($this->lokasi_lahan->CurrentValue);
        }
        $this->lokasi_lahan->EditValue = $this->lokasi_lahan->CurrentValue;
        $this->lokasi_lahan->PlaceHolder = RemoveHtml($this->lokasi_lahan->caption());

        // create_at
        $this->create_at->EditAttrs["class"] = "form-control";
        $this->create_at->EditCustomAttributes = "";
        $this->create_at->EditValue = FormatDateTime($this->create_at->CurrentValue, 8);
        $this->create_at->PlaceHolder = RemoveHtml($this->create_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

        // luas_lahan
        $this->luas_lahan->EditAttrs["class"] = "form-control";
        $this->luas_lahan->EditCustomAttributes = "";
        if (!$this->luas_lahan->Raw) {
            $this->luas_lahan->CurrentValue = HtmlDecode($this->luas_lahan->CurrentValue);
        }
        $this->luas_lahan->EditValue = $this->luas_lahan->CurrentValue;
        $this->luas_lahan->PlaceHolder = RemoveHtml($this->luas_lahan->caption());

        // nilai_sewa
        $this->nilai_sewa->EditAttrs["class"] = "form-control";
        $this->nilai_sewa->EditCustomAttributes = "";
        if (!$this->nilai_sewa->Raw) {
            $this->nilai_sewa->CurrentValue = HtmlDecode($this->nilai_sewa->CurrentValue);
        }
        $this->nilai_sewa->EditValue = $this->nilai_sewa->CurrentValue;
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

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->penanggung_jawab);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->phone_number);
                    $doc->exportCaption($this->produk);
                    $doc->exportCaption($this->lokasi_lahan);
                    $doc->exportCaption($this->create_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->luas_lahan);
                    $doc->exportCaption($this->nilai_sewa);
                    $doc->exportCaption($this->legalitas);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->nama);
                    $doc->exportCaption($this->penanggung_jawab);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->phone_number);
                    $doc->exportCaption($this->produk);
                    $doc->exportCaption($this->lokasi_lahan);
                    $doc->exportCaption($this->create_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->luas_lahan);
                    $doc->exportCaption($this->nilai_sewa);
                    $doc->exportCaption($this->legalitas);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->id);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->penanggung_jawab);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->phone_number);
                        $doc->exportField($this->produk);
                        $doc->exportField($this->lokasi_lahan);
                        $doc->exportField($this->create_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->luas_lahan);
                        $doc->exportField($this->nilai_sewa);
                        $doc->exportField($this->legalitas);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->nama);
                        $doc->exportField($this->penanggung_jawab);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->phone_number);
                        $doc->exportField($this->produk);
                        $doc->exportField($this->lokasi_lahan);
                        $doc->exportField($this->create_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->luas_lahan);
                        $doc->exportField($this->nilai_sewa);
                        $doc->exportField($this->legalitas);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'legalitas') {
            $fldName = "legalitas";
            $fileNameFld = "legalitas";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->id->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssoc($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, 100, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
