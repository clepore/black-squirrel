black-squirrel
==============

PHP cli script for some simple pattern matching 

This script will accept 2 files. The first is a list of patterns, the second is a list of slash-separated paths. It will print the best pattern that matches each path. 

A pattern is a comma-separated sequence of non-empty strings. For a pattern to match a path, each string in the pattern must match exactly the corresponding sub-part of the path. For example, the pattern a,b can only match the path a/b. (Note that leading and trailing slashes in paths are ignored, so that a/b and /a/b/ are equal.) Patterns can also contain a special string consisting of a single asterisk, which is a *wildcard* and will match any string in the path.  For example, the pattern A,*,B,*,C consists of five fields:three strings and two wildcards. It will successfully match the pathsA/123/B/456/C and A/jimmy/B/johns/C, but not A/B/C, A/dog/hefer/B/rocko/C, or ren/B/stimpy/C.

Input File Format

The first line contains an integer, N, specifying the number of patterns. The following N lines contain one pattern per line. Each pattern is unique. The next line contains a second integer, M, specifying the number of paths. The following M lines contain one path per line. 

Output Format

For each path encountered in the input, print the *best-matching pattern*. The best-matching pattern is the one which matches the path using the fewest wildcards. 

If there is a tie — i.e. if two or more patterns with the same number of wildcards match a path—prefer the pattern whose first wildcard appears furthest to the right. (If two or more patterns' first wildcard appears in the same spot, apply this rule recursively to the remainder of the pattern.) For example, given the patterns a,*,c,* and a,*,*,d, and the path/a/b/c/d, the best-matching pattern would be a,*,c,*. If no pattern matches the path, it will print NO MATCH. 

In Unix parlance, it can be run like ./match.php in.txt out.txt
