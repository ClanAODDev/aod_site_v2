## Clan AOD - Website

The Clan AOD website is built using [Laravel]((https://laravel.com/docs)). Local setup and development information is provided below. Contributions should follow the contributor guidelines.

Local setup guidance coming soon™️


#### Local development

Do the following to get a working local copy of the site set up.

```shell

# clone the repo - ssh key (preferred)
git clone git@github.com:clanaoddev/aod_site_v2 

# or with user/pass
git clone https://github.com/clanaoddev/aod_site_v2

# install composer dependencies (requires composer)
composer install 

# install front-end compilation tools (requires npm and NodeJS
npm install

# build docker images and start up containers in detached mode
# - recommend setting up an alias - alias sail='/vendor/bin/sail`
/vendor/bin/sail up -d

# navigate to http://localhost

# run tests
# this execs into the web docker container and runs our phpunit tests
sail test

#### Front-end assets

`resources/src/main.styl` is the pivot template for the compiled CSS assets. I chose Stylus because it was easy to handle complicated rules and clean syntax, free of the technical debt that traditional CSS keeps. 

Compiling Stylus to CSS is handled by Laravel Mix and webpack via `webpack.mix.js` and by running:

```shell
npx mix

# or for production releases
npx mix --production
```

Note that `webpack.mix.js` also handles the JS asset compilation. `app.js` is the pivot file, with `bootstrap.js` handling extra vendor-specific imports.


