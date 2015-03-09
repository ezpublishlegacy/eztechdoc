# eztechdoc

===============
Welcome to the Technical Documentation of the eZ Platform and eZ Publish Platform 5.x "Platform stack"
===============


What is eZ Publish?
===============

eZ Publish an highly-extensible Enterprise Open-Source Content Management System/Framework, based on the Symfony2 framework starting version 5.0. In its default Enterprise offering, eZ Publish Platform, it is extended to provide full CXM capabilities, bundled with support services, provided as a LTS release with first access to security updates and regular fully tested maintenance releases.

Installation
======================

Install $project see https://github.com/ezsystems/ezpublish-kernel


Issue tracker
======================

Submitting bugs, improvements and stories is possible on https://jira.ez.no/browse/EZP.
If you discover a security issue, please see how to responsibly report such issues on https://doc.ez.no/Security.

Contributing
======================

eZ Publish 5.x is a fully open source, community-driven project, and code contributions are simply done via github pull requests.

Short:
-------------

* Remember to first create a issue in our issue tracker and refer to it in commits and pull requests headers, example:
  "Fix EZP-20104: ContentController should return error status when content is not found"
  or
  "Implement EZP-201xx: Add support for X in Y"
* If you want to contribute implementation specification proposals, place them in [doc/](doc/) folder.
* Keep different changes in different commits in case cherry-pick is preferred instead of a merge later.
  * A Pull Request should only cover one issue.
  * A commit should not contain code changes at the same time as doing coding standards/whitespace/typo fixes.
* TDD: Write/Change the test(s) for the change you do and commit it before you do the actual code change.
  * If a bug affects Public API, write or enhance a integration test to make sure the bug is covered.
  * Unit tests should only use mocks/stubs and never test the full stack like integrations tests does.
* Please test/check your commits before pushing even if we have automated checks in place on pull requests:
  * Run unit tests and integration test before commits
  * Make sure you follow our [coding standards](https://github.com/ezsystems/ezcs)

For further information please have a look at the [related guidance page](http://share.ez.no/get-involved/develop). You will, amongst other, learn how to make pull-requests. More on this here : ["How to contribute to eZ Publish using GIT"](http://share.ez.no/learn/ez-publish/how-to-contribute-to-ez-publish-using-git).

Discussing/Exchanging
======================

A dedicated forum has been set-up to discuss all PHP API-related topics : http://share.ez.no/forums/new-php-api

Copyright & license
======================
Copyright eZ Systems AS, for copyright and license details see provided LICENSE file.
