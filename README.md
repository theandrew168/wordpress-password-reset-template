# wordpress-password-reset-template
Simple plugin for customizing the WordPress password reset email

## Overview
This plugin adds an entry to the WordPress site's admin settings menu called "Password Reset Template".
From here, the current password reset email template can be changed / updated.

## Setup
On \*nix systems with `make` and `zip` installed, simply run the `make` command.
This will zip `index.php` into a file named `password-reset-template.zip`.

On Windows, [create a zip file](https://support.microsoft.com/en-us/windows/zip-and-unzip-files-8d28fa72-f2f9-712f-67df-f80cf89fd4e5) containing just the `index.php` file.
You can name it whatever you like, but I recommend `password-reset-template.zip` for consistency.

With the plugin zip in hand, it can be uploaded to a WordPress site from the admin page: Plugins -> Add New.

## Screenshot
![plugin settings showing textarea and save button](https://github.com/theandrew168/wordpress-password-reset-template/blob/main/images/plugin_settings.png)
