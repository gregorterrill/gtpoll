# GT Poll plugin for Craft CMS

Create polls and get your users' opinions.

![Screenshot](resources/screenshots/plugin_logo.png)

## PLEASE NOTE

This plugin was created as a sample plugin and has a very limited feature set. At this time, there are no plans to enhance it or update it for Craft 3. Use it at your own risk. If you're interested in the dev process, read more about it in [this blog post](http://gregorterrill.com/blog/2016/building-a-polls-plugin-in-craft).

## Installation

To install GT Poll, follow these steps:

1. Download & unzip the file and place the `gtpoll` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/gregorterrill/gtpoll.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins
4. The plugin folder should be named `gtpoll` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

GT Poll works on Craft 2.4.x and Craft 2.5.x.

## GT Poll Overview

GT Poll allows you to create polls and add them to your entries using a new Polls field type.

## Configuring GT Poll

If you like, you can change the plugin name under settings to something more generic, like "Polls".

## Using GT Poll

Create new polls under GT Polls > Manage Polls. Click a poll under GT Polls > List Polls to edit it.

You'll find sample CSS, JavaScript, and a template in the /sample/ folder that you can use on the front-end of your site. Modify it as needed.

## GT Poll Roadmap

Some ideas for future improvements:

* Make polls an ElementType (maybe?), so they can be properly translated

## GT Poll Changelog

### 1.0.0 -- 2016.02.23

* Initial release

Brought to you by [Gregor Terrill](http://gregorterrill.com)