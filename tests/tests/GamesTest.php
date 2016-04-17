<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */


class GamesTest extends \PHPUnit_Extensions_Database_TestCase
{

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection(self::$site->pdo(), 'steele41');
    }

    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/games.xml');
    }


    private static $site;

    public static function setUpBeforeClass()
    {
        self::$site = new Steampunked\Site();
        $localize = require 'localize.inc.php';
        if (is_callable($localize)) {
            $localize(self::$site);
        }
    }


    public function test_construct()
    {
        $games = new Steampunked\Games(self::$site);
        $this->assertInstanceOf('Steampunked\Games', $games);
    }

    public function test_getGames()
    {
        $games = new Steampunked\Games(self::$site);
        $game = $games->getGames();



    }

    public function test_addNewGames()
    {
        ;
    }

    public function test_getNewGames()
    {
        ;
    }

    public function test_addPlayer2toGame()
    {
        ;
    }

    public function test_getPlayerIdForGames()
    {
        ;
    }

    public function test_setState()
    {
        ;
    }

    public function test_setTurn()
    {
        ;
    }
}
/// @endcond
?>
