<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'invitation_token')) {
                $table->string('invitation_token')->nullable()->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'invitation_accepted_at')) {
                $table->timestamp('invitation_accepted_at')->nullable()->after('invitation_token');
            }
            if (!Schema::hasColumn('users', 'mfa_secret')) {
                $table->string('mfa_secret')->nullable()->after('invitation_accepted_at');
            }
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('mfa_secret');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['invitation_token', 'invitation_accepted_at', 'mfa_secret', 'is_active']);
        });
    }
};
