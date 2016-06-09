# DB-Migration

[![Build Status](https://travis-ci.org/console-helpers/db-migration.svg?branch=master)](https://travis-ci.org/console-helpers/db-migration)
[![Coverage Status](https://coveralls.io/repos/github/console-helpers/db-migration/badge.svg?branch=master)](https://coveralls.io/github/console-helpers/db-migration?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/console-helpers/db-migration/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/console-helpers/db-migration/?branch=master)


[![Latest Stable Version](https://poser.pugx.org/console-helpers/db-migration/v/stable)](https://packagist.org/packages/console-helpers/db-migration)
[![Total Downloads](https://poser.pugx.org/console-helpers/db-migration/downloads)](https://packagist.org/packages/console-helpers/db-migration)
[![License](https://poser.pugx.org/console-helpers/db-migration/license)](https://packagist.org/packages/console-helpers/db-migration)

DB-Migration is a library allows to run migrations on SQLite databases with ease.

## Usage

```php
use Aura\Sql\ExtendedPdo;
use ConsoleHelpers\DatabaseMigration\MigrationManager;
use ConsoleHelpers\DatabaseMigration\MigrationContext;
use ConsoleHelpers\DatabaseMigration\PhpMigrationRunner;
use ConsoleHelpers\DatabaseMigration\SqlMigrationRunner;
use Pimple\Container;

// 1. Create migration manager instance.
$migration_manager = new MigrationManager(
	'/path/to/migrations', // Directory containing migrations.
	new Container() // Anything implementing "ArrayAccess".
);

// 2. Register migration runners.
$migration_manager->registerMigrationRunner(new SqlMigrationRunner());
$migration_manager->registerMigrationRunner(new PhpMigrationRunner());

// 3. Create database connection.
$database = new ExtendedPdo('sqlite:/path/to/database.sqlite');

// 4. Run migrations.
$migration_manager->runMigrations(
	// Context consists of database and a container.
	new MigrationContext($database)
);
```

## Installation

* execute this command to add dependencies: `php composer.phar require console-helpers/db-migration:^0.1`

## Requirements

* [Aura.Sql](https://github.com/auraphp/Aura.Sql)

## Contributing

See [CONTRIBUTING](CONTRIBUTING.md) file.

## License

DB-Migration is released under the BSD-3-Clause License. See the bundled [LICENSE](LICENSE) file for details.
