# Doks

## Info
This is simple, mainly explanatory PHP library for accessing DOKS API.

## Release notes
This code is not officially provided or supported by Suomen Tunnistetieto Oy. It has no warranty. Since DOKS API and it's versioning can and will change in future, this code is in suspect to outdate. Suomen Tunnistetieto Oy will provide techical support for API integrations case-by-case, so please contact them for more detailed support and information.

## What is DOKS?
DOKS is KYC-tool provided by Suomen Tunnistetieto Oy. See [here] (https://finland.bisnode.fi/documentation/) for more information.

## Credentials
In order to access DOKS API, you need credentials (account email and password). You must obtain these from organization that uses DOKS.

## Test environment
Unfortunately, there is currently no test / development / sandbox -version of DOKS API. Everything you do, will go production immediately. Please also note, that some operations might be chargeable.

## Initializing
Initialize class with your credentials:
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
```

## Get list of customers
```php
$d = new Doks("youremail@domain.fi", "yourpassword");

if(!$data = $d->getCustomers()) {
    if($data === false) {
        die("Unable to get customers");
    }
}

var_dump($data);
```

## Get list of owners and actual beneficiaries
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getOwners($customers_id)) {
    if($data === false) {
        die("Unable to get owners");
    }   
}

var_dump($data);
```

## Get list of identifications
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo"; 

if(!$data = $d->getIdentifications($customers_id)) {
    if($data === false) {
        die("Unable to get identifications");
    }
}

var_dump($data);
```

## Get list of information requests
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getRequests($customers_id)) {
    if($data === false) {
        die("Unable to get requests");
    }
}

var_dump($data);
```

## Get list of electronic signatures
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getSignatures($customers_id)) {
    if($data === false) {
        die("Unable to get signatures");
    }
}

var_dump($data);
```

## Get list of secure messages
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getLetters($customers_id)) {
    if($data === false) {
        die("Unable to get letters");
    }
}

var_dump($data);
```

## Get list of alerts
You can get all alerts that covers all customers:
```php
$d = new Doks("youremail@domain.fi", "yourpassword");

if(!$data = $d->getAlerts()) {
    if($data === false) {
        die("Unable to get documents");
    }
}

var_dump($data);
```

Or you can get alerts for single customer. In that case, you must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getAlerts($customers_id)) {
    if($data === false) {
        die("Unable to get documents");
    }
}

var_dump($data);
```




## Get list of documents
You must know customer's id. You can get it from list of customers.
```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$customers_id = "foo";

if(!$data = $d->getDocuments($customers_id)) {
    if($data === false) {
        die("Unable to get documents");
    }
}

var_dump($data);
```

## Save file to disk
You must know files_id. You can get it from list of documents.

```php
$d = new Doks("youremail@domain.fi", "yourpassword");
$files_id = "foo";
$destination = "/tmp/bar.tmp";

if(!$data = $d->saveFile($files_id, $destination)) {
    die("Unable to save file");
}
```
