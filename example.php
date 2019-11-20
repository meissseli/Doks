<?php
require("Doks.php");

$d = new Doks("email", "password");

if(!$customers = $d->getCustomers()) {
    if($customers === false) {
        die("Unable to get customers");
    }
}

$id = false;
foreach($customers as $customer) {

    print "Customer: ".$customer["name"]." (id: ".$customer["id"].")\n";

    // see for a single customer for id lookup
    if($customer["businessid"] == "2241422-0") {
        $id = $customer["id"];
    } 
}

if($id === false) {
    die("Unable to get wanted customer");
}

if(!$owners = $d->getOwners($id)) {
    if($owners === false) {
        die("Unable to get owners for " . $id);
    }
}

foreach($owners as $owner) {
    print "Owner: ".$owner["name"]."\n";
}

if(!$identifications = $d->getIdentifications($id)) {
    if($identifications === false) {
        die("Unable to get identifications for " . $id);
    }
}

foreach($identifications as $identification) {
    print "Identification: ".$identification["name"]."\n";
}

if(!$requests = $d->getRequests($id)) {
    if($requests === false) {
        die("Unable to get requests for " . $id);
    }
}

foreach($requests as $request) {
    print "Request: ".$identification["name"]."\n";
}

if(!$signatures = $d->getSignatures($id)) {
    if($signatures === false) {
        die("Unable to get signatures for " . $id);
    }
}

foreach($signatures as $signature) {
    print "Signature: ".$signature["name"]."\n";
}

if(!$letters = $d->getLetters($id)) {
    if($letters === false) {
        die("Unable to get letters for " . $id);
    }
}

foreach($letters as $letter) {
    print "Letter: ".$letter["email"]."\n";
}

if($alerts = $d->getAlerts($id)) {
    if($alerts === false) {
        die("Unable to get alerts for " . $id);
    }
}

foreach($alerts as $alert) {
    print "Alert: ".$alert["type"]."\n";
}

if($documents = $d->getDocuments($id)) {
    if($documents === false) {
        die("Unable to get documents for " . $id);
    }
}

foreach($documents as $document) {
    print "Document: ".$document["name"]."\n";

    if(!$d->saveFile($document["files_id"], $document["files_id"].".tmp")) {
        die("Unable to save file " . $document["files_id"]);
    }
}
