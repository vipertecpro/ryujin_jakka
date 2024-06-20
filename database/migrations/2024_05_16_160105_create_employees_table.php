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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('designation_id')->index();
            $table->unsignedBigInteger('department_id')->index();
            $table->timestamp('date_of_birth')->nullable();
            $table->timestamp('date_of_joining')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('employee_code')->nullable();
            $table->string('personal_number')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
