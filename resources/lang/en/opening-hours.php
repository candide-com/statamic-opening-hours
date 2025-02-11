<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Opening hours
    |--------------------------------------------------------------------------
    */
    'opening-hours' => 'Opening hours',
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
      'title' => 'Section Title',
      'description' => 'Section Description',
      'slug' => 'Section Slug',
      'closure' => [
          'is_closed' => 'Temporarily Closed',
          'reason' => 'Closure Reason',
      ],
      'hours' => [
        'title' => 'Opening Hours',
        'add' => 'Add hours',
        'description' => 'Description',
      ]
    ],
    'global' => [
        'closure' => [
            'is_closed' => 'Temporarily Closed',
            'is_closed_instructions' => 'Toggle this to indicate that the entire site is temporarily closed.',
            'reason' => 'Closure Reason',
            'closure_reason_instructions' => 'Provide a reason for the temporary closure.'
        ],
    ],
];

