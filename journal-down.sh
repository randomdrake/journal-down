#!/bin/bash
#
# Copyright (c) 2017 David Drake
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.
#
# journal-down.php
# https://github.com/randomdrake/journal-down
#
# Written by David Drake
# https://randomdrake.com
# https://twitter.com/randomdrake
#
# Tested on macOS Sierra 10.12.6
# MacDown 0.7.1
#
# This script does a couple simple things:
#
# 1. Create a new file in the provided journal directory in this format:
#
#    /YYYY/MM/YYYY-MM-DD.md like /2017/09/2017-09-10.md
#
#    with a heading containing the day in this format:
#
#    Fullmonth DDth, YYYY - Dayofweek like: # September 10th, 2017 - Sunday
#
# 2. Every time the command is run, newlines and a time subheading are
#    appended to the file in this format:
#
#    ## HH:MM pm
#
# This is JournalDown.
#
# Requires: macOS, PHP, MacDown, iCloud Backups
#
# Usage: JournalDown assumes a default MacDown installation, and default iCloud
#        storage setup.
#
# Arguments: you can pass some arguments to JournalDown to view your journal.
#
#        open -- simply opens today's journal, does not append the timestamp
#
#        open YYYY-MM-DD -- like 2017-09-10, this will open the journal for that day
#
#        help -- displays this information

# Simple function get get day suffix
DaySuffix() {
  case `date +%d` in
    1|21|31) echo "st";;
    2|22)    echo "nd";;
    3|23)    echo "rd";;
    *)       echo "th";;
  esac
}

# Grab our date and time parts we'll be using
YEAR=$(date +"%Y")
MONTH=$(date +"%m")
LONG_MONTH=$(date +"%B")
DAY=$(date +"%d")
DAY_SUFFIX=$(DaySuffix)
DAY_OF_WEEK=$(date +"%A")
TIME=$(date +"%l:%M %p")

# https://github.com/MacDownApp/macdown/wiki/Advanced-Usage
MARKDOWN_APP="/Applications/Macdown.app/Contents/SharedSupport/bin/macdown"

STORAGE_LOCATION="/Users/$USER/Library/Mobile Documents/com~apple~CloudDocs/Journal"
ESCAPED_STORAGE_LOCATION="/Users/$USER/Library/Mobile\ Documents/com\~apple\~CloudDocs/Journal"

FILENAME="$YEAR/$MONTH/$YEAR-$MONTH-$DAY.md"

# Make sure our directory exists
mkdir -p $STORAGE_LOCATION/$YEAR/$MONTH

# If our file doesn't exist, create it and put the header on the top
if ! [[ -e "$STORAGE_LOCATION/$FILENAME" ]]; then
    touch "$STORAGE_LOCATION/$FILENAME"
    echo -e "# $LONG_MONTH $DAY$DAY_SUFFIX, $YEAR - $DAY_OF_WEEK\n"
fi

# Add our timestamp prompt to the journal
echo -e "\n\n## $TIME\n" >> "$STORAGE_LOCATION/$FILENAME"

# Open our journal file in MacDown
eval "$MARKDOWN_APP $ESCAPED_STORAGE_LOCATION/$FILENAME"
