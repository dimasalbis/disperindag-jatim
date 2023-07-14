<?php

namespace PHPMaker2021\project1;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for mesin
 */
class Mesin extends DbTable
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
    public $nama_mesin;
    public $no_seri;
    public $nama_penyewa;
    public $alamat;
    public $no_hp;
    public $nilai_sewa;
    public $created_at;
    public $updated_at;
    public $tanggal_sewa;
    public $tanggal_kembali;
    public $foto;
    public $gambar_mesin;
    public $keterangan;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'mesin';
        $this->TableName = 'mesin';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`mesin`";
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
        $this->id = new DbField('mesin', 'mesin', 'x_id', 'id', '`id`', '`id`', 21, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // nama_mesin
        $this->nama_mesin = new DbField('mesin', 'mesin', 'x_nama_mesin', 'nama_mesin', '`nama_mesin`', '`nama_mesin`', 200, 255, -1, false, '`nama_mesin`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_mesin->Nullable = false; // NOT NULL field
        $this->nama_mesin->Required = true; // Required field
        $this->nama_mesin->Sortable = true; // Allow sort
        $this->nama_mesin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_mesin->Param, "CustomMsg");
        $this->Fields['nama_mesin'] = &$this->nama_mesin;

        // no_seri
        $this->no_seri = new DbField('mesin', 'mesin', 'x_no_seri', 'no_seri', '`no_seri`', '`no_seri`', 200, 255, -1, false, '`no_seri`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->no_seri->Nullable = false; // NOT NULL field
        $this->no_seri->Required = true; // Required field
        $this->no_seri->Sortable = true; // Allow sort
        $this->no_seri->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->no_seri->Param, "CustomMsg");
        $this->Fields['no_seri'] = &$this->no_seri;

        // nama_penyewa
        $this->nama_penyewa = new DbField('mesin', 'mesin', 'x_nama_penyewa', 'nama_penyewa', '`nama_penyewa`', '`nama_penyewa`', 200, 255, -1, false, '`nama_penyewa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_penyewa->Nullable = false; // NOT NULL field
        $this->nama_penyewa->Required = true; // Required field
        $this->nama_penyewa->Sortable = true; // Allow sort
        $this->nama_penyewa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_penyewa->Param, "CustomMsg");
        $this->Fields['nama_penyewa'] = &$this->nama_penyewa;

        // alamat
        $this->alamat = new DbField('mesin', 'mesin', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Nullable = false; // NOT NULL field
        $this->alamat->Required = true; // Required field
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // no_hp
        $this->no_hp = new DbField('mesin', 'mesin', 'x_no_hp', 'no_hp', '`no_hp`', '`no_hp`', 200, 255, -1, false, '`no_hp`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->no_hp->Nullable = false; // NOT NULL field
        $this->no_hp->Required = true; // Required field
        $this->no_hp->Sortable = true; // Allow sort
        $this->no_hp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->no_hp->Param, "CustomMsg");
        $this->Fields['no_hp'] = &$this->no_hp;

        // nilai_sewa
        $this->nilai_sewa = new DbField('mesin', 'mesin', 'x_nilai_sewa', 'nilai_sewa', '`nilai_sewa`', '`nilai_sewa`', 200, 255, -1, false, '`nilai_sewa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_sewa->Nullable = false; // NOT NULL field
        $this->nilai_sewa->Required = true; // Required field
        $this->nilai_sewa->Sortable = true; // Allow sort
        $this->nilai_sewa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_sewa->Param, "CustomMsg");
        $this->Fields['nilai_sewa'] = &$this->nilai_sewa;

        // created_at
        $this->created_at = new DbField('mesin', 'mesin', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('mesin', 'mesin', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;

        // tanggal_sewa
        $this->tanggal_sewa = new DbField('mesin', 'mesin', 'x_tanggal_sewa', 'tanggal_sewa', '`tanggal_sewa`', CastDateFieldForLike("`tanggal_sewa`", 0, "DB"), 133, 10, 0, false, '`tanggal_sewa`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_sewa->Nullable = false; // NOT NULL field
        $this->tanggal_sewa->Required = true; // Required field
        $this->tanggal_sewa->Sortable = true; // Allow sort
        $this->tanggal_sewa->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_sewa->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_sewa->Param, "CustomMsg");
        $this->Fields['tanggal_sewa'] = &$this->tanggal_sewa;

        // tanggal_kembali
        $this->tanggal_kembali = new DbField('mesin', 'mesin', 'x_tanggal_kembali', 'tanggal_kembali', '`tanggal_kembali`', CastDateFieldForLike("`tanggal_kembali`", 0, "DB"), 133, 10, 0, false, '`tanggal_kembali`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_kembali->Nullable = false; // NOT NULL field
        $this->tanggal_kembali->Required = true; // Required field
        $this->tanggal_kembali->Sortable = true; // Allow sort
        $this->tanggal_kembali->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_kembali->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_kembali->Param, "CustomMsg");
        $this->Fields['tanggal_kembali'] = &$this->tanggal_kembali;

        // foto
        $this->foto = new DbField('mesin', 'mesin', 'x_foto', 'foto', '`foto`', '`foto`', 200, 255, -1, false, '`foto`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->foto->Sortable = true; // Allow sort
        $this->foto->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto->Param, "CustomMsg");
        $this->Fields['foto'] = &$this->foto;

        // gambar_mesin
        $this->gambar_mesin = new DbField('mesin', 'mesin', 'x_gambar_mesin', 'gambar_mesin', '`gambar_mesin`', '`gambar_mesin`', 200, 255, -1, false, '`gambar_mesin`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->gambar_mesin->Sortable = true; // Allow sort
        $this->gambar_mesin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->gambar_mesin->Param, "CustomMsg");
        $this->Fields['gambar_mesin'] = &$this->gambar_mesin;

        // keterangan
        $this->keterangan = new DbField('mesin', 'mesin', 'x_keterangan', 'keterangan', '`keterangan`', '`keterangan`', 200, 100, -1, false, '`keterangan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->keterangan->Sortable = true; // Allow sort
        $this->keterangan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->keterangan->Param, "CustomMsg");
        $this->Fields['keterangan'] = &$this->keterangan;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`mesin`";
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
        $this->nama_mesin->DbValue = $row['nama_mesin'];
        $this->no_seri->DbValue = $row['no_seri'];
        $this->nama_penyewa->DbValue = $row['nama_penyewa'];
        $this->alamat->DbValue = $row['alamat'];
        $this->no_hp->DbValue = $row['no_hp'];
        $this->nilai_sewa->DbValue = $row['nilai_sewa'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
        $this->tanggal_sewa->DbValue = $row['tanggal_sewa'];
        $this->tanggal_kembali->DbValue = $row['tanggal_kembali'];
        $this->foto->DbValue = $row['foto'];
        $this->gambar_mesin->DbValue = $row['gambar_mesin'];
        $this->keterangan->DbValue = $row['keterangan'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
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
        return $_SESSION[$name] ?? GetUrl("mesinlist");
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
        if ($pageName == "mesinview") {
            return $Language->phrase("View");
        } elseif ($pageName == "mesinedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "mesinadd") {
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
                return "MesinView";
            case Config("API_ADD_ACTION"):
                return "MesinAdd";
            case Config("API_EDIT_ACTION"):
                return "MesinEdit";
            case Config("API_DELETE_ACTION"):
                return "MesinDelete";
            case Config("API_LIST_ACTION"):
                return "MesinList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "mesinlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("mesinview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("mesinview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "mesinadd?" . $this->getUrlParm($parm);
        } else {
            $url = "mesinadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("mesinedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("mesinadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("mesindelete", $this->getUrlParm());
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
        $this->foto->setDbValue($row['foto']);
        $this->gambar_mesin->setDbValue($row['gambar_mesin']);
        $this->keterangan->setDbValue($row['keterangan']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

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
        $this->foto->ViewValue = $this->foto->CurrentValue;
        $this->foto->ViewCustomAttributes = "";

        // gambar_mesin
        $this->gambar_mesin->ViewValue = $this->gambar_mesin->CurrentValue;
        $this->gambar_mesin->ViewCustomAttributes = "";

        // keterangan
        $this->keterangan->ViewValue = $this->keterangan->CurrentValue;
        $this->keterangan->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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
        $this->foto->HrefValue = "";
        $this->foto->TooltipValue = "";

        // gambar_mesin
        $this->gambar_mesin->LinkCustomAttributes = "";
        $this->gambar_mesin->HrefValue = "";
        $this->gambar_mesin->TooltipValue = "";

        // keterangan
        $this->keterangan->LinkCustomAttributes = "";
        $this->keterangan->HrefValue = "";
        $this->keterangan->TooltipValue = "";

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

        // nama_mesin
        $this->nama_mesin->EditAttrs["class"] = "form-control";
        $this->nama_mesin->EditCustomAttributes = "";
        if (!$this->nama_mesin->Raw) {
            $this->nama_mesin->CurrentValue = HtmlDecode($this->nama_mesin->CurrentValue);
        }
        $this->nama_mesin->EditValue = $this->nama_mesin->CurrentValue;
        $this->nama_mesin->PlaceHolder = RemoveHtml($this->nama_mesin->caption());

        // no_seri
        $this->no_seri->EditAttrs["class"] = "form-control";
        $this->no_seri->EditCustomAttributes = "";
        if (!$this->no_seri->Raw) {
            $this->no_seri->CurrentValue = HtmlDecode($this->no_seri->CurrentValue);
        }
        $this->no_seri->EditValue = $this->no_seri->CurrentValue;
        $this->no_seri->PlaceHolder = RemoveHtml($this->no_seri->caption());

        // nama_penyewa
        $this->nama_penyewa->EditAttrs["class"] = "form-control";
        $this->nama_penyewa->EditCustomAttributes = "";
        if (!$this->nama_penyewa->Raw) {
            $this->nama_penyewa->CurrentValue = HtmlDecode($this->nama_penyewa->CurrentValue);
        }
        $this->nama_penyewa->EditValue = $this->nama_penyewa->CurrentValue;
        $this->nama_penyewa->PlaceHolder = RemoveHtml($this->nama_penyewa->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // no_hp
        $this->no_hp->EditAttrs["class"] = "form-control";
        $this->no_hp->EditCustomAttributes = "";
        if (!$this->no_hp->Raw) {
            $this->no_hp->CurrentValue = HtmlDecode($this->no_hp->CurrentValue);
        }
        $this->no_hp->EditValue = $this->no_hp->CurrentValue;
        $this->no_hp->PlaceHolder = RemoveHtml($this->no_hp->caption());

        // nilai_sewa
        $this->nilai_sewa->EditAttrs["class"] = "form-control";
        $this->nilai_sewa->EditCustomAttributes = "";
        if (!$this->nilai_sewa->Raw) {
            $this->nilai_sewa->CurrentValue = HtmlDecode($this->nilai_sewa->CurrentValue);
        }
        $this->nilai_sewa->EditValue = $this->nilai_sewa->CurrentValue;
        $this->nilai_sewa->PlaceHolder = RemoveHtml($this->nilai_sewa->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // updated_at
        $this->updated_at->EditAttrs["class"] = "form-control";
        $this->updated_at->EditCustomAttributes = "";
        $this->updated_at->EditValue = FormatDateTime($this->updated_at->CurrentValue, 8);
        $this->updated_at->PlaceHolder = RemoveHtml($this->updated_at->caption());

        // tanggal_sewa
        $this->tanggal_sewa->EditAttrs["class"] = "form-control";
        $this->tanggal_sewa->EditCustomAttributes = "";
        $this->tanggal_sewa->EditValue = FormatDateTime($this->tanggal_sewa->CurrentValue, 8);
        $this->tanggal_sewa->PlaceHolder = RemoveHtml($this->tanggal_sewa->caption());

        // tanggal_kembali
        $this->tanggal_kembali->EditAttrs["class"] = "form-control";
        $this->tanggal_kembali->EditCustomAttributes = "";
        $this->tanggal_kembali->EditValue = FormatDateTime($this->tanggal_kembali->CurrentValue, 8);
        $this->tanggal_kembali->PlaceHolder = RemoveHtml($this->tanggal_kembali->caption());

        // foto
        $this->foto->EditAttrs["class"] = "form-control";
        $this->foto->EditCustomAttributes = "";
        if (!$this->foto->Raw) {
            $this->foto->CurrentValue = HtmlDecode($this->foto->CurrentValue);
        }
        $this->foto->EditValue = $this->foto->CurrentValue;
        $this->foto->PlaceHolder = RemoveHtml($this->foto->caption());

        // gambar_mesin
        $this->gambar_mesin->EditAttrs["class"] = "form-control";
        $this->gambar_mesin->EditCustomAttributes = "";
        if (!$this->gambar_mesin->Raw) {
            $this->gambar_mesin->CurrentValue = HtmlDecode($this->gambar_mesin->CurrentValue);
        }
        $this->gambar_mesin->EditValue = $this->gambar_mesin->CurrentValue;
        $this->gambar_mesin->PlaceHolder = RemoveHtml($this->gambar_mesin->caption());

        // keterangan
        $this->keterangan->EditAttrs["class"] = "form-control";
        $this->keterangan->EditCustomAttributes = "";
        if (!$this->keterangan->Raw) {
            $this->keterangan->CurrentValue = HtmlDecode($this->keterangan->CurrentValue);
        }
        $this->keterangan->EditValue = $this->keterangan->CurrentValue;
        $this->keterangan->PlaceHolder = RemoveHtml($this->keterangan->caption());

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
                    $doc->exportCaption($this->nama_mesin);
                    $doc->exportCaption($this->no_seri);
                    $doc->exportCaption($this->nama_penyewa);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->no_hp);
                    $doc->exportCaption($this->nilai_sewa);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->tanggal_sewa);
                    $doc->exportCaption($this->tanggal_kembali);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->gambar_mesin);
                    $doc->exportCaption($this->keterangan);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->nama_mesin);
                    $doc->exportCaption($this->no_seri);
                    $doc->exportCaption($this->nama_penyewa);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->no_hp);
                    $doc->exportCaption($this->nilai_sewa);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                    $doc->exportCaption($this->tanggal_sewa);
                    $doc->exportCaption($this->tanggal_kembali);
                    $doc->exportCaption($this->foto);
                    $doc->exportCaption($this->gambar_mesin);
                    $doc->exportCaption($this->keterangan);
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
                        $doc->exportField($this->nama_mesin);
                        $doc->exportField($this->no_seri);
                        $doc->exportField($this->nama_penyewa);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->no_hp);
                        $doc->exportField($this->nilai_sewa);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->tanggal_sewa);
                        $doc->exportField($this->tanggal_kembali);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->gambar_mesin);
                        $doc->exportField($this->keterangan);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->nama_mesin);
                        $doc->exportField($this->no_seri);
                        $doc->exportField($this->nama_penyewa);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->no_hp);
                        $doc->exportField($this->nilai_sewa);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                        $doc->exportField($this->tanggal_sewa);
                        $doc->exportField($this->tanggal_kembali);
                        $doc->exportField($this->foto);
                        $doc->exportField($this->gambar_mesin);
                        $doc->exportField($this->keterangan);
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
        // No binary fields
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
