FeedCentral app
===============

Right now This app is a simple proof of concept for a News app plugin.

Maintainer: * `Lukas W. <https://github.com/psych0d0g>`_ 


**info :: Warning: Curriently This will allow anyone (also not logged in users) to access all feeds of every user**


The generated RSS feed for starred items of a user is available under::

	OWNCLOUD_PATH/index.php/apps/feedcentral/USER_NAME/starred

And the generated RSS feed for all items of all feeds of a user is available under::

        OWNCLOUD_PATH/index.php/apps/feedcentral/USER_NAME/all

where:
* **OWNCLOUD_PATH**: Path to your ownCloud installation
* **USER_NAME**: Name of the user of which you want to access the starred feeds
