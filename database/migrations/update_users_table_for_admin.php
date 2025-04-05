<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin'])->default('user')->after('remember_token');
            $table->text('bio')->nullable()->after('role');
            $table->string('profile_photo_path', 2048)->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('profile_photo_path');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'bio', 'profile_photo_path', 'is_active']);
        });
    }
};