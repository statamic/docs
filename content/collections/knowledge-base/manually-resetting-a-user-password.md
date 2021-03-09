---
title: 'Manually Resetting a User Password'
id: f7de14cd-9160-43c1-a017-c3af018ab8ab
---
Sometimes you're stuck in a perfect storm of an error loop (like if your file permissions are wrong _and_ your didn't configure your email provider correctly) and just need to reset a user's password by any means necessary.

These are those means.

1. Find the user you're looking for the `users` directory — they're organized by email address.
2. Open the appropriate YAML file.
3. Delete the `password_hash` variable.
4. Add a new `password` variable set to whatever you want your password to be — temporary or otherwise.
5. Visit any URL on the site and Statamic will spot that unencrypted password and hash it for you.
6. Now you can log in.

## Example for the sake of clarity

**Before, while you have no idea what the password is:**
``` yaml
name: 'Mrs. Buttersworth'
super: true
id: ca095f7c-8870-4dba-bc97-8f5a43953920
password_hash: $2y$10$Sou9pAY.BXgz6xdWwji8wOdCdYo2GppvPOHBp8TEp074aQOtYl8AS
```

**After Step 4:**
``` yaml
name: 'Mrs. Buttersworth'
super: true
id: ca095f7c-8870-4dba-bc97-8f5a43953920
password: moresyruppleaseplzandthankyou!
```

**After Step 5:**
``` yaml
name: 'Mrs. Buttersworth'
super: true
id: ca095f7c-8870-4dba-bc97-8f5a43953920
password_hash: $2y$10$Vopn8T7e.EMVEjxdP5p.g.AU5GTTN4RklvgR2l0dTwSPeJal91v/q
```
