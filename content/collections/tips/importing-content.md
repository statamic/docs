---
id: c52a611e-2694-4a70-a974-75934d178017
title: 'Importing Existing Content'
intro: "After configuring collections and blueprints, you'll likely want to import content from an existing CMS into Statamic. This guide walks you through the various options."
template: page
---
## Overview

After configuring your collections and blueprints in Statamic, your next step will likely be to import existing content into Statamic from a previous CMS.

This guide walks through the process of importing content using our first-party Importer addon, as well how you can build your own importer using repositories.

## Importer Addon (recommended)

To make the process of importing content super easy, we've built a first-party [Importer addon](https://github.com/statamic/importer). The addon allows you to import entries, taxonomies and users. It provides an easy-to-use UI for mapping data to blueprint fields.

1. To get started, install the Importer addon using Composer:
    ```bash
    composer require statamic/importer
    ```
2. Before importing anything, you should review the [Preperation steps](#preparation) detailed in the addon's documentation.
3. In the Control Panel, under `Utilities > Importer`, you can create an import. You'll be asked to give it a name, upload the file you wish to import and tell it where the data should be imported.
4. You can then map fields from your blueprint to fields/columns in your file. You will also need to specify a "Unique Key", which the Importer will use to determine if the item already exists in Statamic.
5. All that's left to do is click "Import" and watch the magic happen! ✨

For more detailed instructions on how the Importer works, please see the [addon's documentation](https://statamic.com/addons/statamic/importer/docs).

## Build your own importer

If you need more flexibility around how the import happens, or would just prefer to handle it yourself, then you can build your own importer.

1. Create a new command to house the importer:
    ```bash
    php artisan make:command ImportCommand
    ```
2. In that command, you'll need to get the content you're wanting to import. This could be from a JSON file, a spreadsheet or some kind of external API. It's up to you.
3. Now, for the exciting bit, importing the content!

    You can loop through the content and create entries for eeach item. Statamic provides an [entry repository](/repositories/entry-repository), which allows you to programatically create entries. Here's an example:

    ```php
    <?php

    namespace App\Console\Commands;

    use Illuminate\Console\Command;
    use Illuminate\Support\Str;
    use Statamic\Facades\Entry;

    class ImportCommand extends Command
    {
        /**
        * The name and signature of the console command.
        *
        * @var string
        */
        protected $signature = 'app:import';

        /**
        * The console command description.
        *
        * @var string
        */
        protected $description = 'Imports content into Statamic.';

        /**
        * Execute the console command.
        */
        public function handle() // [tl! focus:start]
        {
            // Get your content...
            $teamMembers = [
                ['name' => 'Josh Lyman', 'role' => 'Deputy Chief of Staff'],
                ['name' => 'CJ Cregg', 'role' => 'Press Secretary'],
                ['name' => 'Toby Ziegler', 'role' => 'Communications Director'],
                ['name' => 'Sam Seaborn', 'role' => 'Deputy Communications Director'],
            ];

            // Loop through each item and create a new entry using the Entry facade...
            foreach ($teamMembers as $member) {
                $entry = Entry::make()
                    ->collection('team')
                    ->slug(Str::slug($member['name']))
                    ->data([
                        'name' => $member['name'],
                        'role' => $member['role'],
                    ]);

                $entry->save();
            }
        }  // [tl! focus:end]
    }
    ```
4. Then, simply run the command to import the content:
    ```
    php artisan app:import
    ```

If you need to import other content, like taxonomy terms or users, please review the docs on [Repositories](/reference/repositories).
