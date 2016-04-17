<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class LoginControllersTest extends \PHPUnit_Extensions_Database_TestCase
{
    private static $site;

    public function test_construct() {
        $session = array();	// Fake session
        $root = self::$site->getRoot();

        // Valid login
        $controller = new Steampunked\LoginController(self::$site, $session,
            array("email" => "cbowen@cse.msu.edu", "password" => "super477"));

        $this->assertEquals("Owen, Charles", $session[Steampunked\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/new-steampunked.php", $controller->getRedirect());

        // Valid guest login\
        $controller = new Steampunked\LoginController(self::$site, $session,
            array('Guest' => ""));

        $this->assertEquals("guest", $session[Steampunked\User::SESSION_NAME]->getName());
        $this->assertEquals("$root/new-steampunked.php", $controller->getRedirect());

        // Invalid login
        $controller = new Steampunked\LoginController(self::$site, $session,
            array("email" => "bart@bartman.com", "password" => "wrongpassword"));

        $this->assertNull($session[Steampunked\User::SESSION_NAME]);
        $this->assertEquals("$root/index.php?e", $controller->getRedirect());
    }



    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection() {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'steele41');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet() {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/user.xml');
    }

    public static function setUpBeforeClass() {
        self::$site = new Steampunked\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }


	
}

/// @endcond
?>
