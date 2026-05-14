<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		// Role comes before User seeder here.
		$this->call(RoleTableSeeder::class);
		// User seeder will use the roles above created.
    $this->call(UserTableSeeder::class);
    // Archive
		$this->call(ArchiveTableSeeder::class);
    // News
		$this->call(NewsTableSeeder::class);
    // Category of Publicarions
		$this->call(PublicationCategorySeeder::class);
    // Publications
		$this->call(PublicationSeeder::class);
    // LawCategory
		$this->call(LawCategorySeeder::class);
    // Law
		$this->call(LawSeeder::class);
    // Gallery
		$this->call(GallerSeeder::class);
		// Administration
    $this->call(ScienceSeeder::class);
    // Science
    $this->call(AdministrationSeeder::class);
    // Structure
    $this->call(StructureSeeder::class);
    // Employees (xodimlar)
    $this->call(EmployeeSeeder::class);
    // Journal
    $this->call(JournalSeeder::class);
    // Page
    $this->call(PageSeeder::class);
    // Menu
    $this->call(MenuSeeder::class);
    // Weather and USD
    $this->call(WeatherSeeder::class);
    }
}
