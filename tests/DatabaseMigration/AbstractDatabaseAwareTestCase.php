<?php
/**
 * This file is part of the DB-Migration library.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @copyright Alexander Obuhovich <aik.bold@gmail.com>
 * @link      https://github.com/console-helpers/db-migration
 */

namespace Tests\ConsoleHelpers\DatabaseMigration;


use Aura\Sql\ExtendedPdo;
use Aura\Sql\ExtendedPdoInterface;

abstract class AbstractDatabaseAwareTestCase extends AbstractTestCase
{

	/**
	 * Database.
	 *
	 * @var ExtendedPdoInterface
	 */
	protected $database;

	/**
	 * @before
	 * @return void
	 */
	protected function setupTest()
	{
		$this->database = $this->createDatabase();
	}

	/**
	 * Checks, that database table is empty.
	 *
	 * @param array $table_names Table names.
	 *
	 * @return void
	 */
	protected function assertTablesEmpty(array $table_names)
	{
		foreach ( $table_names as $table_name ) {
			$this->assertTableCount($table_name, 0);
		}
	}

	/**
	 * Checks, that database table is empty.
	 *
	 * @param string $table_name Table name.
	 *
	 * @return void
	 */
	protected function assertTableEmpty($table_name)
	{
		$this->assertTableCount($table_name, 0);
	}

	/**
	 * Checks, table content.
	 *
	 * @param string $table_name       Table name.
	 * @param array  $expected_content Expected content.
	 *
	 * @return void
	 */
	protected function assertTableContent($table_name, array $expected_content)
	{
		$this->assertEquals(
			$expected_content,
			$this->_dumpTable($table_name),
			'Table "' . $table_name . '" content isn\'t correct.'
		);
	}

	/**
	 * Returns contents of the table.
	 *
	 * @param string $table_name Table name.
	 *
	 * @return array
	 */
	private function _dumpTable($table_name)
	{
		$profiler = $this->database->getProfiler();

		if ( is_object($profiler) ) {
			$profiler->setActive(false);
		}

		$sql = 'SELECT *
				FROM ' . $table_name;
		$table_content = $this->database->fetchAll($sql);

		if ( is_object($profiler) ) {
			$profiler->setActive(true);
		}

		return $table_content;
	}

	/**
	 * Checks, that database table contains given number of records.
	 *
	 * @param string  $table_name            Table name.
	 * @param integer $expected_record_count Expected record count.
	 *
	 * @return void
	 */
	protected function assertTableCount($table_name, $expected_record_count)
	{
		$profiler = $this->database->getProfiler();

		if ( is_object($profiler) ) {
			$profiler->setActive(false);
		}

		$sql = 'SELECT COUNT(*)
				FROM ' . $table_name;
		$actual_record_count = $this->database->fetchValue($sql);

		if ( is_object($profiler) ) {
			$profiler->setActive(true);
		}

		$this->assertEquals(
			$expected_record_count,
			$actual_record_count,
			'The "' . $table_name . '" table contains ' . $expected_record_count . ' records'
		);
	}

	/**
	 * Creates database for testing with correct db structure.
	 *
	 * @return ExtendedPdoInterface
	 */
	protected function createDatabase()
	{
		return new ExtendedPdo('sqlite::memory:');
	}

}
