<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GithubIssues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_issues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('github_id')->nullable();
            $table->integer('repository_id')->nullable()->unsigned();
            $table->foreign('repository_id')
                ->references('id')
                ->on('github_repositories')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('title')->nullable();
            $table->integer('number')->nullable();
            $table->string('state')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('github_issues');
    }
}
