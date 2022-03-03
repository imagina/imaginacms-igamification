<?php

namespace Modules\Igamification\Transformers;

use Modules\Core\Icrud\Transformers\CrudResource;

class ActivityTransformer extends CrudResource
{
  /**
   * Method to merge values with response
   *
   * @return array
   */
  public function modelAttributes($request)
  {
    //Get request Filters
    $filter = json_decode($request->filter);

    //Instance data
    $data = [
      'statusName' => $this->statusName,
    ];

    if (isset($filter->validateComplete)) {
      $userId = \Auth::user()->id;
      $user = $this->users->where('id', $userId)->first();

      $data['userId'] = $userId;
      $data['userCompleted'] = $user ? true : false;
    }

    //Response
    return $data;
  }
}
