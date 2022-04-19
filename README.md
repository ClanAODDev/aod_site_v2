## Clan AOD - Website

[![Site Test Suite](https://github.com/ClanAODDev/aod_site_v2/actions/workflows/format_php.yml/badge.svg)](https://github.com/ClanAODDev/aod_site_v2/actions/workflows/format_php.yml)


[![Site Test Suite](https://github.com/ClanAODDev/aod_site_v2/actions/workflows/CI.yml/badge.svg)](https://github.com/ClanAODDev/aod_site_v2/actions/workflows/CI.yml)

The Clan AOD website is built using [Laravel]((https://laravel.com/docs)). Local setup and development information is provided below. Contributions should follow the contributor guidelines.

Local setup guidance coming soon™️


#### Local development

Do the following to get a working local copy of the site set up.

```shell

# clone the repo - ssh key (preferred)
git clone git@github.com:clanaoddev/aod_site_v2 

# or with user/pass
git clone https://github.com/clanaoddev/aod_site_v2

# install composer dependencies (requires composer [v2!])
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
```

#### Front-end assets

`resources/src/main.styl` is the pivot template for the compiled CSS assets. I chose Stylus because it was easy to handle complicated rules and clean syntax, free of the technical debt that traditional CSS keeps. 

Compiling Stylus to CSS is handled by Laravel Mix and webpack via `webpack.mix.js` and by running:

```shell
npx mix

# or for production releases
npx mix --production
```

Note that `webpack.mix.js` also handles the JS asset compilation. `app.js` is the pivot file, with `bootstrap.js` handling extra vendor-specific imports.

## New Division Setup

A few things need to happen when new divisions get added. Typically this work is done by MSGT+ due to access restrictions to administration tools.

- Division logo needs to be extracted. Avoid at all costs fan art. Opt for extracts of icon resources from the game binary. `BeCyIconGrabber` is my tried and true tool for getting these. Typically this involves inspecting the game binary with the tool, looking for "icon" assets, and then extracting the `48x48 px` size. There is nearly always this size available. In rare cases, we would get one size larger, and then do a Bicubic Sharper reduction to that size. 
    - Logo (in PNG format) then goes to `public/images/division-icons/{abbreviation.png}` on the website.
    - Right now it also goes to the same location on the Tracker. Eventually we will consolidate on one location for both the website and tracker to reference. For now... redundancy.
    

- A page needs to be created on the website (`resources/views/division/content/{slug.blade.php}`) for the division using the slug-formatted version of the name.
  
    |Name|Slug|Abbreviation
    |---|---|---|
    |World of Warcraft|world-of-warcraft|wow
    |Tom Clancy|tom-clancy|tc
    |Planetside 2|planetside-2|ps2
    
    


- Division needs to be built on the Tracker. There is an administrative layer called "Nova" for this, where resources are represented by Nova models. Once the division is created, it will populate on the API which we are consuming through the website.  
