# Data handler in TYPO3

## What does it do?

1.0.0 Explains the general usage of the DataHandler API in TYPO3.

1.1.0 Shows basic example operations with DataHandler.

1.2.0 Adds caching via caching tags.

1.3.0 Explains the usage of DataHandler via symfony commands.

1.4.0 Adds an example datahandler hook

1.5.0 Sample integration of processDatamap_beforeStart hook

1.6.0 Sample integration of processDatamap_preProcessFieldArray hook

1.7.0 Sample integration of processDatamap_postProcessFieldArray hook

1.8.0 Sample integration of processDatamap_afterDatabaseOperations hook

## Installation

Add via composer:

    composer require "passionweb/data-handler"

* Install the extension via composer
* Flush TYPO3 and PHP Cache

## Requirements

This example uses no 3rd party libraries.

## Extension settings

There are no extension settings available.

## Troubleshooting and logging

If something does not work as expected take a look at the log file.
Every problem is logged to the TYPO3 log (normally found in `var/log/typo3_*.log`)

## Achieving more together or Feedback, Feedback, Feedback

I'm grateful for any feedback! Be it suggestions for improvement, requests or just a (constructive) feedback on how good or crappy this snippet/repo is.

Feel free to send me your feedback to [service@passionweb.de](mailto:service@passionweb.de "Send Feedback") or [contact me on Slack](https://typo3.slack.com/team/U02FG49J4TG "Contact me on Slack")
