# About

This Kohana module provides simple migrations from the command line for SQL compliant databases.

It is a K3 port of http://github.com/jmhobbs/kohana-2-migrations

# Using

Create a folder named "migrations" in your application folder.  This directory must be writable, or must contain a directory called ".info" which is writable.

Put valid SQL files in that folder, following the naming patterns: 001_ANYTHING_HERE_UP.sql & 001_ANYTHING_HERE_DOWN.sql

For example:

	001_Auth_DOWN.sql
	001_Auth_UP.sql
	002_Users_DOWN.sql
	002_Users_UP.sql
	003_Island_DOWN.sql
	003_Island_UP.sql
	004_Pages_DOWN.sql
	004_Pages_UP.sql

Now add this module to your application/bootstrap.php file.

Then you can run them from the command line:

## Status

	jmhobbs@katya:/var/www/qaargh$ php5 index.php --uri=migrations

	=======================[ Kohana Migrations ]=======================

	    Current Migration: 7
	     Latest Migration: 7

	===================================================================


## Up

	jmhobbs@katya:/var/www/qaargh$ php5 index.php --uri=migrations/up/3

	=======================[ Kohana Migrations ]=======================

	   Current Migration: 0
	    Latest Migration: 7

	===================================================================

	  Requested Migration: 3
	            Migrating: UP

	===================================================================

	Migrated: 001_Auth_UP.sql
	Migrated: 002_Users_UP.sql
	Migrated: 003_Island_UP.sql

	===================================================================

	    Current Migration: 3
	     Latest Migration: 7

	===================================================================


## Down

	jmhobbs@katya:/var/www/qaargh$ php5 index.php --uri=migrations/down/0

	=======================[ Kohana Migrations ]=======================

	    Current Migration: 3
	     Latest Migration: 7

	===================================================================

	  Requested Migration: 0
	            Migrating: DOWN

	===================================================================

	Migrated: 003_Island_DOWN.sql
	Migrated: 002_Users_DOWN.sql
	Migrated: 001_Auth_DOWN.sql

	===================================================================

	    Current Migration: 0
	     Latest Migration: 7

	===================================================================

# License

	Copyright (c) 2010 John Hobbs

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.

# Inspiration

Inspiration and base code from https://code.google.com/p/kohana-migrations/
