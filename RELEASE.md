# Release Changes
* 1.1.1
    * Remove composer.lock as it is not needed because this is a library.
    * Update documentation and remove api docs and requirements for generating docs.
* 1.1.0
    * Add steps to release documentation to make it easy to create a new release.
* 1.0.0
    * Initial Release

**Steps To Create Release**

1. Add version changes to `RELEASE.md`.
3. Update release version in `composer.json`.
4. Run `composer run build` to generate the new documentation for the updates.
5. Merge changes to master branch and push master branch changes upstream.
6. Create git tag with release version: `git tag X.X.X`
7. Push new git tag upstream.
