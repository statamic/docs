---
id: 51e7cb32-0c47-4c89-a0e3-33cc4d48c153
blueprint: ui_component
title: Calendar
template: ui-component
intro: We'll give you 3 guesses what this is for.
---

```component
<ui-card>
    <ui-calendar></ui-calendar>
</ui-card>
```


## Min and Max

You can pass the <code>min</code> and <code>max</code> props to limit the range of dates that can be selected.

```component
<ui-card>
    <ui-calendar
        min="2025-10-05"
        max="2025-10-25"
    ></ui-calendar>
</ui-card>
```


## Multiple Months

You can pass the <code>number-of-months</code> prop to display multiple months at once.

```component
<ui-card>
    <ui-calendar
        :number-of-months="2"
    ></ui-calendar>
</ui-card>
```


## Week Starts On

You can pass the <code>week-starts-on</code> prop to change the first day of the week.

The default is <code>0</code> (Sunday). Monday is <code>1</code>, Tuesday is <code>2</code>, etc.

```component
<ui-card>
<ui-calendar
    week-starts-on="1"
></ui-calendar>
</ui-card>
```


## Weekday Format

You can pass the <code>weekday-format</code> prop to change the format of the weekday names.

The default is <code>narrow</code>, <code>short</code> is <code>Mon</code>, <code>long</code> is <code>Monday</code>.

```component
<ui-card>
    <ui-calendar weekday-format="short"></ui-calendar>
</ui-card>
```


## Additional Props
You can pass additional props to the calendar to customize it.

<table>
    <thead>
        <tr>
            <th>Prop</th>
            <th>Type</th>
            <th>Default</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="font-mono">weekday-format</td>
            <td>string</td>
            <td>narrow</td>
        </tr>
        <tr>
            <td class="font-mono">prevent-deselect</td>
            <td>boolean</td>
            <td>false</td>
        </tr>
        <tr>
            <td class="font-mono">disabled</td>
            <td>boolean</td>
            <td>false</td>
        </tr>
        <tr>
            <td class="font-mono">inline</td>
            <td>boolean</td>
            <td>false</td>
        </tr>
    </tbody>
</table>
