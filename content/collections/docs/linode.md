---
id: f8bac6fc-401c-4f0e-b338-386e332c91b8
blueprint: page
title: 'How to Install Statamic on Linode'
breadcrumb_title: Linode
parent: ab08f409-8bbe-4ede-b421-d05777d292f7
intro: A full walk-through for installing, configuring, and running Statamic on a Linode Ubuntu virtual private server.
---
## Prerequisites

There is only one prerequisite for this guide. You must have:

- A [Linode](https://www.linode.com/) account

## Server Setup

Follow the [official “Getting Started with Linode”](https://www.linode.com/docs/guides/getting-started/) guide to setup your server. Be sure to choose the Ubuntu image when creating your server — preferably the Ubuntu version 20.04 LTS. You can still use Ubuntu 18.04 or 16.04 if you want. To use old software.

We recommend at least 1GB of memory on your VPS.

## Secure Your Server

Follow the [official “How to Secure Your Server” Linode guide](https://www.linode.com/docs/guides/securing-your-server/) to secure your server. This guide covers web users, SSH hardening, trimming down network-facing services, configuring a firewall, and a lot of other stuff.

## Install Statamic on Ubuntu

Now that you have a secure server with Ubuntu, follow our [Ubuntu instructions](/installing/ubuntu) to install Statamic.
