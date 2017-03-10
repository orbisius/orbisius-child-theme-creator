<?php
	/**
	 * Test search by snippet title with pre-set results
	 * 
	 * Returns the code of the snippet which matches the title
	 *
	 * TODO	Provide suggestions among results from db
	 *
	 */
	if ( isset( $_GET[ "search" ] ) )
	{
		$search	= $_GET[ "search" ];
	}

	$results	= array(
			array( "title" => "JAVA", "id" => "1", "code" => "[shortcode]" ),
			array( "title" => "DATA IMAGE PROCESSING", "id" => "2", "code" => "[shortcode]" ),
			array( "title" => "JAVASCRIPT", "id" => "3", "code" => "[shortcode]" ),
			array( "title" => "DATA MANAGEMENT SYSTEM", "id" => "4", "code" => "[shortcode]" ),
			array( "title" => "COMPUTER PROGRAMMING", "id" => "5", "code" => "[shortcode]" ),
			array( "title" => "SOFTWARE DEVELOPMENT LIFE CYCLE", "id" => "6", "code" => "[shortcode]" ),
			array( "title" => "LEARN COMPUTER FUNDAMENTALS", "id" => "7", "code" => "[shortcode]" ),
			array( "title" => "IMAGE PROCESSING USING JAVA", "id" => "8", "code" => "[shortcode]" ),
			array( "title" => "CLOUD COMPUTING", "id" => "9", "code" => "[shortcode]" ),
			array( "title" => "DATA MINING", "id" => "10", "code" => "[shortcode]" ),
			array( "title" => "DATA WAREHOUSE", "id" => "11", "code" => "[shortcode]" ),
			array( "title" => "E-COMMERCE", "id" => "12", "code" => "[shortcode]" ),
			array( "title" => "DBMS", "id" => "13", "code" => "[shortcode]" ),
			array( "title" => "HTTP", "id" => "14", "code" => "[shortcode]" )
	);
	
	$snippetCode	= array();
	
	foreach ( $results as $result )
	{
		$resultTitle	= $result[ "title" ];
		
		if ( strtoupper( $resultTitle ) == strtoupper( $search ) )
		{
			array_push( $snippetCode, $result["code"] );
		}
	}
	
	echo json_encode( $snippetCode );