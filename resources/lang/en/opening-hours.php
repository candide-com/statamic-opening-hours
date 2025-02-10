<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Opening hours
    |--------------------------------------------------------------------------
    */

    'opening-hours' => 'Opening hours',
    'default-hours' => [
        'display' => 'Default hours',
        'instructions' => 'Set the opening hours per weekday. Multiple hour ranges are possible.<br>A weekday without opening hours is considered as closing day.'
    ],
    'weekdays' => [
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
    ],
    'from' => 'From',
    'to' => 'To',
    'date' => 'Date',
    'exceptions' => [
        'display' => 'Exceptions',
        'instructions' => 'Set exceptional closing days.<br>It is possible to set optional exceptional opening hours per closing day.',
        'reason' => 'Reason for closing',
        'set_title' => 'Exception',
        'closing_date' => 'Closing date',
        'exceptional_hours' => 'Exceptional hours',
        'exceptional_hours_display' => 'Open during these exceptional hours.',
    ],
    'sections' => 'Opening Hours Sections',
    'section' => [
      'section_title' => 'Title',
      'section_description' => 'Description',
      'section_slug' => 'Slug',
      'is_closed' => 'Temporarily Closed',
      'closure_reason' => 'Closure Reason',
      'hours' => 'Opening Hours',
      'add-hours' => 'Add hours'
    ],
    'global' => [
      'is_closed' => 'Temporarily Closed',
      'is_closed_instructions' => 'Toggle this to indicate that the entire site is temporarily closed.',
      'closure_reason' => 'Closure Reason',
      'closure_reason_instructions' => 'Provide a reason for the temporary closure.'
    ],
    'hours_description' => 'Description',
];

