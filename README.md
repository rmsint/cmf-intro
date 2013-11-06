Introduction to the Symfony CMF
===============================

Welcome to the code of the presentation introducing the Symfony CMF.

During the presentation a CMS is build following these steps:

1. Install Symfony and bootstrap template;
1. Install Cmf;
1. Add fixtures and content;
1. Add auto routing;
1. Update templates;
1. Add cache;
1. Add backend CMS;
1. Add frontend editing tool;
1. Add media, media browser and imagine.

Each of these steps have a corresponding branch, checkout each branch to see the
changes made.

When checking out a branch run from the command line:

* ``app/console assets:install web``
* ``app/console assetic:dump``

From step 3:

* ``app/console doctrine:phpcr:repository:init``
* ``app/console doctrine:phpcr:fixtures:load``
