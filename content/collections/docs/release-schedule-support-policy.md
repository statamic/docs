---
id: c9ee871c-002b-48d7-b845-1abac58de337
blueprint: page
title: 'Release Schedule & Support Policy'
nav_title: 'Release Schedule'
intro: 'For all Statamic releases, bug fixes are provided for 1 year and security fixes are provided for 18 months.  For all first party addons, only the latest major release receives bug fixes. In addition, please review the [Laravel Support Policy](https://laravel.com/docs/master/releases#support-policy).'
---

## Versioning Scheme
Statamic and its other first-party packages follow [Semantic Versioning](https://semver.org/). Major releases are released every year (~Q1), following Laravel's major releases by roughly a month. Minor and patch releases may be released as often as every few days. Minor and patch releases should never contain breaking changes.

## Support Policy

<table class="text-sm">
   <thead>
      <tr>
         <th class="text-sm font-bold">Statamic</th>
         <th class="text-sm font-bold">Laravel</th>
         <th class="text-sm font-bold">PHP</th>
         <th class="text-sm font-bold">Release</th>
         <th class="text-sm font-bold">Bug Fixes Until</th>
         <th class="text-sm font-bold">Security Fixes Until</th>
      </tr>
   </thead>
   <tbody>
      <tr class="bg-red text-[#ffc9bf]">
         <td class="font-bold">3.3*</td>
         <td>8-9</td>
         <td>7.4-8.1</td>
         <td>Mar 2022</td>
         <td>Mar 2023</td>
         <td>Sep 2023</td>
      </tr>
      <tr class="bg-gray-lightest text-black/60">
         <td class="font-bold">3.4*</td>
         <td>8-9</td>
         <td>7.4-8.1</td>
         <td>Jan 2023</td>
         <td>Jan 2023</td>
         <td>Jul 2024</td>
      </tr>
      <tr class="bg-white">
         <td class="font-bold">4</td>
         <td>9-10</td>
         <td>8.0-8.3</td>
         <td>Mar 2023</td>
         <td>Mar 2024</td>
         <td>Sep 2024</td>
      </tr>
      <tr>
         <td class="font-bold">5</td>
         <td>10-11</td>
         <td>8.2-8.3</td>
         <td>Mar 2024</td>
         <td>Mar 2025</td>
         <td>Sep 2025</td>
      </tr>
   </tbody>
</table>

_*Prior to Semantic Versioning_

These dates are subject to changes based on factors outside of our control, such as the release schedule and required versions of Laravel and major Laravel packages we depend upon.
