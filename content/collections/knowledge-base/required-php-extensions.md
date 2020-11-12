---
title: 'Required PHP Extensions for Assets'
intro: 'Is your Control Panel subtly broken?  Check to see if you have these PHP extensions enabled.'
template: page
stage: Complete
id: 0c30a664-9bc3-4c5e-ad8c-66452b049748
---
Control Panel will gently fail, particularly in the **Assets** section and **Glide** on the front end, unless you have the following PHP extensions enabled on your server:

- mbstring
- exif
- gd2
- fileinfo

Not all PHP installations will have these enabled by default.  Consult your php.ini file or **Utilities > PHP Info** to determine whether you have them installed.
