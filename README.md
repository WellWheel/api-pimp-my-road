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

# Database

On vagrant box, no password is required with root just type :

`mysql`

Then on command line of mysql just type

```sh
  mysql> create database YourDatabaseName;
```

# Install and start

#### Install

```
make install HOST="YOUR_USER" DB_NAME="YOUR_DB_NAME" DB_USER="YOUR_USER" DB_PASSWD="YOUR_PASSWORD"
```

#### Reinstall

```
make reinstall HOST="YOUR_USER" DB_NAME="YOUR_DB_NAME" DB_USER="YOUR_USER" DB_PASSWD="YOUR_PASSWORD"
```

**Indicate:**
  - the name of your database;
  - the user is 'root';
  - No password for database or what ever you want;
  - A mail for user.

# Clear cache
```
make cc
```

# Docuemntation

[Snippets](docs/snippets.md)
