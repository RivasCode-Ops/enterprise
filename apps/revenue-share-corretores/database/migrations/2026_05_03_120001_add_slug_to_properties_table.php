<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        foreach (DB::table('properties')->whereNull('slug')->cursor() as $row) {
            $base = Str::slug(Str::limit((string) ($row->title ?? 'imovel'), 96, ''));
            if ($base === '') {
                $base = 'imovel';
            }
            DB::table('properties')->where('id', $row->id)->update([
                'slug' => $base . '-' . $row->id,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
