
## Badges

[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs) 
[![CodeFactor](https://www.codefactor.io/repository/github/l-clem/bidgames/badge)](https://www.codefactor.io/repository/github/l-clem/bidgames)
![GitHub repo size](https://img.shields.io/github/repo-size/L-Clem/BidGames)
![Maintenance](https://img.shields.io/maintenance/yes/2022)
![PHP requirements](https://img.shields.io/badge/php%20version-%3D8.0.13-blue)
# BidGames

An API server and its web application dedicated to reselling board games through auctions and bidding, done for a school project at EPSI Bordeaux.


## Tech Stack

**Client:** React, Bootstrap

**Server:** Api-Platform, Symfony


## Features

- A full featured API with authentification by JWT tokens.
- A demonstration front web application.



## FAQ

#### Where's the API documentation ?

The API documentation is available on the *Swagger API* page of the application (see **Run Locally** for more informations).

#### What's the E/R diagram of your database ?

Here's our E/R diagram (made with [dbdiagram.io](https://dbdiagram.io/home)) :
![](https://i.ibb.co/znKPJjR/bidgame-2.png)


## Run Locally
❗ You can't run this project without the keys needed for authentification.

Clone the project

```bash
  git clone https://github.com/L-Clem/BidGames.git
```

Go to the project directory

```bash
  cd BidGames
```

Install dependencies after installing yarn

```bash
  composer u --ignore-platform-reqs && composer i && yarn && yarn build
```

Then start a terminal for each commands

```bash
  php -S localhost:8080 -t public
  yarn run encore dev --watch
```

Now you can go on your browser and type :
- http://localhost:8080/api to get to the API documentation.
- http://localhost:8080/app to get to the application website.
## Authors

- [@L-Clem](https://github.com/L-Clem)
- [@Ali3597](https://github.com/Ali3597)
- [@annaty](https://github.com/annaty)
- [@ClemLcs](https://github.com/ClemLcs)

