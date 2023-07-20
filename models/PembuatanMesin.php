<?php

namespace PHPMaker2021\buat_mesin;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for pembuatan_mesin
 */
class PembuatanMesin extends DbTable
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
    public $spesifikasi;
    public $jumlah;
    public $lama_pembuatan;
    public $pemesan;
    public $alamat;
    public $nomor_kontrak;
    public $tanggal_kontrak;
    public $nilai_kontrak;
    public $foto_kontrak;
    public $upload_ktp;
    public $foto_mesin;
    public $status;
    public $created_at;
    public $updated_at;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'pembuatan_mesin';
        $this->TableName = 'pembuatan_mesin';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`pembuatan_mesin`";
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
        $this->id = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_id', 'id', '`id`', '`id`', 21, 20, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // nama_mesin
        $this->nama_mesin = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_nama_mesin', 'nama_mesin', '`nama_mesin`', '`nama_mesin`', 200, 255, -1, false, '`nama_mesin`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nama_mesin->Sortable = true; // Allow sort
        $this->nama_mesin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nama_mesin->Param, "CustomMsg");
        $this->Fields['nama_mesin'] = &$this->nama_mesin;

        // spesifikasi
        $this->spesifikasi = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_spesifikasi', 'spesifikasi', '`spesifikasi`', '`spesifikasi`', 200, 255, -1, false, '`spesifikasi`', false, false, false, 'FORMATTED TEXT', 'TEXTAREA');
        $this->spesifikasi->Nullable = false; // NOT NULL field
        $this->spesifikasi->Required = true; // Required field
        $this->spesifikasi->Sortable = true; // Allow sort
        $this->spesifikasi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->spesifikasi->Param, "CustomMsg");
        $this->Fields['spesifikasi'] = &$this->spesifikasi;

        // jumlah
        $this->jumlah = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_jumlah', 'jumlah', '`jumlah`', '`jumlah`', 200, 255, -1, false, '`jumlah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jumlah->Nullable = false; // NOT NULL field
        $this->jumlah->Required = true; // Required field
        $this->jumlah->Sortable = true; // Allow sort
        $this->jumlah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jumlah->Param, "CustomMsg");
        $this->Fields['jumlah'] = &$this->jumlah;

        // lama_pembuatan
        $this->lama_pembuatan = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_lama_pembuatan', 'lama_pembuatan', '`lama_pembuatan`', '`lama_pembuatan`', 200, 255, -1, false, '`lama_pembuatan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lama_pembuatan->Nullable = false; // NOT NULL field
        $this->lama_pembuatan->Required = true; // Required field
        $this->lama_pembuatan->Sortable = true; // Allow sort
        $this->lama_pembuatan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lama_pembuatan->Param, "CustomMsg");
        $this->Fields['lama_pembuatan'] = &$this->lama_pembuatan;

        // pemesan
        $this->pemesan = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_pemesan', 'pemesan', '`pemesan`', '`pemesan`', 200, 255, -1, false, '`pemesan`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->pemesan->Nullable = false; // NOT NULL field
        $this->pemesan->Required = true; // Required field
        $this->pemesan->Sortable = true; // Allow sort
        $this->pemesan->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->pemesan->Param, "CustomMsg");
        $this->Fields['pemesan'] = &$this->pemesan;

        // alamat
        $this->alamat = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_alamat', 'alamat', '`alamat`', '`alamat`', 200, 255, -1, false, '`alamat`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->alamat->Nullable = false; // NOT NULL field
        $this->alamat->Required = true; // Required field
        $this->alamat->Sortable = true; // Allow sort
        $this->alamat->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->alamat->Param, "CustomMsg");
        $this->Fields['alamat'] = &$this->alamat;

        // nomor_kontrak
        $this->nomor_kontrak = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_nomor_kontrak', 'nomor_kontrak', '`nomor_kontrak`', '`nomor_kontrak`', 200, 255, -1, false, '`nomor_kontrak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nomor_kontrak->Nullable = false; // NOT NULL field
        $this->nomor_kontrak->Required = true; // Required field
        $this->nomor_kontrak->Sortable = true; // Allow sort
        $this->nomor_kontrak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nomor_kontrak->Param, "CustomMsg");
        $this->Fields['nomor_kontrak'] = &$this->nomor_kontrak;

        // tanggal_kontrak
        $this->tanggal_kontrak = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_tanggal_kontrak', 'tanggal_kontrak', '`tanggal_kontrak`', CastDateFieldForLike("`tanggal_kontrak`", 0, "DB"), 133, 10, 0, false, '`tanggal_kontrak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_kontrak->Nullable = false; // NOT NULL field
        $this->tanggal_kontrak->Required = true; // Required field
        $this->tanggal_kontrak->Sortable = true; // Allow sort
        $this->tanggal_kontrak->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_kontrak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_kontrak->Param, "CustomMsg");
        $this->Fields['tanggal_kontrak'] = &$this->tanggal_kontrak;

        // nilai_kontrak
        $this->nilai_kontrak = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_nilai_kontrak', 'nilai_kontrak', '`nilai_kontrak`', '`nilai_kontrak`', 200, 255, -1, false, '`nilai_kontrak`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->nilai_kontrak->Nullable = false; // NOT NULL field
        $this->nilai_kontrak->Required = true; // Required field
        $this->nilai_kontrak->Sortable = true; // Allow sort
        $this->nilai_kontrak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->nilai_kontrak->Param, "CustomMsg");
        $this->Fields['nilai_kontrak'] = &$this->nilai_kontrak;

        // foto_kontrak
        $this->foto_kontrak = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_foto_kontrak', 'foto_kontrak', '`foto_kontrak`', '`foto_kontrak`', 200, 255, -1, true, '`foto_kontrak`', false, false, false, 'IMAGE', 'FILE');
        $this->foto_kontrak->Sortable = true; // Allow sort
        $this->foto_kontrak->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto_kontrak->Param, "CustomMsg");
        $this->Fields['foto_kontrak'] = &$this->foto_kontrak;

        // upload_ktp
        $this->upload_ktp = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_upload_ktp', 'upload_ktp', '`upload_ktp`', '`upload_ktp`', 200, 255, -1, true, '`upload_ktp`', false, false, false, 'IMAGE', 'FILE');
        $this->upload_ktp->Nullable = false; // NOT NULL field
        $this->upload_ktp->Required = true; // Required field
        $this->upload_ktp->Sortable = true; // Allow sort
        $this->upload_ktp->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->upload_ktp->Param, "CustomMsg");
        $this->Fields['upload_ktp'] = &$this->upload_ktp;

        // foto_mesin
        $this->foto_mesin = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_foto_mesin', 'foto_mesin', '`foto_mesin`', '`foto_mesin`', 200, 255, -1, true, '`foto_mesin`', false, false, false, 'IMAGE', 'FILE');
        $this->foto_mesin->Nullable = false; // NOT NULL field
        $this->foto_mesin->Required = true; // Required field
        $this->foto_mesin->Sortable = true; // Allow sort
        $this->foto_mesin->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->foto_mesin->Param, "CustomMsg");
        $this->Fields['foto_mesin'] = &$this->foto_mesin;

        // status
        $this->status = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_status', 'status', '`status`', '`status`', 200, 255, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->status->Nullable = false; // NOT NULL field
        $this->status->Required = true; // Required field
        $this->status->Sortable = true; // Allow sort
        $this->status->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->status->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        $this->status->Lookup = new Lookup('status', 'pembuatan_mesin', false, '', ["","","",""], [], [], [], [], [], [], '', '');
        $this->status->OptionCount = 3;
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // created_at
        $this->created_at = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // updated_at
        $this->updated_at = new DbField('pembuatan_mesin', 'pembuatan_mesin', 'x_updated_at', 'updated_at', '`updated_at`', CastDateFieldForLike("`updated_at`", 0, "DB"), 135, 19, 0, false, '`updated_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->updated_at->Sortable = true; // Allow sort
        $this->updated_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->updated_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->updated_at->Param, "CustomMsg");
        $this->Fields['updated_at'] = &$this->updated_at;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`pembuatan_mesin`";
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
        $this->spesifikasi->DbValue = $row['spesifikasi'];
        $this->jumlah->DbValue = $row['jumlah'];
        $this->lama_pembuatan->DbValue = $row['lama_pembuatan'];
        $this->pemesan->DbValue = $row['pemesan'];
        $this->alamat->DbValue = $row['alamat'];
        $this->nomor_kontrak->DbValue = $row['nomor_kontrak'];
        $this->tanggal_kontrak->DbValue = $row['tanggal_kontrak'];
        $this->nilai_kontrak->DbValue = $row['nilai_kontrak'];
        $this->foto_kontrak->Upload->DbValue = $row['foto_kontrak'];
        $this->upload_ktp->Upload->DbValue = $row['upload_ktp'];
        $this->foto_mesin->Upload->DbValue = $row['foto_mesin'];
        $this->status->DbValue = $row['status'];
        $this->created_at->DbValue = $row['created_at'];
        $this->updated_at->DbValue = $row['updated_at'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['foto_kontrak']) ? [] : [$row['foto_kontrak']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto_kontrak->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto_kontrak->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['upload_ktp']) ? [] : [$row['upload_ktp']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->upload_ktp->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->upload_ktp->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['foto_mesin']) ? [] : [$row['foto_mesin']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->foto_mesin->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->foto_mesin->oldPhysicalUploadPath() . $oldFile);
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
        return $_SESSION[$name] ?? GetUrl("pembuatanmesinlist");
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
        if ($pageName == "pembuatanmesinview") {
            return $Language->phrase("View");
        } elseif ($pageName == "pembuatanmesinedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "pembuatanmesinadd") {
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
                return "PembuatanMesinView";
            case Config("API_ADD_ACTION"):
                return "PembuatanMesinAdd";
            case Config("API_EDIT_ACTION"):
                return "PembuatanMesinEdit";
            case Config("API_DELETE_ACTION"):
                return "PembuatanMesinDelete";
            case Config("API_LIST_ACTION"):
                return "PembuatanMesinList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "pembuatanmesinlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("pembuatanmesinview", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("pembuatanmesinview", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "pembuatanmesinadd?" . $this->getUrlParm($parm);
        } else {
            $url = "pembuatanmesinadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("pembuatanmesinedit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("pembuatanmesinadd", $this->getUrlParm($parm));
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
        return $this->keyUrl("pembuatanmesindelete", $this->getUrlParm());
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
        $this->spesifikasi->setDbValue($row['spesifikasi']);
        $this->jumlah->setDbValue($row['jumlah']);
        $this->lama_pembuatan->setDbValue($row['lama_pembuatan']);
        $this->pemesan->setDbValue($row['pemesan']);
        $this->alamat->setDbValue($row['alamat']);
        $this->nomor_kontrak->setDbValue($row['nomor_kontrak']);
        $this->tanggal_kontrak->setDbValue($row['tanggal_kontrak']);
        $this->nilai_kontrak->setDbValue($row['nilai_kontrak']);
        $this->foto_kontrak->Upload->DbValue = $row['foto_kontrak'];
        $this->foto_kontrak->setDbValue($this->foto_kontrak->Upload->DbValue);
        $this->upload_ktp->Upload->DbValue = $row['upload_ktp'];
        $this->upload_ktp->setDbValue($this->upload_ktp->Upload->DbValue);
        $this->foto_mesin->Upload->DbValue = $row['foto_mesin'];
        $this->foto_mesin->setDbValue($this->foto_mesin->Upload->DbValue);
        $this->status->setDbValue($row['status']);
        $this->created_at->setDbValue($row['created_at']);
        $this->updated_at->setDbValue($row['updated_at']);
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

        // spesifikasi

        // jumlah

        // lama_pembuatan

        // pemesan

        // alamat

        // nomor_kontrak

        // tanggal_kontrak

        // nilai_kontrak

        // foto_kontrak

        // upload_ktp

        // foto_mesin

        // status

        // created_at

        // updated_at

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

        // foto_kontrak
        if (!EmptyValue($this->foto_kontrak->Upload->DbValue)) {
            $this->foto_kontrak->ImageWidth = 200;
            $this->foto_kontrak->ImageHeight = 0;
            $this->foto_kontrak->ImageAlt = $this->foto_kontrak->alt();
            $this->foto_kontrak->ViewValue = $this->foto_kontrak->Upload->DbValue;
        } else {
            $this->foto_kontrak->ViewValue = "";
        }
        $this->foto_kontrak->ViewCustomAttributes = "";

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

        // status
        if (strval($this->status->CurrentValue) != "") {
            $this->status->ViewValue = $this->status->optionCaption($this->status->CurrentValue);
        } else {
            $this->status->ViewValue = null;
        }
        $this->status->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // updated_at
        $this->updated_at->ViewValue = $this->updated_at->CurrentValue;
        $this->updated_at->ViewValue = FormatDateTime($this->updated_at->ViewValue, 0);
        $this->updated_at->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

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

        // foto_kontrak
        $this->foto_kontrak->LinkCustomAttributes = "";
        if (!EmptyValue($this->foto_kontrak->Upload->DbValue)) {
            $this->foto_kontrak->HrefValue = GetFileUploadUrl($this->foto_kontrak, $this->foto_kontrak->htmlDecode($this->foto_kontrak->Upload->DbValue)); // Add prefix/suffix
            $this->foto_kontrak->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->foto_kontrak->HrefValue = FullUrl($this->foto_kontrak->HrefValue, "href");
            }
        } else {
            $this->foto_kontrak->HrefValue = "";
        }
        $this->foto_kontrak->ExportHrefValue = $this->foto_kontrak->UploadPath . $this->foto_kontrak->Upload->DbValue;
        $this->foto_kontrak->TooltipValue = "";
        if ($this->foto_kontrak->UseColorbox) {
            if (EmptyValue($this->foto_kontrak->TooltipValue)) {
                $this->foto_kontrak->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->foto_kontrak->LinkAttrs["data-rel"] = "pembuatan_mesin_x_foto_kontrak";
            $this->foto_kontrak->LinkAttrs->appendClass("ew-lightbox");
        }

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

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // updated_at
        $this->updated_at->LinkCustomAttributes = "";
        $this->updated_at->HrefValue = "";
        $this->updated_at->TooltipValue = "";

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

        // spesifikasi
        $this->spesifikasi->EditAttrs["class"] = "form-control";
        $this->spesifikasi->EditCustomAttributes = "";
        $this->spesifikasi->EditValue = $this->spesifikasi->CurrentValue;
        $this->spesifikasi->PlaceHolder = RemoveHtml($this->spesifikasi->caption());

        // jumlah
        $this->jumlah->EditAttrs["class"] = "form-control";
        $this->jumlah->EditCustomAttributes = "";
        if (!$this->jumlah->Raw) {
            $this->jumlah->CurrentValue = HtmlDecode($this->jumlah->CurrentValue);
        }
        $this->jumlah->EditValue = $this->jumlah->CurrentValue;
        $this->jumlah->PlaceHolder = RemoveHtml($this->jumlah->caption());

        // lama_pembuatan
        $this->lama_pembuatan->EditAttrs["class"] = "form-control";
        $this->lama_pembuatan->EditCustomAttributes = "";
        if (!$this->lama_pembuatan->Raw) {
            $this->lama_pembuatan->CurrentValue = HtmlDecode($this->lama_pembuatan->CurrentValue);
        }
        $this->lama_pembuatan->EditValue = $this->lama_pembuatan->CurrentValue;
        $this->lama_pembuatan->PlaceHolder = RemoveHtml($this->lama_pembuatan->caption());

        // pemesan
        $this->pemesan->EditAttrs["class"] = "form-control";
        $this->pemesan->EditCustomAttributes = "";
        if (!$this->pemesan->Raw) {
            $this->pemesan->CurrentValue = HtmlDecode($this->pemesan->CurrentValue);
        }
        $this->pemesan->EditValue = $this->pemesan->CurrentValue;
        $this->pemesan->PlaceHolder = RemoveHtml($this->pemesan->caption());

        // alamat
        $this->alamat->EditAttrs["class"] = "form-control";
        $this->alamat->EditCustomAttributes = "";
        if (!$this->alamat->Raw) {
            $this->alamat->CurrentValue = HtmlDecode($this->alamat->CurrentValue);
        }
        $this->alamat->EditValue = $this->alamat->CurrentValue;
        $this->alamat->PlaceHolder = RemoveHtml($this->alamat->caption());

        // nomor_kontrak
        $this->nomor_kontrak->EditAttrs["class"] = "form-control";
        $this->nomor_kontrak->EditCustomAttributes = "";
        if (!$this->nomor_kontrak->Raw) {
            $this->nomor_kontrak->CurrentValue = HtmlDecode($this->nomor_kontrak->CurrentValue);
        }
        $this->nomor_kontrak->EditValue = $this->nomor_kontrak->CurrentValue;
        $this->nomor_kontrak->PlaceHolder = RemoveHtml($this->nomor_kontrak->caption());

        // tanggal_kontrak
        $this->tanggal_kontrak->EditAttrs["class"] = "form-control";
        $this->tanggal_kontrak->EditCustomAttributes = "";
        $this->tanggal_kontrak->EditValue = FormatDateTime($this->tanggal_kontrak->CurrentValue, 8);
        $this->tanggal_kontrak->PlaceHolder = RemoveHtml($this->tanggal_kontrak->caption());

        // nilai_kontrak
        $this->nilai_kontrak->EditAttrs["class"] = "form-control";
        $this->nilai_kontrak->EditCustomAttributes = "";
        if (!$this->nilai_kontrak->Raw) {
            $this->nilai_kontrak->CurrentValue = HtmlDecode($this->nilai_kontrak->CurrentValue);
        }
        $this->nilai_kontrak->EditValue = $this->nilai_kontrak->CurrentValue;
        $this->nilai_kontrak->PlaceHolder = RemoveHtml($this->nilai_kontrak->caption());

        // foto_kontrak
        $this->foto_kontrak->EditAttrs["class"] = "form-control";
        $this->foto_kontrak->EditCustomAttributes = "";
        if (!EmptyValue($this->foto_kontrak->Upload->DbValue)) {
            $this->foto_kontrak->ImageWidth = 200;
            $this->foto_kontrak->ImageHeight = 0;
            $this->foto_kontrak->ImageAlt = $this->foto_kontrak->alt();
            $this->foto_kontrak->EditValue = $this->foto_kontrak->Upload->DbValue;
        } else {
            $this->foto_kontrak->EditValue = "";
        }
        if (!EmptyValue($this->foto_kontrak->CurrentValue)) {
            $this->foto_kontrak->Upload->FileName = $this->foto_kontrak->CurrentValue;
        }

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

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        $this->status->EditValue = $this->status->options(true);
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

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
                    $doc->exportCaption($this->spesifikasi);
                    $doc->exportCaption($this->jumlah);
                    $doc->exportCaption($this->lama_pembuatan);
                    $doc->exportCaption($this->pemesan);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->nomor_kontrak);
                    $doc->exportCaption($this->tanggal_kontrak);
                    $doc->exportCaption($this->nilai_kontrak);
                    $doc->exportCaption($this->foto_kontrak);
                    $doc->exportCaption($this->upload_ktp);
                    $doc->exportCaption($this->foto_mesin);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->nama_mesin);
                    $doc->exportCaption($this->spesifikasi);
                    $doc->exportCaption($this->jumlah);
                    $doc->exportCaption($this->lama_pembuatan);
                    $doc->exportCaption($this->pemesan);
                    $doc->exportCaption($this->alamat);
                    $doc->exportCaption($this->nomor_kontrak);
                    $doc->exportCaption($this->tanggal_kontrak);
                    $doc->exportCaption($this->nilai_kontrak);
                    $doc->exportCaption($this->foto_kontrak);
                    $doc->exportCaption($this->upload_ktp);
                    $doc->exportCaption($this->foto_mesin);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->updated_at);
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
                        $doc->exportField($this->spesifikasi);
                        $doc->exportField($this->jumlah);
                        $doc->exportField($this->lama_pembuatan);
                        $doc->exportField($this->pemesan);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->nomor_kontrak);
                        $doc->exportField($this->tanggal_kontrak);
                        $doc->exportField($this->nilai_kontrak);
                        $doc->exportField($this->foto_kontrak);
                        $doc->exportField($this->upload_ktp);
                        $doc->exportField($this->foto_mesin);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->nama_mesin);
                        $doc->exportField($this->spesifikasi);
                        $doc->exportField($this->jumlah);
                        $doc->exportField($this->lama_pembuatan);
                        $doc->exportField($this->pemesan);
                        $doc->exportField($this->alamat);
                        $doc->exportField($this->nomor_kontrak);
                        $doc->exportField($this->tanggal_kontrak);
                        $doc->exportField($this->nilai_kontrak);
                        $doc->exportField($this->foto_kontrak);
                        $doc->exportField($this->upload_ktp);
                        $doc->exportField($this->foto_mesin);
                        $doc->exportField($this->status);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->updated_at);
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
        if ($fldparm == 'foto_kontrak') {
            $fldName = "foto_kontrak";
            $fileNameFld = "foto_kontrak";
        } elseif ($fldparm == 'upload_ktp') {
            $fldName = "upload_ktp";
            $fileNameFld = "upload_ktp";
        } elseif ($fldparm == 'foto_mesin') {
            $fldName = "foto_mesin";
            $fileNameFld = "foto_mesin";
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
