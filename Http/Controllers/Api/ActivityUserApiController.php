<?php

namespace Modules\Igamification\Http\Controllers\Api;

use Illuminate\Http\Request;

use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

//Repositories
use Modules\Igamification\Repositories\ActivityRepository;

// Entities
use Modules\Igamification\Entities\Activity;

class ActivityUserApiController extends BaseApiController
{
   
    public $activity;

    public function __construct(
        ActivityRepository $activity
    ){
        parent::__construct();
        $this->activity = $activity;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Filter params
            $paramsFilters = (array)$params->filter;
          
            //Filter default
            $defaultFilters = ["status" => 1]; // Only Actives

            //Merge filters
            $filters = array_merge($paramsFilters,$defaultFilters);
            $params->filter = (object)($filters);

            // Get activities
            $activities = $this->activity->getItemsBy(json_decode(json_encode($params)));
            //$activities = Activity::with('translations')->where('status',1)->get();

            if(count($activities)==0)
                throw new \Exception(trans('igamification::activities.validation.not actives'), 500);

            //Get User Logged - Middleware Auth
            $userId = \Auth::user()->id;
            
            //Get activities completed for this User
            foreach ($activities as $key => $activity) {
                $user = $activity->users->where('id',$userId)->first();

                $activity->user_id = $userId;

                if(!is_null($user))
                    $activity->user_completed = true;
                else
                    $activity->user_completed = false;

                // To clean result data
                $activity->unsetRelation('users');
            }
           
        
            /*
                Response Collection activities with 2 extra attributes: 
                    user_id and user_completed
            */
            $response = ["data" => $activities];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($models)] : false;

        } catch (\Exception $e) {
            \Log::Error($e);
            $response = ["messages" => [["message" => $e->getMessage(), "type" => "error"]]];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }


}