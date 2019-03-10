<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GithubRepositories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_repositories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('github_id')->nullable();
            $table->integer('github_user_id')->unsigned()->nullable();
            $table->foreign('github_user_id')
                ->references('id')
                ->on('github_users')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('private')->nullable();
            $table->string('language')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('github_repositories');
    }
}
