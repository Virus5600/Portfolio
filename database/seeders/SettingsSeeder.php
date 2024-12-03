<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Settings;

class SettingsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$webName = config('app.name', 'Portfolio');
		$webDesc = "A simple portfolio website where you can showcase your works.";

		// FAVICON/LOGO
		Settings::create([
			'name' => 'web-logo',
			'value' => 'default.png',
			'default_value' => 'default.png',
			'is_file' => true
		]);

		// WEB NAME
		Settings::create([
			'name' => 'web-name',
			'value' => $webName,
			'default_value' => $webName
		]);

		// DESCRIPTION
		Settings::create([
			'name' => 'web-desc',
			'value' => $webDesc,
			'default_value' => $webDesc,
		]);
	}
}
