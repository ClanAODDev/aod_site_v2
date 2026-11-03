## Clan AOD - Website

The public Clan AOD website.

**Tech Stack:** [Laravel](https://laravel.com/docs) 13 · PHP 8.4 · React 19 + Inertia + TypeScript · Tailwind v4 · Stylus · Vite

Division information (names, logos, page content, leadership) comes from the [AOD Tracker](https://github.com/ClanAODDev/tracker_v3) API, so the site needs a tracker API token to show divisions.

#### Local development

Requires [Docker](https://www.docker.com/) or Docker Desktop, plus Node.js and npm for the front-end build.

The site's container joins the `tracker_site_bridge` Docker network that the Tracker's Sail setup creates. Start the Tracker locally first, or create the network yourself with `docker network create tracker_site_bridge`.

```shell
# clone the repo - ssh key (preferred)
git clone git@github.com:clanaoddev/aod_site_v2

# or over https
git clone https://github.com/clanaoddev/aod_site_v2

# set up the environment file
cp .env.example .env

# install composer dependencies (needs PHP 8.4 and Composer 2)
composer install

# or without local PHP
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

# build the docker image and start the container in detached mode
# - recommend setting up an alias: alias sail='./vendor/bin/sail'
./vendor/bin/sail up -d

# generate the application encryption key
./vendor/bin/sail artisan key:generate

# install and build front-end assets
npm install
npm run build

# navigate to http://localhost:8080 (or the APP_PORT set in .env)

# run tests (runs phpunit inside the container)
./vendor/bin/sail test
```

Set `AOD_TRACKER_TOKEN` in `.env` to a Tracker API token with the `division:read` scope (create one on the Tracker's Developers page). `TRACKER_URL` defaults to the production Tracker. Point it at a local Tracker to develop against local data.

#### Front-end assets

Vite builds everything (`vite.config.js`):

- **Pages** are React components in `resources/js/pages`, rendered through Inertia from the Laravel controllers. `resources/js/app.tsx` is the entry point.
- **Styles**: `resources/src/main.styl` is the pivot template for the site's Stylus styles, with Tailwind v4 alongside for the React pages.

```shell
npm run build       # production build
npm run typecheck   # type-check the TypeScript
```

## New Division Setup

A few things need to happen when a new division is added. This is typically done by MSGT+ because of access to the administration tools.

- **Create the division on the Tracker** in the Filament admin panel. Everything the site shows about a division comes from the Tracker API, so the division appears on the site once it exists there and is active.
- **Logo**: upload it on the division in the Tracker admin. The site gets it from the API. Avoid fan art at all costs; opt for icons extracted from the game binary. `BeCyIconGrabber` is the tried and true tool: inspect the game binary, look for "icon" assets, and extract the `48x48 px` size, which is nearly always available. In rare cases, take the next size up and do a Bicubic Sharper reduction to 48x48.
- **Division page content**: written in Markdown in the division's **Site content** field in the Tracker admin. The site renders it on `/divisions/{slug}`.
- **Header banner (optional)**: add `public/images/division-headers/{abbreviation}.jpg` to this repo. Without one, the division page uses the default header image.

  | Name              | Slug              | Abbreviation |
  |-------------------|-------------------|--------------|
  | World of Warcraft | world-of-warcraft | wow          |
  | Tom Clancy        | tom-clancy        | tc           |
  | Planetside 2      | planetside-2      | ps2          |
