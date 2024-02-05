<?php

namespace App\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;

trait HasTimestampSerializable
{
  use HasAttributes;

  protected function serializeDate(DateTimeInterface $date)
  {
    return Carbon::instance($date)->format("Y-m-d H:i:s");
  }
}
