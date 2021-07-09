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
