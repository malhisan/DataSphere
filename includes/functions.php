<?php

function loadEvents($filePath)
  {
    $events = array();
    if(!file_exists($filePath)){
      return $events;
    }
    $file = fopen($filePath, "r");
    if($file === false){
      return $events;
    }
    $headings = fgetcsv($file);
    while(($row=fgetcsv($file)) !== false){
      if(count($headings) === count($row)){
        $events[] = array_combine($headings, $row);
      }
    }
    fclose($file);
    return $events;
  }
function sortEventsByDate($events)
  {
    usort($events, function ($a, $b) {
      return strtotime($a["date"]) <=> strtotime($b["date"]);
    });
    return $events;
  }
function getUpcomingEvents($events)
  {
    $today = strtotime(date("Y-m-d"));
    $upcoming = array_filter($events, function ($event) use ($today) {
      $eventDate = strtotime($event["date"]);
      return $eventDate !== false && $eventDate >= $today;
    });
    return sortEventsByDate($upcoming);
  }
function escape($value)
  {
    return htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8");
  }
function formatEventDate($date)
{
  $timestamp = strtotime($date);
  if($timestamp === false){
    return $date;
  }
  return date("j F Y", $timestamp);
}
