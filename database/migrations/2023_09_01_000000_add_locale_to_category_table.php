<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocaleToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categoriesTable = config('nova-blog.blog_categories_table', 'nova_blog_posts');

        Schema::table($categoriesTable, function (Blueprint $table) {
            $table->string('locale')->default('undefined');
            $table->unsignedBigInteger('locale_parent_id')->nullable();
            $table->foreign('locale_parent_id')->references('id')->on($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $categoriesTable = config('nova-blog.blog_categories_table', 'nova_blog_posts');

        Schema::table($categoriesTable, function (Blueprint $table) {
            $table->dropColumn('locale');
            $table->dropForeign(['locale_parent_id']);
            $table->dropColumn('locale_parent_id');
        });
    }
}
