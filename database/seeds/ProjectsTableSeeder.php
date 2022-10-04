<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'name' => 'FoodClub',
            'description' => '<p>This is a complete sample application that shows things divided by categories. It has a dashboard with authentication where the administrator can manage them and a contact page to send messages. The "theme" chosen here relates to culinary, but it could have been anything else.</p><p>Overall, it was built using the Vue.js and Lumen frameworks. Please refer to its source code link above for documentation and technical details.</p>',
            'image' => $this->getBase64Image('FoodClub.png'),
            'live_demo_link' => 'https://foodclub.pedrohsalmeida.com',
            'source_code_link' => 'https://github.com/pedro1191/my-products-vue',
            'order' => 1,
        ]);

        DB::table('projects')->insert([
            'name' => 'Pokémon Game',
            'description' => '<p>This is a simple Pokémon game. The player can select two pokémons at a time and make them fight until there is only one pokémon left, which will be the champion. The pokémons are loaded from the open RESTful API <a href="https://pokeapi.co/docs/v2" target="_blank" rel="noreferrer noopener">PokéAPI</a>.</p><p>Overall, it was built using the Vue.js framework. Please refer to its source code link above for documentation and technical details.</p>',
            'image' => $this->getBase64Image('PokemonGame.png'),
            'live_demo_link' => 'https://pokemongame.pedrohsalmeida.com',
            'source_code_link' => 'https://github.com/pedro1191/pokemon-challenge',
            'order' => 2,
        ]);

        DB::table('projects')->insert([
            'name' => 'My Portfolio',
            'description' => '<p>This is the application that you are currently in. It loads the portfolio\'s projects and sends contact messages.</p><p>Overall, it was built using the Vue.js and Lumen frameworks. Please refer to its source code link above for documentation and technical details.</p>',
            'image' => $this->getBase64Image('MyPortfolio.jpeg'),
            'live_demo_link' => 'https://www.pedrohsalmeida.com',
            'source_code_link' => 'https://github.com/pedro1191/my-personal-portfolio-vue',
            'order' => 3,
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
        $path = resource_path('img/' . $imageName);
        $image = File::get($path);
        $contentType = File::mimeType($path);

        return "data:{$contentType};base64," . base64_encode($image);
    }
}
