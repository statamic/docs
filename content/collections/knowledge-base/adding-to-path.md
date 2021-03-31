---
title: 'Adding to PATH'
id: 5d5e0add-3e2b-44c9-8ec2-7d18b9965504
intro: |
  In order for you to run globally installed Composer binaries, (like our `statamic` installer) you'll need to tell your
  computer where it's located.
---

If you were to run `statamic` in your terminal, it would have no idea you meant the one you just installed with Composer.

```bash
$ statamic new mysite
Command not found: statamic
```

You _could_ use the full path to the binary instead:

```bash
$ ~/.composer/vendor/bin/statamic new mysite
Building a new statamic site.
```

But that's silly. Who wants to do that every time?

You can solve this by adding Composer's `bin` directory to your `PATH` (sometimes seen as `$PATH`).

## MacOS or Linux

Find out what shell you're using by running `echo $SHELL`.

- If it's `bash`, create a `~/.bashrc` file.
- If it's `zsh`, create a `~/.zshrc` file.

Then add this to the end of it:

```bash
export PATH=${PATH}:~/.composer/vendor/bin
```

To test it, open a _new_ terminal window and run `echo $PATH`. You should see the composer directory at the end.

## Windows 10

To add to your `PATH` on Windows, it requires you to click through some things. Ryan Hoffman has written [an article](https://www.architectryan.com/2018/03/17/add-to-the-path-on-windows-10/) with screenshots to walk you through it.

Composer's directory to add is `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`.
