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

            $table->string('employee_code', 50)->unique();
            $table->string('name', 150);
            $table->string('photo', 250)->nullable();

            // Personal Information
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();


            // Contact Information
            $table->string('email', 150)->nullable()->unique();
            $table->string('phone', 20)->nullable();

            $table->string('address', 255)->nullable();

            $table->enum('gender', [
                'P',
                'W',
            ])->default('P');

            $table->enum('religion', [
                'Islam',
                'Kristen',
                'Katholik',
                'Hindu',
                'Buddha',
                'Konghucu',

            ])->default('Islam');


            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();

            $table->unsignedBigInteger('leader_id')->nullable();

            $table->date('join_date')->nullable();

            $table->enum('employment_status', [
                'permanent',
                'contract',
                'probation',
                'intern',
                'resigned'
            ])->default('permanent');

            $table->decimal('salary', 15, 2)->default(0);

            $table->timestamps();

            $table->index('employee_code');
            $table->index('department_id');
            $table->index('position_id');
            $table->index('leader_id');

            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->nullOnDelete();

            $table->foreign('position_id')
                ->references('id')
                ->on('positions')
                ->nullOnDelete();

            $table->foreign('leader_id')
                ->references('id')
                ->on('employees')
                ->nullOnDelete();
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
