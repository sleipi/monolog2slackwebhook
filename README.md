Project Skeleton
==============================


This repository is ment as a package-skeleton.
Everytime you start a new project, you can use this project as the skeleton for it.
It provides a basic folder structur with composer and phpunit prepared.

Here are just a few hints to get along with this skeleton:

 * in contrib you will find the composer.phar
 * in root there is a symlink "composer" which links to the .phar file
 * composer.json describes your project (Change the values if needed, the entered values are for example only)
 * phpunit.xml.dist describes your unittests
 * with tests/boostrap you have a bootstrap file for your tests
 * src and tests contain the specific source code
 * in src you will find the class "Greeter.php", to see where your test need to be look in tests/unit-tests.. there is the GreeterTest.php


# Usage

To use this skeleton take the following steps:

 `git clone git@treehouse.parkingcrew.com:dominik/package-skel.git` to the folder where your project is planned to be

 Create your own project on git

 `git remote remove origin && git remote add origin git@path_of_your_own_project`

 now you can work on your project and push it like you're used to it.




