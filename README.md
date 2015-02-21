# Google Hangouts Takeout Conversation Splitter

This repository contains a PHP script I used to split Google Hangouts conversations by thread, using the `Hangouts.json` file found in a Google Takeout archive.

As the `Hangouts.json` is encoded in JSON, it cannot be viewed or searched easily through standard commandline tools. This script aims to fix this by parsing the file, and outputting each conversation into its own file.

## Requirements

The script is pretty basic; just the PHP interpreter is needed — version 5.2.0 or higher will do.

## Usage
```
$ ./hangouts.php path/to/hangouts.json conversations/
```

This will read hangouts.json from directory `path/to` and store the threads in separate files by conversation.

## Licence

I am releasing this code under the BSD 2-clause licence as found on http://opensource.org/licenses/BSD-2-Clause
