<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categoryRepository = app('Modules\Igamification\Repositories\CategoryRepository');
        
        //System name default category
        $systemName = "panel_home";

        $result = $categoryRepository->findByAttributes([
                'system_name'=> $systemName
            ]);

        //Not added before
        if(is_null($result)){

            //Este codigo comentado guarda bien en español, pero en ingles lo guarda sin la traduccion
            /*
            $dataToCreate = [
                "system_name" => $systemName,
                "es" => [
                  "title" => trans("igamification::categories.defaults.panel_home.title",[],"es").' '.setting('core::site-name'),
                  "description" => setting('core::site-description')
                ],
                "en" => [
                  "title" => trans("igamification::categories.default.panel_home.title",[],"en").' '.setting('core::site-name'),
                  "description" => setting('core::site-description')
                ]
            ];
            */
            $dataToCreate = [
                "system_name" => $systemName
            ];

            $categoryCreated = $categoryRepository->create($dataToCreate);

            // Alternativa para traducciones
            $this->addTranslation($categoryCreated,'en');
            $this->addTranslation($categoryCreated,'es');


           
        }

        
    }

    /*
    * Add Translations
    */
    public function addTranslation($category,$locale){

        $title = trans('igamification::categories.defaults.panel_home.title',[],$locale).' '.setting('core::site-name');

        $description = setting('core::site-description');

        \DB::table('igamification__category_translations')->insert([
          'title' => $title,
          'description' => $description,
          'slug' => \Str::slug($title, '-'),
          'category_id' => $category->id,
          'locale' => $locale
        ]);

    }

   

    

   

}
