# Logger

This logger package provides a few helper classes to minimize the performance impact of writing logs. If you desire additional options, please open an issues.

## Installation

```bash
composer require bjoern-buettner/logger
```

## Contained Classes

All mentioned classes can be found in the namespace `Me\BjoernBuettner\Logger`.

### EagerMonologRoundRobinFileHandler

The eager monolog round robin file handler for [Monolog](https://github.com/Seldaek/monolog) writes directly to a set of files, that are randomly chosen from a list of possible files. This means, that the chance of a file being written to by multiple handlers at once gets way smaller, removing nearly all of the performance impact.

### LazyLoggerFacade

This is a psr-compatible implementation of a logger only dumping the messages from memory after a request finished. This completely removes the file access overhead from the user-measurable webrequest speed.

###  LazyMonologHandlerFacade

The lazy monolog handler facade is an implementation of a [Monolog](https://github.com/Seldaek/monolog) handler only dumping the messages from memory after a request finished. This completely removes all remote access overhead from the user-measurable webrequest speed.
