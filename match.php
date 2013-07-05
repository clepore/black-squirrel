#!/usr/bin/php

<?php

if ($argc != 3 || in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
  echo "REQUIRES 3 INPUTS!!!\n";
  die();
}

$lines = split("\n", file_get_contents($argv[1], "r"));
$patterns = array();
$tests = array();

// Separate the patterns
$p_len = (int) $lines[0];
for ($i=1; $i <= $p_len; $i++) { 
  $patterns[] = $lines[$i];
}

// Separate the tests
$t_start = $p_len + 1;
$t_len = (int) $lines[$t_start];

for ($i=$t_start+1; $i <= count($lines)-1; $i++) {
  $tests[] = trim($lines[$i], '/');
}

foreach ($tests as $test) {

  $results = array();

  $t_arr = explode('/', $test);

  foreach ($patterns as $p) {
    $p_arr = explode(',', $p);

    if (count($t_arr) === count($p_arr)) {

      for ($i=0; $i < count($t_arr); $i++) {

        // Compare non-* characters
        if ($p_arr[$i] !== '*' && $p_arr[$i] !== $t_arr[$i]) {
          break;
        }

        // If the whole loop succeeds, add the pattern to success results
        if ($i === count($t_arr) - 1) {
          $results[] = $p;
        }

      }

    }

  }
  if (count($results) === 0) {
    echo "\n".$test." = NO MATCH\n\n";
  } else {
    foreach ($results as $r) {
      echo $test." = ".$r."\n";
    }
    echo "\n";
  }

}


?>