<?php
namespace BookStore\Test\Util;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;

use PDO;
use ReflectionClass;
use Exception;

abstract class DatabaseTestCase extends TestCase
{
    use TestCaseTrait;

    /**
     * Fixture file path
     * @type string
     */
    protected $fixtureFile = null;

    /**
     * Fixture file type
     * @type string
     */
    protected $fixtureXmlType = '';

    /**
     * PDO Object as a singleton.
     * @type PDO
     */
    static private $pdo = null;

    /**
     * DBConnection as a singleton.
     * @type {[type]}
     */
    private $conn;

    /**
     * @return PHPUnit\DbUnit\Database\IConnection
     */
    public function getConnection()
    {
        if ($this->conn === null) {
            $this->conn = $this->createDefaultDBConnection($this->getPDO(), $GLOBALS['DB_DBNAME']);
        }

        return $this->conn;
    }

    /**
     * Get PDO Instance
     *
     * @return PDO
     */
    protected function getPDO()
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                $GLOBALS['DB_DSN'],
                $GLOBALS['DB_USER'],
                $GLOBALS['DB_PASSWORD']
            );
        }
        return self::$pdo;
    }

    /**
     * @return PHPUnit\DbUnit\DataSet\IDataSet
     */
    public function getDataSet()
    {
        $filePath = $this->getFixtureFilePath();
        if (is_null($filePath)) {
            throw new Exception("\$fixtureFile property required");
        }

        $basePath = $this->getCurrentFilePath();

        $methodName = "create{$this->fixtureXmlType}XMLDataSet";
        return $this->$methodName($basePath . $filePath);
    }

    /**
     * Set fixture format as a MySQL XML format.
     *
     * The XML file can extract from MySQL server via mysqldump command.
     *
     *   mysqldump --xml -t -u [username] --password=[password] \
     *    [database] > /path/to/file.xml
     *
     * @return void
     */
    public function setFixtureFormatAsMySQLXML() {
        $this->fixtureXmlType = 'MySQL';
    }

    /**
     * Set fixture format as a Flat XML format.
     *
     * @return void
     */
    public function setFixtureFormatAsFlatXML() {
        $this->fixtureXmlType = 'Flat';
    }

    /**
     * Set fixture format as a XML format.
     *
     * @return void
     */
    public function setFixtureFormatAsXML() {
        $this->fixtureXmlType = '';
    }

    /**
     * Returns fixture file path
     *
     * @return string
     */
    public function getFixtureFilePath() {
        return $this->fixtureFile;
    }

    /**
     * Get Current File Path
     *
     * __FILE__ refers defined file path so that this method uses ReflectionClass
     * for identifying acutal path of the class.
     *
     * @return string
     */
    public function getCurrentFilePath()
    {
        return dirname((new ReflectionClass($this))->getFileName());
    }
}
