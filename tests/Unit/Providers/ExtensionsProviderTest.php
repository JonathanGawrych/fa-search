<?php

namespace Tests\Unit\Providers;

use App\Models\User;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ExtensionsProviderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->createApplication();
    }

    /*************************************************
     * Blueprint::belongsTo extension tests
     *************************************************/

    private function mockDoctrine($type = 'bigint', $unsigned = true, $length = 191, $precision = 10, $scale = 0) {
        /** @var MockInterface $mockConnection **/
        $mockConnection = Mockery::mock(Connection::class);
        $mockConnection->shouldReceive('getDoctrineColumn->getType->getName')->andReturn($type);
        $mockConnection->shouldReceive('getDoctrineColumn->getUnsigned')->andReturn($unsigned);
        $mockConnection->shouldReceive('getDoctrineColumn->getLength')->andReturn($length);
        $mockConnection->shouldReceive('getDoctrineColumn->getPrecision')->andReturn($precision);
        $mockConnection->shouldReceive('getDoctrineColumn->getScale')->andReturn($scale);
        DB::shouldReceive('connection')->andReturn($mockConnection);
    }

    public function testBlueprintBelongsToUnsignedBigInteger()
    {
        $this->mockDoctrine();

        $bluePrint = new Blueprint('table_name');
        $bluePrint->belongsTo(User::class);

        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `user_id` BIGINT UNSIGNED NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_user_id_foreign`
            FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE",
            $foreign
        );
    }

    public function testBlueprintBelongsToSignedInteger()
    {
        $this->mockDoctrine('integer', /*$unsigned*/ false);

        $bluePrint = new Blueprint('table_name');

        $bluePrint->belongsTo(User::class);
        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `user_id` INT NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_user_id_foreign`
            FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE",
            $foreign
        );
    }

    public function testBlueprintBelongsToSmallInteger()
    {
        $this->mockDoctrine('smallint', /*$unsigned*/ false);

        $bluePrint = new Blueprint('table_name');

        $bluePrint->belongsTo(User::class);
        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `user_id` SMALLINT NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_user_id_foreign`
            FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE",
            $foreign
        );
    }

    public function testBlueprintBelongsToString()
    {
        $this->mockDoctrine('string', /*$unsigned*/ false, /*$length*/ 100);

        $bluePrint = new Blueprint('table_name');
        $bluePrint->belongsTo(User::class);
        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `user_id` VARCHAR(100) NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_user_id_foreign`
            FOREIGN KEY (`user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE",
            $foreign
        );
    }

    public function testBlueprintBelongsToOverrideForeignKey()
    {
        $this->mockDoctrine();

        $bluePrint = new Blueprint('table_name');
        $bluePrint->belongsTo(User::class, 'other_user_id');
        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `other_user_id` BIGINT UNSIGNED NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_other_user_id_foreign`
            FOREIGN KEY (`other_user_id`)
            REFERENCES `users` (`id`)
            ON DELETE CASCADE",
            $foreign
        );
    }

    public function testBlueprintBelongsToOverrideOwnerKey()
    {
        $this->mockDoctrine();

        $bluePrint = new Blueprint('table_name');
        $bluePrint->belongsTo(User::class, 'user_lower', 'lower');
        [$column, $foreign] = $bluePrint->toSql(DB::connection(), new MySqlGrammar());

        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD `user_lower` BIGINT UNSIGNED NOT NULL",
            $column
        );
        $this->assertEqualsIgnoringCaseAndWhitespace(
            "ALTER TABLE `table_name`
            ADD CONSTRAINT `table_name_user_lower_foreign`
            FOREIGN KEY (`user_lower`)
            REFERENCES `users` (`lower`)
            ON DELETE CASCADE",
            $foreign
        );
    }
}
