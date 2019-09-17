title: Date
description: A datepicker that includes an optional timepicker.
overview: >
  Select a date and optional time. Data is stored as a timestamp and can be formatted with any of the date [modifiers](/modifiers) or used in Tag conditions to filter results.
image: /assets/fieldtypes/date.png
options:
  -
    name: allow_time
    type: boolean *true*
    description: Enable/disable the timepicker
  -
    name: require_time
    type: boolean *false*
    description: Makes the time fields visible and non-dismissible.
  -
    name: allow_blank
    type: boolean *false*
    description: Allow the field to be left blank on save
  -
    name: format
    type: string *Y-m-d* (*H:i*)
    description: How the date should be saved. Any [PHP date formatting variables](http://php.net/manual/en/function.date.php) may be used.
  -
    name: input_format
    type: string *YYYY/M/DD*
    description: |
      How the date should be displayed in the field. Any [Moment.js date formatting variables][moment] may be used.
      [moment]: https://momentjs.com/docs/#/displaying/format/
  -
    name: earliest_date
    type: string
    description: The earliest date selectable. Accepts Moment.js dates, eg. `January 1, 1900`
id: 7dfba904-8a74-40e1-b507-51cd2b5f6123
