#!/usr/bin/php

<?php

$lines = split("\n", file_get_contents($argv[1], "r"));
$patterns = array();
$tests = array();
$out = array();

// Separate the patterns indexed by length
$p_len = (int) $lines[0];
for ($i=1; $i <= $p_len; $i++) {
  $exp = explode(',', $lines[$i]);
  $patterns[count($exp)][] = $lines[$i];
}

// Sort the patterns based on specificity
foreach ($patterns  as &$p) {
  usort(&$p, 'cmp');
}

// Separate and trim the test strings
$t_start = $p_len + 1;
$t_len = (int) $lines[$t_start];
for ($i=$t_start+1; $i <= count($lines)-1; $i++) {
  $tests[] = trim($lines[$i], '/');
}

// Loop through each test
foreach ($tests as $test) {

  $result = 'NO MATCH';
  $pieces = explode('/', $test);
  $len = count($pieces);

  // Compare test with patterns that match its length
  if (isset($patterns[$len])) {

    $pat = $patterns[$len];

    foreach ($pat as $p) {
      $p_arr = explode(',',$p);

      for ($i = 0; $i < $len; $i++) {
        // Compare non-* characters
        if ($p_arr[$i] !== '*' && $p_arr[$i] !== $pieces[$i]) {
          break;
        }
      }

      if ($i === $len) {
        $result = $p;
        break;
      } 
    }
  }
  $out[] = $result;
}

// Write contents to output file
file_put_contents($argv[2], implode("\n", $out));



/**
 * Pattern Sort Function
 */
function cmp($a, $b) {
  $amtA = substr_count($a, '*');
  $amtB = substr_count($b, '*');

  if ($amtA === $amtB) { // Have the same amount of *'s
    $posA = strpos($a, '*');
    $posB = strpos($b, '*');

    if ($posA === $posB) { // Have the same index for *
      return cmp(substr($a, $posA + 1), substr($b, $posB + 1));
    } else {
      return ($posA > $posB) ? -1 : 1;
    }
  } else {
    return ($amtA < $amtB) ? -1 : 1;
  }
}

?>