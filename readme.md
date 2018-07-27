# Kirby Authenticator (Beta) [![Release](https://img.shields.io/github/release/pedroborges/kirby-authenticator.svg)](https://github.com/pedroborges/kirby-authenticator/releases) [![Issues](https://img.shields.io/github/issues/pedroborges/kirby-authenticator.svg)](https://github.com/pedroborges/kirby-authenticator/issues)

Improved authentication system with 2-step verification for Kirby CMS.

[![Click to watch a short clip of the Authenticator plugin in action](https://raw.githubusercontent.com/pedroborges/pedroborges/kirby-authenticator/master/preview.gif)](https://jumpshare.com/v/gGVqJuIYQ3JV7Hqj99GA)

## Main features
- 2-step verification
- Password reset (soon)
- Password-less login via email (soon)
- Custom login layout (soon)
- Your turn...

## Basic Usage
Once installed, Authenticator will automatically register the necessary users blueprint to activate the plugin. If your project already have a [default users blueprint](https://getkirby.com/docs/panel/users#custom-user-form-fields), you will need to add the field below to `site/blueprints/users/default.yml`:

```yaml
fields:
  authenticator:
    type: authenticator
```

Then you can login, go to `https://your-site.com/panel/users/[username]/edit`, and scroll to the **2-step verification** section. From there you can turn 2-step verification on/off by clicking on the button on the right and following the instructions.

This plugin is still in _beta_ and there are [some features](#roadmap) that I'd like to complete. That doesn't mean it's buggy, all implemented features should work well. It just doesn't have all the features I have planned for it yet. I'd appreciate if you can test it and give feedback.

## Installation

### Requirements
- Kirby 2.5+
- PHP 7.1+

### Download
[Download the files](https://github.com/pedroborges/kirby-authenticator/archive/master.zip) and place them inside `site/plugins/authenticator`.

### Kirby CLI
Kirby's [command line interface](https://github.com/getkirby/cli) makes installing the Authenticator plugin a breeze:

    $ kirby plugin:install pedroborges/kirby-authenticator

Updating couldn't be any easier, simply run:

    $ kirby plugin:update pedroborges/kirby-authenticator

### Git Submodule
You can add the Authenticator plugin as a Git submodule.

    $ cd your/project/root
    $ git submodule add https://github.com/pedroborges/kirby-authenticator.git site/plugins/authenticator
    $ git submodule update --init --recursive
    $ git commit -am "Add Authenticator plugin"

Updating is as easy as running a few commands.

    $ cd your/project/root
    $ git submodule foreach git checkout master
    $ git submodule foreach git pull
    $ git commit -am "Update submodules"
    $ git submodule update --init --recursive

## Roadmap

- [ ] Password reset
- [ ] Password-less login via email
- [ ] Separate login and 2-step verification in two screens
- [ ] Request verification code to change password
- [ ] Option to copy secret if QR code can't be scanned
- [ ] Allow admin to turn 2-step verification on/off for users
- [ ] Login with email/password instead of username/password
- [ ] Create backup codes when activating 2-step verification
- [ ] Custom login layout

## Change Log
All notable changes to this project will be documented at: <https://github.com/pedroborges/kirby-authenticator/blob/master/changelog.md>

## License
Authenticator plugin is open-sourced software licensed under the [MIT license](http://www.opensource.org/licenses/mit-license.php).

Copyright © 2018 Pedro Borges <oi@pedroborg.es>
