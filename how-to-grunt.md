### Use Grunt To Make A Release
* Make sure package.json has the version number set for the version you want to release.
* In terminal switch to this directory
* Install node modules. `npm install` -- If OSX will need to use sudo.
* Update version in package.json
* `grunt build`

### What this does:
* Runs composer update to get latest version.
* Tags the version.
* Creates a zip file of the plugin, with the dependencies and commits that to the repo. That way a built copy can be downloaded.

@todo svn deploy, once this has a WPORG release.
