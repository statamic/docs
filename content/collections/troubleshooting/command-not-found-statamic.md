---
id: 5d5e0add-3e2b-44c9-8ec2-7d18b9965504
title: 'CLI Command Not Found: Statamic'
intro: |-
  In order for you to run globally installed [Composer](https://getcomposer.org) binaries, (like our `statamic` installer) you'll need to tell your computer where it's located.
template: page
categories:
  - cli
  - troubleshooting
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622820986
---
If you were to run `statamic` in your terminal, it would have no idea you meant the one you just installed with Composer.

``` shell
$ statamic new mysite
Command not found: statamic
```

You _could_ use the full path to the binary instead:

``` shell
$ ~/.composer/vendor/bin/statamic new mysite
Building a new statamic site.
```

But that's silly. Who wants to do that every time?

You can solve this by adding Composer's `bin` directory to your `PATH` (sometimes seen as `$PATH`).

## MacOS or Linux

1. You'll need to find Composer's global directory. This is usually somewhere in your home directory. This command will output the absolute path:
    ``` shell
    composer global config bin-dir --absolute
    ```

2. Identify which shell you're using. You can determine this by running `echo $SHELL`.
3. Next, you'll need to add Composer's `bin` directory to your shell `rc` file. Feel free to create the file if it doesn't already exist.
    - If you're using `bash`, this will be  `~/.bashrc`
    - If you're using `zsh`, this will be `~/.zshrc`

    ``` shell
    # Replace the path below with the path identified in step 1
    export PATH="/Users/me/.composer/vendor/bin/":$PATH
    ```

To test it, open a _new_ terminal window and run `echo $PATH`. You should see the composer directory at the end.

## Windows

To add to your `PATH` on Windows, it requires you to click through some things. Ryan Hoffman has written [an article](https://www.architectryan.com/2018/03/17/add-to-the-path-on-windows-10/) with screenshots to walk you through it.

Composer's directory to add is `%USERPROFILE%\AppData\Roaming\Composer\vendor\bin`.
