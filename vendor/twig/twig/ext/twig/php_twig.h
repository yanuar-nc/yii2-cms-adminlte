/*
   +----------------------------------------------------------------------+
   | Twig Extension                                                       |
   +----------------------------------------------------------------------+
   | Copyright (c) 2011 Derick Rethans                                    |
   +----------------------------------------------------------------------+
   | Redistribution and use in source and binary forms, with or without   |
   | modification, are permitted provided that the conditions mentioned   |
   | in the accompanying LICENSE file are met (BSD-3-Clause).             |
   +----------------------------------------------------------------------+
   | Author: Derick Rethans <derick@derickrethans.nl>                     |
   +----------------------------------------------------------------------+
 */

#ifndef PHP_TWIG_H
#define PHP_TWIG_H

<<<<<<< HEAD
#define PHP_TWIG_VERSION "1.33.0"
=======
#define PHP_TWIG_VERSION "1.32.0"
>>>>>>> 4fcaf81c6640d7d4aca4501f2dc7763657b5a3ce

#include "php.h"

extern zend_module_entry twig_module_entry;
#define phpext_twig_ptr &twig_module_entry
#ifndef PHP_WIN32
zend_module_entry *get_module(void);
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

PHP_FUNCTION(twig_template_get_attributes);
PHP_RSHUTDOWN_FUNCTION(twig);

#endif
