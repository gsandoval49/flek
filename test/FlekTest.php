<?php
namespace Edu\Cnm\Flek\Test;

//grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * Abstract class containing universal and project specific mySQL parameters
 *
 * This class is designed to lay the foundation of the unit tests per project. It loads all the database parameters about the project so that table specifc tests can share the parameters in on place. To use it:
 *
 * 1. Rename the class from DataDesignTest to a project specific name (e.g., ProjectNameTest)
 * 2. Modify DataDesignTest::getDataSet() to include all the tables in your project
 * 3. Modity DataDesignTest::getConnection() to include the correct mySQL properties file.
 * 4. Have all table specific tests include this class.
 *
 * *NOTE*: Tables must be added in the order they were created in step (2).
 *
 * @author Chrisitna Sosa <csosa4@cnm.edu>
 *
 **/
abstract class FlekTest extends \PHPUnit_Extensions_Database_TestCase {
	/**
	 * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
	 * @see https://dev.mysql.com/doc/refman/5.6/en/integer-types.html mySQL Integer Types
	 * @var int INVALID_KEY
	**/
	const INVALID_KEY = 4294967296;

	/**
	 * PHPUnit database connection interface
	 * @var \PHPUnit_Extensions_Database_DB_IDatabaseConnection $connection
	**/
	protected $connection = null;

/**
 * assembles the table from the schema and provides it to PHPUnit
 *
 * @return \PHPUnit_Extensions_Database_QueryDataSet assembled schema for PHPUnit
**/
public final function getDataSet() {
	$dataset = new \PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());

	//add all the tables for hte project here
	//THESE TABLES *MUST* BE LISTED IN TEH SAME ORDER THEY WERE CREATED
	$dataset->addTable("profile");
	$dataset->addTable("mail");
	$dataset->addTable("socialLogin");
	$dataset->addTable("image");
	$dataset->addTable("genre");
	$dataset->addTable("hashtag");
	$dataset->addTable("tag");
	$dataset->addTable("favorite");
	retun($dataset);
}

/**
 * templates the setUp method that runs before each test; this method expunges the database before each run
 *
 * @see https://phpunit.de/manual/current/en/fixtures.html#fixtures.more-setup-than-teardown PHPUnit Fixtures: setUp and tearDown
 * @see https://github.com/sebastianbergmann/dbunit/issues/37 TRUNCATE fails on tables which have foreign key constraints
 * @return \PHPUnit_Extensions_Database_Operation_Composite array containing delete and insert commands
**/
public final function getSetUpOperation() {
	return new \PHPUnit_Extensions_Database_Operation_Composite(array(
		\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL(),
		\PHPUnit_Extensions_Database_Operation_Factory::INSERT()
	));
}

/**
 * templates the tearDown method that runs after each test; this method expunges the database after each run
 *
 * @return \PHPUnit_Extensions_Database_Operation_IDatabaseOperation delete command for the database
**/
public final function getTearDownOperation() {
	return(\PHPUnit_Extensions_Database_Operation_Factory::DELETE_ALL());
}

/**
 * sets up the database connection and provides it to PHPUnit
**/
}