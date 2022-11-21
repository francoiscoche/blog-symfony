# blog-symfony
Blog app with Symfony and Docker. Made to learn.



*Developpement in progress ...*

- Integration of [Slugify](https://github.com/cocur/slugify) to generate post slugs.
- Integration of [VichUploaderBundle](https://github.com/dustin10/VichUploaderBundle) for images uploading.
- Integration of [DoctrineFixturesBundle](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html) and [FakePHP](https://fakerphp.github.io/) for generating false test data.
- Integration of TailWindCss with WebPackEncore from this [tutorial](https://www.yourigalescot.com/fr/blog/comment-integrer-tailwindcss-v3-a-un-projet-symfony-avec-webpack-encore).
- Integration of [TailWindElement](https://tailwind-elements.com/quick-start/) (Bootstrap components recreated with tailwind css).
- Integration of [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) to use a pagination system.

<br>

### Requirements

- Docker
- Docker-compose

<br><br>
### Run the project locally with docker
<br>

Clone the project
```bash
git clone git@github.com:francoiscoche/blog-symfony.git
```

Run docker-compose
```bash
docker-compose build
docker-compose up -d
```

Copy the vendor folder to the container (did for performance purpose)
```bash
cd .\project\
composer install
docker cp vendor www_symblog:/var/www/app
```

Log into the PHP container
```bash
docker exec -it www_symblog bash
```

Run the fixtures (need to configure database into .env.local)
```bash
php bin/console doctrine:fixtures:load
```

Run npm
```bash
npm run build
```


*The application is available at http://127.0.0.1:8000*

<br><br>

### UML
<img width="500" alt="image" src="https://user-images.githubusercontent.com/102531037/201717308-daa63ba3-04eb-4246-a713-4e07fac463ff.png">



### Author

Inspired by [@Emilien.Gts](https://gitlab.com/Emilien.Gts)
Adapted by [@francoiscoche](https://github.com/francoiscoche)
