---
title: Events
template: page
updated_by: 42bb2659-2277-44da-a5ea-2f1eed146402
updated_at: 1569347432
id: 6843f6e9-ac62-4128-8d50-887560f201ca
intro: |
  Events serve as a great way to decouple various aspects of the application, or even modify behavior or output of core functionality. A single event can have multiple listeners that do not depend on each other.
---
## Overview {#overview}

Statamic will dispatch a number of events in various locations throughout the codebase.

To listen for events, simply create an event listener, type the event name, then handle the event.

``` php
use Statamic\Events\SomeEvent;

class SomeListener
{
    public function handle(SomeEvent $event)
    {
        //
    }
}
```

For applications with a `app/Providers/EventServiceProvider.php` file, you should also register the event listener in the `$listen` array:

``` php
protected $listen = [
    'SomeEvent' => [
        'SomeListener',
    ],
];
```

For a more in-depth explanation on events, please consult the [Laravel documentation](https://laravel.com/docs/events).

If you're creating an addon, you can quickly [register event listeners or subscribers](/extending/addons#events).

## Available Events

### AssetContainerBlueprintFound
`Statamic\Events\AssetContainerBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for an asset in an asset container.

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add fields to the publish page on the fly.

``` php
public function handle(AssetContainerBlueprintFound $event)
{
    $event->blueprint;
    $event->container;
}
```

### AssetContainerCreating
`Statamic\Events\AssetContainerCreating`

Dispatched before an asset container is created. You can return `false` to prevent it from being created.

``` php
public function handle(AssetContainerCreating $event)
{
    $event->container;
}
```

### AssetContainerDeleted
`Statamic\Events\AssetContainerDeleted`

Dispatched after an asset container has been deleted.

``` php
public function handle(AssetContainerDeleted $event)
{
    $event->container;
}
```

### AssetContainerSaved
`Statamic\Events\AssetContainerSaved`

Dispatched after an asset container has been saved.

``` php
public function handle(AssetContainerSaved $event)
{
    $event->container;
}
```

### `AssetCreated`
`Statamic\Events\AssetCreated`

Dispatched after an asset has been created or uploaded.

``` php
public function handle(AssetCreated $event)
{
    $event->asset;
}
```

### `AssetCreating`
`Statamic\Events\AssetCreating`

Dispatched before an asset is created or uploaded. You can return `false` to prevent it from being created.

``` php
public function handle(AssetCreating $event)
{
    $event->asset;
}
```

### AssetDeleting
`Statamic\Events\AssetDeleting`

Dispatched before an asset is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(AssetDeleting $event)
{
    $event->asset;
}
```

### AssetDeleted
`Statamic\Events\AssetDeleted`

Dispatched after an asset has been deleted.

``` php
public function handle(AssetDeleted $event)
{
    $event->asset;
}
```

### AssetFolderDeleted
`Statamic\Events\AssetFolderDeleted`

Dispatched after an asset folder has been deleted.

``` php
public function handle(AssetFolderDeleted $event)
{
    $event->folder;
}
```

### AssetFolderSaved
`Statamic\Events\AssetFolderSaved`

Dispatched after an asset folder has been saved.

``` php
public function handle(AssetFolderSaved $event)
{
    $event->folder;
}
```

### AssetSaved
`Statamic\Events\AssetSaved`

Dispatched after an asset has been saved.

``` php
public function handle(AssetSaved $event)
{
    $event->asset;
}
```

### AssetSaving
`Statamic\Events\AssetSaving`

Dispatched before an asset is saved. You can return `false` to prevent it from being saved.

``` php
public function handle(AssetSaving $event)
{
    $event->asset;
}
```

### AssetUploaded
`Statamic\Events\AssetUploaded`

Dispatched after an asset has been uploaded.

``` php
public function handle(AssetUploaded $event)
{
    $event->asset;
}
```

### BlueprintCreating
`Statamic\Events\BlueprintCreating`

Dispatched before a blueprint is created. You can return `false` to prevent it from being creating.

``` php
public function handle(BlueprintCreating $event)
{
    $event->blueprint;
}
```

### BlueprintDeleting
`Statamic\Events\BlueprintDeleting`

Dispatched before a blueprint is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(BlueprintDeleting $event)
{
    $event->blueprint;
}
```

### BlueprintDeleted
`Statamic\Events\BlueprintDeleted`

Dispatched after a blueprint has been deleted.

``` php
public function handle(BlueprintDeleted $event)
{
    $event->blueprint;
}
```

### BlueprintSaved
`Statamic\Events\BlueprintSaved`

Dispatched after a blueprint has been saved.

``` php
public function handle(BlueprintSaved $event)
{
    $event->blueprint;
}
```

### CollectionDeleting
`Statamic\Events\CollectionDeleting`

Dispatched before a collection is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(CollectionDeleting $event)
{
    $event->collection;
}
```

### CollectionDeleted
`Statamic\Events\CollectionDeleted`

Dispatched after a collection has been deleted.

``` php
public function handle(CollectionDeleted $event)
{
    $event->collection;
}
```

### CollectionCreated
`Statamic\Events\CollectionCreated`

Dispatched after a collection has been created.

``` php
public function handle(CollectionCreated $event)
{
    $event->collection;
}
```

### CollectionCreating
`Statamic\Events\CollectionCreating`

Dispatched before a collection is created. You can return `false` to prevent it from being created.

``` php
public function handle(CollectionCreating $event)
{
    $event->collection;
}
```

### CollectionSaved
`Statamic\Events\CollectionSaved`

Dispatched after a collection has been saved.

``` php
public function handle(CollectionSaved $event)
{
    $event->collection;
}
```

### CollectionSaving
`Statamic\Events\CollectionSaving`

Dispatched before a collection is saved. You can return `false` to prevent it from being saved.

``` php
public function handle(CollectionSaving $event)
{
    $event->collection;
}
```


### CollectionTreeDeleted
`Statamic\Events\CollectionTreeDeleted`

Dispatched after a collection tree has been deleted.

``` php
public function handle(CollectionTreeDeleted $event)
{
    $event->tree;
}
```

### CollectionTreeSaved
`Statamic\Events\CollectionTreeSaved`

Dispatched after a collection tree has been saved.

``` php
public function handle(CollectionTreeSaved $event)
{
    $event->tree;
}
```

### CollectionTreeSaving
`Statamic\Events\CollectionTreeSaving`

Dispatched when a collection tree is being saved. You can return `false` to prevent it from being saved.

``` php
public function handle(CollectionTreeSaving $event)
{
    $event->tree;
}
```

### EntryBlueprintFound
`Statamic\Events\EntryBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for an entry.

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add a section to a blueprint in the publish page on the fly.

``` php
public function handle(EntryBlueprintFound $event)
{
    $event->blueprint;
    $event->entry;
}
```

### EntryCreated
`Statamic\Events\EntryCreated`

Dispatched after an entry has been created.

``` php
public function handle(EntryCreated $event)
{
    $event->entry;
}
```

### EntryCreating
`Statamic\Events\EntryCreating`

Dispatched before an entry is created. You can return `false` to prevent it from being created.

``` php
public function handle(EntryCreating $event)
{
    $event->entry;
}
```

### EntryDeleting
`Statamic\Events\EntryDeleting`

Dispatched before an entry is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(EntryDeleting $event)
{
    $event->entry;
}
```

### EntryDeleted
`Statamic\Events\EntryDeleted`

Dispatched after an entry has been deleted.

``` php
public function handle(EntryDeleted $event)
{
    $event->entry;
}
```

### EntrySaved
`Statamic\Events\EntrySaved`

Dispatched after an entry has been saved.

``` php
public function handle(EntrySaved $event)
{
    $event->entry;
}
```

:::tip Note
When an entry has multiple localizations, the `EntrySaved` event will be fired for each of those localizations. You may use the `$event->isInitial()` method to determine whether the localized entry from the event was the one originally being saved.
:::

### EntrySaving
`Statamic\Events\EntrySaving`

Dispatched before an entry is saved. You can return `false` to prevent it from being saved.

``` php
public function handle(EntrySaving $event)
{
    $event->entry;
}
```

### EntryScheduleReached
`Statamic\Events\EntryScheduleReached`

Dispatched whenever a scheduled entry reaches its target date. This event is used in multiple places such as updating search indexes and invalidating caches.

The event will be dispatched on the minute _after_ the scheduled time.

``` php
public function handle(EntryScheduleReached $event)
{
    $event->entry;
}
```

### FieldsetCreating
`Statamic\Events\FieldsetCreating`

Dispatched before a fieldset is created. You can return `false` to prevent it from being created.

``` php
public function handle(FieldsetCreating $event)
{
    $event->fieldset;
}
```

### FieldsetDeleting
`Statamic\Events\FieldsetDeleting`

Dispatched before a fieldset is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(FieldsetDeleting $event)
{
    $event->fieldset;
}
```

### FieldsetDeleted
`Statamic\Events\FieldsetDeleted`

Dispatched after a fieldset has been deleted.

``` php
public function handle(FieldsetDeleted $event)
{
    $event->fieldset;
}
```

### FieldsetSaved
`Statamic\Events\FieldsetSaved`

Dispatched after a fieldset has been saved.

``` php
public function handle(FieldsetSaved $event)
{
    $event->fieldset;
}
```

### FormBlueprintFound
`Statamic\Events\FormBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for a form.

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add a section to a blueprint in the publish page on the fly.

``` php
public function handle(FormBlueprintFound $event)
{
    $event->blueprint;
    $event->form;
}
```

### FormCreating
`Statamic\Events\FormCreating`

Dispatched before a form is created. You can return `false` to prevent it from being created.

``` php
public function handle(FormCreating $event)
{
    $event->form;
}
```

### FormDeleting
`Statamic\Events\FormDeleting`

Dispatched before a form is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(FormDeleting $event)
{
    $event->form;
}
```

### FormDeleted
`Statamic\Events\FormDeleted`

Dispatched after a form has been deleted.

``` php
public function handle(FormDeleted $event)
{
    $event->form;
}
```

### FormSaved
`Statamic\Events\FormSaved`

Dispatched after a form has been saved.

``` php
public function handle(FormSaved $event)
{
    $event->form;
}
```

### FormSubmitted
`Statamic\Events\FormSubmitted`

Dispatched when a [Form](/forms) is submitted on the front-end, before the Submission is created.

``` php
public function handle(FormSubmitted $event)
{
    $event->submission; // The Submission object
}
```

You can `return false` to prevent the submission, but appear to the user as though it succeeded.

If you'd like to show validation errors, you may throw an `Illuminate\Validation\ValidationException`:

``` php
throw ValidationException::withMessages(['You did something wrong.']);
```

You may also just modify the submission object. You do not need to `return` anything.

### GlideCacheCleared
`Statamic\Events\GlideCacheCleared`

Dispatched after the Glide cache has been cleared, either via the `php please glide:clear` command or via the Cache Manager utility.

``` php
public function handle(GlideCacheCleared $event)
{
    //
}
```

### GlideImageGenerated
`Statamic\Events\GlideImageGenerated`

Dispatched after Glide generates an image.

``` php
public function handle(GlideImageGenerated $event)
{
    $event->path;
    $event->params;
}
```

### GlobalSetCreating
`Statamic\Events\GlobalSetCreating`

Dispatched before a global set is created. You can return `false` to prevent it from being created.

``` php
public function handle(GlobalSetCreating $event)
{
    $event->globals;
}
```

### GlobalSetDeleting
`Statamic\Events\GlobalSetDeleting`

Dispatched before a global set is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(GlobalSetDeleting $event)
{
    $event->globals;
}
```

### GlobalSetDeleted
`Statamic\Events\GlobalSetDeleted`

Dispatched after a global set has been deleted.

``` php
public function handle(GlobalSetDeleted $event)
{
    $event->globals;
}
```

### GlobalSetSaved
`Statamic\Events\GlobalSetSaved`

Dispatched after a global set has been saved.

``` php
public function handle(GlobalSetSaved $event)
{
    $event->globals;
}
```

### GlobalVariablesCreated
`Statamic\Events\GlobalVariablesCreated`

Dispatched after Global Variables have been created.

``` php
public function handle(GlobalVariablesCreated $event)
{
    $event->variables;
}
```

### GlobalVariablesCreating
`Statamic\Events\GlobalVariablesCreating`

Dispatched before Global Variables are created. You can return `false` to prevent it from being created.

``` php
public function handle(GlobalVariablesCreating $event)
{
    $event->variables;
}
```

### GlobalVariablesDeleting
`Statamic\Events\GlobalVariablesDeleting`

Dispatched after Global Variables have been deleted.

``` php
public function handle(GlobalVariablesDeleting $event)
{
    $event->variables;
}
```

### GlobalVariablesDeleted
`Statamic\Events\GlobalVariablesDeleted`

Dispatched before Global Variables are deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(GlobalVariablesDeleted $event)
{
    $event->variables;
}
```

### GlobalVariablesSaved
`Statamic\Events\GlobalVariablesSaved`

Dispatched after Global Variables have been saved.

``` php
public function handle(GlobalVariablesSaved $event)
{
    $event->variables;
}
```

### GlobalVariablesSaving
`Statamic\Events\GlobalVariablesSaving`

Dispatched before Global Variables are saved. You can return `false` to prevent it from being saved.

``` php
public function handle(GlobalVariablesSaving $event)
{
    $event->variables;
}
```

### GlobalVariablesBlueprintFound
`Statamic\Events\GlobalVariablesBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for a variables in a global set.
(Variables meaning the globals localized to a particular site)

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add a section to a blueprint in the publish page on the fly.

``` php
public function handle(GlobalVariablesBlueprintFound $event)
{
    $event->blueprint;
    $event->globals;
}
```

### ImpersonationStarted
`Statamic\Events\ImpersonationStarted`

Dispatched whenever a user starts impersonating another user.

``` php
public function handle(ImpersonationStarted $event)
{
    $event->impersonator; // The other who started impersonating the other.
    $event->impersonated; // The user being impersonated.
}
```

### ImpersonationEnded
`Statamic\Events\ImpersonationEnded`

Dispatched whenever a user finishes impersonating another user.

``` php
public function handle(ImpersonationEnded $event)
{
    $event->impersonator; // The other who started impersonating the other.
    $event->impersonated; // The user being impersonated.
}
```

### LicensesRefreshed
`Statamic\Events\LicensesRefreshed`

Dispatched when a user manually triggers a "Sync" of a site's licenses via the Licenses utility.

``` php
public function handle(LicensesRefreshed $event)
{
    //
}
```

### LicenseSet
`Statamic\Events\LicenseSet`

Dispatched after a license key has been set via the `php please license:set` command.

``` php
public function handle(LicenseSet $event)
{
    //
}
```

### LocalizedTermDeleted
`Statamic\Events\LocalizedTermDeleted`

Dispatched after a taxonomy term has been deleted.

This event is *similar* to the [`TermDeleted`](#termdeleted) event, however, instead of `$term` being a `Term` instance, it will be a `LocalizedTerm` instance.

``` php
public function handle(LocalizedTermDeleted $event)
{
    $event->term;
}
```

### LocalizedTermSaved
`Statamic\Events\LocalizedTermSaved`

Dispatched after a taxonomy term has been saved.

This event is *similar* to the [`TermSaved`](#termsaved) event, however, instead of `$term` being a `Term` instance, it will be a `LocalizedTerm` instance.

``` php
public function handle(LocalizedTermSaved $event)
{
    $event->term;
}
```

### NavCreated
`Statamic\Events\NavCreated`

Dispatched after a nav has been created.

``` php
public function handle(NavCreated $event)
{
    $event->nav;
}
```

### NavCreating
`Statamic\Events\NavCreating`

Dispatched before a nav is created. You can return `false` to prevent it from being created.

``` php
public function handle(NavCreating $event)
{
    $event->nav;
}
```

### NavDeleting
`Statamic\Events\NavDeleting`

Dispatched before a nav is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(NavDeleting $event)
{
    $event->nav;
}
```

### NavDeleted
`Statamic\Events\NavDeleted`

Dispatched after a nav has been deleted.

``` php
public function handle(NavDeleted $event)
{
    $event->nav;
}
```

### NavSaved
`Statamic\Events\NavSaved`

Dispatched after a nav has been saved.

``` php
public function handle(NavSaved $event)
{
    $event->nav;
}
```

### NavSaving
`Statamic\Events\NavSaving`

Dispatched before a nav is saved. You can return `false` to prevent it from being saved.

``` php
public function handle(NavSaving $event)
{
    $event->nav;
}
```

### NavTreeSaved
`Statamic\Events\NavTreeSaved`

Dispatched after a nav tree has been saved.

``` php
public function handle(NavTreeSaved $event)
{
    $event->tree;
}
```

### NavTreeSaving
`Statamic\Events\NavTreeSaving`

Dispatched when a nav tree is being saved. You can return `false` to prevent it from being saved.

``` php
public function handle(NavTreeSaving $event)
{
    $event->tree;
}
```

### ResponseCreated
`Statamic\Events\ResponseCreated`

Dispatched after Statamic finishes creating the response to send to the front-end.
You may wish to modify the response to add headers, etc.

``` php
public function handle(ResponseCreated $event)
{
    $event->response; // The Response object
}
```

### RevisionDeleted
`Statamic\Events\RevisionDeleted`

Dispatched after a revision of an entry has been deleted.

``` php
public function handle(RevisionDeleted $event)
{
    $event->revision;
}
```

### RevisionSaving
`Statamic\Events\RevisionSaving`

Dispatched before a revision of an entry is saved. You can return `false` to prevent it from being saved.

``` php
public function handle(RevisionSaving $event)
{
    $event->revision;
}
```

### RevisionSaved
`Statamic\Events\RevisionSaved`

Dispatched after a revision of an entry has been saved.

``` php
public function handle(RevisionSaved $event)
{
    $event->revision;
}
```


### RoleDeleted
`Statamic\Events\RoleDeleted`

Dispatched after a role has been deleted.

``` php
public function handle(RoleDeleted $event)
{
    $event->role;
}
```

### RoleSaved
`Statamic\Events\RoleSaved`

Dispatched after a role has been saved.

``` php
public function handle(RoleSaved $event)
{
    $event->role;
}
```

### SearchIndexUpdated
`Statamic\Events\SearchIndexUpdated`

Dispatched when a search index is updated, either via the `php please search:update` command or via the Search utility.

``` php
public function handle(SearchIndexUpdated $event)
{
    $event->index;
}
```

### SiteCreated
`Statamic\Events\SiteCreated`

Dispatched when a site is created via the Control Panel.

``` php
public function handle(SiteCreated $event)
{
    $event->site;
}
```

### SiteDeleted
`Statamic\Events\SiteDeleted`

Dispatched when a site is deleted via the Control Panel.

``` php
public function handle(SiteDeleted $event)
{
    $event->site;
}
```

### SiteSaved
`Statamic\Events\SiteSaved`

Dispatched when a site is saved via the Control Panel.

``` php
public function handle(SiteSaved $event)
{
    $event->site;
}
```

### StacheCleared
`Statamic\Events\StacheCleared`

Dispatched after the Stache cache has been cleared, either via the `php please stache:clear` command or via the Cache Manager utility.

``` php
public function handle(StacheCleared $event)
{
    //
}
```

### StacheWarmed
`Statamic\Events\StacheWarmed`

Dispatched after the Stache cache has been warmed, either via the `php please stache:warm` command or via the Cache Manager utility.

``` php
public function handle(StacheWarmed $event)
{
    //
}
```

### StaticCacheCleared
`Statamic\Events\StaticCacheCleared`

Dispatched after the Static Cache has been cleared, either via the `php please static:clear` command or via the Cache Manager utility.

``` php
public function handle(StaticCacheCleared $event)
{
    //
}
```

### SubmissionCreated
`Statamic\Events\SubmissionCreated`

Dispatched after a form submission has been created. This happens after a form has been submitted on the front-end.

``` php
public function handle(SubmissionCreated $event)
{
    $event->submission;
}
```

If you're looking to prevent a form being submitted or trigger validation errors, check out the [FormSubmitted](#formsubmitted) event.

### SubmissionCreating
`Statamic\Events\SubmissionCreating`

Dispatched before a submission is created. You can return `false` to prevent it from being created.

``` php
public function handle(SubmissionCreating $event)
{
    $event->submission;
}
```

### SubmissionDeleted
`Statamic\Events\SubmissionDeleted`

Dispatched after a form submission has been deleted.

``` php
public function handle(SubmissionDeleted $event)
{
    $event->submission;
}
```

### SubmissionSaved
`Statamic\Events\SubmissionSaved`

Dispatched after a form submission has been saved.

``` php
public function handle(SubmissionSaved $event)
{
    $event->submission;
}
```

### TaxonomyCreating
`Statamic\Events\TaxonomyCreating`

Dispatched before a taxonomy is created. You can return `false` to prevent it from being created.

``` php
public function handle(TaxonomyCreating $event)
{
    $event->taxonomy;
}
```

### TaxonomyDeleting
`Statamic\Events\TaxonomyDeleting`

Dispatched before a taxonomy is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(TaxonomyDeleting $event)
{
    $event->taxonomy;
}
```

### TaxonomyDeleted
`Statamic\Events\TaxonomyDeleted`

Dispatched after a taxonomy has been deleted.

``` php
public function handle(TaxonomyDeleted $event)
{
    $event->taxonomy;
}
```

### TaxonomySaved
`Statamic\Events\TaxonomySaved`

Dispatched after a taxonomy has been saved.

``` php
public function handle(TaxonomySaved $event)
{
    $event->taxonomy;
}
```

### TermBlueprintFound
`Statamic\Events\TermBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for a taxonomy term.

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add a section to a blueprint in the publish page on the fly.

``` php
public function handle(TermBlueprintFound $event)
{
    $event->blueprint;
    $event->term;
}
```

### TermCreating
`Statamic\Events\TermCreating`

Dispatched before a taxonomy term is created. You can return `false` to prevent it from being created.

``` php
public function handle(TermCreating $event)
{
    $event->term;
}
```

### TermDeleting
`Statamic\Events\TermDeleting`

Dispatched before a taxonomy term is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(TermDeleting $event)
{
    $event->term;
}
```

### TermDeleted
`Statamic\Events\TermDeleted`

Dispatched after a taxonomy term has been deleted.

This event is *similar* to the [`LocalizedTermDeleted`](#localizedtermdeleted) event, however, instead of `$term` being a `LocalizedTerm` instance, it will be a `Term` instance.

``` php
public function handle(TermDeleted $event)
{
    $event->term;
}
```

### TermSaved
`Statamic\Events\TermSaved`

Dispatched after a taxonomy term has been saved.

This event is *similar* to the [`LocalizedTermSaved`](#localizedtermsaved) event, however, instead of `$term` being a `LocalizedTerm` instance, it will be a `Term` instance.

``` php
public function handle(TermSaved $event)
{
    $event->term;
}
```

### UserBlueprintFound
`Statamic\Events\UserBlueprintFound`

Dispatched after Statamic finds the blueprint to be used for a user.

You may modify the blueprint here and it will be reflected in the publish form (and wherever else a blueprint is used).
An example of when this would be useful is to add a section to a blueprint in the publish page on the fly.

``` php
public function handle(UserBlueprintFound $event)
{
    $event->blueprint;
}
```

### UserCreating
`Statamic\Events\UserCreating`

Dispatched before a user is created. You can return `false` to prevent it from being created.

``` php
public function handle(UserCreating $event)
{
    $event->user;
}
```

### UserDeleting
`Statamic\Events\UserDeleting`

Dispatched before a user is deleted. You can return `false` to prevent it from being deleted.

``` php
public function handle(UserDeleting $event)
{
    $event->user;
}
```

### UserDeleted
`Statamic\Events\UserDeleted`

Dispatched after a user has been deleted.

``` php
public function handle(UserDeleted $event)
{
    $event->user;
}
```

### UserGroupDeleted
`Statamic\Events\UserGroupDeleted`

Dispatched after a user group has been deleted.

``` php
public function handle(UserGroupDeleted $event)
{
    $event->group;
}
```

### UserGroupSaved
`Statamic\Events\UserGroupSaved`

Dispatched after a user group has been saved.

``` php
public function handle(UserGroupSaved $event)
{
    $event->group;
}
```

### UserPasswordChanged
`Statamic\Events\UserPasswordChanged`

Dispatched when the password of another user has been changed in the Control Panel.

``` php
public function handle(UserPasswordChanged $event)
{
    $event->user;
}
```

### UserRegistering
`Statamic\Events\UserRegistering`

Dispatched before a user is saved.

You can return false to prevent the submission, but appear to the user as though it succeeded.

``` php
public function handle(UserRegistering $event)
{
    $event->user;
}
```

### UserRegistered
`Statamic\Events\UserRegistered`

Dispatched after a user is saved.

``` php
public function handle(UserRegistered $event)
{
    $event->user;
}
```

### UserSaved
`Statamic\Events\UserSaved`

Dispatched after a user has been saved.

``` php
public function handle(UserSaved $event)
{
    $event->user;
}
```

### UrlInvalidated
`Statamic\Events\UrlInvalidated`

Dispatched after a URL has been removed from the static cache.

``` php
public function handle(UrlInvalidated $event)
{
    $event->url;
}
```
