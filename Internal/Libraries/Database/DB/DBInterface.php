<?php
namespace ZN\Database;

interface DBInterface
{	
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Select
	//----------------------------------------------------------------------------------------------------
	//
	// @param string ...$condition
	//
	//----------------------------------------------------------------------------------------------------
	public function select($condition);
	
	//----------------------------------------------------------------------------------------------------
	// Where
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed  $column
	// @param scalar $value
	// @param string $logical
	//
	//----------------------------------------------------------------------------------------------------
	public function where($column, $value, String $logical);
	
	
	//----------------------------------------------------------------------------------------------------
	// Having
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed  $column
	// @param scalar $value
	// @param string $logical
	//
	//----------------------------------------------------------------------------------------------------
	public function having($column, $value, String $logical);

	//----------------------------------------------------------------------------------------------------
	// Where Group
	//----------------------------------------------------------------------------------------------------
	//
	// @param array ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function whereGroup(...$args);

	//----------------------------------------------------------------------------------------------------
	// Having Group
	//----------------------------------------------------------------------------------------------------
	//
	// @param array ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function havingGroup(...$args);
	
	//----------------------------------------------------------------------------------------------------
	// Join
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	// @param string $condition
	// @param string $type
	//
	//----------------------------------------------------------------------------------------------------
	public function join(String $table, String $condition, String $type);

	//----------------------------------------------------------------------------------------------------
	// Inner Join
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	// @param string $column
	// @param string $otherColumn
	//
	//----------------------------------------------------------------------------------------------------
	public function innerJoin(String $table, String $otherColumn, $operator);

	//----------------------------------------------------------------------------------------------------
	// Outer Join
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	// @param string $column
	// @param string $otherColumn
	//
	//----------------------------------------------------------------------------------------------------
	public function outerJoin(String $table, String $otherColumn, $operator);

	//----------------------------------------------------------------------------------------------------
	// Left Join
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	// @param string $column
	// @param string $otherColumn
	//
	//----------------------------------------------------------------------------------------------------
	public function leftJoin(String $table, String $otherColumn, $operator);

	//----------------------------------------------------------------------------------------------------
	// Right Join
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	// @param string $column
	// @param string $otherColumn
	//
	//----------------------------------------------------------------------------------------------------
	public function rightJoin(String $table, String $otherColumn, $operator);
	
	//----------------------------------------------------------------------------------------------------
	// Get
	//----------------------------------------------------------------------------------------------------
	//
	// Sorguyu tamamlamak için kullanılır.
	//
	// @param  string $table  -> Tablo adı.
	// @return string $return -> Sorgunun dönüş türü. object, string
	//
	//----------------------------------------------------------------------------------------------------
	public function get(String $table, String $return);

	//----------------------------------------------------------------------------------------------------
	// Get String
	//----------------------------------------------------------------------------------------------------
	//
	// Sorguyunun çalıştırılmadan metinsel çıktısını almak için kullanılır.
	//
	// @param  string $table -> Tablo adı.
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function getString(String $table);
	
	//----------------------------------------------------------------------------------------------------
	// Query
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $query
	// @param array  $secure
	//
	//----------------------------------------------------------------------------------------------------
	public function query(String $query, Array $secure);
	
	//----------------------------------------------------------------------------------------------------
	// Exec Query
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $query
	// @param array  $secure
	//
	//----------------------------------------------------------------------------------------------------
	public function execQuery(String $query, Array $secure);

	//----------------------------------------------------------------------------------------------------
	// Multi Query
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $query
	// @param array  $secure
	//
	//----------------------------------------------------------------------------------------------------
	public function multiQuery(String $query, Array $secure);
	
	//----------------------------------------------------------------------------------------------------
	// Trans Start
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function transStart();
	
	//----------------------------------------------------------------------------------------------------
	// Trans End
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function transEnd();
	
	//----------------------------------------------------------------------------------------------------
	// Total Rows
	//----------------------------------------------------------------------------------------------------
	//
	// @param bool $total
	//
	//----------------------------------------------------------------------------------------------------
	public function totalRows(Boolean $total);
	
	//----------------------------------------------------------------------------------------------------
	// Total Columns
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function totalColumns();
	
	//----------------------------------------------------------------------------------------------------
	// Columns
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function columns();
	
	//----------------------------------------------------------------------------------------------------
	// Result
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $type: object, 'json', 'array'
	//
	//----------------------------------------------------------------------------------------------------
	public function result(String $type);
	
	//----------------------------------------------------------------------------------------------------
	// Result Array
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function resultArray();
	
	//----------------------------------------------------------------------------------------------------
	// Result Json
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function resultJson();
	
	//----------------------------------------------------------------------------------------------------
	// Fetch Array
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function fetchArray();
	
	//----------------------------------------------------------------------------------------------------
	// Fetch Assoc
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function fetchAssoc();
	
	//----------------------------------------------------------------------------------------------------
	// Fetch
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $type: assoc, array, row
	//
	//----------------------------------------------------------------------------------------------------
	public function fetch(String $type);
	
	//----------------------------------------------------------------------------------------------------
	// Fetch Row
	//----------------------------------------------------------------------------------------------------
	//
	// @param boolean $printable
	//
	//----------------------------------------------------------------------------------------------------
	public function fetchRow(Boolean $printable);
	
	//----------------------------------------------------------------------------------------------------
	// Row
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed $printable
	//
	//----------------------------------------------------------------------------------------------------
	public function row($printable);
	
	//----------------------------------------------------------------------------------------------------
	// Value
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function value();
	
	//----------------------------------------------------------------------------------------------------
	// Affected Rows
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function affectedRows();
	
	//----------------------------------------------------------------------------------------------------
	// Insert ID
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function insertID();
	
	//----------------------------------------------------------------------------------------------------
	// Column Data
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function columnData(String $column);
	
	//----------------------------------------------------------------------------------------------------
	// Table Name
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function tableName();
	
	//----------------------------------------------------------------------------------------------------
	// Pagination
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $url
	// @param array  $settigs
	// @param bool   $output
	//
	//----------------------------------------------------------------------------------------------------
	public function pagination(String $url, Array $settings, Boolean $output);
	
	//----------------------------------------------------------------------------------------------------
	// Group By
	//----------------------------------------------------------------------------------------------------
	//
	// @param string ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function groupBy($condition);
	
	//----------------------------------------------------------------------------------------------------
	// Order By
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed  $condition
	// @param string $type
	//
	//----------------------------------------------------------------------------------------------------
	public function orderBy($condition, String $type);
	
	//----------------------------------------------------------------------------------------------------
	// Limit
	//----------------------------------------------------------------------------------------------------
	//
	// @param int $start
	// @param int $limit
	//
	//----------------------------------------------------------------------------------------------------
	public function limit($start, $limit);
	
	//----------------------------------------------------------------------------------------------------
	// Status
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $table
	//
	//----------------------------------------------------------------------------------------------------
	public function status(String $table);
	
	//----------------------------------------------------------------------------------------------------
	// Increment
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed   $table
	// @param mixed   $columns
	// @param numeric $increment
	//
	//----------------------------------------------------------------------------------------------------
	public function increment($table, $columns, $increment);
	
	//----------------------------------------------------------------------------------------------------
	// Decrement
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed   $table
	// @param mixed   $columns
	// @param numeric $decrement
	//
	//----------------------------------------------------------------------------------------------------
	public function decrement($table, $columns, $decrement);
	
	//----------------------------------------------------------------------------------------------------
	// Insert
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed $table
	// @param mixed $datas
	//
	//----------------------------------------------------------------------------------------------------
	public function insert($table, $datas);
	
	//----------------------------------------------------------------------------------------------------
	// Updated
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed $table
	// @param mixed $set
	//
	//----------------------------------------------------------------------------------------------------
	public function update($table, $set);
	
	//----------------------------------------------------------------------------------------------------
	// Delete
	//----------------------------------------------------------------------------------------------------
	//
	// @param mixed $table
	//
	//----------------------------------------------------------------------------------------------------
	public function delete($table);
	
	//----------------------------------------------------------------------------------------------------
	// Escape String
	//----------------------------------------------------------------------------------------------------
	//
	// Tırnak işaretlerinin başına \ işareti ekler.
	//
	// @param  string $data
	// @return string 
	//
	//----------------------------------------------------------------------------------------------------
	public function escapeString(String $data);
	
	//----------------------------------------------------------------------------------------------------
	// Real Escape String
	//----------------------------------------------------------------------------------------------------
	//
	// Tırnak işaretlerinin başına \ işareti ekler.
	//
	// @param  string $data
	// @return string 
	//
	//----------------------------------------------------------------------------------------------------
	public function realEscapeString(String $data);

	//----------------------------------------------------------------------------------------------------
	// Alias
	//----------------------------------------------------------------------------------------------------
	//
	// Veriye takma ad vermek için kullanılır.
	//
	// @param  string $string   -> Metin.
	// @param  string $alias    -> Takma ad.
	// @param  bool   $brackets -> Parantezlerin olup olmayacağı.
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function alias(String $string, String $alias, $brackets);

	//----------------------------------------------------------------------------------------------------
	// Brackets
	//----------------------------------------------------------------------------------------------------
	//
	// Verinin başına ve sonuna parantez eklemek için kullanılır.
	//
	// @param  string $string   -> Metin.
	// @return string
	//
	//----------------------------------------------------------------------------------------------------
	public function brackets(String $string);

	//----------------------------------------------------------------------------------------------------
	// All
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function all();

	//----------------------------------------------------------------------------------------------------
	// Distinct
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function distinct();

	//----------------------------------------------------------------------------------------------------
	// Max Statement Time
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function maxStatementTime($time);

	//----------------------------------------------------------------------------------------------------
	// Distinct Row
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function distinctRow();

	//----------------------------------------------------------------------------------------------------
	// Distinct Row
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function straightJoin();

	//----------------------------------------------------------------------------------------------------
	// High Priority
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function highPriority();
	
	//----------------------------------------------------------------------------------------------------
	// Low Priority
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function lowPriority();
	
	//----------------------------------------------------------------------------------------------------
	// Quick
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function quick();
	
	//----------------------------------------------------------------------------------------------------
	// Delayed
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function delayed();
	
	//----------------------------------------------------------------------------------------------------
	// Ignore
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function ignore();
	
	//----------------------------------------------------------------------------------------------------
	// Partition
	//----------------------------------------------------------------------------------------------------
	//
	// @param string ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function partition(...$args);

	//----------------------------------------------------------------------------------------------------
	// Procedure
	//----------------------------------------------------------------------------------------------------
	//
	// @param string ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function procedure(...$args);

	//----------------------------------------------------------------------------------------------------
	// Out File
	//----------------------------------------------------------------------------------------------------
	//
	// @param string ...$args
	//
	//----------------------------------------------------------------------------------------------------
	public function outFile(String $file);

	//----------------------------------------------------------------------------------------------------
	// Dump File
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $file
	//
	//----------------------------------------------------------------------------------------------------
	public function dumpFile(String $file);

	//----------------------------------------------------------------------------------------------------
	// Character Set
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $file
	//
	//----------------------------------------------------------------------------------------------------
	public function characterSet(String $set, $return);

	//----------------------------------------------------------------------------------------------------
	// Character Set
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $set
	//
	//----------------------------------------------------------------------------------------------------
	public function cset(String $set);

	//----------------------------------------------------------------------------------------------------
	// Collate
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $set
	//
	//----------------------------------------------------------------------------------------------------
	public function collate(String $set);

	//----------------------------------------------------------------------------------------------------
	// Encoding
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $charset
	// @param string $collate
	//
	//----------------------------------------------------------------------------------------------------
	public function encoding(String $charset, String $collate);

	//----------------------------------------------------------------------------------------------------
	// Into
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $varname1
	// @param string $varname2
	//
	//----------------------------------------------------------------------------------------------------
	public function into(String $varname1, String $varname2);

	//----------------------------------------------------------------------------------------------------
	// For Update
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function forUpdate();

	//----------------------------------------------------------------------------------------------------
	// Lock In Share Mode
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function lockInShareMode();

	//----------------------------------------------------------------------------------------------------
	// Small Result
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function smallResult();
	
	//----------------------------------------------------------------------------------------------------
	// Big Result
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function bigResult();
	
	//----------------------------------------------------------------------------------------------------
	// Buffer Result
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function bufferResult();
	
	//----------------------------------------------------------------------------------------------------
	// Cache
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function cache();
	
	//----------------------------------------------------------------------------------------------------
	// No Cache
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function noCache();
	
	//----------------------------------------------------------------------------------------------------
	// Calc Found Rows
	//----------------------------------------------------------------------------------------------------
	//
	// @param void
	//
	//----------------------------------------------------------------------------------------------------
	public function calcFoundRows();
}