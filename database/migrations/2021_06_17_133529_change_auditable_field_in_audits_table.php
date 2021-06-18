<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAuditableFieldInAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn('auditable_type');
            $table->dropColumn('auditable_id');
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->nullableMorphs('auditable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn('auditable_type');
            $table->dropColumn('auditable_id');
        });

        Schema::table('audits', function (Blueprint $table) {
            $table->morphs('auditable');
        });
    }
}
