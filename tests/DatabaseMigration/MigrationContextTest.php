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


use Aura\Sql\ExtendedPdoInterface;
use ConsoleHelpers\DatabaseMigration\MigrationContext;

class MigrationContextTest extends AbstractTestCase
{

	/**
	 * Database.
	 *
	 * @var ExtendedPdoInterface
	 */
	protected $database;

	/**
	 * Container.
	 *
	 * @var \ArrayAccess
	 */
	protected $container;

	/**
	 * Context.
	 *
	 * @var MigrationContext
	 */
	protected $context;

	/**
	 * @before
	 * @return void
	 */
	protected function setupTest()
	{
		$this->database = $this->prophesize(ExtendedPdoInterface::class)->reveal();
		$this->container = $this->prophesize('ArrayAccess')->reveal();

		$this->context = new MigrationContext($this->database);
	}

	public function testNoContainerInitially()
	{
		$this->assertNull($this->context->getContainer());
	}

	public function testSetContainer()
	{
		$this->context->setContainer($this->container);

		$this->assertSame($this->container, $this->context->getContainer());
	}

	public function testGetDatabase()
	{
		$this->assertSame($this->database, $this->context->getDatabase());
	}

}
