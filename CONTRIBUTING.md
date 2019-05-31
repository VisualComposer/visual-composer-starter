# Contributing to Visual Composer Starter Theme

Visual Composer Starter Theme project operates an open contributor model where anyone is
welcome to contribute towards development in the form of peer review, testing
and patches.


## Contributor Workflow

The codebase is maintained using the "contributor workflow" where everyone
without exception contributes patch proposals using "pull requests". This
facilitates social contribution, easy testing and peer review.

To contribute a patch, the workflow is as follows:

  - Fork repository
  - Create topic branch
  - Commit patches
  
If you send a pull request, please do it against the master branch.

## Set up a local dev environment

To set up a local dev environment following steps are required:

### Clone repo:

```
git clone https://github.com/[Your UserName]/visual-composer-starter.git
```

### Build assets:

Install node modules:

```
npm install
```

Build assets:

```
grunt build
```

Watch changes and build assets:

```
grunt watch
```
