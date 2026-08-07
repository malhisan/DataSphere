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
