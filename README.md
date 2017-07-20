# Environment dependencies

```sh
$ git clone https://github.com/WellWheel/api-pimp-my-road.git
$ sudo apt-get update
$ sudo apt-get install php7.0-xml php7.0-apcu php7.0-mbstring php7.0-mysql -y
$ sudo apt-get install libapache2-mod-php7.0 libphp7.0-embed libssl-dev openssl php7.0-cgi php7.0-cli php7.0-common php7.0-dev php7.0-fpm php7.0-phpdbg -y
$ sudo service php7.0-fpm restart
$ sudo service apache2 reload
$ cd api-pimp-my-road
```

# Clear cache
```
make cc
```

# start
```
make
```

# Api User
Créer un utilisateur dans la base de données User
```
var qs = require("querystring");
var http = require("http");

var options = {
  "method": "POST",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/register",
  "headers": {
    "content-type": "application/x-www-form-urlencoded",
    "cache-control": "no-cache",
    "postman-token": "298f9e77-dfaf-d657-c55a-8b71bbe26dd3"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.write(qs.stringify({ username: 'bob@test.fr',
  email: 'bob@test.fr',
  password: '1234' }));
req.end();

```
Login utilisateur
```
var qs = require("querystring");
var http = require("http");

var options = {
  "method": "POST",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/login_check",
  "headers": {
    "content-type": "application/x-www-form-urlencoded",
    "cache-control": "no-cache",
    "postman-token": "262b174f-944d-90ab-3554-4b1840ac1f9c"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.write(qs.stringify({ _username: 'test@example.com', _password: 'p@ssword' }));
req.end();

```

# URL Google direction
Créer un voyage
```
var http = require("http");

var options = {
  "method": "POST",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/journey/create",
  "headers": {
    "authorization": "Bearer <Token>",
    "content-type": "application/json",
    "cache-control": "no-cache",
    "postman-token": "ebc35dab-d6b7-9877-0c21-207ded309b57"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.write(JSON.stringify({ origin: 'Paris', destination: 'Lyon', iduser: '1' }));
req.end();
```
Liste des voyages par user
```
var http = require("http");

var options = {
  "method": "GET",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/journey/1",
  "headers": {
    "authorization": "Bearer <TOKEN>",
    "cache-control": "no-cache",
    "postman-token": "634a49e0-bf2c-8978-2b77-e1ca8137a870"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.end();
```
Supprimer un voyage
```
var http = require("http");

var options = {
  "method": "DELETE",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/journey/delete/1",
  "headers": {
    "authorization": "Bearer <TOKEN>",
    "cache-control": "no-cache",
    "postman-token": "7907ca89-d04b-d0ba-0916-2ff1732838ef"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.end();
```
Mettre à jour un voyage
```
var http = require("http");

var options = {
  "method": "POST",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/journey/update/2",
  "headers": {
    "authorization": "Bearer <TOKEN>",
    "content-type": "application/json",
    "cache-control": "no-cache",
    "postman-token": "984b6192-f776-497d-acad-f229dfc44258"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.write(JSON.stringify({ origin: 'Marseille' }));
req.end();
```
Obtenir la météo
```
var http = require("http");

var options = {
  "method": "POST",
  "hostname": "192.168.33.10",
  "port": null,
  "path": "/app_dev.php/api/meteo/",
  "headers": {
    "content-type": "application/json",
    "authorization": "Bearer <TOKEN>",
    "cache-control": "no-cache",
    "postman-token": "a52bbd96-ebdf-c46f-d21a-70fbc0b2ac1c"
  }
};

var req = http.request(options, function (res) {
  var chunks = [];

  res.on("data", function (chunk) {
    chunks.push(chunk);
  });

  res.on("end", function () {
    var body = Buffer.concat(chunks);
    console.log(body.toString());
  });
});

req.write(JSON.stringify({ lat: '45.75', lon: '4.85' }));
req.end();
```
