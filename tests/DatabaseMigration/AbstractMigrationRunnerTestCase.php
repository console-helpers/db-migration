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


use ConsoleHelpers\DatabaseMigration\AbstractMigrationRunner;
use Prophecy\Prophecy\ObjectProphecy;
use Aura\Sql\ExtendedPdoInterface;
use ConsoleHelpers\DatabaseMigration\MigrationContext;

abstract class AbstractMigrationRunnerTestCase extends AbstractTestCase
{

	/**
	 * Database.
	 *
	 * @var ObjectProphecy
	 */
	protected $database;

	/**
	 * Migration context.
	 *
	 * @var ObjectProphecy
	 */
	protected $context;

	/**
	 * Migration runner.
	 *
	 * @var AbstractMigrationRunner
	 */
	protected $runner;

	/**
	 * @before
	 * @return void
	 */
	protected function setupTest()
	{
		$this->database = $this->prophesize(ExtendedPdoInterface::class);

		$this->context = $this->prophesize(MigrationContext::class);
		$this->context->getDatabase()->willReturn($this->database);

		$this->runner = $this->createMigrationRunner();
	}

	/**
	 * Creates migration type.
	 *
	 * @return AbstractMigrationRunner
	 */
	abstract protected function createMigrationRunner();

	/**
	 * Returns fixture by name.
	 *
	 * @param string $name Fixture name.
	 *
	 * @return string
	 * @throws \InvalidArgumentException When fixture not found.
	 */
	protected function getFixture($name)
	{
		$absolute_path = __DIR__ . '/fixtures/' . $name;

		if ( !file_exists($absolute_path) ) {
			throw new \InvalidArgumentException('The "' . $name . '" fixture not found.');
		}

		return $absolute_path;
	}

}
