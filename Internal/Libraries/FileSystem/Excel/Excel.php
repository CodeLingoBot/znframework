<?php
namespace ZN\FileSystem;

class InternalExcel extends \CallController implements ExcelInterface
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
	// Output
	//----------------------------------------------------------------------------------------------------
	//
	// @param array  $rows
	//
	//----------------------------------------------------------------------------------------------------
	public function rows(Array $rows)
	{
		$this->rows = $rows;
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// fileName
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $fileName
	//
	//----------------------------------------------------------------------------------------------------
	public function fileName(String $fileName)
	{
		$this->fileName = suffix($fileName, '.xls');
		
		return $this;	
	}
	
	//----------------------------------------------------------------------------------------------------
	// Array To XLS
	//----------------------------------------------------------------------------------------------------
	//
	// @param array  $data
	// @param string $file
	//
	//----------------------------------------------------------------------------------------------------
	public function arrayToXLS(Array $data, String $file = 'excel.xls')
	{
		if( ! empty($this->fileName) )
		{
			$file = $this->fileName;
			$this->fileName = NULL;	
		}
		
		$file = suffix($file, '.xls');
		
		header("Content-Disposition: attachment; filename=\"$file\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		if( ! empty($this->rows) )
		{
			$data = $this->rows;
			$this->rows = NULL;	
		}
		
		$output = fopen("php://output", 'w');
		
		foreach( $data as $column )
		{
			fputcsv($output, $column, "\t");
		}
		
		fclose($output);
	}
	
	//----------------------------------------------------------------------------------------------------
	// CSV To Array
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $file
	//
	//----------------------------------------------------------------------------------------------------
	public function CSVToArray(String $file) : Array
	{
		if( ! empty($this->fileName) )
		{
			$file = $this->fileName;	
			$this->fileName = NULL;	
		}
		
		$file = suffix($file, '.csv');
		
		if( ! is_file($file) )
		{
			\Exceptions::throws('File', 'notFoundError', $file);

			return [];
		}
		
		$row  = 1;
		$rows = [];
		
		if( ( $resource = fopen($file, "r") ) !== false ) 
		{
			while( ($data = fgetcsv($resource, 1000, ",")) !== false ) 
			{
				$num = count($data);
			
				$row++;
				for( $c = 0; $c < $num; $c++ ) 
				{
					$rows[] = explode(';', $data[$c]);
				}
			}
			 
			fclose($resource);
		 }	
		 
		 return $rows;
	}
}