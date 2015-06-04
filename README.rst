.. title:: Error

=====
Error
=====

With this package, you can control error codes and exceptions in system with many sub systems.

Installation
------------

Add **FivePercent/Error** in your composer.json:

.. code-block:: json

    {
        "require": {
            "fivepercent/error": "~1.0"
        }
    }


Now tell composer to download the library by running the command:


.. code-block:: bash

    $ php composer.phar update fivepercent/error


Basic usage
-----------

For collect all error codes, you must create a error factory in you sub system:

.. code-block:: php

    use FivePercent\Component\Error\ErrorFactoryInterface;

    final class MySystemError implements ErrorFactoryInterface
    {
        const ERROR_1 = 1;
        const ERROR_2 = 2;

        public function getErrors()
        {
            return [
                self::ERROR_1 => 'Error #1',
                self::ERROR_2 => 'Error #2'
            ];
        }

        public function getExceptions()
        {
            return [];
        }

        public function getReservedDiapason()
        {
            return [1, 5];
        }
    }

And create error system (Storage), and add this factory to storage:

.. code-block:: php

    use FivePercent\Component\Error\Errors;

    $errors = new Errors();
    $errors->addFactory(new MySystemError());


After, you can:

#. Get reserved diapasons for each system
    .. code-block:: php

        $errors->getReservedCodes();

#. Get all errors for system
    .. code-block:: php

        $errors->getErrors();

#. Get all exceptions
    .. code-block:: php

        $exceptions = $errors->getExceptions();

#. Check, if has exception in errors storage
    .. code-block:: php

        $exception = new \Exception();
        $errors->hasException($exception);

#. Get error code for exception
    .. code-block:: php

        $exception = new \Exception();
        $code = $errors->getExceptionCode($exception);

#. Check reserved codes
    .. code-block:: php

        $errors->checkReservedCodes();
