<br>
<picture>
  <source media="(prefers-color-scheme: dark)" srcset="https://candide-com.be/images/gh/logo-dark.svg">
  <img alt="Insight Media Logo" src="https://candide-com.be/images/gh/logo-light.svg">
</picture>

# Statamic Opening hours

> Set your business' opening hours and exceptional closing times in the Statamic control panel.
>
> Display or query the opening hours in your antler views using the provided openingHours tag.

## Features

- Adds an 'opening hours' page to the CP navigation, where you can define multiple opening hours per weekday
- Add exceptional closing times, which override the default opening hours
- Display the opening hours using the provided tag
- Query for open/close status
- Query for next/previous opening hours/closing times
- Uses the [Spatie Opening Hours package](https://github.com/spatie/opening-hours) to perform queries

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

``` bash
composer require candide-com/statamic-opening-hours
```

Publish the optional config file.
``` bash
php artisan vendor:publish --tag=statamic-google-opening-hours-config --force
```

## How to Use

### In the Statamic Control Panel

Set your business' opening hours in the Statamic control panel.

### In your antlers templates

Use the openingHours tag to display or query opening hours:

Check if currently open:
``` antlers
{{ if {openingHours:isOpen} }}
    We are open
{{ /if }}
```

Check if currently closed:
``` antlers
{{ if {openingHours:isClosed} }}
    We are closed
{{ /if }}
```

Check if open on specific weekday:
``` antlers
{{ if {openingHours:isOpen on="tuesday"} }}
    We are open on tuesday
{{ /if }}
```

Check if open on specific date:
``` antlers
{{ if {openingHours:isOpen on="2022-12-31"} }}
    We are open on 2022-12-31
{{ /if }}
```

Check if open at specific time:
``` antlers
{{ if {openingHours:isOpen at="2022-12-31 15:00:00"} }}
    We are open on 2022-12-31 at 15:00:00
{{ /if }}
```

Check if closed on specific weekday:
``` antlers
{{ if {openingHours:isClosed on="monday"} }}
    We are closed on monday
{{ /if }}
```

Check if closed on specific date:
``` antlers
{{ if {openingHours:isClosed on="2023-01-02"} }}
    We are closed on 2023-01-02
{{ /if }}
```

Check if closed at specific time:
``` antlers
{{ if {openingHours:isClosed at="2022-12-31 22:00:00"} }}
    We are closed on 2022-12-31 at 22:00:00
{{ /if }}
```

Query opening times for specific weekday:
``` antlers
{{ openingHours:forDay day="monday" format="H:i" }}
    <div>{{ from }}-{{ to }}</div>
{{ /openingHours:forDay }}
```

Query opening times for all weekdays:
``` antlers
{{ openingHours:forWeek format="H:i" }}
    {{ day }}: {{ hours }} <div>{{ from }}-{{ to }}</div> {{ /hours }}<br>
{{ /openingHours:forWeek }}
 ```

Query opening times for specific date:
``` antlers
{{ openingHours:forDate date="2022-12-14" format="H:i" }}
    <div>{{ from }}-{{ to }}</div>
{{ /openingHours:forDate }}
 ```

Query exceptional closing times:
``` antlers
{{ openingHours:exceptions format="H:i" }}
    {{ day }} {{ hours }} from {{ from }}-{{ to }} {{ /hours }} {{ if reason }}({{ reason }}){{ /if }}<br>
{{ /openingHours:exceptions }}
 ```

Get next opening times
``` antlers
{{ openingHours:nextOpen date="{now format='Y-m-d H:i:s'}" format="Y-m-d H:i:s" }}
```

Get next closing times
``` antlers
{{ openingHours:nextClose date="{now format='Y-m-d H:i:s'}" format="Y-m-d H:i:s" }}
```

Get previous closing times
``` antlers
{{ openingHours:previousOpen date="{now format='Y-m-d H:i:s'}" format="Y-m-d H:i:s" }}
```

Get the amount of open time (number of hours as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInOpenHours from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

Get the amount of open time (number of minutes as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInOpenMinutes from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

Get the amount of open time (number of seconds as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInOpenSeconds from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

Get the amount of closed time (number of hours as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInClosedHours from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

Get the amount of closed time (number of minutes as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInClosedMinutes from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

Get the amount of minutes until opening time.
``` antlers
{{ openingHours:diffInClosedMinutes from="{now format='Y-m-d H:i:s'}" to="{ openingHours:nextOpen date="{now format='Y-m-d H:i:s'}" format="Y-m-d H:i:s" }" }}
```

Get the amount of closed time (number of seconds as a floating number) between 2 dates/times.
``` antlers
{{ openingHours:diffInClosedSeconds from="2022-12-21 10:00:00" to="2022-12-21 13:00:00" }}
```

**Important**: We recommend using the Antlers runtime parser when working with the openingHours tag.
