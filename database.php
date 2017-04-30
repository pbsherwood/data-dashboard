<?php
class Database__Query
{
    public $dbconn;
    public $result;
    public $tables = array();
    public $numrows;
    public $dbName;
	public $order;
	public $group;
	public $clauses = array();

    public function __construct($passedDBName) 
    {
		$this->dbName = $passedDBName;
		$this->initialize_db_conn();
    }

    public function initialize_db_conn()
    {
        $this->dbconn = mysqli_connect("SERVER","USERNAME","PASSWORD");
		if (!$this->dbconn)
		{
			die('Could not connect: ' . mysqli_error($this->dbconn));
		}
		mysqli_select_db($this->dbconn, $this->dbName);
    }

	public function build_query_statement($base_sql)
	{
		$SQL = $base_sql;
		if (count($this->clauses) > 0)
		{
		   $where_clause = " where " . implode(" and ", $this->clauses);
		   $SQL .= $where_clause;
		}	

		if ($this->group != "")
		{
			$SQL .= " group by " . $this->group;
		}
		
		if ($this->order != "")
		{
			$SQL .= " order by " . $this->order;
		}
		return $SQL;
	}
	
	public function set_order($passedOrder)
    {
		$this->order = $passedOrder;
    }
	
	public function set_grouping($passedGroup)
    {
		$this->group = $passedGroup;
    }

    public function add_clause($passedClause)
    {
		array_push($this->clauses, $passedClause);
    } 
	
    public function query($base_sql)
    { 
		$SQL = $this->build_query_statement($base_sql);
		$this->result = mysqli_query($this->dbconn, $SQL);

	    if (!$this->result)
	    {
	       echo "<h2>[$SQL] FAILED</h2>"; 
	    }
	    return $this->result;
    }

    public function get_num_results(){ 
        $this->numrows = mysqli_num_rows($this->result);
		return $this->numrows;
    }

    public function get_all_rows()
    { 
		$records = $this->mysqli_fetch_all();
		return $records;
    }

	function mysqli_fetch_all ($result_type = MYSQLI_BOTH)    
	{        
		if (!($this->result instanceof mysqli_result))        
		{            
			trigger_error(__FUNCTION__ . '(): supplied argument is not a valid MySQL result resource', E_USER_WARNING);            
			return false;        
		}        
		if (!in_array($result_type, array(MYSQLI_ASSOC, MYSQLI_BOTH, MYSQLI_NUM), true))        
		{            
			trigger_error(__FUNCTION__ . '(): result type should be MYSQLI_NUM, MYSQLI_ASSOC, or MYSQLI_BOTH', E_USER_WARNING);            
			return false;        
		}        
		$rows = array();        
		while ($row = mysqli_fetch_array($this->result, $result_type))        
		{            
			$rows[] = $row;        
		}        
		return $rows;    
	}

}
?>
	
