# JWT Login Proof of Concept
A proof of concept for JWT based user login.

The concepts behind Json Web Tokens (JWT) can be explored at [jwt.io](https://jwt.io).

The quickest and simplest way to get the app up and running is to use the PHP embedded server.

ex. `php -S 127.0.0.1:8080 -t public server.php`

The hard-coded credentials are `foo@bar.com` and  `baz`.

After you have logged in you can get the token from the `usertoken` cookie and then pass the value
into the debugger at [jwt.io/#debugger-io](https://jwt.io/#debugger-io). Though at the time
of this writing that tool does not support the HS512 algorithm I used for the signature.
