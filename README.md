# TPRE315_BidGames

---

A web application dedicated to reselling board games through auctions and bidding, done for a school project at EPSI Bordeaux.

## Requirements:

- ❗️PHP == 8.0.13❗️
- Composer
- Symfony
- NodeJS
- NPM
- Yarn

## Installation steps:

1. Decompress the .zip file of the project wherever you want.
    1. Move to the project directory.
2. Paste the JWT decompressed folder into the `/config` project directory.
3. Enter in order these commands in the project directory :
    1. `composer u --ignore-platform-reqs && composer i && yarn && yarn build` 
    2. Then open two terminal with each commands and keep them running : 
        1. `php -S localhost:8080 -t public`
        2. `yarn run encore dev --watch`
4. Now you can go on your browser and type :
    1. [http://localhost:8080/api](http://localhost:8080/api) 
    To get to the API documentation.
    2. [http://localhost:8080/app](http://localhost:8080/api)
    To get to the application website.
