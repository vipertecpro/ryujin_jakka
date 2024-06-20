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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('module_id')->index();
            $table->unsignedBigInteger('uploaded_by')->index();
            $table->string('module');
            $table->string('purpose');
            $table->string('file_original_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size');
            $table->string('file_extension');
            $table->string('file_mime_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
