#!/usr/bin/php

<?php

if ($argc != 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
  echo "REQUIRES 2 INPUTS!!!\n";
  die();
}

$lines = split("\n", file_get_contents($argv[1], "r"));
$patterns = array();
$tests = array();

// Separate the patterns indexed by length
$p_len = (int) $lines[0];
for ($i=1; $i <= $p_len; $i++) {
  $exp = explode(',', $lines[$i]);
  $patterns[count($exp)][] = $lines[$i];
}

foreach ($patterns  as &$p) {
  usort(&$p, 'cmp');
}

// Separate the tests
$t_start = $p_len + 1;
$t_len = (int) $lines[$t_start];

for ($i=$t_start+1; $i <= count($lines)-1; $i++) {
  $tests[] = trim($lines[$i], '/');
}

foreach ($tests as $test) {

  $result = "\n".$test." = NO MATCH";

  $pieces = explode('/', $test);

  $len = count($pieces);

  if (isset($patterns[$len])) {

    $arr = $patterns[$len];

    foreach ($arr as $p) {
      $p_arr = explode(',',$p);

      for ($i = 0; $i < $len; $i++) {
        // Compare non-* characters
        if ($p_arr[$i] !== '*' && $p_arr[$i] !== $pieces[$i]) {
          break;
        }
      }

      if ($i === $len) {
        $result = "\n".$test.' = ' .$p;
        break;
      } 
    }
  }
  echo $result;
}

function cmp($a, $b) {
  $amtA = substr_count($a, '*');
  $amtB = substr_count($b, '*');

  if ($amtA === $amtB) { // Have the same number of *'s
    $posA = strpos($a, '*');
    $posB = strpos($b, '*');

    if ($posA === $posB) { // Have the * in the same position
      return cmp(substr($a, $posA + 1), substr($b, $posB + 1));
    
    } else {
      return ($posA > $posB) ? -1 : 1;
    }
  
  } else {
    return ($amtA < $amtB) ? -1 : 1;
  }
}


?>