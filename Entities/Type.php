<?php

namespace Modules\Igamification\Entities;

class Type
{
  const INTERNAL_URL = 1;
  const EXTERNAL_URL = 2;
  const INTERNAL_FORM = 3;
  const EXTERNAL_SCRIPT = 4;
  const DEFAULT_TYPE = self::INTERNAL_URL;

  private $types = [];

  public function __construct()
  {
    $this->types = [
      self::INTERNAL_URL => trans('igamification::activities.type.internalURL'),
      self::EXTERNAL_URL => trans('igamification::activities.type.externalUrl'),
      self::INTERNAL_FORM => trans('igamification::activities.type.internalForm'),
      self::EXTERNAL_SCRIPT => trans('igamification::activities.type.externalScript')
    ];
  }

  public function lists()
  {
    return $this->types;
  }

  public function index()
  {
    //Instance response
    $response = [];
    //AMp status
    foreach ($this->types as $key => $status) {
      array_push($response, ['id' => $key, 'title' => $status]);
    }
    //Repsonse
    return collect($response);
  }

  public function get($statusId)
  {
    $response = isset($this->types[$statusId]) ? ['id' => $statusId, 'title' => $this->types[$statusId]] :
      ['id' => self::DEFAULT_TYPE, 'title' => $this->types[self::DEFAULT_TYPE]];
    //Repsonse
    return $response;
  }
}