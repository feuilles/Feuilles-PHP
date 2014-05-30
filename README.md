# Feuilles PHP

A simple class to interact with [Feuilles' API](https://feuill.es/documentation/api).

## Get started

```
require_once "path/to/Feuilles.php";
$feuilles = new Feuilles(array(
	"client_id" => $your_client_id,
	"client_secret" => $your_client_secret,
	"redirect_uri" => $your_redirect_uri,
));
```

You can optionaly add an `access_token` argument at this stage, if you already have one.

## OAuth2

Feuilles' flow is pretty basic. To authorize an app, point your users to the following url: 

`https://feuill.es/api/v1/oauth2/authorize?client_id=your_client_client_id&redirect_uri=your_url&response_type=code`

__Note:__ we currently only support `code` response types.

### `getAccessToken`

When an application is authorized, your users will be redirected to your `redirect_uri`, which is an endpoint you own. That's where you can use the `getAccessToken` method to acquire an access token:

```
// Example of a redirect uri: https://your-super-website.com/?code=1234567890
// We need to use the code in the url to get the access token
$res = $feuilles->getAccessToken($_GET["code"]);
$res = json_decode($res);
$access_token = $res->access_token;
```

### `setAccessToken`

When you have an access token, you can store it and start making requests to our API on behalf of your user:

```
$feuilles->getAccessToken($access_token);
```

## The “Doc” methods

### `createDoc`

```
$res = $feuilles->createDoc(array(
	"title" => "I am the title",
	"body" => "I am the body",
));

// $res = json_decode($res);
// $sha = $res->sha;
```

The `createDoc` method returns a `sha` that you can use to identify a specific document.

### `readDoc`

```
$res = $feuilles->readDoc($sha);
// $res = json_decode($res);
```

### `updateDoc`

```
$res = $feuilles->updateDoc($sha, array(
	"title" => "I am the new title",
	"body" => "I am the new body",
	"note" => "I am a note", // Optional
	"status_slug" => "final", // Optional
));

// $res = json_decode($res);
```

__Note:__ the `status_slug` param can be one of the following: 

* draft
* revising
* final


### `deleteDoc`

```
$res = $feuilles->deleteDoc($sha);
// $res = json_decode($res);
```

__Note:__ When a doc is deleted, it's gone forever.
