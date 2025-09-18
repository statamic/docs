---
id: b46adc3b-c4de-4148-a388-c8ff498ae9c9
blueprint: tips
title: 'Git Workflow'
intro: 'A good workflow revolving around git to manage your deployments is a key factor in a pain-free and efficient project.'
template: page
---
Given a properly configured VPS solution (like Laravel Forge or similar), your typical deployment workflow would normally look like this:

## As a solo developer {#solo}

1. Make your changes locally
2. Git commit changes and push to `main`
3. Changes are automatically deployed to your server

## As a dev team {#team}

1. Make your changes locally
2. Git commit changes and push to a feature or bug branch (e.g. `feature/new-contact-form`)
3. Open a Pull Request to your `main` branch
4. Have a team member review the Pull Request and either request changes or approve
5. Merge branch to `main`
6. Changes are automatically deployed to your server

## Content Editing in Production

If you or your clients manage your content in production (like one would using WordPress), there are two main approaches you can take.

### Version Controlling Content

If you want to version control your content (which we usually encourage folks to do), we recommend enabling [Git Automation](/git-automation) to automatically commit and deploy changes to content.

With that enabled, your _developer_ workflow might look like this:

1. Make your changes locally
2. Git commit changes.
3. `git pull --rebase` changes from production
4. Push changes
5. Changes automatically deployed to server

### Ignoring Content

Sometimes it makes sense to keep the content _outside_ of git. Perhaps you have a lot of writers and content changes happen fast and furiously. Or maybe you have a ton of content and want to keep your git repo small.

Whatever the reason, you can ignore the `content` directory in your `.gitignore` file, and just use git to manage everything else [just like usual](#team).

## Additional Reading

- [Gitflow Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow) – When working with a team (and even when by yourself) it's a good practice to follow a standardized workflow for working with git. We recommend Gitflow.

- [Zero Downtime Deployment Tips](/tips/zero-downtime-deployments#understanding-the-folder-structure) - If you plan on using a zero downtime deployment tool like [Envoyer](https://envoyer.io/), [Deployer](https://deployer.org/), etc. be sure to read our tips & tricks guide.