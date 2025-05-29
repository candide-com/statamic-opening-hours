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
      'slug' => 'Section Slug',
      'description' => 'Section Description',
      'booking_link' => 'Booking Link',
      'icon' => 'Icon',
      'associated_tour_markers' => [
         'title' => 'Associated Tour Markers',
         'tour_id' => 'Tour',
         'marker_id' => 'Marker',
      ],
      'closure' => [
          'is_closed' => 'Temporarily Closed',
          'reason' => 'Closure Reason',
      ],
      'hours' => [
        'title' => 'Opening Hours',
        'add' => 'Add hours',
        'description' => 'OSM',
        'validation' => [
            'invalid_format' => 'The opening hours format in :attribute is invalid. Please use format like "09:00-17:00" or "Mo-Fr 09:00-17:00".',
            'instructions' => 'Set opening hours.'
        ],
      ]
    ],
    'global' => [
        'closure' => [
            'is_closed' => 'Temporarily Closed',
            'is_closed_instructions' => 'Toggle this to indicate that the entire site is temporarily closed.',
            'reason' => 'Closure Reason',
            'reason_instructions' => 'Provide a reason for the temporary closure.',
        ],
    ],
];

