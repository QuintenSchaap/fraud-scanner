<?php

use App\Models\Scan;
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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scan_id');
            $table->integer('customer_id');
            $table->bigInteger('bsn');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('tag')->nullable();
            $table->json('address')->nullable();
            $table->json('products')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('iban')->nullable();
            $table->date('last_invoice_date')->nullable();
            $table->dateTime('last_login_date_time')->nullable();
            $table->boolean('is_fraudulent')->default(false);
            $table->timestamps();

            $table->foreign('scan_id')->references('id')->on('scans')->onDelete('cascade');
        });
    }

    public function scan()
    {
        return $this->belongsTo(Scan::class);
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
