<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tweets', function (Blueprint $table) {
            //
            // 🔽 1行追加
            $table->foreignId('user_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tweets', function (Blueprint $table) {
            // 🔽 1行追加
            // ./vendor/bin/sail php artisan:rollback
            // $table->dropForeign(['user_id']); <- wrong code!
            // https://readouble.com/laravel/9.x/ja/migrations.html
            // https://qiita.com/igayamaguchi/items/897097ff430588f43a30
            // https://laravel.com/docs/9.x/database
            $table->dropForeign('tweets_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};
