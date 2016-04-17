<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * @brief Empty unit testing template/database version
 * @cond 
 * @brief Unit tests for the class 
 */

class ValidatorsTest extends \PHPUnit_Extensions_Database_TestCase {

    private static $site;

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
        return $this->createFlatXMLDataSet(dirname(__FILE__) . '/db/validator.xml');
    }

    public static function setUpBeforeClass() {
        self::$site = new Steampunked\Site();
        $localize  = require 'localize.inc.php';
        if(is_callable($localize)) {
            $localize(self::$site);
        }
    }


    public function test_construct() {
        $users = new Steampunked\Validators(self::$site);
        $this->assertInstanceOf('Steampunked\Validators', $users);
    }

    public function test_newValidator() {
        $validators = new Steampunked\Validators(self::$site);

        $validator = $validators->newValidator(27);
        $this->assertEquals(32, strlen($validator));

        $table = $validators->getTableName();
        $sql = <<<SQL
select * from $table
where userid=? and validator=?
SQL;

        $stmt = $validators->pdo()->prepare($sql);
        $stmt->execute(array(27, $validator));
        $this->assertEquals(1, $stmt->rowCount());
    }

    public function test_getOnce() {
        $validators = new Steampunked\Validators(self::$site);

         // Test a not-found condition
         $this->assertNull($validators->getOnce(""));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(27);
        $validator2 = $validators->newValidator(27);

        $this->assertEquals(27, $validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));

        // Create two validators
        // Either can work, but only one time!
        $validator1 = $validators->newValidator(33);
        $validator2 = $validators->newValidator(33);

        $this->assertEquals(33, $validators->getOnce($validator2));
        $this->assertNull($validators->getOnce($validator1));
        $this->assertNull($validators->getOnce($validator2));
    }
}

/// @endcond
?>
