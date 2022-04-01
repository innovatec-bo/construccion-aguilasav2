<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

class AddFieldsToSecUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sec_users', function (Blueprint $table) {
            $table->string('first_name')->after('umbo_usr');
            $table->string('last_name')->after('first_name');
            $table->string('email')->nullable()->unique()->after('last_name');
            $table->timestamp('email_verified_at')->nullable()->after('email');
            $table->string('password')->after('email_verified_at');
            $table->rememberToken()->after('password');
            $table->foreignId('current_team_id')->nullable()->after('remember_token');
            $table->string('profile_photo_path', 2048)->nullable()->after('current_team_id');
            $table->text('two_factor_secret')
                    ->after('password')
                    ->nullable();

            $table->text('two_factor_recovery_codes')
                    ->after('two_factor_secret')
                    ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                        ->after('two_factor_recovery_codes')
                        ->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sec_users', function (Blueprint $table) {
            $table->dropForeign('current_team_id');

            $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'email_verified_at',
                'password',
                'remember_token',
                'current_team_id',
                'profile_photo_path'
                
            ]);
            
            $table->dropColumn(array_merge([
                'two_factor_secret',
                'two_factor_recovery_codes',
            ], Fortify::confirmsTwoFactorAuthentication() ? [
                'two_factor_confirmed_at',
            ] : []));
        });
    }
}
