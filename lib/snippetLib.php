<?php
	/**
	 * Test autocomplete with pre-set results
	 * 
	 * TODO	Provide suggestions among results from db
	 * 
	 */
	if ( isset( $_GET[ "term" ] ) )
	{
		$term	= $_GET[ "term" ];
	}
	
	$results	= array(
		array( "title" => "JAVA", "id" => "1" ),
		array( "title" => "DATA IMAGE PROCESSING", "id" => "2" ),
		array( "title" => "JAVASCRIPT", "id" => "3" ),
		array( "title" => "DATA MANAGEMENT SYSTEM", "id" => "4" ),
		array( "title" => "COMPUTER PROGRAMMING", "id" => "5" ),
		array( "title" => "SOFTWARE DEVELOPMENT LIFE CYCLE", "id" => "6" ),
		array( "title" => "LEARN COMPUTER FUNDAMENTALS", "id" => "7" ),
		array( "title" => "IMAGE PROCESSING USING JAVA", "id" => "8" ),
		array( "title" => "CLOUD COMPUTING", "id" => "9" ),
		array( "title" => "DATA MINING", "id" => "10" ),
		array( "title" => "DATA WAREHOUSE", "id" => "11" ),
		array( "title" => "E-COMMERCE", "id" => "12" ),
		array( "title" => "DBMS", "id" => "13" ),
		array( "title" => "HTTP", "id" => "14" )
	);
	
	$suggestions	= array();
	
	foreach ( $results as $result )
	{
		$resultTitle	= $result[ "title" ];
		
		if ( strpos( strtoupper( $resultTitle ), strtoupper( $term ) ) !== false )
		{
			array_push( $suggestions, $result );
		}
	}
	
	echo json_encode( $suggestions );