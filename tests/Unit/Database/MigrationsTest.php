<?php declare(strict_types=1);

namespace Tests\Unit\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MigrationsTest extends TestCase
{
	/**
	 * We want to make sure that down migrations work
	 * For example, let's say you wanted to drop a column
	 *      $table->dropColumn('foo');
	 * But your down doesn't undo the change, then the down
	 * wasn't sucessful. Worse, if you run migrate, rollback,
	 * migrate, you'll get an error.
	 *
	 * This just walks the migrations, to ensure each step is
	 * fully reversable.
	 */
	public function testMigrationUpDownIdempotent(): void
	{
		// Start with a fresh database
		$this->artisan('db:wipe');
		$this->artisan('migrate:install');

		/** @var Migrator $migrator **/
		$migrator = $this->app->make('migrator');

		// Get info about the migrations
		$migrationFiles = $migrator->getMigrationFiles($this->app->databasePath('migrations'));

		// Loop through them. Ignoring coverage on the foreach,
		// as we aren't testing for no migrations.
		foreach ($migrationFiles as $migrationFile) { // @codeCoverageIgnore
			// First get the current schema
			/** @var Connection $connection */
			$connection = DB::connection();
			$before = $connection->getDoctrineSchemaManager()->createSchema();

			// Then run the migration's up/down
			// If the migrations are broken, this could throw
			$migrator->run($migrationFile);
			$migrator->rollback($migrationFile);

			// Get the schema again and assert they are equal
			$after = $connection->getDoctrineSchemaManager()->createSchema();
			static::assertEquals($after, $before);

			// Then run the migration up (so we run the next migration)
			$migrator->run($migrationFile);
		}
	}
}
