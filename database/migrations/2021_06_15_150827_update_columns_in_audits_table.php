<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsInAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropColumn('url');
            $table->dropColumn('ip_address');
            $table->dropColumn('user_agent');
            $table->dropColumn('tags');
            $table->string('alias')->default('')->nullable()->after('auditable_id');
            $table->softDeletes();
        });
    }
}
