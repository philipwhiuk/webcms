<?php
class DateUtils {
  static function dateTimeToEpochTime($date_string) {
    $dateTime = DateTime::createFromFormat("d-m-Y H:i:s", $date_string);
    if (!$dateTime) {
      throw new Exception("Invalid format for date-time: '$date_string'");
    }
    return $dateTime->getTimestamp();
  }
}
