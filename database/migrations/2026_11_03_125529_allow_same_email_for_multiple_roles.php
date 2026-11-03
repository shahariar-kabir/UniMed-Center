<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_unique');
            $table->dropUnique('users_university_id_unique');

            $table->unique(['email', 'role'], 'users_email_role_unique');
            $table->unique(['university_id', 'role'], 'users_university_id_role_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_email_role_unique');
            $table->dropUnique('users_university_id_role_unique');

            $table->unique('email', 'users_email_unique');
            $table->unique('university_id', 'users_university_id_unique');
        });
    }
};
