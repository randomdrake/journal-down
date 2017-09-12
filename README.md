# journal-down

## Journal in Markdown, using MacDown, backed up to your iCloud.

## About:

Lately I've been finding most of my productive writing has been occurring in Markdown. Specifically, I enjoy using [MacDown](https://macdown.uranusjr.com). 

To jumpstart more habitual writing, I wanted dead-simple, 0-dependency, Markdown journaling.

1. From desire to write, to actually writing, as quickly as possible.
2. Automatic backups to the iCloud storage I already pay for so I don't have to configure or worry about anything.

Upon searching around, most of the stuff in the simple Markdown journal category came with a lot of extra fluff, required Dropbox, or had a host of dependencies.

This is JournalDown.

## How it Works:

1. When you run `journal-down` it will create a file for you in your iCloud storage like this: `/JournalDown/2017/09/2017-09-10.md`
2. JournalDown will add a header to the file with the current date, and day of the week like: `# September 11th, 2017 - Monday`
3. Additionally, JournalDown will create a subheading with the current time like: `## 08:44 PM`
4. MacDown will open with the current file and your cursor on a new line ready to type.
5. Simply `⌘-Q` out of MacDown when you're finished.
6. Come back and start writing again by running `journal-down` and MacDown will open today's journal, add newlines, create a timestamp subheading, and your cursor will be ready to write.

Simple, easy, Markdown journaling.

That is JournalDown.

## Requirements

* macOS
* MacDown - The Open Source Markdown editor for macOS ([https://macdown.uranusjr.com](https://macdown.uranusjr.com))
* iCloud Storage - Default setup.

## Installation

Be sure you've installed MacDown. Copy the `journal-down` file to an accessible location like your Home Directory. Make sure the file is executable with: `chmod +x journal-down`. Run `journal-down` and start typing.

## Help

For help using `journal-down` you can use the `-h` flag like:

`journal-down -h`

It will print the following:

```
This is JournalDown.

Requires:
    MacDown - The open source Markdown editor for macOS.

    https://macdown.uranusjr.com

    ...or with Homebrew Cask: brew cask install macdown

    Default iCloud Storage configuration.

Usage:
    journal-down                      Open journal file for today with a new timestamp.
    journal-down -h                   Display this help message.
    journal-down -o                   Open journal for today.
    journal-down -r <YYYY-MM-DD>      Open a journal for a given valid date like: 2017-09-10.
```

## Development:

This was a pretty fun project that I have a feeling I'll be re-visiting quite a bit. Originally, I wrote this as a PHP script since that's the language I'm most comfortable in. 

While the PHP script did the job, it had two problems:

1. PHP was a dependency. I wanted something that was dead easy to get running on a Mac with MacDown installed.
2. It was verbose.

I knew that BASH would be a better choice from the get-go, so I went ahead and decided to dust off the ol' BASH-hacking skills. Unfortunately, I couldn't find them anywhere in the noggin so I checked up on some of the current best practices, and leaned on a few people in `#bash` on [Freenode](https://freenode.net) to come up with what we've got here.

There's probably some ways I could improve things, so please feel free to open some issues or throw some pull requests in there.

## License:

>Copyright (c) 2017 David Drake
>
>Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except in compliance with the License. You may obtain a copy of the License at
>
>http://www.apache.org/licenses/LICENSE-2.0
>
>Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License. 

Author:
=====
David Drake 

[@randomdrake](https://twitter.com/randomdrake) | [https://randomdrake.com](https://randomdrake.com) | [LinkedIn](https://www.linkedin.com/in/david-drake-46524752/)
