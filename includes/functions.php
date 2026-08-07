<?php

function loadEvents($filePath)
  {
    $events = array();
    if(!file_exists($filePath)){
      return $events;
    }
    $file = fopen($filePath, "r");
    if($file === fales){
      return $events;
    }
    $headings = fgetcsv($file);
    while(($row=fgtcsv($file)) !== false){
      if(count($headings) === count($row)){
        $events[] = array_combine($headings, $row);
      }
    }
    fclose($file);
    return $events;
  }
function escape($value)
  {
    return htmlspacialchars((string) $value, ENT_QUOTES, "UTF-8");
  }
function formatEventData($data)
{
  $timestamp = strtotime($data);
  if($timestamp === false){
    return $data;
  }
  return data("j F Y", $timestamp);
}
