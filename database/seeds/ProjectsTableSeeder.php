<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            'name' => 'My Products',
            'description' => '<p>This is a sample application that shows products divided by category</p>',
            'image' => $this->getBase64Image('My_Food.jpg'),
            'live_demo_link' => 'http://www.pedrohsalmeida.com:8088',
            'source_code_link' => 'https://github.com/pedro1191/my-products-vue',
            'order' => 1
        ]);

        DB::table('projects')->insert([
            'name' => 'My Products API',
            'description' => '<p>This is the RESTful API that My Products application communicates with</p>',
            'image' => $this->getBase64Image('RESTful_API_900x650.png'),
            'live_demo_link' => null,
            'source_code_link' => 'https://github.com/pedro1191/my-products-rest',
            'order' => 2
        ]);

        DB::table('projects')->insert([
            'name' => 'My Products Dashboard',
            'description' => '<p>This is a dashboard application for the My Products application that allows to manage products and categories</p>',
            'image' => $this->getBase64Image('My_Food_Dashboard.png'),
            'live_demo_link' => 'http://www.pedrohsalmeida.com:8086',
            'source_code_link' => 'https://github.com/pedro1191/my-products-dashboard-vue',
            'order' => 3
        ]);

        DB::table('projects')->insert([
            'name' => 'My Products Dashboard API',
            'description' => '<p>This is the RESTful API that My Products Dashboard application communicates with</p>',
            'image' => $this->getBase64Image('RESTful_API_900x650.png'),
            'live_demo_link' => null,
            'source_code_link' => 'https://github.com/pedro1191/my-products-dashboard-rest',
            'order' => 4
        ]);

        DB::table('projects')->insert([
            'name' => 'My Personal Portfolio',
            'description' => '<p>This is the application that you are currently in</p>',
            'image' => $this->getBase64Image('My_Personal_Portfolio.jpg'),
            'live_demo_link' => 'http://www.pedrohsalmeida.com',
            'source_code_link' => 'https://github.com/pedro1191/my-personal-portfolio-vue',
            'order' => 5
        ]);

        DB::table('projects')->insert([
            'name' => 'My Personal Portfolio API',
            'description' => '<p>This is the RESTful API that My Personal Portfolio application communicates with</p>',
            'image' => $this->getBase64Image('RESTful_API_900x650.png'),
            'live_demo_link' => null,
            'source_code_link' => 'https://github.com/pedro1191/my-personal-portfolio-rest',
            'order' => 6
        ]);
    }

    /**
     * Returns a image in base64
     * 
     * @param  string  $imageName
     * @return string
     */
    private function getBase64Image(string $imageName)
    {
        $path = storage_path('app/public/' . $imageName);
        $image = File::get($path);
        $contentType = File::mimeType($path);

        return "data:{$contentType};base64," . base64_encode($image);
    }
}
