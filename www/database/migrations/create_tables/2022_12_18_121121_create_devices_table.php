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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('inventory_id',8)->unique();
            $table->dateTime('warranty')->nullable();
            $table->string('serial_tag',200)->nullable();
            $table->string('imei',15)->nullable();
            $table->text('comment',255)->nullable();
            $table->foreignId('location_id')->nullable()->constrained();
			$table->foreignId('devicemodel_id')->constrained();
			$table->foreignId('status_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->bigInteger('current_employee_id')->nullable()->unsigned();
            $table->bigInteger('last_employee_id')->nullable()->unsigned();
            $table->foreign('last_employee_id')->references('id')->on('employees');
            $table->foreign('current_employee_id')->references('id')->on('employees');

            $table->timestamp('created_at')->default(now());
            $table->timestamp('updated_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('devices');
    }
};
