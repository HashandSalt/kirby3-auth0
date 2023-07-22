# Kirby Auth0

 A plugin for K3+ to allow for decentralised front-end logins via Auth0.

 ## Install

 #### Manual

 Copy the plugins folder to `site\plugins`

 #### Composer

 ```
 composer require hashandsalt/kirby3-auth0
 ```

 ## Setup

 The plugin uses `.env` to protect the auth0 credentials. You will need to create a `.env` file in the root of the public folder with the following (replace XXX with your own details):

 ```
# Your Auth0 application's Client ID
AUTH0_CLIENT_ID=XXX

# The URL of your Auth0 tenant domain
AUTH0_DOMAIN=XXX

# Your Auth0 application's Client Secret
AUTH0_CLIENT_SECRET=XXX

# A long, secret value used to encrypt the session cookie.
# This can be generated using `openssl rand -hex 32` from your shell.
AUTH0_COOKIE_SECRET=XXX
```


You should exclude this file from Git.

## Usage

Once you have a properly configured app set up in the Auth0 dashboard, you can go ahead and work with the users. In a controller (recomended) or template, we can check if a user is logged in and get the profile of the user:

```php
$auth0 = site()->auth0();
$session = $auth0->getCredentials();
$user = $session === null ? null : $session->user;
```

Now we can use that info to make a login / logout switch. A very basic example:

```php
if (is_null($user)) {
  echo 'You are not logged in</br>';
  echo '<p>Please <a href="/login">log in</a>.</p>';
} else {
  $name = $user['given_name'] ?? $user['nickname'] ?? $user['email'] ?? 'Unknown';
  echo '<h1>Welcome '  . $name . '!</h1>';
  echo '<p><a href="/logout">log out</a>.</p>';
}
```

There is more information in the profile, such as the users Gravatar image. View the rest with `dump($user)`.

## Options

Change the base uri and the location of the `.env` file:

```php
'hashandsalt.auth0.baseUri' => 'https://localhost:3000/', // set to your live domain name on the public server
'hashandsalt.auth0.env' => './',
```


### Contributers


