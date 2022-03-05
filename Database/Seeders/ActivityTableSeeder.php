<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Only modules actives
        $modules = \Module::getByStatus(1);
        foreach ($modules as $key => $module) {
            $name = $module->getLowerName();

            // Get activities from config module
            $activities = config('asgard.'.$name.'.config.activities');

            if(!is_null($activities)){
                $this->command->info("Activities to Module: ".$name);
                $this->saveActivitiesFromModule($activities);
            }

        }

    }

    /*
    * Save activities
    */
    public function saveActivitiesFromModule($activities){

        $activityRepository = app('Modules\Igamification\Repositories\ActivityRepository');

        // Each activity from config
        foreach ($activities as $key => $activity) {

            $result = $activityRepository->findByAttributes([
                'system_name'=> $activity['system_name']
            ]);

            // Save Activity
            if(!$result){

                $params = array(
                    'system_name' => $activity['system_name'],
                    'url' => $activity['url'] ?? '',
                    'status' => $activity['status'] ?? 0
                );
                $activityCreated = $activityRepository->create($params);

                // For now adding translations like this, with the other methods it did not work in all cases
                $translationsAtt['title'] = $activity['title'];
                $translationsAtt['description'] = $activity['description'] ?? $activity['title'];

                $this->addTranslation($activityCreated,'en',$translationsAtt);
                $this->addTranslation($activityCreated,'es',$translationsAtt);

            }else{
                $this->command->alert("This activity: {$activity['system_name']} has already exist !!");
            }

        }// end foreach
    }

    /*
    * Add Translations
    * PD: New Alternative method due to problems with astronomic translatable
    **/
    public function addTranslation($activity,$locale,$transAtt){

      \DB::table('igamification__activity_translations')->insert([
          'title' => trans($transAtt['title'],[],$locale),
          'description' => trans($transAtt['description'],[],$locale),
          'activity_id' => $activity->id,
          'locale' => $locale
      ]);

    }





}
