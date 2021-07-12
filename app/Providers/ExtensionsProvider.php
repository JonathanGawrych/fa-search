<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class ExtensionsProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Make it easier to make foreign keys, add a macro that'll do it for us
         * We'll use the same syntax that is used in generating relations
         *
         * @param string $class
         * @param string|null $foreignKey
         * @param string|null $ownerKey
         * @return void
         */
        Blueprint::macro('belongsTo', function (string $Class, ?string $foreignKey = null, ?string $ownerKey = null) {
            /** @var Blueprint $this **/

            // First we need to figure out some stuff about the destination
            /** @var Model $instance */
            $instance = new $Class();
            $tableName = $instance->getTable();
            $ownerKey = $ownerKey ?: $instance->getKeyName();
            $foreignKey = $foreignKey ?: $instance->getForeignKey();

            // Now we need to learn the datatype of the key
            /** @var Connection $connection */
            $connection = DB::connection();
            $columnDoctrine = $connection->getDoctrineColumn($tableName, $ownerKey);

            $type = $columnDoctrine->getType()->getName();
            // Converts doctrine types into fluent types. Opposite of getDoctrineColumnType
            // @see Illuminate\Database\Schema\Grammars\ChangeColumn::getDoctrineColumnType
            if ($type === 'bigint') {
                $type = 'bigInteger';
            } else if ($type === 'smallint') {
                $type = 'smallInteger';
            }

            // Add the column
            $column = $this->foreignId($foreignKey)->type($type);

            // Set its modifiers. Note some of these modifiers are for different
            // types but it'll only use the ones it needs.
            $column->unsigned($columnDoctrine->getUnsigned());
            $column->length($columnDoctrine->getLength());
            $column->total($columnDoctrine->getPrecision());
            $column->places($columnDoctrine->getScale());

            // Add the foreign key
            $column->constrained($tableName, $ownerKey)
                ->onDelete('cascade');

            return $column;
        });
    }
}
