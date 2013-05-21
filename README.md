CodeIgniter-ACL-Hook
====================

A simple to use ACL for CodeIgniter

Introduction
------------

CodeIgniter is a great PHP-Framework with a lot of features.
However it does not provide a ACL from ground up.

ACL
---

An ACL, short for Access Control List, is simple and easy maintainable way of controlling permissions.

This ACL is based on the post_controller_constructor hook of CodeIgniter.

Installation
------------

* Download the hook acl.php
* Place the file into application/hooks
* Open the main config file and change $config['enable_hooks'] = FALSE; to $config['enable_hooks'] = TRUE;
* Hook the acl class into the system by editing application/config/hooks.php
		$hook['post_controller_constructor'] = array(
    		'class' => 'ACL',
    		'function' => 'auth',
    		'filename' => 'acl.php',
    		'filepath' => 'hooks'    
		);

* Now you just need to add your rules:
	In the contstructor of the class:
		$this->role_field = 'role_id';
	This is the name of field in the session which indicates the role id of the user
	
	Now you can add rules like this:
		$this->perms[<ROLE_ID>][<CONTROLLER>][<METHOD>] = true;
		
	The first array is setting the rule for the role id. The next two values are defining the controller and method.
		$this->perms[2]['admin']['index'] = true;
	This for example will allow everyone with the role_id 2 to access BASE_URL/admin(/index)

* Please make sure, that you need a need a field in your session with the role id!
* Note that role id 0 is reserved for guests!
* Inheritance is **NOT** supportet at this point in time!
	
TODO
----

A good way to control redirect.