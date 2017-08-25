# The Events Calendar PRO Simple List Events plugin

A simple little plugin to display Events from Events Calendar Pro in list via a shortcode with very little styling.

Example:
```
[ec_simple_events_list start_date="2017-08-20" end_date="2017-08-26" cat="featured" show_date_in_title="true" limit="10"]
```

The plugin takes 5 possible arguments.

| (string) | `$cat`                | category of the events to retrieve                                                 |
| (string) |  `$start_date`        | start date of the date range you want to list                                      |
| (string) | `$end_date`           | end date of the range you want to list                                             |
| (bool)   | `$show_date_in_title` | show the date in the title w/ the date formate of `D M j g:i a` (defaults to false)|
| (int)    | `$limit`              | how many events to get in the list (defaults to 20)                                |


This has been tested with The Events Caledar PRO v4.4.14


