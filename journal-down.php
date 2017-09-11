#!/usr/local/bin/php

<?php
/**
 * Copyright (c) 2017 David Drake
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * journal-down.php
 * https://github.com/randomdrake/journal-down
 *
 * Written by David Drake
 * https://randomdrake.com
 * https://twitter.com/randomdrake
 *
 * Tested on macOS Sierra 10.12.6
 * PHP 7.1.5 installed via Homebrew
 * MacDown 0.7.1
 *
 * This script does a couple simple things:
 *
 * 1. Create a new file in the provided journal directory in this format:
 *
 *    /YYYY/MM/YYYY-MM-DD.md like /2017/09/2017-09-10.md
 *
 *    with a heading containing the day in this format:
 *
 *    Fullmonth DDth, YYYY - Dayofweek like: # September 10th, 2017 - Sunday
 *
 * 2. Every time the command is run, newlines and a time subheading are
 *    appended to the file in this format:
 *
 *    ## HH:MM pm
 *
 * This is Journaldown.
 *
 * Requires: macOS, PHP, MacDown, iCloud Backups
 *
 * Usage: run this file by making it executable and ensuring an appropriate
 *        shebang is on the top of this file like the one included:
 *
 *        #!/usr/local/bin/php
 *
 *        or, simply run the file by issuing the following command:
 *
 *        php journal-down.php
 *
 *        Ensure you've set your timezone, username, and MacDown location. This
 *        assumes a default MacDown installation, default iCloud storage
 *        setup and Homebrew PHP installation.
 */

// Make sure the proper dates and times are used
$timezone = 'America/Los_Angeles';

// Your username to access the default iCloud storage location
$username = 'randomdrake';

// MacDown CLI helper: https://github.com/MacDownApp/macdown/wiki/Advanced-Usage
$markdownApp = '/Applications/Macdown.app/Contents/SharedSupport/bin/macdown';


$storage = '/Users/' . $username . '/Library/Mobile Documents/com~apple~CloudDocs/Journal';
date_default_timezone_set($timezone);

$year = date('Y');
$month = date('m');
$day = date('d');

try {
    // Make sure we can write to our storage location
    if (!file_exists($storage)) {
        throw new Exception('Storage location does not exist.');
    } else if (!is_writeable($storage)) {
        throw new Exception('Cannot write to storage location.');
    }

    // Create our year directory
    $yearDirectory = sprintf('%s/%s', $storage, $year);
    if (!file_exists($yearDirectory)) {
        if (!mkdir($yearDirectory, 0755)) {
            throw new Exception('Could not create year directory.');
        }
    }

    // Create our month directory
    $monthDirectory = sprintf('%s/%s/%s', $storage, $year, $month);
    if (!file_exists($monthDirectory)) {
        if (!mkdir($monthDirectory, 0755)) {
            throw new Exception('Could not create month directory.');
        }
    }

    // See if our file exists
    $filename = sprintf('%s/%s/%s/%s-%s-%s.md', $storage, $year, $month, $year, $month, $day);
    $timePrompt = "\n\n" . "## " . date("g:i a") . "\n\n";
    if (!file_exists($filename)) {
        // Create our file with the date at the top
        $handle = fopen($filename, 'w');
        if (!$handle) {
            throw new Exception('Could not create new markdown file.');
        }
        $header = "# " . date('F jS, Y - l') . "\n";
        fwrite($handle, $header);
        fclose($handle);
    }

    // Add our time string and close our file handle
    $handle = fopen($filename, 'a');
    if (!$handle) {
        throw new Exception('Could not open existing markdown file.');
    }
    fwrite($handle, $timePrompt);
    fclose($handle);

    // Open Macdown with the filename, escaping the space and ~
    $escapedFilename = str_replace([' ', '~'], ['\ ', '\~'], $filename);
    $command = sprintf('%s %s', $markdownApp, $escapedFilename);

    exec($command);
} catch (Exception $e) {
    echo "\nError: {$e->getMessage()}\n";
}
